<?php
/*
Template Name: ByNextPr - User Actions
*/
?>
<?php
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
    function gen_password($length = 6){
        $password = '';
        $arr = array(
            'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',
            'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
            '1','2','3','4','5','6','7','8','9','0'
        );
        for ($i = 0; $i < $length; $i++) {
            $password .= $arr[random_int(0, count($arr) - 1)];
        }
        return $password;
    }
    function send_password($tel, $pass){
        require_once 'assets/smsru_php/sms.ru.php';
        $smsru = new SMSRU('7C452DB3-6DDA-D66B-F068-F1332632E48B'); // Ваш уникальный программный ключ, который можно получить на главной странице
        $data = new stdClass();
        $data->to = $tel;
        $data->text = $pass; // Текст сообщения
        $data->from = 'PERESVET'; // Если у вас уже одобрен буквенный отправитель, его можно указать здесь, в противном случае будет использоваться ваш отправитель по умолчанию
        $sms = $smsru->send_one($data); // Отправка сообщения и возврат данных в переменную
        // $sms = new stdClass();
        // $sms->status = "Test";
        if ($sms->status == "OK") { // Запрос выполнен успешно
            // echo $pass;
            // echo "Сообщение отправлено успешно. ";
            // echo "ID сообщения: $sms->sms_id. ";
            // echo "Ваш новый баланс: $sms->balance";
        } else {
            // echo "Сообщение не отправлено. Телефон: ".$tel." Пароль: ".$pass;
            // echo "Код ошибки: $sms->status_code. ";
            // echo "Текст ошибки: $sms->status_text.";
        }
    }
    if (isset($_POST)) {
        // print_r($_POST);
        if(isset($_POST['action'])){
            if($_POST['action'] === 'registration'){
                if(isset($_POST['tel'])) {
                    $tel = prepareLogin($_POST['tel']);
                    // echo $tel;
                    if(mb_strlen($tel) == 11) {
                        // echo 'подходит';
                        // проверяем наличие телефона в базе пользователей по номеру телефона
                        if ( username_exists( $tel ) ) {
                            // echo 'Номер телефона занят';
                            echo 'error';
                        } else {
                            // echo 'true';
                            // данного номера телефона нет в базе - можно регистрировать нового пользователя
                            // логин - номер телефона, пароль - генерируем
                            $pass = gen_password();
                            send_password($tel, $pass);
                            $userdata = array(
                                'user_login' => $tel,
                                'user_pass'  => $pass,
                                'description' => $pass,
                                // 'user_email' => $_POST['u-tel'].'@mail.ru',
                                // 'display_name'    => '*'.substr($_POST['u-tel'], -4),
                                // 'last_name'       => $_POST['u-tel'],
                                // 'nickname'        => '*'.substr($_POST['u-tel'], -4),
                            );
                            $user_id = wp_insert_user( $userdata );
                            if( ! is_wp_error( $user_id ) ) {
                                echo 'ok';
                                // echo $pass;
                            }
                        }
                    }
                }
            }
            if($_POST['action'] === 'code-check'){
                if(isset($_POST['tel']) && isset($_POST['code'])){
                    // echo 'Сверяем пароли пользователя';
                    $user = wp_authenticate( prepareLogin($_POST['tel']), $_POST['code'] );
                    if ( is_wp_error($user) ) {
                        // echo 'Не правильные данные';
                        // print_r($user);
                        echo 'error';
                    } else {
                        // echo 'Данные совпадают';
                        // print_r($user);
                        echo 'ok';
                    }
                } else {
                    echo 'Не достаточно данных';
                }
            }
            if($_POST['action'] === 'user-login'){
                // print_r($_POST);
                $user = wp_authenticate( prepareLogin($_POST['u-tel']), $_POST['u-pass'] );
                if ( is_wp_error($user) ) {
                    echo 'Неправильный логин или пароль';
                } else {
                    echo 'ok';
                }
            }
        }
    } else {
        echo 'Запрос обрабатывается';
    }
?>
