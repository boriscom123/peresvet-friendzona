<?php
    // echo "REFRESH начало";
    $subdomain = 'adminailikeru'; //Поддомен нужного аккаунта - как в амосрм
    $link = 'https://' . $subdomain . '.amocrm.ru/oauth2/access_token'; //Формируем URL для запроса
    $token = explode("/",file_get_contents("wp-content/themes/friendzone/assets/amocrm/amointegrationapi.json"));
    $refresh_token = json_decode($token[0], true)['refresh_token'];
    /** Соберем данные для запроса */
    $data = [
        'client_id' => '0fdf96e2-46e1-46c4-9cb4-776b59b4b23e',
        'client_secret' => 'qtNYabSKTqeKvsKqJKXTJ7Ce9UNvqepfqtNGeL4uQqS2WDnbWDNJ7wu5puhfxXKG',
        'grant_type' => 'refresh_token',
        'refresh_token' => $refresh_token,
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
    // echo $out;
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
        die('Файл: amoreffesh Строка: 57 Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode());
    }
    // сохраняем ответ от сервера в файл.
    unlink("wp-content/themes/friendzone/assets/amocrm/amointegrationapi.json");
    $addtofile = $out.'/{"until":'. ($_SERVER['REQUEST_TIME'] + 86400) .'}';
    $handle = fopen("wp-content/themes/friendzone/assets/amocrm/amointegrationapi.json", "a");
    fwrite($handle, $addtofile);
    fclose($handle);
    // echo "REFRESH конец";
?>