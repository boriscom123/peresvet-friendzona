<?php
/*
    Template Name: ByNextPr - User Page
*/
get_header();
?>
<?php
if (is_user_logged_in()) {
    $userPageResult = [];
    $user_data = get_userdata(get_current_user_id());
    $all_meta_for_user = get_user_meta(get_current_user_id());
    $avatar = get_avatar_url(get_current_user_id());
    $user_lead_id = $all_meta_for_user['amo-lead-id'][0];
    if ($user_lead_id == '') {
        $userPageResult['user_lead_id'] = 'Не задана основная сделка для пользователя';
    } else {
        $amo_integration_page = get_page_by_title('Интеграция с АМО СРМ');
        $content = $amo_integration_page->post_content;
        $content = mb_substr($content, mb_strpos($content, '{'), mb_strpos($content, '}') - mb_strpos($content, '{') + 1);
        $content = json_decode($content);

        if ($content->access_token === null) {
            echo "Нет связи с АМО СРМ";
        } else {
            $all_leads = get_all_linked_leads($content->domain, $content->access_token, $all_meta_for_user['amo-lead-id'][0]);
            $user_main_lead = [];
            $user_connected_leads = [];
            $form_link = '';
            if ($all_leads['_embedded']['leads']) {
                foreach ($all_leads['_embedded']['leads'] as $lead) {
                    if ($lead['id'] != $all_meta_for_user['amo-lead-id'][0]) {
                        $user_connected_leads[] = $lead;
                    } else {
                        $user_main_lead = $lead;
                        if ($lead['custom_fields_values']) {
                            foreach ($lead['custom_fields_values'] as $cf) {
                                if ($cf['field_id'] == 384025) {
                                    $form_link = $cf['values'][0]['value'];
                                }
                            }
                        }
                    }
                }
            }

            $user_bonus_balance = 0;
            if (count($user_connected_leads) > 0) {
                // print_r($user_connected_leads_id);
                foreach ($user_connected_leads as $lead) {
                    if ($lead['status_id'] === 142 || $lead['status_id'] === 35437765) {
                        $user_bonus_balance += 40000;
                    }
                }
            }

            $user_money_balance = 0;
            foreach ($user_main_lead['custom_fields_values'] as $cf) {
                if ($cf['field_name'] == "Вознаграждение получено") {
                    $user_money_balance = $cf['values'][0]['value'];
                }
            }

            $user_bonus_balance = $user_bonus_balance - $user_money_balance;
            if ($user_bonus_balance < 0) {
                $user_bonus_balance = 0;
            }

            $show_bonuses = '';
            if (strlen($user_bonus_balance) > 3 && strlen($user_bonus_balance) < 7) {
                $show_bonuses = substr($user_bonus_balance, 0, strlen($user_bonus_balance) - 3) . ' ' . substr($user_bonus_balance, strlen($user_bonus_balance) - 3, strlen($user_bonus_balance));
            } elseif (strlen($user_bonus_balance) > 6 && strlen($user_bonus_balance) < 10) {
                $show_bonuses = substr($user_bonus_balance, 0, strlen($user_bonus_balance) - 6) . ' ' . substr($user_bonus_balance, strlen($user_bonus_balance) - 6, strlen($user_bonus_balance) - 3) . ' ' . substr($user_bonus_balance, strlen($user_bonus_balance) - 3, strlen($user_bonus_balance));
            } elseif (strlen($user_bonus_balance) > 9 && strlen($user_bonus_balance) < 13) {
                $show_bonuses = $user_bonus_balance;
            } else {
                $show_bonuses = $user_bonus_balance;
            }

            $progress_bar = $user_bonus_balance / (1440000 / 100);
        }
    }


}
if (isset($_GET)) {
}
if (isset($_POST)) {
}
if (isset($_GET['n'])) {
    $nav = $_GET['n'];
} else {
    $nav = 0;
}
if (isset($_POST['n'])) {
    $nav = $_POST['n'];
}
?>
    <div class="d-none">
        <?php
        if ($content->access_token === null) {
            echo "Нет связи с АМО СРМ";
        } else {
            echo "Связь с АМО СРМ установлена. Смотрим подготовленные данные";
        }
        ?>
    </div>
    <div class="breadcrumbs">
        <div class="container">
            <div class="image">
                <a href="https://fz2020.ru/">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/arrow-left.svg"
                         alt="arrow-left">
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
                            <img src="<?php if (isset($all_meta_for_user['user_avatar'])) {
                                print wp_get_attachment_image_url($all_meta_for_user['user_avatar'][0]);
                            } else {
                                echo get_template_directory_uri() . '/assets/images/avatar-new-grey.svg';
                            } ?>" alt="user-avatar">
                            <form enctype="multipart/form-data" method="post" id="user-avatar">
                                <input type="hidden" name="form-action" value="update-user-avatar" form="user-avatar">
                                <input class="d-none" type="file" name="avatar" id="user-avatar-select"
                                       form="user-avatar">
                            </form>
                            <label class="avatar-add" for="user-avatar-select">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icon-cross.svg"
                                     alt="icon-cross">
                            </label>
                        </div>

                        <div class="user-pages">

                            <a class="page <?php if ($nav == 1 || $nav == 0) {
                                echo 'active';
                            } ?>" href="https://fz2020.ru/user/?n=1">
                                <div class="icon body"></div>
                                <div class="text">Профиль</div>
                            </a>

                            <a class="page <?php if ($nav == 2) {
                                echo 'active';
                            } ?>" href="https://fz2020.ru/user/?n=2">
                                <div class="icon bodies"></div>
                                <div class="text">Друзья</div>
                            </a>

                            <a class="page <?php if ($nav == 3) {
                                echo 'active';
                            } ?>" href="https://fz2020.ru/user/?n=3">
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

                    <div class="user-code <?php if ($nav != 1) {
                        echo 'd-none';
                    } else {
                        echo 'd-flex';
                    } ?>">
                        <div class="code">
                            <h2>Уникальный код</h2>
                            <h3 data-code="<?php if (isset($all_meta_for_user['amo-lead-id'])) {
                                print $all_meta_for_user['amo-lead-id'][0];
                            } ?>" id="copy-code"><?php if (isset($all_meta_for_user['amo-lead-id'])) {
                                    print $all_meta_for_user['amo-lead-id'][0];
                                } ?></h3>
                        </div>
                        <div class="link">
                            <button data-link="<?php echo $form_link; ?>" id="copy-link">Копировать индивидуальную
                                ссылку
                            </button>
                        </div>
                    </div>

                    <div class="user-bonus <?php if ($nav != 1) {
                        echo 'd-none';
                    } ?>">
                        <h2>Бонусный счет</h2>
                        <div class="info">
                            <h3><?php echo $show_bonuses; ?> баллов</h3>
                            <button id="user-money-button" data-max-summ="<?php echo $user_bonus_balance; ?>">Вывести
                            </button>
                        </div>
                        <?php
                        if (isset($user_money_balance) && $user_money_balance > 0) {
                            echo "<a href='#'>Всего выведено: {$user_money_balance}</a>";
                        } else {
                            echo "<a href='#'>Операций по счету нет</a>";
                        }
                        ?>
                    </div>

                    <div class="user-bank <?php if ($nav != 1) {
                        echo 'd-none';
                    } ?>">
                        <h2>Копилка</h2>
                        <p>Наберите необходимое количество баллов и получите скидку 560 000 рублей на свою квартиру</p>
                        <div class="progress">
                            <div class="start"></div>
                            <div class="line">
                                <div style="width: <?php echo $progress_bar; ?>%"></div>
                            </div>
                            <div class="end"></div>
                            <div class="range" style="left: <?php echo $progress_bar; ?>%"></div>
                        </div>
                        <div class="info">
                            <div>
                                <h3>Текущий баланс</h3>
                                <h2 class="color-red"><?php echo $show_bonuses; ?></h2>
                            </div>
                            <div>
                                <h3>Необходимо для скидки</h3>
                                <h2 class="color-black">1 440 000</h2>
                            </div>
                        </div>
                    </div>

                    <div class="user-friends <?php if ($nav != 2) {
                        echo 'd-none';
                    } ?>">
                        <h2>Список друзей</h2>
                        <div class="friends-list">

                            <?php
                            if (count($user_connected_leads) > 0) {
                                foreach ($user_connected_leads as $lead) {
                                    if ($lead['_embedded']['contacts'][0]['id']) {
                                        $contact_id = $lead['_embedded']['contacts'][0]['id'];
                                    }

                                    $contact_tel = 0;
                                    if ($contact_id > 0) {
                                        $contact = get_contact_by_id($content->domain, $content->access_token, $contact_id);

                                        $contact_name = $contact['name'];
                                        foreach ($contact['custom_fields_values'] as $field) {
                                            if ($field['field_id'] === 248661)
                                                $contact_tel = prepareLogin($field['values'][0]['value']);
                                        }

                                        $status = get_pipline_status($lead['status_id']);
                                        $status_date = date('d-m-Y', $lead['updated_at']);
                                        if ($lead['status_id'] === 143) {
                                            $reason = $lead['_embedded']['loss_reason'][0]['name'];
                                        }
                                    }
                                    ?>
                                    <div class="friend-item">
                                        <div class="friend-main <?php if ($status !== 'Успешная рекомендация') {
                                            echo 'not-';
                                        } ?>confirm">
                                            <div class="title">
                                                <h2><?php echo $contact_name; ?></h2>
                                                <h3><?php echo '+' . substr($contact_tel, 0, 1) . ' (***) ***-' . substr($contact_tel, 7, 2) . '-' . substr($contact_tel, 9, 2); ?></h3>
                                            </div>
                                            <h4><?php echo $status; ?></h4>
                                            <div class="circle"></div>
                                            <?php
                                            if ($status !== 'Успешная рекомендация') { ?>
                                                <div class="friend-hover">
                                                    <div class="info">
                                                        <div class="title">
                                                            <h2><?php echo $status; ?></h2>
                                                            <h3><?php echo $status_date; ?></h3>
                                                        </div>
                                                        <?php
                                                        if ($lead['status_id'] === 143) {
                                                            echo "<h2>{$reason}</h2>";
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </div>

                    <div class="user-contacts <?php if ($nav != 3) {
                        echo 'd-none';
                    } ?>">
                        <h2>Контактные данные</h2>
                        <form method="post" id="user-contacts"></form>
                        <input type="hidden" name="n" value="3" form="user-contacts">
                        <input type="hidden" name="form-action" value="update-user-contacts" form="user-contacts">
                        <div class="info-field">
                            <p>ФИО<span>*</span></p>
                            <input type="text" name="fio" <?php if (!empty($user_data->first_name)) {
                                print 'value="' . $user_data->first_name . '"';
                            } else {
                                print 'placeholder="ФИО"';
                            } ?> form="user-contacts">
                        </div>
                        <div class="info-field">
                            <p>Город<span>*</span></p>
                            <input type="text" name="city" <?php if (!empty($user_data->first_name)) {
                                print 'value="' . $user_data->last_name . '"';
                            } else {
                                print 'placeholder="Город"';
                            } ?> form="user-contacts">
                        </div>
                        <div class="info-field-date">
                            <p>Дата рождения</p>
                              <div>
                                <input type="date" name="date"
                                       form="user-contacts" <?php if (isset($all_meta_for_user['date'])) {
                                    print 'value="' . $all_meta_for_user['date'][0] . '"';
                                } ?>>
                            </div>
                        </div>
                        <div class="info-field-gender">
                            <p>Пол</p>
                            <div>
                                <input type="radio" id="male" name="gender" value="male"
                                       form="user-contacts" <?php if (isset($all_meta_for_user['gender'])) {
                                    if ($all_meta_for_user['gender'][0] === 'male') {
                                        print 'checked';
                                    }
                                } ?>>
                                <label for="male">Мужской</label>
                                <input type="radio" id="female" name="gender" value="female"
                                       form="user-contacts" <?php if (isset($all_meta_for_user['gender'])) {
                                    if ($all_meta_for_user['gender'][0] === 'female') {
                                        print 'checked';
                                    }
                                } ?>>
                                <label for="female">Женский</label>
                            </div>
                        </div>
                        <div class="info-field">
                            <p>E-mail<span>*</span></p>
                            <input type="email" name="email" <?php if (isset($all_meta_for_user['email'])) {
                                print 'value="' . $all_meta_for_user['email'][0] . '"';
                            } else {
                                print 'placeholder="email@gmail.com"';
                            } ?> form="user-contacts">
                        </div>
                        <div class="info-field">
                            <p>Телефон<span>*</span></p>
                            <input type="text" name="tel"
                                   value="<?php print '+' . substr($user_data->user_login, 0, 1) . '(' . substr($user_data->user_login, 1, 3) . ')' . substr($user_data->user_login, 4, 3) . '-' . substr($user_data->user_login, 7, 2) . '-' . substr($user_data->user_login, 9, 2); ?>"
                                   readonly>
                        </div>
                        <div class="info-field-submit">
                            <input type="submit" value="Сохранить изменения" form="user-contacts">
                        </div>
                    </div>

                    <div class="user-pass <?php if ($nav != 3) {
                        echo 'd-none';
                    } ?>">
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
