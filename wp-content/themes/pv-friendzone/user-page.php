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
                <a href="http://bynextpr.ru/">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/arrow-left.svg" alt="arrow-left">
                </a>
            </div>
            <div class="link">
                <a href="http://bynextpr.ru/">На главную</a>
            </div>
        </div>
    </div>

    <main class="main">

        <div class="main-user">
            <div class="container">

                <div class="user-main-info">
                    <div>
                        <div class="avatar">
                            <img src="<?php if(isset($all_meta_for_user['user_avatar'])){print wp_get_attachment_image_url($all_meta_for_user['user_avatar'][0]);} else {echo get_template_directory_uri().'/assets/images/question-red.svg';} ?>" alt="user-avatar">
                            <form enctype="multipart/form-data" method="post" id="user-avatar">
                                <input type="hidden" name="form-action" value="update-user-avatar" form="user-avatar">
                                <input class="d-none" type="file" name="avatar" id="user-avatar-select" form="user-avatar">
                            </form>
                            <label class="avatar-add" for="user-avatar-select">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icon-cross.svg" alt="icon-cross">
                            </label>
                        </div>

                        <div class="user-pages">

                            <a class="page <?php if($nav == 1 || $nav == 0){echo 'active';} ?>" href="http://bynextpr.ru/user/?n=1">
                                <div class="icon body"></div>
                                <div class="text">Профиль</div>
                            </a>

                            <a class="page <?php if($nav == 2){echo 'active';} ?>" href="http://bynextpr.ru/user/?n=2">
                                <div class="icon bodies"></div>
                                <div class="text">Друзья</div>
                            </a>

                            <a class="page <?php if($nav == 3){echo 'active';} ?>" href="http://bynextpr.ru/user/?n=3">
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
                            <div>Ваша индивидуальная ссылка и код</div>
                            <button>Копировать</button>
                        </div>
                    </div>

                    <div class="user-bonus <?php if($nav != 1 || $nav != 1){echo 'd-none';} ?>">
                        <h2>Бонусный счет</h2>
                        <div class="info">
                            <h3>105 000 баллов</h3>
                            <button id="user-money-button">Вывести</button>
                        </div>
                        <a href="#">Операции по счету</a>
                    </div>

                    <div class="user-bank <?php if($nav != 1 || $nav != 1){echo 'd-none';} ?>">
                        <h2>Копилка</h2>
                        <p>Наберите необходимое количество баллов и получите скидку 300 000 рублей на свою квартиру</p>
                        <div class="progress">
                            <div class="start"></div>
                            <div class="line"><div></div></div>
                            <div class="end"></div>
                            <div class="range"></div>
                        </div>
                        <div class="info">
                            <div>
                                <h3>Текущий баланс</h3>
                                <h2 class="color-red">105 000</h2>
                            </div>
                            <div>
                                <h3>Осталось до скидки</h3>
                                <h2 class="color-black">2 395 000</h2>
                            </div>
                        </div>
                    </div>

                    <div class="user-friends <?php if($nav != 2){echo 'd-none';} ?>">
                        <h2>Список друзей</h2>
                        <div class="friends-list">

                            <div class="friend-item">
                                <div class="friend-main not-confirm">
                                    <div class="title">
                                        <h2>Виктория</h2>
                                        <h3>+7 (902) 344-23-15</h3>
                                    </div>
                                    <h4>Ожидайте проведения переговоров</h4>
                                    <div class="circle"></div>
                                    <div class="friend-hover">
                                        <div class="info">
                                            <h2>Консультация</h2>
                                            <h3>Назначена на 21 мая 2021</h3>
                                        </div>
                                        <div class="info">
                                            <h2>Бронирование</h2>
                                            <h3>Нет информации</h3>
                                        </div>
                                        <div class="info">
                                            <h2>Покупка</h2>
                                            <h3>Нет информации</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="friend-item">
                                <div class="friend-main not-confirm">
                                    <div class="title">
                                        <h2>Жанна</h2>
                                        <h3>+7 (913) 942-93-11</h3>
                                    </div>
                                    <h4>Ожидайте проведения переговоров</h4>
                                    <div class="circle"></div>
                                    <div class="friend-hover">
                                        <div class="info">
                                            <h2>Консультация</h2>
                                            <h3>Назначена на 21 мая 2021</h3>
                                        </div>
                                        <div class="info">
                                            <h2>Бронирование</h2>
                                            <h3>Нет информации</h3>
                                        </div>
                                        <div class="info">
                                            <h2>Покупка</h2>
                                            <h3>Нет информации</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="friend-item">
                                <div class="friend-main not-confirm active">
                                    <div class="title">
                                        <h2>Виктория</h2>
                                        <h3>+7 (902) 344-23-15</h3>
                                    </div>
                                    <h4>Ожидайте проведения переговоров</h4>
                                    <div class="circle"></div>
                                    <div class="friend-hover">
                                        <div class="info">
                                            <h2>Консультация</h2>
                                            <h3>Назначена на 21 мая 2021</h3>
                                        </div>
                                        <div class="info">
                                            <h2>Бронирование</h2>
                                            <h3>Нет информации</h3>
                                        </div>
                                        <div class="info">
                                            <h2>Покупка</h2>
                                            <h3>Нет информации</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="friend-item">
                                <div class="friend-main confirm">
                                    <div class="title">
                                        <h2>Кристина</h2>
                                        <h3>+7 (900) 965-98-98</h3>
                                    </div>
                                    <h4>Покупка совершена</h4>
                                    <div class="circle"></div>
                                </div>
                                <div class="friend-hover">
                                    <div class="info">
                                        <h2>Консультация</h2>
                                        <h3>Назначена на 21 мая 2021</h3>
                                    </div>
                                    <div class="info">
                                        <h2>Бронирование</h2>
                                        <h3>Нет информации</h3>
                                    </div>
                                    <div class="info">
                                        <h2>Покупка</h2>
                                        <h3>Нет информации</h3>
                                    </div>
                                </div>
                            </div>

                            <div class="friend-item">
                                <div class="friend-main confirm">
                                    <div class="title">
                                        <h2>Александр</h2>
                                        <h3>+7 (987) 965-98-98</h3>
                                    </div>
                                    <h4>Покупка совершена</h4>
                                    <div class="circle"></div>
                                </div>
                                <div class="friend-hover">
                                    <div class="info">
                                        <h2>Консультация</h2>
                                        <h3>Назначена на 21 мая 2021</h3>
                                    </div>
                                    <div class="info">
                                        <h2>Бронирование</h2>
                                        <h3>Нет информации</h3>
                                    </div>
                                    <div class="info">
                                        <h2>Покупка</h2>
                                        <h3>Нет информации</h3>
                                    </div>
                                </div>
                            </div>

                            <div class="friend-item">
                                <div class="friend-main confirm">
                                    <div class="title">
                                        <h2>Инна</h2>
                                        <h3>+7 (987) 345-98-98</h3>
                                    </div>
                                    <h4>Покупка совершена</h4>
                                    <div class="circle"></div>
                                </div>
                                <div class="friend-hover">
                                    <div class="info">
                                        <h2>Консультация</h2>
                                        <h3>Назначена на 21 мая 2021</h3>
                                    </div>
                                    <div class="info">
                                        <h2>Бронирование</h2>
                                        <h3>Нет информации</h3>
                                    </div>
                                    <div class="info">
                                        <h2>Покупка</h2>
                                        <h3>Нет информации</h3>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="user-contacts <?php if($nav != 3){echo 'd-none';} ?>">
                        <h2>Контактные данные</h2>
                        <form method="post" id="user-contacts"></form>
                        <input type="hidden" name="n" value="3" form="user-contacts">
                        <input type="hidden" name="form-action" value="update-user-contacts" form="user-contacts">
                        <div class="info-field">
                            <p>Фамилия<span>*</span></p>
                            <input type="text" name="f" <?php if(!empty($user_data->last_name)){ print 'value="'.$user_data->last_name.'"'; } else { print 'placeholder="Фамилия"'; } ?> form="user-contacts">
                        </div>
                        <div class="info-field">
                            <p>Имя<span>*</span></p>
                            <input type="text" name="i" <?php if(!empty($user_data->first_name)){ print 'value="'.$user_data->first_name.'"'; } else { print 'placeholder="Имя"'; } ?> form="user-contacts">
                            <input type="text" name="o" <?php if(isset($all_meta_for_user['patronymic'])){print 'value="'.$all_meta_for_user['patronymic'][0].'"';} else {print 'placeholder="Отчество"';} ?> form="user-contacts">
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
