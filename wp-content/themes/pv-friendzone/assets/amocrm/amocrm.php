<?php
$amo_crm = [];
$amo_crm[] = "Настройки интеграции";
$subdomain = 'zakirov'; //Поддомен нужного аккаунта - как в амосрм
$link = 'https://' . $subdomain . '.amocrm.ru/oauth2/access_token'; //Формируем URL для запроса
$amo_crm['link'] = $link;
/** Соберем данные для запроса */
$data = [
    'client_id' => 'bb93e072-9cf4-4304-a96f-fe577a215915',
    'client_secret' => '08mJptjFF5MC6G07IkdfCjChhTmzajbWgwRKrab8oGP0ZOI61LEgnT7wP9T0H1DR',
    'grant_type' => 'authorization_code',
    'code' => 'def50200d2b30199a97be6c9ff21d7770d90160f3c3d84538da2e0427c0a357b31a917533fd9e00a6a69a245cea72eca22f1644b94cc694304071d0d8869c20d1186dcc814067b3f48159917a63886d3b03083d324547a3f43a618d20bfda8f2a0ab596af11d696e7bddc48167f3e6ff77a31293ed35c67d94ee62a33b96aed8b33f5f815bb9812dbac856d209983000f47b502d300fbf5286bb5d9d538ab5799a443d5325b1c2625f78c0c03af6172ab080ddd78cb2fba11cb760a8e0f70d41270d80f362899ad5c27d99423e57c0a1486d00ec4a53f03eb5f9b9ee88dd91e806be304679fa976c41f87b0009fed021a61d1736c3ed406060d56386a5f8b060e98e53681641d313298f0edf5bf07bcea58f16c10a4f2f65bab776955447ba354e50b98f3d3d063defac7a2ff9bbc8ea7137a7ee5d35b11182a48ac55be54d10052026551b8a4d4d23b53290e3400f621b66e1a1e9192d9012d1ca82d254d5852db222a24f2a4f6f24743a8cb867a05078998aec61299b235c1a69151d9229ff2d11896f2d4698940a453aea3fd9a3f14a88d40a70328468ec5eac36f58ab34d5499d76b506f69939dab9f74118c5efd46c23754bdf8e2dced80da0136',
    'redirect_uri' => 'https://fz2020.ru/',
];
$amo_crm['data'] = $data;
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
$code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);
$amo_crm['out'] = $out;
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
// сохраняем ответ от сервера в файл.
$addtofile = $out . '/{"until":' . ($_SERVER['REQUEST_TIME'] + 86400) . '}';
$handle = fopen("wp-content/themes/pv-friendzone/assets/amocrm/amointegrationapi.json", "a");
fwrite($handle, $addtofile);
fclose($handle);
$amo_crm[] = "Токен Получен";