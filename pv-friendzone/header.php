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
$result = [];

if (is_user_logged_in()) {
    $user_data = get_userdata(get_current_user_id());
    $all_meta_for_user = get_user_meta(get_current_user_id());
    $result['all_meta_for_user'] = $all_meta_for_user;

    include 'assets/amocrm/amocrm-users.php';

    $amo_integration_page = get_page_by_title('Интеграция с АМО СРМ');
    $content = $amo_integration_page->post_content;
    $content = mb_substr($content, mb_strpos($content, '{'), mb_strpos($content, '}') - mb_strpos($content, '{') + 1);
    $content = json_decode($content);
    $result['amo-page-content'] = $content;

    if($content->access_token === null){
        $result[] = "Делаем новую интеграцию";
        $result['new_amo_integration_response'] = set_new_integration($content->domain, $content->client_id, $content->client_secret, $content->code);
        $result[] = "Интеграция прошла";
    }

    if ($content->token_expires < $_SERVER['REQUEST_TIME']) {
        $result[] = "Токен просрочен";
        $result['amo_refresh_token_response'] = amo_token_refresh($content->domain, $content->client_id, $content->client_secret, $content->refresh_token, $content->redirect_uri);
        $result[] = "Токен обновлен";
        $content = $amo_integration_page->post_content;
        $content = mb_substr($content, mb_strpos($content, '{'), mb_strpos($content, '}') - mb_strpos($content, '{') + 1);
        $content = json_decode($content);
    }
}

function prepareLogin($tel)
{
    $user_tel = $tel;
    $tel = '';
    for ($i = 0; $i < mb_strlen($user_tel); $i++) {
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
        $result[] = 'Регистрируем пользователя';
        $user_info = array(
            'user_login' => prepareLogin($_POST['tel']),
            'user_password' => $_POST['code'],
            'remember' => true,
        );
        $user = wp_signon($user_info);
        $result['user'] = $user;
        if (is_wp_error($user)) {
            $result[] = 'Не удалось найти зарегистрированного пользователя. Попробуйте в другой раз';
        } else {
            $result[] = 'Пользователь успешно зарегистрирован';
            $result[] = 'Добавляем все данные к пользователю';
            $user_id = $user->data->ID;
            $result['user_id'] = $user_id;
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
            $result[] = 'Подготовка данных к добавлению в АМО СРМ';

            include 'assets/amocrm/amocrm-users.php';

            $amo_integration_page = get_page_by_title('Интеграция с АМО СРМ');
            $content = $amo_integration_page->post_content;
            $content = mb_substr($content, mb_strpos($content, '{'), mb_strpos($content, '}') - mb_strpos($content, '{') + 1);
            $content = json_decode($content);
            $result['amo-page-content'] = $content;

            if($content->access_token === null){
                $result[] = "Делаем новую интеграцию";
                $result['new_amo_integration_response'] = set_new_integration($content->domain, $content->client_id, $content->client_secret, $content->code);
                $result[] = "Интеграция прошла";
            }

            if ($content->token_expires < $_SERVER['REQUEST_TIME']) {
                $result[] = "Токен просрочен";
                $result['amo_refresh_token_response'] = amo_token_refresh($content->domain, $content->client_id, $content->client_secret, $content->refresh_token, $content->redirect_uri);
                $result[] = "Токен обновлен";
                $content = $amo_integration_page->post_content;
                $content = mb_substr($content, mb_strpos($content, '{'), mb_strpos($content, '}') - mb_strpos($content, '{') + 1);
                $content = json_decode($content);
            }

            if ($content->access_token !== null) {
                $result[] = "Используем имеющийся токен";
                $result['access_token'] = $content->access_token;
                $result[] = "Создаем новую сделку";
                $new_lead_id = add_new_lead($content->domain, $content->access_token, $content->pipeline_id, $_POST['city'], $_POST['card']);
                $result[] = "Номер новой сделки new_lead_id";
                $result['new_lead_id'] = $new_lead_id;

                $result[] = "Обновляем наименование сделки по new_lead_id";
                $update_lead = update_lead($content->domain, $content->access_token, $new_lead_id);
                $result[] = "Ответ после обновления сделки update_lead";
                $result['update_lead'] = $update_lead;

                $result[] = "Создаем новый контакт";
                $new_contact_id = add_new_contact($content->domain, $content->access_token, $user_id);
                $result[] = "Номер контакта new_contact_id";
                $result['new_contact_id'] = $new_contact_id;

                $result[] = "Добавляем номер контакта к сделке";
                $connect = lead_link_to_contact($content->domain, $content->access_token, $new_lead_id, $result['new_contact_id']['id']);
                $result[] = "Ответ после прикрепления контакта к сделке - connect";
                $result['connect'] = $connect;

                $result[] = 'добавляем пользователю ссылку на его сделку в амо срм';
                update_user_meta($user_id, 'amo-lead-id', $new_lead_id);
                $result[] = 'добавляем пользователю ссылку на его контакт в амо срм';
                update_user_meta($user_id, 'amo-contact-id', $result['new_contact_id']['id']);
                $result[] = "Добавление прошло";

                $result[] = 'Редирект на главную';
                wp_redirect(home_url());
                exit;
            }
        }
    }
    if ($_POST['action'] === 'login') {
        $user_info = array(
            'user_login' => prepareLogin($_POST['u-login']),
            'user_password' => $_POST['u-pass'],
            'remember' => true,
        );
        $user = wp_signon($user_info);
        if (is_wp_error($user)) {
            echo 'Не удалось определить пользователя. Попробуйте в другой раз';
        } else {
            header("Refresh: 0");
            exit;
        }
    }
    if ($_POST['action'] === 'send-message') {
        if (isset($_POST['user-login'])) {
            $u_login = $_POST['user-login'];
        }
        if (isset($_POST['user-email'])) {
            $u_email = $_POST['user-email'];
        }
        if (isset($_POST['user-question'])) {
            $u_question = $_POST['user-question'];
        }
        if (isset($u_login) && isset($u_email) && isset($u_question)) {
            $to = 'fz2020@pv-real.ru';
            $copy = 'boriscom@mail.ru';
            $subject = 'Вопрос с сайта fz2020.ru';
            $message = 'Логин: ' . $u_login . ' Почта: ' . $u_email . ' Вопрос:' . $u_question;
            $headers = array(
                'From' => 'admin@fz2020.ru',
                'Reply-To' => $u_email,
                'X-Mailer' => 'PHP/' . phpversion()
            );
            $mail = mail($to, $subject, $message);
        }
    }
    if ($_POST['action'] === 'get-money') {
        $result[] = "Запрос с формы вывода денежных средств";
        $result['POST_request'] = $_POST;
        if (!isset($all_meta_for_user['amo-lead-id'])) {
            $result[] = "Невозможно получить номер сделки пользователя";
        }
        $lead_id = $all_meta_for_user['amo-lead-id'][0];
        $result['user_lead_id'] =  $lead_id;
        $user_summ = add_money_request_to_lead($content->domain, $content->access_token, $lead_id, $_POST['u-summ']);
        $result['user_summ'] = $user_summ;
    }
}
if (isset($_POST['form-action'])) {
    $result['POST_request'] = $_POST;
    if ($_POST['form-action'] === 'update-user-contacts') {
        if (isset($_POST['fio'])) {
            wp_update_user([
                'ID' => get_current_user_id(),
                'first_name' => $_POST['fio']
            ]);
        }
        if (isset($_POST['city'])) {
            wp_update_user([
                'ID' => get_current_user_id(),
                'last_name' => $_POST['city']
            ]);
        }
        if (isset($_POST['date'])) {
            $result[] =  "изменяем дату рождения";
            update_user_meta(get_current_user_id(), 'date', $_POST['date']);
            $contact_id = $all_meta_for_user['amo-contact-id'][0];
            $result['user_contact_id'] = $contact_id;
            $user_birthday_timestamp = strtotime($_POST['date']);
            $result['user_birthday_timestamp'] =  $user_birthday_timestamp;
            $add_birthday = set_user_birthday($content->domain, $content->access_token, $contact_id, $user_birthday_timestamp);
            $result['add_birthday'] =  $add_birthday;
        }
        if (isset($_POST['gender'])) {
            update_user_meta(get_current_user_id(), 'gender', $_POST['gender']);
        }
        if (isset($_POST['email'])) {
            update_user_meta(get_current_user_id(), 'email', $_POST['email']);
        }
    }
    if ($_POST['form-action'] === 'update-user-password') {
        if (isset($_POST['old']) && !empty($_POST['old']) && isset($_POST['new']) && !empty($_POST['new']) && isset($_POST['new2']) && !empty($_POST['new2'])) {
            if (wp_check_password($_POST['old'], $user_data->data->user_pass)) {
                if ($_POST['new'] === $_POST['new2']) {
                    if (mb_strlen($_POST['new']) < 6) {
                    } else {
                        wp_set_password($_POST['new'], get_current_user_id());
                        wp_update_user([
                            'ID' => get_current_user_id(),
                            'description' => $_POST['new']
                        ]);
                    }
                }
            }
        }
    }
    if ($_POST['form-action'] === 'update-user-avatar') {

        if (isset($_FILES['avatar'])) {
            require_once ABSPATH . 'wp-admin/includes/media.php';
            require_once ABSPATH . 'wp-admin/includes/file.php';
            require_once ABSPATH . 'wp-admin/includes/image.php';
            $file_array = $_FILES['avatar'];
            $post_id = 0;
            // media_handle_upload( 'my_image_upload', $_POST['post_id'] );
            $img_tag = media_handle_sideload($file_array, $post_id);
            if (is_wp_error($img_tag)) {
                echo $img_tag->get_error_message();
            }

            $meta_key = 'user_avatar';
            if (isset($all_meta_for_user['user_avatar'])) {
                wp_delete_attachment($all_meta_for_user['user_avatar'][0], true);
            }
            update_user_meta(get_current_user_id(), $meta_key, $img_tag);
        }
    }
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
        if (!is_user_logged_in()) {
            echo "Пользователь не определен";
        } else {
            print_r($result);
         }
        ?>
    </div>
    <div class="header-fixed">
        <div class="header-progress-bar">
            <div class="header-progress-bar-line"></div>
        </div>
        <div class="container">
            <div class="header-logo">
                <div class="header-logo-image">
                    <a class="image-1" href="https://fz2020.ru/">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logos/logo_friendzona-01.svg" alt="FRIENDзона">
                    </a>
                    <div class="decoration"></div>
                    <a class="image-2" href="https://pv-real.ru/" target="_blank">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logos/peresvet.svg" alt="FRIENDзона">
                    </a>
                </div>
            </div>
            <div class="header-buttons">
                <?php
                if (is_user_logged_in()) { ?>
                    <div class="login d-flex user-info">
                        <div class="avatar">
                            <img src="<?php if (isset($all_meta_for_user['user_avatar'])) {
                                print wp_get_attachment_image_url($all_meta_for_user['user_avatar'][0]);
                            } else {
                                echo get_template_directory_uri() . '/assets/images/avatar-new-grey.svg';
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

