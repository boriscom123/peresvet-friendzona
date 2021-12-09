<?php
$refresh_result = [];
$refresh_result[] = "REFRESH начало";
// получаем данные по интеграции
$amo_integration_page = get_page_by_title('Интеграция с АМО СРМ');
$content = $amo_integration_page->post_content;
$content = mb_substr($content, mb_strpos($content, '{'), mb_strpos($content, '}') - mb_strpos($content, '{') + 1);
$content = json_decode($content);

// $subdomain = $content->domain; //Поддомен нужного аккаунта - как в амосрм
$link = 'https://' . $content->domain . '.amocrm.ru/oauth2/access_token'; //Формируем URL для запроса
// $token = explode("/", file_get_contents("wp-content/themes/pv-friendzone/assets/amocrm/amointegrationapi.json"));
// $refresh_token = json_decode($token[0], true)['refresh_token'];
/** Соберем данные для запроса */
$data = [
    'client_id' => $content->client_id,
    'client_secret' => $content->client_secret,
    'grant_type' => 'refresh_token',
    'refresh_token' => $content->refresh_token,
    'redirect_uri' => $content->redirect_uri,
];
$refresh_result['data'] = $data;
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
$refresh_result['out'] = $out;
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

try {
    /** Если код ответа не успешный - возвращаем сообщение об ошибке  */
    if ($code < 200 || $code > 204) {
        throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undefined error', $code);
    }
} catch (\Exception $e) {
    $refresh_result['exeption'] = 'Файл: amoreffesh Строка: 55 Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode();
    // die('Файл: amoreffesh Строка: 57 Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode());
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
//unlink("wp-content/themes/pv-friendzone/assets/amocrm/amointegrationapi.json");
//$addtofile = $out . '/{"until":' . ($_SERVER['REQUEST_TIME'] + 86400) . '}';
//$handle = fopen("wp-content/themes/pv-friendzone/assets/amocrm/amointegrationapi.json", "a");
//fwrite($handle, $addtofile);
//fclose($handle);
$refresh_result[] = "REFRESH конец";