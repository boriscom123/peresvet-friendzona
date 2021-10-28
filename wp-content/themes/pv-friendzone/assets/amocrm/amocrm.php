<?php
    echo "Настройки интеграции";
    $subdomain = 'zakirov'; //Поддомен нужного аккаунта - как в амосрм
    $link = 'https://' . $subdomain . '.amocrm.ru/oauth2/access_token'; //Формируем URL для запроса
    /** Соберем данные для запроса */
    $data = [
        'client_id' => 'ad57c5dd-f50a-4649-a6f3-1e1fc44480bd',
        'client_secret' => 'Hd0bYwVgDLFY850AAqo8bCshZgWOCVJLN0iD8E1gEB05UCxkgJ6t9PAh7n4BTiSW',
        'grant_type' => 'authorization_code',
        'code' => 'def50200203727428142afc773825bcef14f6dbb5ec9b0f58dd3417895345e8ea7c7f60241010faa9838802aa6d2d6211ca598c5f1bb858674e74c8ec5e5325653c3acc7ce5090fd926bfbcf3e254913f704101862bdb9ec3a1440959adae213221278bdd7b7f8095456a2154167fdf810bd7a50d92d3543d09c2407dac831391417b0e6a99d04ddb33c2c1b21e1e1352fc9bb83a91e2df5d4d9b07b1e6a9afc5b75f78dad28c6e3ca2caadce166caae4d140d9651557e32d66748f7d567f1a248985ef0baae5858b8f9cd92492380fe43b7e3fb8a92094b782050a58ca4b8e914a84b314992bf1a5c27010c53408e70325093b55ab5d340dd7659fc4c7275bab2107986476a929069acf43d4411a59035d79dd6fea547894bbb760bb478e63e22a98eede067caa7f3b52caea060db726cd7c3f64cce1f329ba15c154bb8438050873d4129b876445a0f9308d12c2a998ebe4165011bff0e0f7677f5f760d133e569f9159b5917a256a7a5316d33e00f6913f6d97c3633b0fc0d8bef97ce64d45a14e121cfcb1e103f9c30cf20703debe73b3d6a175bf9cef1b68138f6198b82cb85d69305a5baebed38390464e27bba0e8b3497b46c3f3f9232642571',
        'redirect_uri' => 'https://fz2020.ru/',
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
    $handle = fopen("wp-content/themes/pv-friendzone/assets/amocrm/amointegrationapi.json", "a");
    fwrite($handle, $addtofile);
    fclose($handle);
    echo "Токен Получен";
?>
