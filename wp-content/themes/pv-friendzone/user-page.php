<?php
/*
    Template Name: ByNextPr - User Page
*/
get_header();
?>
<?php
    if(isset($_GET)){
        print_r($_GET);
    }
?>

    <div class="breadcrumbs">
        <div class="container">
            <div class="image">
                <a href="news.html">
                    <img src="images/arrow-left.svg" alt="arrow-left">
                </a>
            </div>
            <div class="link">
                <a href="index.html">На главную</a>
            </div>
        </div>
    </div>

    <main class="main">

        <div class="main-user">
            <div class="container">

                <div class="user-info">
                    <div>
                        <div class="avatar">
                            <img src="images/user-avatar.svg" alt="user-avatar">
                            <div class="avatar-add">
                                <img src="images/icon-cross.svg" alt="icon-cross">
                            </div>
                        </div>

                        <div class="user-pages">

                            <div class="page active">
                                <div class="icon body"></div>
                                <div class="text">Профиль</div>
                            </div>

                            <div class="page">
                                <div class="icon bodies"></div>
                                <div class="text">Друзья</div>
                            </div>

                            <div class="page">
                                <div class="icon options"></div>
                                <div class="text">Настройки</div>
                            </div>

                        </div>
                        <div class="question">
                            <button id="user-question-button">Задать вопрос</button>
                        </div>
                    </div>
                </div>

                <div class="user-pages">

                    <div class="user-code">
                        <h2>Уникальный код</h2>
                        <h3>348595NZ</h3>
                        <div class="info">
                            <div>Ваша индивидуальная ссылка и код</div>
                            <button>Копировать</button>
                        </div>
                    </div>

                    <div class="user-bonus">
                        <h2>Бонусный счет</h2>
                        <div class="info">
                            <h3>105 000 баллов</h3>
                            <button id="user-money-button">Вывести</button>
                        </div>
                        <a href="#">Операции по счету</a>
                    </div>

                    <div class="user-bank">
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

                    <div class="user-friends">
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

                    <div class="user-info">
                        <h2>Контактные данные</h2>
                        <form action="user.html" method="get" id="user"></form>
                        <div class="info-field">
                            <p>Фамилия<span>*</span></p>
                            <input type="text" name="f" placeholder="Иванов" form="user">
                        </div>
                        <div class="info-field">
                            <p>Имя<span>*</span></p>
                            <input type="text" name="i" placeholder="Иван" form="user">
                            <input type="text" name="o" placeholder="Отчество" form="user">
                        </div>
                        <div class="info-field-date">
                            <p>Дата рождения</p>
                            <div>
                                <select name="day" id="day" form="user">
                                    <option disabled selected>День</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                                <select name="month" id="month" form="user">
                                    <option disabled selected>Месяц</option>
                                    <option value="1">01</option>
                                    <option value="2">02</option>
                                    <option value="3">03</option>
                                </select>
                                <select name="year" id="year" form="user">
                                    <option disabled selected>Год</option>
                                    <option value="2021">2021</option>
                                    <option value="2020">2020</option>
                                    <option value="2019">2019</option>
                                </select>
                            </div>
                            <div>
                                <input type="date" name="date">
                            </div>
                        </div>
                        <div class="info-field-gender">
                            <p>Пол</p>
                            <div>
                                <input type="radio" id="male" name="gender" checked form="user">
                                <label for="male">Мужской</label>
                                <input type="radio" id="female" name="gender" form="user">
                                <label for="female">Женский</label>
                            </div>
                        </div>
                        <div class="info-field">
                            <p>E-mail<span>*</span></p>
                            <input type="email" name="email" placeholder="ivan2124@gmail.com" form="user">
                        </div>
                        <div class="info-field">
                            <p>Телефон<span>*</span></p>
                            <input type="text" name="tel" placeholder="+7 (987) 654-32-12" form="user">
                        </div>
                        <div class="info-field-submit">
                            <input type="submit" value="Сохранить изменения" form="user">
                        </div>
                    </div>

                    <div class="user-pass">
                        <h2>Сменить пароль</h2>
                        <form action="user.html" method="get" id="pass"></form>
                        <div class="pass-field-inputs">
                            <p>Все поля обязательны для заполнения<span>*</span></p>
                            <input type="password" name="old" placeholder="Текущий пароль" form="pass">
                            <input type="password" name="new" placeholder="Новый пароль" form="pass">
                            <input type="password" name="new2" placeholder="Повторите новый пароль" form="pass">
                        </div>
                        <div class="pass-field-submit">
                            <input type="submit" value="Сохранить изменения" form="user">
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </main>

<?php
get_footer();
