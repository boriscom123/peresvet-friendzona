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
    function prepareLogin($tel){
        $user_tel = $tel;
        $tel = '';
        for($i=0; $i<mb_strlen($user_tel); $i++){
            // echo $user_tel[$i];
            if(is_numeric($user_tel[$i])) {
                $tel .= $user_tel[$i];
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
                echo 'Не удалось зарегистрировать пользователя. Попробуйте в другой раз';
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
    if( is_user_logged_in() ){
        $user_data = get_userdata( get_current_user_id() );
        $avatar = get_avatar_url( get_current_user_id() );
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
                <a class="header-logo-image" href="http://bynextpr.ru/">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.svg" alt="FRIENDзона">
                </a>
            </div>
            <div class="header-buttons">
                <?php
                    if( is_user_logged_in() ){ ?>
                        <div class="login d-flex user-info">
                            <div class="avatar">
                                <img src="<?php echo $avatar; ?>" alt="user-avatar">
                            </div>
                            <div class="user"><?php echo $user_data->get('display_name'); ?></div>
                            <div class="actions">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/chevron-down-black.svg" alt="chevron-down">
                            </div>
                            <div class="drop-down-menu d-none">
                                <a class="user-link" href="http://bynextpr.ru/user/?n=1">Профиль</a>
                                <a class="user-link" href="http://bynextpr.ru/user/?n=2">Друзья</a>
                                <a class="user-link" href="http://bynextpr.ru/user/?n=3">Настройки</a>
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

