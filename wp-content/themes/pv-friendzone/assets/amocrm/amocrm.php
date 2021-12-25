<?php
//function set_new_integration($domain, $client_id, $client_secret, $code)
//{
//    $link = 'https://' . $domain . '.amocrm.ru/oauth2/access_token';
//    $data = [
//        'client_id' => $client_id,
//        'client_secret' => $client_secret,
//        'grant_type' => 'authorization_code',
//        'code' => $code,
//        'redirect_uri' => 'https://fz2020.ru/',
//    ];
//
//    $curl = curl_init(); //Сохраняем дескриптор сеанса cURL
//    /** Устанавливаем необходимые опции для сеанса cURL  */
//    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//    curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-oAuth-client/1.0');
//    curl_setopt($curl, CURLOPT_URL, $link);
//    curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
//    curl_setopt($curl, CURLOPT_HEADER, false);
//    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
//    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
//    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1);
//    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
//    $out = curl_exec($curl); //Инициируем запрос к API и сохраняем ответ в переменную
//    $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
//    curl_close($curl);
//    $out = json_decode($out);
//    $code = (int)$code;
//    if ($code < 200 || $code > 204) {
//        echo "Ошибочный код ответа: " . $code;
//    } else {
//        echo "Код ответа успешный: " . $code;
//        // сохраняем ответ от сервера на странице интеграции.
//        $amo_integration_page = get_page_by_title('Интеграция с АМО СРМ');
//        $content = $amo_integration_page->post_content;
//        $content = mb_substr($content, mb_strpos($content, '{'), mb_strpos($content, '}') - mb_strpos($content, '{') + 1);
//        $content = json_decode($content);
//
//        $content->expires_in = $out->expires_in;
//        $content->access_token = $out->access_token;
//        $content->refresh_token = $out->refresh_token;
//        $content->token_expires = $_SERVER['REQUEST_TIME'] + 86400;
//        $content = json_encode($content);
//        $data = [
//            'ID' => $amo_integration_page->ID,
//            'post_content' => $content
//        ];
//        wp_update_post(wp_slash($data));
//    }
//    return $out;
//}

// получаем данные со страницы интеграции
$amo_integration_page = get_page_by_title('Интеграция с АМО СРМ');
$content = $amo_integration_page->post_content;
$content = mb_substr($content, mb_strpos($content, '{'), mb_strpos($content, '}') - mb_strpos($content, '{') + 1);
$content = json_decode($content);

$link = 'https://' . $content->domain . '.amocrm.ru/oauth2/access_token'; //Формируем URL для запроса
echo $link;
/** Соберем данные для запроса */
$data = [
    'client_id' => $content->client_id,
    'client_secret' => $content->client_secret,
    'grant_type' => 'authorization_code',
    'code' => $content->code,
    'redirect_uri' => 'https://fz2020.ru/',
];
print_r($data);
/**
 * Нам необходимо инициировать запрос к серверу.
 * Воспользуемся библиотекой cURL (поставляется в составе PHP).
 * Вы также можете использовать и кроссплатформенную программу cURL, если вы не программируете на PHP.
 */
$curl = curl_init(); //Сохраняем дескриптор сеанса cURL
/** Устанавливаем необходимые опции для сеанса cURL  */
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-oAuth-client/1.0');
curl_setopt($curl, CURLOPT_URL, $link);
curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
$out = curl_exec($curl); //Инициируем запрос к API и сохраняем ответ в переменную
// print_r($out);
$code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
// print_r($code);
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

try {
    /** Если код ответа не успешный - возвращаем сообщение об ошибке  */
    if ($code < 200 || $code > 204) {
        throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undefined error', $code);
    }

} catch (\Exception $e) {
    $amo_crm['message'] = 'Файл amocrm. Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode();
    // die('Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode());
}
// сохраняем ответ от сервера на странице интеграции.
$out = json_decode($out);
$content->expires_in = $out->expires_in;
$content->access_token = $out->access_token;
$content->refresh_token = $out->refresh_token;
$content->token_expires = $_SERVER['REQUEST_TIME'] + 86400;
$content = json_encode($content);
$data = [
    'ID' => $amo_integration_page->ID,
    'post_content' => $content
];
wp_update_post(wp_slash($data));
