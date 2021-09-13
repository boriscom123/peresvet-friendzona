<?php
    $subdomain = 'testfirebladeru'; //Поддомен нужного аккаунта - как в амосрм
    $link = 'https://' . $subdomain . '.amocrm.ru/oauth2/access_token'; //Формируем URL для запроса
    /** Соберем данные для запроса */
    $data = [
        'client_id' => '8011009d-0be6-4f52-afe0-e289ab9be428',
        'client_secret' => 'KyTK0szB8MJCyqHT6FPXsGUGEbSHhTQRqMT80OGxgn7IUXwlgWwuDRVoUM6e24KM',
        'grant_type' => 'authorization_code',
        'code' => 'def50200025d90f3e6ed73980ec056ef84a307bb1cffd3b05557ed012b7717357b2527004154a53f1f76c15caab75af910366a7cf466b473bf43776edbef4a3c8d765b1889c78045a0c4b8dda6478d4d9cfe59584f23be4d37c7020333ee91e4743cf5a0e64b27ebc807608df72ba146e30b70fbe2defced9e21dd2931cefb5f3f6d560b4f68272d224489794f9141e1c8da99dd376ffcae27c5db44eb64007dd1403d255384aec76719ab2ee427db0132a21ff1b436cf0c24bc45048b906916b22853d698d954778cc68a7b6e50b214540bc9663a478fbe55a2055fcf9ce97d688c0fa00feb5102b87073a8c8614f61f06d1f787350ac3502547dd8e2a0827a3cea03fe771cbb0db8f3401d3e8c40478e8c2e167ad2c0e990c25aa9c6c9c46dc6bba4c46b044c6e8238c499eccf5716a661bef9def8fb59758212b383810b7b593db7d61b76b40f5b4efd8ca0ff38049e422cba1659d3c8111f08fe1d32ed6bc8c3eaa302fe393c844a11ec8fd70507ce40173fec50e104e946dc2f6a0b5d9a732b92f93b28ca0dce0b1ed00c75ac1a1efcac4e16a4d152bbe12c357472fd5f3eff713a61642ce27fe2143460d67a09d9f2167744367b7989356bc1cf8b',
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
