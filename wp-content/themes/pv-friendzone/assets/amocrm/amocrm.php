<?php
    $subdomain = 'adminailikeru'; //Поддомен нужного аккаунта - как в амосрм
    $link = 'https://' . $subdomain . '.amocrm.ru/oauth2/access_token'; //Формируем URL для запроса
    /** Соберем данные для запроса */
    $data = [
        'client_id' => 'cfe3acdd-3c80-434d-a10b-d6a0d5a791c4',
        'client_secret' => 'pJVSMtOiA0yI0CQgcyuUaNiBL9oVouP0nlvCCTU1c7lTiXZYFaV2NXf8uiwa3xfK',
        'grant_type' => 'authorization_code',
        'code' => 'def502005f1e961e154e64fc9340a76669e67bd17efa752db63d8ba787cd8d993024ec0c5ff96ad79ce9939d80e584730f8dacca26d76fad029a772b3f6ae6d379cda4455d54362ca7fade908616fb1a3c00ee5191d1c03ad5e20238112929a3f69ca3dbda6f2420ff588b18a15b1bc6650b998fa99281c510b6498413fd687b1ac5cfed7919ffc2925c51cd47d905d7f5828bfd71de79d8aef90cad9b3d08151ce041ff4b9ce94ef5f93cd7ab24b67ac32962a2e2e364feaa1f5e962595c3e83260bcc0f5415f5bab8a0ff57d939ec5345a73f222888c1df47b0d232ded153acedf44738ffa44cffae2688e24f00ee711c2d13a2c26a21f4e5254de3093c61801b953041979b9215776f3932f128e63360dbea33c0827cc64d0f12dcc6920207d1a8240f9b3ae355e34a813c6ff651cd3cfe23bcc2153dc1174b398d7d1a37c2365859fd9ae4e8db67b60f525ed2e74e8034d3464351b322543193f855af3491c20b2ef12e102845c5141b0578a92f9198c8a175f4b08725b96d20fc94f0c64de2467f9fff2f79cafbf84eb284631002bd14c554bbf34acddbe287d36ae9e248ac8f8490095e02f6f0b4e0918f10ce03043b369a42d87a66b41a1cc973d',
        'redirect_uri' => 'http://bynextpr.ru/',
    ];

    /**
     * Нам необходимо инициировать запрос к серверу.
     * Воспользуемся библиотекой cURL (поставляется в составе PHP).
     * Вы также можете использовать и кроссплатформенную программу cURL, если вы не программируете на PHP.
     */
    $curl = curl_init(); //Сохраняем дескриптор сеанса cURL
    /** Устанавливаем необходимые опции для сеанса cURL  */
    curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
    curl_setopt($curl,CURLOPT_URL, $link);
    curl_setopt($curl,CURLOPT_HTTPHEADER,['Content-Type:application/json']);
    curl_setopt($curl,CURLOPT_HEADER, false);
    curl_setopt($curl,CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($curl,CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 2);
    $out = curl_exec($curl); //Инициируем запрос к API и сохраняем ответ в переменную
    $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    /** Теперь мы можем обработать ответ, полученный от сервера. Это пример. Вы можете обработать данные своим способом. */
    $code = (int)$code;
    $errors = [
        400 => 'Bad request',
        401 => 'Unauthorized',
        403 => 'Forbidden',
        404 => 'Not found',
        500 => 'Internal server error',
        502 => 'Bad gateway',
        503 => 'Service unavailable',
    ];

    try
    {
        /** Если код ответа не успешный - возвращаем сообщение об ошибке  */
        if ($code < 200 || $code > 204) {
            throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undefined error', $code);
        }
    }
    catch(\Exception $e)
    {
        echo $out;
        die('Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode());
    }
    // сохраняем ответ от сервера в файл.
    $addtofile = $out.'/{"until":'. ($_SERVER['REQUEST_TIME'] + 86400) .'}';
    $handle = fopen("wp-content/themes/friendzone/assets/amocrm/amointegrationapi.json", "a");
    fwrite($handle, $addtofile);
    fclose($handle);
    // echo "Токен Получен";
?>
