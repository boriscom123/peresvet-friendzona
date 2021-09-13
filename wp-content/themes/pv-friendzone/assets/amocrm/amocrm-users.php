<?php
    // echo "Подготовка необходимых данных для работы с амосрм";
    $subdomain = 'testfirebladeru'; //Поддомен нужного аккаунта - как в амосрм
    $token = explode("/",file_get_contents("wp-content/themes/friendzone/assets/amocrm/amointegrationapi.json"));
    $access_token = json_decode($token[0], true)['access_token'];
    // проверка доступности аккаунта
    function check_account($subdomain, $access_token){
        $link = 'https://' . $subdomain . '.amocrm.ru/api/v2/account'; //Формируем URL для запроса
        /** Формируем заголовки */
        $headers = [
            'Authorization: Bearer ' . $access_token
        ];
        $curl = curl_init(); //Сохраняем дескриптор сеанса cURL
        /** Устанавливаем необходимые опции для сеанса cURL  */
        curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
        curl_setopt($curl,CURLOPT_URL, $link);
        curl_setopt($curl,CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl,CURLOPT_HEADER, false);
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 2);
        $out = curl_exec($curl); //Инициируем запрос к API и сохраняем ответ в переменную
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        // print_r($out);
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
                print $out;
                throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undefined error', $code);
            }
        }
        catch(\Exception $e)
        {
            print $out;
            die('Файл: addcontact Строка: 44 Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode());
        }
        return $out;
    }
    // добавление новой сделки
    function add_new_lead($subdomain, $access_token){
        $lead_link = 'https://' . $subdomain . '.amocrm.ru/api/v4/leads'; // добавление сделки
        /** Формируем заголовки */
        $headers = [
            'Authorization: Bearer ' . $access_token
        ];
        /** Подготовка запроса к БД */
        $data = '[
            {
                "name": "Ваш номер участника FRIENDзона ID ",
                "pipeline_id": 4646092
            }
        ]';
        $curl = curl_init(); #Сохраняем дескриптор сеанса cURL
        //Устанавливаем необходимые опции для сеанса cURL
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
        $out = curl_exec($curl); #Инициируем запрос к API и сохраняем ответ в переменную
        curl_close($curl);
        $out_link = json_decode($out, true);
        // echo "id сделки: ";
        $id_link = $out_link['_embedded']['leads'][0]['id'];
        // echo $id_link;
        return $id_link;
    }
    // обновление названия сделки в соответствии с полученным id
    function update_lead($subdomain, $access_token, $lead_id){
        // print 'Обновляем сделку ID '.$lead_id;
        $link = 'https://' . $subdomain . '.amocrm.ru/api/v4/leads/'.$lead_id;
        /** Формируем заголовки */
        $headers = [
            'Authorization: Bearer ' . $access_token
        ];
        /** Подготовка запроса к БД */

        $data = 'name='.urlencode('Ваш номер участника FRIENDзона ID ').$lead_id;
        // print $data;
        $curl = curl_init(); #Сохраняем дескриптор сеанса cURL
        //Устанавливаем необходимые опции для сеанса cURL
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-API-client/1.0');
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PATCH');
        curl_setopt($curl, CURLOPT_POSTFIELDS,  $data);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_COOKIEFILE, dirname(__FILE__) . '/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
        curl_setopt($curl, CURLOPT_COOKIEJAR, dirname(__FILE__) . '/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        $out = curl_exec($curl); #Инициируем запрос к API и сохраняем ответ в переменную
        curl_close($curl);
        return $out;
    }
    // получить сделку по ID
    function get_lead_by_id($subdomain, $access_token, $lead_id){
        // получить сделку по ID
        print 'Выводим сделку с ID '.$lead_id;
        $link = 'https://' . $subdomain . '.amocrm.ru/api/v4/leads/'.$lead_id;
        /** Формируем заголовки */
        $headers = [
            'Authorization: Bearer ' . $access_token
        ];

        $curl = curl_init(); #Сохраняем дескриптор сеанса cURL
        //Устанавливаем необходимые опции для сеанса cURL
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
        print $out;
        print '<br>';
    }
    // добавляем новый контакт
    function add_new_contact($subdomain, $access_token, $user_id){
        // добавление нового контакта
        $contact_custom_fields = json_decode(contact_custom_fields($subdomain, $access_token), true);
        $user_data = get_userdata( $user_id );
        $link = 'https://' . $subdomain . '.amocrm.ru/api/v4/contacts';
        /** Формируем заголовки */
        $headers = [
            'Authorization: Bearer ' . $access_token
        ];
        $user_tel_id = $contact_custom_fields['_embedded']['custom_fields'][1]['id'];
        // $user_email_id = $id['_embedded']['custom_fields'][2]['id'];
        $data = '[
            {
                "first_name" : "'.$user_data->first_name.'",
                "last_name" : "'.$user_data->last_name.'",
                "custom_fields_values": [
                    {
                        "field_id": '.$user_tel_id.', "values": [
                            {
                                "value": "+'.$user_data->user_login.'",
                                "enum_code": "HOME"
                            }
                        ]
                    }
                ]
            }
        ]';
        // echo $data;
        $curl = curl_init(); //Сохраняем дескриптор сеанса cURL
        /** Устанавливаем необходимые опции для сеанса cURL  */
        curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
        curl_setopt($curl,CURLOPT_HTTPHEADER,['Content-Type:application/json']);
        curl_setopt($curl,CURLOPT_URL, $link);
        curl_setopt($curl,CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl,CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl,CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl,CURLOPT_HEADER, false);
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 2);
        $out = curl_exec($curl); //Инициируем запрос к API и сохраняем ответ в переменную
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
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

        try
        {
            /** Если код ответа не успешный - возвращаем сообщение об ошибке  */
            if ($code < 200 || $code > 204) {
                print $out;
                throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undefined error', $code);
            }
        }
        catch(\Exception $e)
        {
            print $out;
            die('Файл: addcontact Строка: 146 Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode());
        }
        return json_decode($out, true)['_embedded']['contacts'][0]['id'];
    }
    // получение дополнительных полей контакта
    function contact_custom_fields($subdomain, $access_token){
        // получаем дополнительные поля использования при добавлении контакта
        $link = 'https://' . $subdomain . '.amocrm.ru/api/v4/contacts/custom_fields';
        /** Формируем заголовки */
        $headers = [
            'Authorization: Bearer ' . $access_token
        ];
        $curl = curl_init(); //Сохраняем дескриптор сеанса cURL
        /** Устанавливаем необходимые опции для сеанса cURL  */
        curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
        curl_setopt($curl,CURLOPT_HTTPHEADER,['Content-Type:application/json']);
        curl_setopt($curl,CURLOPT_URL, $link);
        curl_setopt($curl,CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl,CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl,CURLOPT_HEADER, false);
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 2);
        $out = curl_exec($curl); //Инициируем запрос к API и сохраняем ответ в переменную
        curl_close($curl);
        return $out;
    }
    // связь сделки с контактом пользователя
    function lead_link_to_contact($subdomain, $access_token, $lead_id, $contact_id){
        // связь сделки с контактом пользователя
        $link = 'https://' . $subdomain . '.amocrm.ru/api/v4/leads/'.$lead_id.'/link';
        /** Формируем заголовки */
        $headers = [
            'Authorization: Bearer ' . $access_token
        ];
        $data = '[
            {
                "to_entity_id": '.$contact_id.', 
                "to_entity_type": "contacts"
            }
        ]';
        // echo $data;
        $curl = curl_init(); //Сохраняем дескриптор сеанса cURL
        /** Устанавливаем необходимые опции для сеанса cURL  */
        curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
        curl_setopt($curl,CURLOPT_HTTPHEADER,['Content-Type:application/json']);
        curl_setopt($curl,CURLOPT_URL, $link);
        curl_setopt($curl,CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl,CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl,CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl,CURLOPT_HEADER, false);
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 2);
        $out = curl_exec($curl); //Инициируем запрос к API и сохраняем ответ в переменную
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        // print_r($out);
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
                print $out;
                throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undefined error', $code);
            }
        }
        catch(\Exception $e)
        {
            print $out;
            die('Файл: addcontact Строка: 190 Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode());
        }
        return $out;
    }
    // $check_acc = check_account($subdomain, $access_token);
    // print $check_acc;
    // $new_lead_id = add_new_lead($subdomain, $access_token);
    // print $new_lead_id;
    // $update_lead = update_lead($subdomain, $access_token, $new_lead_id);
    // print $update_lead;
    // $new_contact_id = add_new_contact($subdomain, $access_token);
    // print $new_contact_id;
    // $connect = lead_link_to_contact($subdomain, $access_token, $new_lead_id, $new_contact_id);
    // print $connect;
//   echo get_current_user_id();
//    $user_data = get_userdata( get_current_user_id() );
//    print_r($user_data);
?>