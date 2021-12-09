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
// echo 'test';
$result = [];
// получаем данные со страницы интеграции
$amo_integration_page = get_page_by_title('Интеграция с АМО СРМ');
// include 'assets/amocrm/amocrm.php';
// $result['amo_crm'] = $amo_crm;
// include 'assets/amocrm/amocrm-users.php';
// include 'assets/amocrm/amocrm-refresh.php';
// $result['refresh_result'] = $refresh_result;
function prepareLogin($tel)
{
    $user_tel = $tel;
    $tel = '';
    for ($i = 0; $i < mb_strlen($user_tel); $i++) {
        // echo $user_tel[$i];
        if ($i == 0) {
            if ($user_tel[$i] === '+') {
                $tel .= 7;
                $i++;
            } elseif ($user_tel[$i] === '8') {
                $tel .= 7;
            } else {
                if (is_numeric($user_tel[$i])) {
                    $tel .= $user_tel[$i];
                }
            }
        } else {
            if (is_numeric($user_tel[$i])) {
                $tel .= $user_tel[$i];
            }
        }
    }
    return $tel;
}

if (isset($_POST['action'])) {
    $result['POST'] = $_POST;
    if ($_POST['action'] === 'registration') {
        // echo 'Регистрируем пользователя';
        $result[] = 'Регистрируем пользователя';
        // print_r($_POST);
        $user_info = array(
            'user_login' => prepareLogin($_POST['tel']),
            'user_password' => $_POST['code'],
            'remember' => true,
        );
        $user = wp_signon($user_info);
        // print_r($user);
        $result['user'] = $user;
        if (is_wp_error($user)) {
            // echo 'Не удалось найти зарегистрированного пользователя. Попробуйте в другой раз';
            $result[] = 'Не удалось найти зарегистрированного пользователя. Попробуйте в другой раз';
        } else {
            // echo 'Пользователь успешно зарегистрирован';
            // echo 'Добавляем все данные к пользователю';
            $result[] = 'Пользователь успешно зарегистрирован';
            $result[] = 'Добавляем все данные к пользователю';
            // echo 'ID нового пользователя: '.$user->data->ID;
            $user_id = $user->data->ID;
            $result['user_id'] = $user_id;
            // wp_update_user( [ 'ID' => $user_id, 'description' => $_POST['code'] ] );
            if (isset($_POST['fio'])) {
                $result[] = 'добавляем ФИО';
                wp_update_user(['ID' => $user_id, 'first_name' => $_POST['fio']]);
            }
            if (isset($_POST['city'])) {
                $result[] = 'добавляем город';
                wp_update_user(['ID' => $user_id, 'last_name' => $_POST['city']]);
            }
            if (isset($_POST['card'])) {
                $result[] = 'добавляем Номер карты клиента если есть';
                wp_update_user(['ID' => $user_id, 'description' => $_POST['card']]);
            }
//                if(isset($_POST['f'])) {
//                    $result[] = 'добавляем фамилию';
//                    wp_update_user( [ 'ID' => $user_id, 'last_name' => $_POST['f'] ] );
//                }
//                if(isset($_POST['i'])) {
//                    $result[] = 'добавляем имя';
//                    wp_update_user( [ 'ID' => $user_id, 'first_name' => $_POST['i'], 'display_name' => $_POST['i'], 'nickname' => $_POST['i'] ] );
//                }
            $result[] = 'Подготовка данных к добавлению в АМО СРМ';
            if ($amo_integration_page === null) {
                $result[] = "Делаем новую интеграцию";
                include 'assets/amocrm/amocrm.php';
                $result['amo_crm'] = $amo_crm;
            } else {
                $result[] = "Используем имеющийся токен";
                $content = $amo_integration_page->post_content;
                $content = mb_substr($content, mb_strpos($content, '{'), mb_strpos($content, '}') - mb_strpos($content, '{') + 1);
                $content = json_decode($content);

                // $token = explode("/", file_get_contents("wp-content/themes/pv-friendzone/assets/amocrm/amointegrationapi.json"));

                // if (json_decode($token[1], true)['until'] < $_SERVER['REQUEST_TIME']) {
                if ($content->token_expires < $_SERVER['REQUEST_TIME']) {
                    $result[] = "Токен просрочен";
                    include 'assets/amocrm/amocrm-refresh.php';
                    $result['refresh_result'] = $refresh_result;
                    $result[] = "Токен обновлен";
                }
                $result['access_token'] = $content->access_token;
                $result[] = "Отправляем в Амо";
                include 'assets/amocrm/amocrm-users.php';
                $result[] = "Создаем новую сделку";
                $new_lead_id = add_new_lead($content->domain, $content->access_token, $content->pipeline_id, $_POST['city'], $_POST['card']);
                $result[] = "Номер новой сделки new_lead_id";
                $result['new_lead_id'] = $new_lead_id;
                // var_dump('Номер новой сделки', $new_lead_id);
                $result[] = "Обновляем наименование сделки по new_lead_id";
                $update_lead = update_lead($content->domain, $content->access_token, $new_lead_id);
                $result[] = "Ответ после обновления сделки update_lead";
                $result['update_lead'] = $update_lead;
                // var_dump('Ответ после обновления сделки', $update_lead);
                $new_contact_id = add_new_contact($content->domain, $content->access_token, $user_id);
                $result[] = "Номер контакта new_contact_id";
                $result['new_contact_id'] = $new_contact_id;
                // var_dump('Номер контакта', $new_contact_id);
                $connect = lead_link_to_contact($content->domain, $content->access_token, $new_lead_id, $result['new_contact_id']['id']);
                $result[] = "Ответ после прикрепления контакта к сделке connect";
                $result['connect'] = $connect;
                // var_dump('Ответ после прикрепления контакта к сделке', $connect);
                $result[] = 'добавляем пользователю ссылку на его сделку в амо срм';
                update_user_meta($user_id, 'amo-lead-id', $new_lead_id);
                $result[] = 'добавляем пользователю ссылку на его контакт в амо срм';
                update_user_meta($user_id, 'amo-contact-id', $result['new_contact_id']['id']);
                $result[] = "Добавление прошло";
            }
            $result[] = 'Редирект на главную';
            wp_redirect(home_url());
            // var_dump($result);
            exit;
        }
    }
    if ($_POST['action'] === 'login') {
        // логин пользователя
        $user_info = array(
            'user_login' => prepareLogin($_POST['u-login']),
            'user_password' => $_POST['u-pass'],
            'remember' => true,
        );
        $user = wp_signon($user_info);
        if (is_wp_error($user)) {
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
if (isset($_POST['form-action'])) {
    $result['POST'] = $_POST;
    if ($_POST['form-action'] === 'update-user-contacts') {
        // print 'Изменяем данные пользователя';
//        if (isset($_POST['f'])) {
//            // изменяем фамилию
//            wp_update_user([
//                'ID' => get_current_user_id(),
//                'last_name' => $_POST['f']
//            ]);
//        }
        if (isset($_POST['fio'])) {
            // изменяем ФИО
            wp_update_user([
                'ID' => get_current_user_id(),
                'first_name' => $_POST['fio']
            ]);
        }
        if (isset($_POST['city'])) {
            // изменяем город
            wp_update_user([
                'ID' => get_current_user_id(),
                'last_name' => $_POST['city']
            ]);
        }
//        if (isset($_POST['i'])) {
//            // изменяем имя
//            wp_update_user([
//                'ID' => get_current_user_id(),
//                'first_name' => $_POST['i'],
//                'display_name' => $_POST['i']
//            ]);
//        }
//        if (isset($_POST['o'])) {
//            // изменяем отчество
//            update_user_meta(get_current_user_id(), 'patronymic', $_POST['o']);
//        }
        if (isset($_POST['date'])) {
            // изменяем дату рождения
            update_user_meta(get_current_user_id(), 'date', $_POST['date']);
        }
        if (isset($_POST['gender'])) {
            // print 'Изменяем пол';
            update_user_meta(get_current_user_id(), 'gender', $_POST['gender']);
        }
        if (isset($_POST['email'])) {
            // изменяем email
            update_user_meta(get_current_user_id(), 'email', $_POST['email']);
        }
    }
    if ($_POST['form-action'] === 'update-user-password') {
        if (isset($_POST['old']) && !empty($_POST['old']) && isset($_POST['new']) && !empty($_POST['new']) && isset($_POST['new2']) && !empty($_POST['new2'])) {
            // print 'Изменяем пароль пользователя';
            if (wp_check_password($_POST['old'], $user_data->data->user_pass)) {
                // print 'Текущий пароль совпал';
                if ($_POST['new'] === $_POST['new2']) {
                    // print 'Пароли совпадают';
                    if (mb_strlen($_POST['new']) < 6) {
                        // print 'Слишком короткий новый пароль';
                    } else {
                        // print 'Длинна нового пароля подходит';
                        wp_set_password($_POST['new'], get_current_user_id());
                        wp_update_user([
                            'ID' => get_current_user_id(),
                            'description' => $_POST['new']
                        ]);
                    }
                } else {
                    // print 'Новый пароль не совпадает';
                }
            } else {
                // print 'Текущий пароль Не совпал';
            }
        }
    }
    if ($_POST['form-action'] === 'update-user-avatar') {
        // print 'Изменяем аватар пользователя';
        // print_r($_FILES);
        if (isset($_FILES['avatar'])) {
            // подключаем необходимые библиотеки
            require_once ABSPATH . 'wp-admin/includes/media.php';
            require_once ABSPATH . 'wp-admin/includes/file.php';
            require_once ABSPATH . 'wp-admin/includes/image.php';
            $file_array = $_FILES['avatar'];
            $post_id = 0; // просто для добавления в библиотеку без прикрепления к посту
            // media_handle_upload( 'my_image_upload', $_POST['post_id'] );
            $img_tag = media_handle_sideload($file_array, $post_id);
            if (is_wp_error($img_tag)) {
                echo $img_tag->get_error_message();
            }
            // после добавления изображения в библиотеку связываем его с аватаром пользователя
            // echo $img_tag;
            //
            $meta_key = 'user_avatar'; // поле для хранения ID изображения аватарки
            // проверяем был ли прикреплен аватар ранее и удаляем его
            if (isset($all_meta_for_user['user_avatar'])) {
                wp_delete_attachment($all_meta_for_user['user_avatar'][0], true);
            }
            update_user_meta(get_current_user_id(), $meta_key, $img_tag);
        }
    }
}
if (is_user_logged_in()) {
    $user_data = get_userdata(get_current_user_id());
    // $result['user_data'] = $user_data;
    $all_meta_for_user = get_user_meta(get_current_user_id());
    $result['all_meta_for_user'] = $all_meta_for_user;
}
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <?php wp_head(); ?>
</head>

<header class="header">
    <div class="d-none">
        <?php
        // print_r($result);
        if ($amo_integration_page === null) {
            echo "Страница не найдена";
        } else {
            $user_data = get_userdata(get_current_user_id());
            // var_dump($user_data);
            $content = $amo_integration_page->post_content;
            $content = mb_substr($content, mb_strpos($content, '{'), mb_strpos($content, '}') - mb_strpos($content, '{') + 1);
            $content = json_decode($content);
            // var_dump('AMO CRM', $content);
            include 'assets/amocrm/amocrm-users.php';
            // получаем коллекцию всех сделок
            // $all_leads = get_all_linked_leads($content->domain, $content->access_token, $all_meta_for_user['amo-lead-id'][0]);
            // echo '<br>Всего сделок: ' . count($all_leads['_embedded']['leads']). '<br>';
            // var_dump('$all_leads_embeddedleads', $all_leads['_embedded']['leads']);
//            $user_connected_leads_id = [];
//            foreach ($all_leads['_embedded']['leads'] as $lead) {
//                // print_r($lead['name']);
//                if($lead['id'] != $all_meta_for_user['amo-lead-id'][0]){
//                    $user_connected_leads_id[] = $lead['id'];
//                }
//            }
//            var_dump('Всего прикрепленных сделок:', $user_connected_leads_id);
            // $pipeline_id = 1974898;
            // echo '$pipeline_id '. $pipeline_id;
            // $city = "Красноярск";
            // echo '$city '. $city;
//            $add_ntl = add_new_lead($content->domain, $content->access_token, $pipeline_id, $city);
//            var_dump('$add_ntl', $add_ntl);
            // $test = check_account($content->domain, $content->access_token);
            // var_dump('check_account', $test);
            // $leads = get_all_leads($content->domain, $content->access_token);
            // var_dump('get_all_leads', $leads);
            // foreach ($leads['_embedded']['leads'] as $lead) {
            //     echo "id: " . $lead['id'] . " имя: " . $lead['name'] . "<br>";
            // }
            // получаем дополнительные поля
            // leads|contacts|companies|customers
            $gcf = get_custom_fields($content->domain, $content->access_token, 'leads');
            var_dump('get_custom_field_by_id', $gcf);
            foreach ($gcf['_embedded']['custom_fields'] as $field) {
                echo '<br>';
                print_r($field['name']);
            }

            // посмотреть доступные тэги
            // leads|contacts|companies|customers
//            $tags = get_all_tags($content->domain, $content->access_token, 'leads');
//            foreach ($tags['_embedded']['tags'] as $tag) {
//                echo "<br>";
//                print_r($tag);
//            }


            // $new_lead_id = 21367677;
//            $new_lead_id = 21368073;
//            $lead = get_lead_by_id($content->domain, $content->access_token, $new_lead_id);
//            var_dump('get_lead_by_id', $lead);
            // $cc = contact_custom_fields($content->domain, $content->access_token);
            // var_dump('contact_custom_fields', $cc);
            // $new_contact = add_new_contact($content->domain, $content->access_token, $user_data->ID);
            // $new_contact_id = 26670382;
            // var_dump('add_new_contact', $new_contact_id);
            // $allc = get_all_contacts($content->domain, $content->access_token);
            // var_dump('get_all_contacts', $allc);
            // print_r($allc['_embedded']['contacts']);
//            foreach ($allc['_embedded']['contacts'] as $contact) {
//                echo "id: " . $contact['id'] . " имя: " . $contact['name'] . " first_name: " . $contact['first_name'] . "<br>";
//            }
            // $ci = get_contact_by_id($content->domain, $content->access_token, $new_contact_id);
            // var_dump('get_contact_by_id', $ci);
            // leads|contacts|companies|customers
            // $ll = get_entity_links($content->domain, $content->access_token, 'leads', $new_lead_id);
            // var_dump('get_entity_links', $ll);
        }
        ?>
    </div>
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
                if (is_user_logged_in()) { ?>
                    <div class="login d-flex user-info">
                        <div class="avatar">
                            <img src="<?php if (isset($all_meta_for_user['user_avatar'])) {
                                print wp_get_attachment_image_url($all_meta_for_user['user_avatar'][0]);
                            } else {
                                echo get_template_directory_uri() . '/assets/images/avatar-new.svg';
                            } ?>" alt="user-avatar">
                        </div>
                        <div class="user"><?php if (isset($user_data)) {
                                echo $user_data->get('display_name');
                            } ?></div>
                        <div class="actions">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/chevron-down-black.svg"
                                 alt="chevron-down">
                        </div>
                        <div class="drop-down-menu d-none">
                            <a class="user-link" href="https://fz2020.ru/user/?n=1">Профиль</a>
                            <a class="user-link" href="https://fz2020.ru/user/?n=2">Друзья</a>
                            <a class="user-link" href="https://fz2020.ru/user/?n=3">Настройки</a>
                            <div class="decoration"></div>
                            <a class="user-logout" href="<?php echo wp_logout_url(home_url()); ?>">Выйти</a>
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

