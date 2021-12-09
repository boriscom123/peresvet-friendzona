<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package pv-friendZONE
 */

?>
<?php
// include 'assets/amocrm/amocrm.php';
// include 'assets/amocrm/amocrm-users.php';
    function prepareLogin($tel){
        $user_tel = $tel;
        $tel = '';
        for($i=0; $i<mb_strlen($user_tel); $i++){
            // echo $user_tel[$i];
            if($i==0){
                if($user_tel[$i] === '+'){
                    $tel .= 7;
                    $i++;
                } elseif ($user_tel[$i] === '8'){
                    $tel .= 7;
                } else {
                    if(is_numeric($user_tel[$i])) {
                        $tel .= $user_tel[$i];
                    }
                }
            } else {
                if(is_numeric($user_tel[$i])) {
                    $tel .= $user_tel[$i];
                }
            }
        }
        return $tel;
    }
    if(isset($_POST['action'])){
        if($_POST['action'] === 'registration'){
            // echo 'Регистрируем пользователя';
            // print_r($_POST);
            $user_info = array(
                'user_login'    => prepareLogin($_POST['tel']),
                'user_password' => $_POST['code'],
                'remember'      => true,
            );
            $user = wp_signon( $user_info );
            // print_r($user);
            if ( is_wp_error($user) ) {
                echo 'Не удалось найти зарегистрированного пользователя. Попробуйте в другой раз';
            } else {
                // echo 'Пользователь успешно зарегистрирован';
                // необходимо обновить дополнительные данные пользователя Фамилия + Имя
                // echo 'ID нового пользователя: '.$user->data->ID;
                $user_id = $user->data->ID;
                wp_update_user( [ 'ID' => $user_id, 'description' => $_POST['code'] ] );
                if(isset($_POST['f'])) {
                    // добавляем фамилию
                    wp_update_user( [ 'ID' => $user_id, 'last_name' => $_POST['f'] ] );
                }
                if(isset($_POST['i'])) {
                    // добавляем имя
                    wp_update_user( [ 'ID' => $user_id, 'first_name' => $_POST['i'], 'display_name' => $_POST['i'], 'nickname' => $_POST['i'] ] );
                }
                // отправка данных в амо срм
                if(!file_exists('wp-content/themes/pv-friendzone/assets/amocrm/amointegrationapi.json')){
                    // echo "Делаем новую интеграцию";
                    include 'assets/amocrm/amocrm.php';
                } else {
                    // echo "Используем имеющийся токен";
                    $token = explode("/",file_get_contents("wp-content/themes/pv-friendzone/assets/amocrm/amointegrationapi.json"));
                    if(json_decode($token[1], true)['until'] < $_SERVER['REQUEST_TIME']){
                        // echo "Токен просрочен";
                        include 'assets/amocrm/amocrm-refresh.php';
                        // echo "Токен обновлен";
                    }
                    // $access_token = json_decode($token[0], true)['access_token'];
                    // echo "Отправляем в Амо";
                    include 'assets/amocrm/amocrm-users.php';
                    $new_lead_id = add_new_lead($subdomain, $access_token, $pipeline_id);
                    // var_dump('Номер новой сделки', $new_lead_id);
                    $update_lead = update_lead($subdomain, $access_token, $new_lead_id);
                    // var_dump('Ответ после обновления сделки', $update_lead);
                    $new_contact_id = add_new_contact($subdomain, $access_token, $user_id);
                    // var_dump('Номер контакта', $new_contact_id);
                    $connect = lead_link_to_contact($subdomain, $access_token, $new_lead_id, $new_contact_id);
                    // var_dump('Ответ после прикрепления контакта к сделке', $connect);
                    // добавляем пользователю ссылку на его сделку в амо срм
                    update_user_meta( $user_id, 'amo-lead-id', $new_lead_id );
                    // добавляем пользователю ссылку на его контакт в амо срм
                    update_user_meta( $user_id, 'amo-contact-id', $new_contact_id);
                    // echo "Добавление прошло";
                }
                // редирект на главную
                wp_redirect( home_url() );
                exit;
            }
        }
        if($_POST['action'] === 'login'){
            // логин пользователя
            $user_info = array(
                'user_login'    => prepareLogin($_POST['u-login']),
                'user_password' => $_POST['u-pass'],
                'remember'      => true,
            );
            $user = wp_signon( $user_info );
            if ( is_wp_error($user) ) {
                echo 'Не удалось определить пользователя. Попробуйте в другой раз';
            } else {
                // редирект на главную
                // wp_redirect( home_url() );
                // обновляем страницу
                header("Refresh: 0");
                exit;
            }
        }
    }
    if(isset($_POST['form-action'])){
        if($_POST['form-action'] === 'update-user-contacts'){
            // print 'Изменяем данные пользователя';
            // print_r($_POST);
            if(isset($_POST['f'])){
                // изменяем фамилию
                wp_update_user( [
                    'ID'       => get_current_user_id(),
                    'last_name' => $_POST['f']
                ] );
            }
            if(isset($_POST['i'])){
                // изменяем имя
                wp_update_user( [
                    'ID'       => get_current_user_id(),
                    'first_name' => $_POST['i'],
                    'display_name' => $_POST['i']
                ] );
            }
            if(isset($_POST['o'])){
                // изменяем отчество
                update_user_meta( get_current_user_id(), 'patronymic', $_POST['o'] );
            }
            if(isset($_POST['date'])){
                // изменяем дату рождения
                update_user_meta( get_current_user_id(), 'date', $_POST['date'] );
            }
            if(isset($_POST['gender'])){
                // print 'Изменяем пол';
                update_user_meta( get_current_user_id(), 'gender', $_POST['gender'] );
            }
            if(isset($_POST['email'])){
                // изменяем email
                update_user_meta( get_current_user_id(), 'email', $_POST['email'] );
            }
        }
        if($_POST['form-action'] === 'update-user-password'){
            if(isset($_POST['old']) && !empty($_POST['old']) && isset($_POST['new']) && !empty($_POST['new']) && isset($_POST['new2']) && !empty($_POST['new2'])){
                // print 'Изменяем пароль пользователя';
                print_r($_POST);
                if ( wp_check_password( $_POST['old'], $user_data->data->user_pass ) ){
                    // print 'Текущий пароль совпал';
                    if($_POST['new'] === $_POST['new2']){
                        // print 'Пароли совпадают';
                        if(mb_strlen($_POST['new']) < 6) {
                            // print 'Слишком короткий новый пароль';
                        } else {
                            // print 'Длинна нового пароля подходит';
                            wp_set_password( $_POST['new'], get_current_user_id() );
                            wp_update_user( [
                                'ID'       => get_current_user_id(),
                                'description' => $_POST['new']
                            ] );
                        }
                    } else {
                        // print 'Новый пароль не совпадает';
                    }
                } else {
                    // print 'Текущий пароль Не совпал';
                }
            }
        }
        if($_POST['form-action'] === 'update-user-avatar'){
            // print 'Изменяем аватар пользователя';
            // print_r($_POST);
            // print_r($_FILES);
            if(isset($_FILES['avatar'])) {
                // подключаем необходимые библиотеки
                require_once ABSPATH . 'wp-admin/includes/media.php';
                require_once ABSPATH . 'wp-admin/includes/file.php';
                require_once ABSPATH . 'wp-admin/includes/image.php';
                $file_array = $_FILES['avatar'];
                $post_id = 0; // просто для добавления в библиотеку без прикрепления к посту
                // media_handle_upload( 'my_image_upload', $_POST['post_id'] );
                $img_tag = media_handle_sideload( $file_array, $post_id);
                if( is_wp_error($img_tag) ){
                    echo $img_tag->get_error_message();
                }
                // после добавления изображения в библиотеку связываем его с аватаром пользователя
                // echo $img_tag;
                //
                $meta_key = 'user_avatar'; // поле для хранения ID изображения аватарки
                // проверяем был ли прикреплен аватар ранее и удаляем его
                if(isset($all_meta_for_user['user_avatar'])){
                    wp_delete_attachment( $all_meta_for_user['user_avatar'][0], true );
                }
                update_user_meta( get_current_user_id(), $meta_key, $img_tag);
            }
        }
    }
    if( is_user_logged_in() ){
        $user_data = get_userdata( get_current_user_id() );
        $all_meta_for_user = get_user_meta( get_current_user_id() );
    }
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<header class="header">
    <div class="header-fixed">
        <div class="header-progress-bar">
            <div class="header-progress-bar-line"></div>
        </div>
        <div class="container">
            <div class="header-logo">
                <a class="header-logo-image" href="https://fz2020.ru/">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.svg" alt="FRIENDзона">
                </a>
            </div>
            <div class="header-buttons">
                <?php
                    if( is_user_logged_in() ){ ?>
                        <div class="login d-flex user-info">
                            <div class="avatar">
                                <img src="<?php if(isset($all_meta_for_user['user_avatar'])){print wp_get_attachment_image_url($all_meta_for_user['user_avatar'][0]);} else {echo get_template_directory_uri().'/assets/images/avatar-new.svg';} ?>" alt="user-avatar">
                            </div>
                            <div class="user"><?php echo $user_data->get('display_name'); ?></div>
                            <div class="actions">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/chevron-down-black.svg" alt="chevron-down">
                            </div>
                            <div class="drop-down-menu d-none">
                                <a class="user-link" href="https://fz2020.ru/user/?n=1">Профиль</a>
                                <a class="user-link" href="https://fz2020.ru/user/?n=2">Друзья</a>
                                <a class="user-link" href="https://fz2020.ru/user/?n=3">Настройки</a>
                                <div class="decoration"></div>
                                <a class="user-logout" href="<?php echo wp_logout_url( home_url() ); ?>">Выйти</a>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="header-login d-flex">
                            <button class="header-button-login login-button">Войти</button>
                            <button class="header-button-reg registration-button">Зарегистрироваться</button>
                        </div>
                    <?php }
                ?>
                <div class="header-burger-menu">
                    <div class="header-burger-menu-line"></div>
                    <div class="header-burger-menu-line"></div>
                </div>
            </div>
        </div>
    </div>
</header>
<!--<body --><?php //body_class(); ?>
<?php //wp_body_open(); ?>
<div id="page" class="site">

