<?php
/*
    Template Name: ByNextPr - User Page
*/
get_header();
?>
<?php
    if( is_user_logged_in() ){
        $user_data = get_userdata( get_current_user_id() );
        $all_meta_for_user = get_user_meta( get_current_user_id() );
        $avatar = get_avatar_url( get_current_user_id() );
        // print_r($user_data);
        // print_r($all_meta_for_user);

        // получаем ссылку на форму
        $amo_integration_page = get_page_by_title('Интеграция с АМО СРМ');
        $content = $amo_integration_page->post_content;
        $content = mb_substr($content, mb_strpos($content, '{'), mb_strpos($content, '}') - mb_strpos($content, '{') + 1);
        $content = json_decode($content);
        if ($content->token_expires < $_SERVER['REQUEST_TIME']) {
            include 'assets/amocrm/amocrm-refresh.php';
            $result['refresh_result'] = $refresh_result;
            $content = $amo_integration_page->post_content;
            $content = mb_substr($content, mb_strpos($content, '{'), mb_strpos($content, '}') - mb_strpos($content, '{') + 1);
            $content = json_decode($content);
        }
        $new_lead_id = $all_meta_for_user['amo-lead-id'][0];
        // include 'assets/amocrm/amocrm-users.php';
        $lead = get_lead_by_id($content->domain, $content->access_token, $new_lead_id);
        $form_link = '';
        foreach ($lead['custom_fields_values'] as $cf){
            if ($cf['field_id'] == 384025){
                $form_link = $cf['values'][0]['value'];
            }
        }
        // получаем массив id сделок зарегистрированных через форму
        // https://zakirov.amocrm.ru/api/v4/leads?filter[query]=21367677
        $all_leads = get_all_linked_leads($content->domain, $content->access_token, $all_meta_for_user['amo-lead-id'][0]);
        $user_connected_leads_id = [];
        if(count($all_leads['_embedded']['leads']) > 0){
            foreach ($all_leads['_embedded']['leads'] as $lead) {
                // print_r($lead['name']);
                if($lead['id'] != $all_meta_for_user['amo-lead-id'][0]){
                    $user_connected_leads_id[] = $lead['id'];
                }
            }
        }
    } else {
        // echo 'Вы всего лишь пользователь!';
        wp_redirect( home_url() ); // перенаправляем на главную страницу
        exit;
    }
    if(isset($_GET)){
        // print_r($_GET);
    }
    if(isset($_POST)){
        // print_r($_POST);
    }
    if(isset($_GET['n'])){
        $nav = $_GET['n'];
    } else {
        $nav = 0;
    }
    if(isset($_POST['n'])){
        $nav = $_POST['n'];
    }
?>

    <div class="breadcrumbs">
        <div class="container">
            <div class="image">
                <a href="https://fz2020.ru/">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/arrow-left.svg" alt="arrow-left">
                </a>
            </div>
            <div class="link">
                <a href="https://fz2020.ru/">На главную</a>
            </div>
        </div>
    </div>

    <main class="main">

        <div class="main-user">
            <div class="container">

                <div class="user-main-info">
                    <div>
                        <div class="avatar">
                            <img src="<?php if(isset($all_meta_for_user['user_avatar'])){print wp_get_attachment_image_url($all_meta_for_user['user_avatar'][0]);} else {echo get_template_directory_uri().'/assets/images/avatar-new.svg';} ?>" alt="user-avatar">
                            <form enctype="multipart/form-data" method="post" id="user-avatar">
                                <input type="hidden" name="form-action" value="update-user-avatar" form="user-avatar">
                                <input class="d-none" type="file" name="avatar" id="user-avatar-select" form="user-avatar">
                            </form>
                            <label class="avatar-add" for="user-avatar-select">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icon-cross.svg" alt="icon-cross">
                            </label>
                        </div>

                        <div class="user-pages">

                            <a class="page <?php if($nav == 1 || $nav == 0){echo 'active';} ?>" href="https://fz2020.ru/user/?n=1">
                                <div class="icon body"></div>
                                <div class="text">Профиль</div>
                            </a>

                            <a class="page <?php if($nav == 2){echo 'active';} ?>" href="https://fz2020.ru/user/?n=2">
                                <div class="icon bodies"></div>
                                <div class="text">Друзья</div>
                            </a>

                            <a class="page <?php if($nav == 3){echo 'active';} ?>" href="https://fz2020.ru/user/?n=3">
                                <div class="icon options"></div>
                                <div class="text">Настройки</div>
                            </a>

                        </div>
                        <div class="question">
                            <button id="user-question-button">Задать вопрос</button>
                        </div>
                    </div>
                </div>

                <div class="user-pages">

                    <div class="user-code <?php if($nav != 1 || $nav != 1){echo 'd-none';} ?>">
                        <h2>Уникальный код</h2>
                        <h3><?php if(isset($all_meta_for_user['amo-lead-id'])){ print $all_meta_for_user['amo-lead-id'][0]; } ?></h3>
                        <div class="info">
                            <div>
                                <?php
                                    // echo $lead['custom_fields_values'][2]['values'][0]['value'];
                                    echo "Ваша индивидуальная ссылка и код";
                                ?>
                            </div>
                            <button data-link="<?php echo $form_link; ?>" id="copy-link">Копировать</button>
                        </div>
                    </div>

                    <div class="user-bonus <?php if($nav != 1 || $nav != 1){echo 'd-none';} ?>">
                        <?php
                        $user_bonus_balance = 0;
                        if (count($user_connected_leads_id) > 0) {
                            // print_r($user_connected_leads_id);
                            foreach ($user_connected_leads_id as $lead_id) {
                                // print_r($lead_id);
                                $lead = get_lead_by_id($content->domain, $content->access_token, $lead_id);
                                if($lead['status_id'] === 142){
                                    $user_bonus_balance +=40000;
                                }
                            }
                        }
                        $show_bonuses = '';
                        if(strlen($user_bonus_balance) > 3 && strlen($user_bonus_balance) < 7){
                            // echo 'Больше 3 и меньше 7';
                            $show_bonuses = substr($user_bonus_balance, 0, strlen($user_bonus_balance) - 3 ) . ' ' . substr($user_bonus_balance, strlen($user_bonus_balance) - 3, strlen($user_bonus_balance));
                            // echo $show_bonuses;
                        } elseif (strlen($user_bonus_balance) > 6 && strlen($user_bonus_balance) < 10){
                            // echo 'Больше 6 и меньше 10';
                            $show_bonuses = substr($user_bonus_balance, 0, strlen($user_bonus_balance) - 6 ) . ' ' . substr($user_bonus_balance, strlen($user_bonus_balance) - 6, strlen($user_bonus_balance) - 3) . ' ' . substr($user_bonus_balance, strlen($user_bonus_balance) - 3, strlen($user_bonus_balance));
                        } elseif (strlen($user_bonus_balance) > 9 && strlen($user_bonus_balance) < 13) {
                            // echo 'Больше 9 и меньше 13';
                            $show_bonuses = $user_bonus_balance;
                        } else {
                            // echo 'Больше 12';
                            $show_bonuses = $user_bonus_balance;
                        }
                        $progress_bar = $user_bonus_balance / (1440000 / 100);
                        ?>
                        <h2>Бонусный счет</h2>
                        <div class="info">
                            <h3><?php echo $show_bonuses; ?> баллов</h3>
                            <button id="user-money-button">Вывести</button>
                        </div>
                        <a href="#">Операции по счету</a>
                    </div>

                    <div class="user-bank <?php if($nav != 1 || $nav != 1){echo 'd-none';} ?>">
                        <h2>Копилка</h2>
                        <p>Наберите необходимое количество баллов и получите скидку 560 000 рублей на свою квартиру</p>
                        <div class="progress">
                            <div class="start"></div>
                            <div class="line"><div style="width: <?php echo $progress_bar; ?>%"></div></div>
                            <div class="end"></div>
                            <div class="range" style="left: <?php echo $progress_bar; ?>%"></div>
                        </div>
                        <div class="info">
                            <div>
                                <h3>Текущий баланс</h3>
                                <h2 class="color-red"><?php echo $show_bonuses; ?></h2>
                            </div>
                            <div>
                                <h3>Осталось до скидки</h3>
                                <h2 class="color-black">1 440 000</h2>
                            </div>
                        </div>
                    </div>

                    <div class="user-friends <?php if($nav != 2){echo 'd-none';} ?>">
                        <h2>Список друзей</h2>
                        <div class="friends-list">

                            <?php
                                if (count($user_connected_leads_id) > 0){
                                    // print_r($user_connected_leads_id);
                                    foreach ($user_connected_leads_id as $lead_id){
                                        $lead = get_lead_by_id($content->domain, $content->access_token, $lead_id);
                                        // print_r($lead);
                                        // запрос на получение связанных сущностей (контакт) - https://zakirov.amocrm.ru/api/v4/leads/{ ID }/links
                                        $linked_contact = get_entity_links($content->domain, $content->access_token, 'leads', $lead_id);
                                        // print_r($contact);
                                        $contact_id = $linked_contact['_embedded']['links'][0]['to_entity_id'];
                                        // echo $contact_id;
                                        $contact = get_contact_by_id($content->domain, $content->access_token, $contact_id);
                                        // var_dump($contact);
                                        $contact_name = $contact['name'];
                                        // var_dump('Имя:', $contact_name);
                                        $contact_tel = 0;
                                        foreach ($contact['custom_fields_values'] as $field){
                                            if($field['field_id'] === 248661)
                                            $contact_tel = prepareLogin($field['values'][0]['value']);
                                        }
                                        $status = get_pipline_status($lead['status_id']);
                                        // var_dump('status', $status);
                                        $status_date = date('d-m-Y', $lead['updated_at']);
                                        // var_dump('$status_date', $status_date);
                                        if($lead['status_id'] === 143){
                                            $loss_reason = get_loss_reason($content->domain, $content->access_token, $lead['id']);
                                            // var_dump('$loss_reason', $loss_reason['_embedded']['loss_reason'][0]['name']);
                                            $reason = $loss_reason['_embedded']['loss_reason'][0]['name'];
                                        }
                                        ?>
                                        <div class="friend-item">
                                            <div class="friend-main <?php if($status !== 'Успешная рекомендация') { echo 'not-'; }?>confirm">
                                                <div class="title">
                                                    <h2><?php echo $contact_name; ?></h2>
                                                    <h3><?php echo '+'. substr($contact_tel, 0, 1) . ' (' . substr($contact_tel, 1, 3) . ') ' . substr($contact_tel, 4, 3) . '-' . substr($contact_tel, 7, 2) . '-' . substr($contact_tel, 9, 2); ?></h3>
                                                </div>
                                                <h4><?php echo $status; ?></h4>
                                                <div class="circle"></div>
                                                <?php
                                                if($status !== 'Успешная рекомендация') { ?>
                                                <div class="friend-hover">
                                                    <div class="info">
                                                        <h2><?php echo $status; ?></h2>
                                                        <h3><?php echo $status_date; ?></h3>
                                                        <?php
                                                            if($lead['status_id'] === 143){
                                                                echo "<h2>{$reason}</h2>";
                                                            }
                                                        ?>
                                                    </div>
<!--                                                    <div class="info">-->
<!--                                                        <h2>Бронирование</h2>-->
<!--                                                        <h3>Нет информации</h3>-->
<!--                                                    </div>-->
<!--                                                    <div class="info">-->
<!--                                                        <h2>Покупка</h2>-->
<!--                                                        <h3>Нет информации</h3>-->
<!--                                                    </div>-->
                                                </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                            ?>

<!--                            <div class="friend-item">-->
<!--                                <div class="friend-main not-confirm">-->
<!--                                    <div class="title">-->
<!--                                        <h2>Виктория</h2>-->
<!--                                        <h3>+7 (902) 344-23-15</h3>-->
<!--                                    </div>-->
<!--                                    <h4>Ожидайте проведения переговоров</h4>-->
<!--                                    <div class="circle"></div>-->
<!--                                    <div class="friend-hover">-->
<!--                                        <div class="info">-->
<!--                                            <h2>Консультация</h2>-->
<!--                                            <h3>Назначена на 21 мая 2021</h3>-->
<!--                                        </div>-->
<!--                                        <div class="info">-->
<!--                                            <h2>Бронирование</h2>-->
<!--                                            <h3>Нет информации</h3>-->
<!--                                        </div>-->
<!--                                        <div class="info">-->
<!--                                            <h2>Покупка</h2>-->
<!--                                            <h3>Нет информации</h3>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!---->
<!--                            <div class="friend-item">-->
<!--                                <div class="friend-main not-confirm">-->
<!--                                    <div class="title">-->
<!--                                        <h2>Жанна</h2>-->
<!--                                        <h3>+7 (913) 942-93-11</h3>-->
<!--                                    </div>-->
<!--                                    <h4>Ожидайте проведения переговоров</h4>-->
<!--                                    <div class="circle"></div>-->
<!--                                    <div class="friend-hover">-->
<!--                                        <div class="info">-->
<!--                                            <h2>Консультация</h2>-->
<!--                                            <h3>Назначена на 21 мая 2021</h3>-->
<!--                                        </div>-->
<!--                                        <div class="info">-->
<!--                                            <h2>Бронирование</h2>-->
<!--                                            <h3>Нет информации</h3>-->
<!--                                        </div>-->
<!--                                        <div class="info">-->
<!--                                            <h2>Покупка</h2>-->
<!--                                            <h3>Нет информации</h3>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!---->
<!--                            <div class="friend-item">-->
<!--                                <div class="friend-main not-confirm active">-->
<!--                                    <div class="title">-->
<!--                                        <h2>Виктория</h2>-->
<!--                                        <h3>+7 (902) 344-23-15</h3>-->
<!--                                    </div>-->
<!--                                    <h4>Ожидайте проведения переговоров</h4>-->
<!--                                    <div class="circle"></div>-->
<!--                                    <div class="friend-hover">-->
<!--                                        <div class="info">-->
<!--                                            <h2>Консультация</h2>-->
<!--                                            <h3>Назначена на 21 мая 2021</h3>-->
<!--                                        </div>-->
<!--                                        <div class="info">-->
<!--                                            <h2>Бронирование</h2>-->
<!--                                            <h3>Нет информации</h3>-->
<!--                                        </div>-->
<!--                                        <div class="info">-->
<!--                                            <h2>Покупка</h2>-->
<!--                                            <h3>Нет информации</h3>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!---->
<!--                            <div class="friend-item">-->
<!--                                <div class="friend-main confirm">-->
<!--                                    <div class="title">-->
<!--                                        <h2>Кристина</h2>-->
<!--                                        <h3>+7 (900) 965-98-98</h3>-->
<!--                                    </div>-->
<!--                                    <h4>Покупка совершена</h4>-->
<!--                                    <div class="circle"></div>-->
<!--                                </div>-->
<!--                                <div class="friend-hover">-->
<!--                                    <div class="info">-->
<!--                                        <h2>Консультация</h2>-->
<!--                                        <h3>Назначена на 21 мая 2021</h3>-->
<!--                                    </div>-->
<!--                                    <div class="info">-->
<!--                                        <h2>Бронирование</h2>-->
<!--                                        <h3>Нет информации</h3>-->
<!--                                    </div>-->
<!--                                    <div class="info">-->
<!--                                        <h2>Покупка</h2>-->
<!--                                        <h3>Нет информации</h3>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!---->
<!--                            <div class="friend-item">-->
<!--                                <div class="friend-main confirm">-->
<!--                                    <div class="title">-->
<!--                                        <h2>Александр</h2>-->
<!--                                        <h3>+7 (987) 965-98-98</h3>-->
<!--                                    </div>-->
<!--                                    <h4>Покупка совершена</h4>-->
<!--                                    <div class="circle"></div>-->
<!--                                </div>-->
<!--                                <div class="friend-hover">-->
<!--                                    <div class="info">-->
<!--                                        <h2>Консультация</h2>-->
<!--                                        <h3>Назначена на 21 мая 2021</h3>-->
<!--                                    </div>-->
<!--                                    <div class="info">-->
<!--                                        <h2>Бронирование</h2>-->
<!--                                        <h3>Нет информации</h3>-->
<!--                                    </div>-->
<!--                                    <div class="info">-->
<!--                                        <h2>Покупка</h2>-->
<!--                                        <h3>Нет информации</h3>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!---->
<!--                            <div class="friend-item">-->
<!--                                <div class="friend-main confirm">-->
<!--                                    <div class="title">-->
<!--                                        <h2>Инна</h2>-->
<!--                                        <h3>+7 (987) 345-98-98</h3>-->
<!--                                    </div>-->
<!--                                    <h4>Покупка совершена</h4>-->
<!--                                    <div class="circle"></div>-->
<!--                                </div>-->
<!--                                <div class="friend-hover">-->
<!--                                    <div class="info">-->
<!--                                        <h2>Консультация</h2>-->
<!--                                        <h3>Назначена на 21 мая 2021</h3>-->
<!--                                    </div>-->
<!--                                    <div class="info">-->
<!--                                        <h2>Бронирование</h2>-->
<!--                                        <h3>Нет информации</h3>-->
<!--                                    </div>-->
<!--                                    <div class="info">-->
<!--                                        <h2>Покупка</h2>-->
<!--                                        <h3>Нет информации</h3>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->

                        </div>
                    </div>

                    <div class="user-contacts <?php if($nav != 3){echo 'd-none';} ?>">
                        <h2>Контактные данные</h2>
                        <form method="post" id="user-contacts"></form>
                        <input type="hidden" name="n" value="3" form="user-contacts">
                        <input type="hidden" name="form-action" value="update-user-contacts" form="user-contacts">
                        <div class="info-field">
                            <p>ФИО<span>*</span></p>
                            <input type="text" name="fio" <?php if(!empty($user_data->first_name)){ print 'value="'.$user_data->first_name.'"'; } else { print 'placeholder="ФИО"'; } ?> form="user-contacts">
<!--                            <input type="text" name="f" --><?php //if(!empty($user_data->last_name)){ print 'value="'.$user_data->last_name.'"'; } else { print 'placeholder="Фамилия"'; } ?><!-- form="user-contacts">-->
                        </div>
                        <div class="info-field">
                            <p>Город<span>*</span></p>
                            <input type="text" name="city" <?php if(!empty($user_data->first_name)){ print 'value="'.$user_data->last_name.'"'; } else { print 'placeholder="Город"'; } ?> form="user-contacts">
                            <!--                            <input type="text" name="o" --><?php //if(isset($all_meta_for_user['patronymic'])){print 'value="'.$all_meta_for_user['patronymic'][0].'"';} else {print 'placeholder="Отчество"';} ?><!-- form="user-contacts">-->
                        </div>
                        <div class="info-field-date">
                            <p>Дата рождения</p>
<!--                            <div>-->
<!--                                <select name="day" id="day" form="user-contacts">-->
<!--                                    <option disabled selected>День</option>-->
<!--                                    <option value="1">1</option>-->
<!--                                    <option value="2">2</option>-->
<!--                                    <option value="3">3</option>-->
<!--                                </select>-->
<!--                                <select name="month" id="month" form="user-contacts">-->
<!--                                    <option disabled selected>Месяц</option>-->
<!--                                    <option value="1">01</option>-->
<!--                                    <option value="2">02</option>-->
<!--                                    <option value="3">03</option>-->
<!--                                </select>-->
<!--                                <select name="year" id="year" form="user-contacts">-->
<!--                                    <option disabled selected>Год</option>-->
<!--                                    <option value="2021">2021</option>-->
<!--                                    <option value="2020">2020</option>-->
<!--                                    <option value="2019">2019</option>-->
<!--                                </select>-->
<!--                            </div>-->
                            <div>
                                <input type="date" name="date" form="user-contacts" <?php if(isset($all_meta_for_user['date'])){ print 'value="'.$all_meta_for_user['date'][0].'"'; } ?>>
                            </div>
                        </div>
                        <div class="info-field-gender">
                            <p>Пол</p>
                            <div>
                                <input type="radio" id="male" name="gender" value="male" form="user-contacts" <?php if(isset($all_meta_for_user['gender'])){ if($all_meta_for_user['gender'][0] === 'male'){ print 'checked'; } } ?>>
                                <label for="male">Мужской</label>
                                <input type="radio" id="female" name="gender" value="female" form="user-contacts" <?php if(isset($all_meta_for_user['gender'])){ if($all_meta_for_user['gender'][0] === 'female'){ print 'checked'; } } ?>>
                                <label for="female">Женский</label>
                            </div>
                        </div>
                        <div class="info-field">
                            <p>E-mail<span>*</span></p>
                            <input type="email" name="email" <?php if(isset($all_meta_for_user['email'])){ print 'value="'.$all_meta_for_user['email'][0].'"'; } else { print 'placeholder="email@gmail.com"'; } ?> form="user-contacts">
                        </div>
                        <div class="info-field">
                            <p>Телефон<span>*</span></p>
                            <input type="text" name="tel" value="<?php print '+'.substr($user_data->user_login, 0, 1).'('.substr($user_data->user_login, 1, 3).')'.substr($user_data->user_login, 4, 3).'-'.substr($user_data->user_login, 7, 2).'-'.substr($user_data->user_login, 9, 2); ?>" readonly>
                        </div>
                        <div class="info-field-submit">
                            <input type="submit" value="Сохранить изменения" form="user-contacts">
                        </div>
                    </div>

                    <div class="user-pass <?php if($nav != 3){echo 'd-none';} ?>">
                        <h2>Сменить пароль</h2>
                        <form method="post" id="user-pass"></form>
                        <input type="hidden" name="n" value="3" form="user-pass">
                        <input type="hidden" name="form-action" value="update-user-password" form="user-pass">
                        <div class="pass-field-inputs">
                            <p>Все поля обязательны для заполнения<span>*</span></p>
                            <input type="password" name="old" placeholder="Текущий пароль" form="user-pass">
                            <input type="password" name="new" placeholder="Новый пароль" form="user-pass">
                            <input type="password" name="new2" placeholder="Повторите новый пароль" form="user-pass">
                        </div>
                        <div class="pass-field-submit">
                            <input type="submit" value="Сохранить изменения" form="user-pass">
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </main>

<?php
get_footer();
