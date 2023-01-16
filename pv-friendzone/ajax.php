<?php
/*
Template Name: ByNextPr - User Actions
*/
?>
<?php
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

function gen_password($length = 6)
{
    $password = '';
    $arr = array(
        'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
        'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
        '1', '2', '3', '4', '5', '6', '7', '8', '9', '0'
    );
    for ($i = 0; $i < $length; $i++) {
        $password .= $arr[random_int(0, count($arr) - 1)];
    }
    return $password;
}

function send_password($tel, $pass)
{
    require_once 'assets/smsru_php/sms.ru.php';
    $smsru = new SMSRU(''); // Ваш уникальный программный ключ, который можно получить на главной странице
    $data = new stdClass();
    $data->to = $tel;
    $data->text = $pass; // Текст сообщения
    $data->from = 'PERESVET'; // Если у вас уже одобрен буквенный отправитель, его можно указать здесь, в противном случае будет использоваться ваш отправитель по умолчанию
    $sms = $smsru->send_one($data); // Отправка сообщения и возврат данных в переменную
    if ($sms->status == "OK") { // Запрос выполнен успешно
    } else {
    }
}

if (isset($_POST)) {
    $response['post'] = $_POST;
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'registration') {
            $response['action'] = 'registration';
            if (isset($_POST['tel'])) {
                $tel = prepareLogin($_POST['tel']);
                if (mb_strlen($tel) == 11) {
                    if (username_exists($tel)) {
                        $response['message'] = 'Номер телефона занят';
                        $response['result'] = 'error';
                        echo json_encode($response, JSON_UNESCAPED_UNICODE);
                    } else {
                        $pass = gen_password();
                        send_password($tel, $pass);
                        $userdata = array(
                            'user_login' => $tel,
                            'user_pass' => $pass,
                        );
                        $user_id = wp_insert_user($userdata);
                        if (!is_wp_error($user_id)) {
                            $response['message'] = 'Номер телефона свободен';
                            $response['result'] = 'ok';
                            $response['pass'] = $pass;
                            echo json_encode($response, JSON_UNESCAPED_UNICODE);
                        }
                    }
                }
            }
        }
        if ($_POST['action'] === 'code-check') {
            $response['action'] = 'code-check';
            if (isset($_POST['tel']) && isset($_POST['code'])) {
                // echo 'Сверяем пароли пользователя';
                $user = wp_authenticate(prepareLogin($_POST['tel']), $_POST['code']);
                if (is_wp_error($user)) {
                    $response['message'] = 'Не правильные данные';
                    $response['result'] = 'error';
                    $response['user'] = $user;
                    echo json_encode($response, JSON_UNESCAPED_UNICODE);
                } else {
                    $response['message'] = 'Данные совпадают';
                    $response['result'] = 'ok';
                    $response['user'] = $user;
                    echo json_encode($response, JSON_UNESCAPED_UNICODE);
                }
            } else {
                $response['message'] = 'Не достаточно данных';
                echo json_encode($response, JSON_UNESCAPED_UNICODE);
            }
        }
        if ($_POST['action'] === 'user-login') {
            $response['action'] = 'user-login';
            $user = wp_authenticate(prepareLogin($_POST['u-tel']), $_POST['u-pass']);
            if (is_wp_error($user)) {
                $response['message'] = 'Неправильный логин или пароль';
                $response['result'] = 'error';
                $response['user'] = $user;
                echo json_encode($response, JSON_UNESCAPED_UNICODE);
            } else {
                $response['message'] = 'Данные пользователя совпали';
                $response['result'] = 'ok';
                $response['user'] = $user;
                echo json_encode($response, JSON_UNESCAPED_UNICODE);
            }
        }
        if ($_POST['action'] === 'send-restore-pass') {
            $response['action'] = 'send-restore-pass';
            if (isset($_POST['tel'])) {
                $tel = prepareLogin($_POST['tel']);
                if (mb_strlen($tel) == 11) {
                    if (username_exists($tel)) {
                        $pass = gen_password();
                        $user = get_user_by('login', $tel);
                        send_password($tel, $pass);
                        $userdata = array(
                            'ID' => $user->ID,
                            'user_pass' => $pass,
                            'description' => $pass,
                        );
                        $user_id = wp_update_user($userdata);
                        if (!is_wp_error($user_id)) {
                            $response['message'] = 'Пароль пользователя обновлен';
                            $response['result'] = 'ok';
                            $response['user_id'] = $user_id;
                            $response['pass'] = $pass;
                            echo json_encode($response, JSON_UNESCAPED_UNICODE);
                        } else {
                            $response['message'] = 'Не удалось обновить пароль для пользователя';
                            $response['result'] = 'error';
                            $response['user_id'] = $user_id;
                            $response['pass'] = $pass;
                            echo json_encode($response, JSON_UNESCAPED_UNICODE);
                        }
                    } else {
                        echo 'error';
                        $response['message'] = 'Данного номера телефона нет в базе - можно регистрировать нового пользователя';
                        $response['result'] = 'error';
                        echo json_encode($response, JSON_UNESCAPED_UNICODE);
                    }
                }
            }
        }
    }
} else {
    echo 'Запрос обрабатывается';
}
?>