<?php
$amo_users_result = [];
$amo_users_result[] = "Подготовка необходимых данных для работы с амосрм";
// проверка доступности аккаунта
function check_account($subdomain, $access_token)
{
    $link = 'https://' . $subdomain . '.amocrm.ru/api/v2/account'; //Формируем URL для запроса
    /** Формируем заголовки */
    $headers = [
        'Authorization: Bearer ' . $access_token
    ];
    $curl = curl_init(); //Сохраняем дескриптор сеанса cURL
    /** Устанавливаем необходимые опции для сеанса cURL  */
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-oAuth-client/1.0');
    curl_setopt($curl, CURLOPT_URL, $link);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
    $out = curl_exec($curl); //Инициируем запрос к API и сохраняем ответ в переменную
    $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    // print_r(json_decode($out, true));
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
            // print $out;
            throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undefined error', $code);
        }
    } catch (\Exception $e) {
        // print $out;
        die('Файл: amocrm-users check_account Строка: 44 Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode());
    }
    return json_decode($out, true);
}

// получить все сделки
function get_all_leads($subdomain, $access_token)
{
    // echo "получить все сделки";
    $link = 'https://' . $subdomain . '.amocrm.ru/api/v4/leads';
    // echo $link;
    /** Формируем заголовки */
    $headers = [
        'Authorization: Bearer ' . $access_token
    ];

    $curl = curl_init(); #Сохраняем дескриптор сеанса cURL
    /** Устанавливаем необходимые опции для сеанса cURL  */
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-API-client/1.0');
    curl_setopt($curl, CURLOPT_URL, $link);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_COOKIEFILE, dirname(__FILE__) . '/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
    curl_setopt($curl, CURLOPT_COOKIEJAR, dirname(__FILE__) . '/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    $out = curl_exec($curl); #Инициируем запрос к API и сохраняем ответ в переменную
    curl_close($curl);
    // var_dump($out);
    return json_decode($out, true);
}

// получить все связанные сделки
function get_all_linked_leads($subdomain, $access_token, $lead_id)
{
    // echo "получить все связанные сделки";
    $link = 'https://' . $subdomain . '.amocrm.ru/api/v4/leads?filter[query]=' . $lead_id;
    /** Формируем заголовки */
    $headers = [
        'Authorization: Bearer ' . $access_token
    ];

    $curl = curl_init(); #Сохраняем дескриптор сеанса cURL
    /** Устанавливаем необходимые опции для сеанса cURL  */
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-API-client/1.0');
    curl_setopt($curl, CURLOPT_URL, $link);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_COOKIEFILE, dirname(__FILE__) . '/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
    curl_setopt($curl, CURLOPT_COOKIEJAR, dirname(__FILE__) . '/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    $out = curl_exec($curl); #Инициируем запрос к API и сохраняем ответ в переменную
    curl_close($curl);
    // var_dump($out);
    return json_decode($out, true);
}

// добавление новой сделки
function add_new_lead($subdomain, $access_token, $pipeline_id, $city = '', $card = '')
{
    // echo 'Добавляем новую сделку с городом и тегом';
    $lead_link = 'https://' . $subdomain . '.amocrm.ru/api/v4/leads';
    /** Формируем заголовки */
    $headers = [
        'Authorization: Bearer ' . $access_token
    ];
    /** Подготовка запроса к БД */
    $data = '[
        {
            "name": "Ваш номер участника FRIENDзона ID ",
            "pipeline_id": ' . $pipeline_id . ',
            "custom_fields_values": [
                {
                    "field_id": 329671,
                    "values": [
                        {
                            "value": "' . $city . '"
                        }
                    ]
                },
                {
                    "field_id": 390735,
                    "values": [
                        {
                            "value": "' . $card . '"
                        }
                    ]
                }
            ],
            "_embedded": {
                "tags": [
                    {
                        "id": 274791
                    }
                ]
            }
        }
    ]';
    $curl = curl_init(); // Сохраняем дескриптор сеанса cURL
    /** Устанавливаем необходимые опции для сеанса cURL  */
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-API-client/1.0');
    curl_setopt($curl, CURLOPT_URL, $lead_link);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_COOKIEFILE, dirname(__FILE__) . '/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
    curl_setopt($curl, CURLOPT_COOKIEJAR, dirname(__FILE__) . '/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    $out = curl_exec($curl); // Инициируем запрос к API и сохраняем ответ в переменную
    curl_close($curl);
    $out = json_decode($out, true);
    $id_link = $out['_embedded']['leads'][0]['id'];
    // echo '<br>'.$out.'<br>';
    // echo 'add_new_lead - end'.$id_link.'<br>';
    // var_dump('', $out);
    return $id_link;
}

// обновление названия сделки в соответствии с полученным id
function update_lead($subdomain, $access_token, $lead_id)
{
    // print 'update_lead - Обновляем сделку ID '.$lead_id;
    $link = 'https://' . $subdomain . '.amocrm.ru/api/v4/leads/' . $lead_id;
    /** Формируем заголовки */
    $headers = [
        'Authorization: Bearer ' . $access_token
    ];
    /** Подготовка запроса к БД */

    $data = 'name=' . urlencode('Ваш номер участника FRIENDзона ID ') . $lead_id;
    // print $data;
    $curl = curl_init(); #Сохраняем дескриптор сеанса cURL
    /** Устанавливаем необходимые опции для сеанса cURL  */
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-API-client/1.0');
    curl_setopt($curl, CURLOPT_URL, $link);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PATCH');
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_COOKIEFILE, dirname(__FILE__) . '/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
    curl_setopt($curl, CURLOPT_COOKIEJAR, dirname(__FILE__) . '/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    $out = curl_exec($curl); #Инициируем запрос к API и сохраняем ответ в переменную
    curl_close($curl);
    // echo 'update_lead - Обновляем сделку '.$out.'<br>';
    // var_dump($out);
    return $out;
}

// получить сделку по ID
function get_lead_by_id($subdomain, $access_token, $lead_id)
{
    // echo "получить сделку по ID";
    $link = 'https://' . $subdomain . '.amocrm.ru/api/v4/leads/' . $lead_id;
    // echo $link;
    /** Формируем заголовки */
    $headers = [
        'Authorization: Bearer ' . $access_token
    ];
    $curl = curl_init(); // Сохраняем дескриптор сеанса cURL
    /** Устанавливаем необходимые опции для сеанса cURL  */
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-API-client/1.0');
    curl_setopt($curl, CURLOPT_URL, $link);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_COOKIEFILE, dirname(__FILE__) . '/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
    curl_setopt($curl, CURLOPT_COOKIEJAR, dirname(__FILE__) . '/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    $out = curl_exec($curl); // Инициируем запрос к API и сохраняем ответ в переменную
    curl_close($curl);
    // var_dump($out);
    return json_decode($out, true);
}

// получение дополнительных полей сделки
function get_lead_custom_fields($subdomain, $access_token)
{
    // echo 'получаем дополнительные поля использования при добавлении сделки';
    $link = 'https://' . $subdomain . '.amocrm.ru/api/v4/leads/custom_fields';
    /** Формируем заголовки */
    $headers = [
        'Authorization: Bearer ' . $access_token
    ];
    $curl = curl_init(); //Сохраняем дескриптор сеанса cURL
    /** Устанавливаем необходимые опции для сеанса cURL  */
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-oAuth-client/1.0');
    curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
    curl_setopt($curl, CURLOPT_URL, $link);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
    $out = curl_exec($curl); //Инициируем запрос к API и сохраняем ответ в переменную
    curl_close($curl);
    // var_dump($out);
    return json_decode($out, true);;
}

// добавляем новый контакт
function add_new_contact($subdomain, $access_token, $user_id)
{
    $result = [];
    $result[] = 'добавление нового контакта';
    $contact_custom_fields = json_decode(contact_custom_fields($subdomain, $access_token), true);
    // $result[] = $contact_custom_fields;
    $user_data = get_userdata($user_id);
    $link = 'https://' . $subdomain . '.amocrm.ru/api/v4/contacts';
    /** Формируем заголовки */
    $headers = [
        'Authorization: Bearer ' . $access_token
    ];
    $user_tel_id = $contact_custom_fields['_embedded']['custom_fields'][1]['id'];
    $result['user_tel_id'] = $contact_custom_fields['_embedded']['custom_fields'][1]['id'];
    // $user_email_id = $id['_embedded']['custom_fields'][2]['id'];
    $data = '[
            {
                "first_name" : "' . $user_data->first_name . '",
                "custom_fields_values": [
                    {
                        "field_id": ' . $user_tel_id . ', 
                        "values": [
                            {
                                "value": "+' . $user_data->user_login . '",
                                "enum_code": "HOME"
                            }
                        ]
                    }
                ]
            }
        ]';
    $result['data'] = $data;
    $curl = curl_init(); //Сохраняем дескриптор сеанса cURL
    /** Устанавливаем необходимые опции для сеанса cURL  */
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-oAuth-client/1.0');
    curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
    curl_setopt($curl, CURLOPT_URL, $link);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
    $out = curl_exec($curl); //Инициируем запрос к API и сохраняем ответ в переменную
    $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    $result['out'] = json_decode($out, true);
    // print_r($out);
    // $out_contact = json_decode($out, true);
    // echo "Выводим ID нового пользователя: ";
    // $id_contact = $out_contact['_embedded']['contacts'][0]['id'];
    // echo $id_contact;
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
            // print $out;
            throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undefined error', $code);
        }
    } catch (\Exception $e) {
        $result['message'] = 'Файл: amocrm-users add_new_contact Строка: 231 Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode();
        // die('Файл: amocrm-users add_new_contact Строка: 229 Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode());
    }
    $result['id'] = json_decode($out, true)['_embedded']['contacts'][0]['id'];
    return $result;
}

// получить данные всех контактов
function get_all_contacts($subdomain, $access_token)
{
    // echo "получить все контакты";
    $link = 'https://' . $subdomain . '.amocrm.ru/api/v4/contacts';
    /** Формируем заголовки */
    $headers = [
        'Authorization: Bearer ' . $access_token
    ];

    $curl = curl_init(); #Сохраняем дескриптор сеанса cURL
    /** Устанавливаем необходимые опции для сеанса cURL  */
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-API-client/1.0');
    curl_setopt($curl, CURLOPT_URL, $link);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_COOKIEFILE, dirname(__FILE__) . '/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
    curl_setopt($curl, CURLOPT_COOKIEJAR, dirname(__FILE__) . '/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    $out = curl_exec($curl); #Инициируем запрос к API и сохраняем ответ в переменную
    curl_close($curl);
    // var_dump($out);
    return json_decode($out, true);
}

// получить данные контакта по id
function get_contact_by_id($subdomain, $access_token, $id)
{
    // echo "получить контакт по ID";
    $link = 'https://' . $subdomain . '.amocrm.ru/api/v4/contacts/' . $id;
    // echo $link;
    /** Формируем заголовки */
    $headers = [
        'Authorization: Bearer ' . $access_token
    ];

    $curl = curl_init(); #Сохраняем дескриптор сеанса cURL
    /** Устанавливаем необходимые опции для сеанса cURL  */
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-API-client/1.0');
    curl_setopt($curl, CURLOPT_URL, $link);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_COOKIEFILE, dirname(__FILE__) . '/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
    curl_setopt($curl, CURLOPT_COOKIEJAR, dirname(__FILE__) . '/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    $out = curl_exec($curl); #Инициируем запрос к API и сохраняем ответ в переменную
    curl_close($curl);
    // var_dump($out);
    return json_decode($out, true);
}

// получение дополнительных полей контакта
function contact_custom_fields($subdomain, $access_token)
{
    // echo 'получаем дополнительные поля использования при добавлении контакта';
    $link = 'https://' . $subdomain . '.amocrm.ru/api/v4/contacts/custom_fields';
    /** Формируем заголовки */
    $headers = [
        'Authorization: Bearer ' . $access_token
    ];
    $curl = curl_init(); //Сохраняем дескриптор сеанса cURL
    /** Устанавливаем необходимые опции для сеанса cURL  */
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-oAuth-client/1.0');
    curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
    curl_setopt($curl, CURLOPT_URL, $link);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
    $out = curl_exec($curl); //Инициируем запрос к API и сохраняем ответ в переменную
    curl_close($curl);
    // var_dump($out);
    return $out;
}

// получение дополнительных полей контакта
function get_contact_custom_fields($subdomain, $access_token)
{
    // echo 'получаем дополнительные поля использования при добавлении контакта';
    $link = 'https://' . $subdomain . '.amocrm.ru/api/v4/contacts/custom_fields';
    /** Формируем заголовки */
    $headers = [
        'Authorization: Bearer ' . $access_token
    ];
    $curl = curl_init(); //Сохраняем дескриптор сеанса cURL
    /** Устанавливаем необходимые опции для сеанса cURL  */
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-oAuth-client/1.0');
    curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
    curl_setopt($curl, CURLOPT_URL, $link);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
    $out = curl_exec($curl); //Инициируем запрос к API и сохраняем ответ в переменную
    curl_close($curl);
    // var_dump($out);
    return json_decode($out, true);;
}

// связь сделки с контактом пользователя
function lead_link_to_contact($subdomain, $access_token, $lead_id, $contact_id)
{
    $result = [];
    // echo 'связь сделки с контактом пользователя';
    $link = 'https://' . $subdomain . '.amocrm.ru/api/v4/leads/' . $lead_id . '/link';
    /** Формируем заголовки */
    $headers = [
        'Authorization: Bearer ' . $access_token
    ];
    $data = '[
            {
                "to_entity_id": ' . $contact_id . ', 
                "to_entity_type": "contacts"
            }
        ]';
    $result['headers'] = $headers;
    $result['data'] = $data;
    $curl = curl_init(); //Сохраняем дескриптор сеанса cURL
    /** Устанавливаем необходимые опции для сеанса cURL  */
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-oAuth-client/1.0');
    curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
    curl_setopt($curl, CURLOPT_URL, $link);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
    $out = curl_exec($curl); //Инициируем запрос к API и сохраняем ответ в переменную
    $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    $result['out'] = $out;
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
            // print $out;
            throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undefined error', $code);
        }
    } catch (\Exception $e) {
        $result['message'] = 'Файл: lead_link_to_contact Строка: 316 Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode();
        // die('Файл: lead_link_to_contact Строка: 252 Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode());
    }
    return $result;
}

// получить все тэги
function get_all_tags($subdomain, $access_token, $entity_type)
{
    // echo "Получить все тэги для сущности: " . $entity_type;
    $link = 'https://' . $subdomain . '.amocrm.ru/api/v4/' . $entity_type . '/tags';

    /** Формируем заголовки */
    $headers = [
        'Authorization: Bearer ' . $access_token
    ];

    $curl = curl_init(); #Сохраняем дескриптор сеанса cURL
    /** Устанавливаем необходимые опции для сеанса cURL  */
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-API-client/1.0');
    curl_setopt($curl, CURLOPT_URL, $link);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_COOKIEFILE, dirname(__FILE__) . '/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
    curl_setopt($curl, CURLOPT_COOKIEJAR, dirname(__FILE__) . '/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    $out = curl_exec($curl); #Инициируем запрос к API и сохраняем ответ в переменную
    curl_close($curl);
    // var_dump($out);
    return json_decode($out, true);
}

// получение дополнительных полей контакта
function get_custom_fields($subdomain, $access_token, $entity_type)
{
    // echo "Получаем дополнительные поля для сущности: " . $entity_type;
    $link = 'https://' . $subdomain . '.amocrm.ru/api/v4/' . $entity_type . '/custom_fields';
    /** Формируем заголовки */
    $headers = [
        'Authorization: Bearer ' . $access_token
    ];
    $curl = curl_init(); //Сохраняем дескриптор сеанса cURL
    /** Устанавливаем необходимые опции для сеанса cURL  */
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-oAuth-client/1.0');
    curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
    curl_setopt($curl, CURLOPT_URL, $link);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
    $out = curl_exec($curl); //Инициируем запрос к API и сохраняем ответ в переменную
    curl_close($curl);
    // var_dump($out);
    return json_decode($out, true);
}

// получение дополнительных полей сущности по id
function get_custom_field_by_id($subdomain, $access_token, $entity_type, $custom_field_id)
{
    $link = 'https://' . $subdomain . '.amocrm.ru/api/v4/' . $entity_type . '/custom_fields/' . $custom_field_id;
    /** Формируем заголовки */
    $headers = [
        'Authorization: Bearer ' . $access_token
    ];
    $curl = curl_init(); //Сохраняем дескриптор сеанса cURL
    /** Устанавливаем необходимые опции для сеанса cURL  */
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-oAuth-client/1.0');
    curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
    curl_setopt($curl, CURLOPT_URL, $link);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
    $out = curl_exec($curl); //Инициируем запрос к API и сохраняем ответ в переменную
    curl_close($curl);
    // var_dump($out);
    return json_decode($out, true);
}

// получить связи сущности
function get_entity_links($subdomain, $access_token, $entity_type, $entity_id){
    // echo "Получаем связи для сущности: " . $entity_type . " по id: " . $entity_id;
    $link = 'https://' . $subdomain . '.amocrm.ru/api/v4/' . $entity_type . '/' . $entity_id . '/links';
    /** Формируем заголовки */
    $headers = [
        'Authorization: Bearer ' . $access_token
    ];
    $curl = curl_init(); //Сохраняем дескриптор сеанса cURL
    /** Устанавливаем необходимые опции для сеанса cURL  */
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-oAuth-client/1.0');
    curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
    curl_setopt($curl, CURLOPT_URL, $link);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
    $out = curl_exec($curl); //Инициируем запрос к API и сохраняем ответ в переменную
    curl_close($curl);
    // var_dump($out);
    return json_decode($out, true);
}