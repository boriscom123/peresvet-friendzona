<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package pv-friendZONE
 */

get_header();
?>

	<main id="primary" class="site-main">

        <div class="main">

            <div class="main-block-1">
            <div class="container">
                <div class="main-block-1-container-info">
                    <div class="text-block" id="slider-text">
                        <div class="text">
                            <h2>Счастье не в друзьях, а в их количестве!</h2>
                            <h1>Помоги другу купить квартиру и получи<br>40 000 ₽</h1>
                        </div>
                        <div class="text d-none">
                            <h2>FRIENDзона — пространство возможностей</h2>
                            <h1>Присоединяйтесь к уникальному сообществу единомышленников и экспертов недвижимости</h1>
                        </div>
                        <div class="text d-none">
                            <h2>FRIENDзона — пространство возможностей</h2>
                            <h1>Купите себе квартиру со скидкой в 300 000 ₽</h1>
                        </div>
                    </div>
                    <div class="main-block-1-container-info-navigation">
                        <button>Узнать подробнее</button>
                        <div class="scroll-buttons">
                            <button class="left" id="slider-left-button"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/chevron-left.svg" alt="chevron-left"></button>
                            <button class="right" id="slider-right-button"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/chevron-right.svg" alt="chevron-right"></button>
                        </div>
                        <div class="pagination" id="slider-pagination">
                            <div class="circle active"></div>
                            <div class="circle"></div>
                            <div class="circle"></div>
                        </div>
                    </div>
                </div>
                <div class="main-block-1-container-image" id="slider-images">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/block-1-image-1.svg" alt="block-1-image">
                    <img class="d-none" src="<?php echo get_template_directory_uri(); ?>/assets/images/block-1-image-2.svg" alt="block-2-image">
                    <img class="d-none" src="<?php echo get_template_directory_uri(); ?>/assets/images/block-1-image-3.svg" alt="block-3-image">
                </div>
            </div>
        </div>

            <div class="main-block-2">
            <div class="main-block-2-top">
                <div class="container">
                    <div class="main-block-2-container-info">
                        <h2>Что такое FRIENDзона?</h2>
                        <h3>FRIENDзона — это уникальное сообщество людей, вдохновленных темой недвижимости</h3>
                        <div class="main-block-2-container-info-button" id="play-video-button-small">
                            <p>Смотреть видео</p>
                            <div class="circle">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/play.svg" alt="play">
                            </div>
                        </div>
                    </div>
                    <div class="main-block-2-container-image">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/block-2-image-notebook.svg" alt="notebook">
                        <div class="video">
                            <video controls="controls" poster="<?php echo get_template_directory_uri(); ?>/assets/images/test-image.jpg" id="video-container-small">
                                <!--                                <source src="video/duel.ogv" type='video/ogg; codecs="theora, vorbis"'>-->
                                <source src="<?php echo get_template_directory_uri(); ?>/assets/images/test-video.mp4" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"'>
                                <!--                                <source src="video/duel.webm" type='video/webm; codecs="vp8, vorbis"'>-->
                                Тег video не поддерживается вашим браузером.
                                <a href="<?php echo get_template_directory_uri(); ?>/assets/images/test-video.mp4">Скачайте видео</a>.
                            </video>
                        </div>
                        <div class="decoration">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/block-2-image-bg.svg" alt="block-2-image-bg">
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-block-2-bottom">
                <div class="container">
                    <div class="main-block-2-bottom-items">
                        <div class="main-block-2-bottom-item">
                            <div class="main-block-2-bottom-item-icon">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/block-2-ico-1.svg" alt="block-2-ico-1">
                            </div>
                            <p>Сообщество экспертов и&nbsp;единомышленников</p>
                        </div>
                        <div class="main-block-2-bottom-item">
                            <div class="main-block-2-bottom-item-icon">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/block-2-ico-2.svg" alt="block-2-ico-2">
                            </div>
                            <p>Эксклюзивная информация и&nbsp;качественная аналитика</p>
                        </div>
                        <div class="main-block-2-bottom-item">
                            <div class="main-block-2-bottom-item-icon">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/block-2-ico-3.svg" alt="block-2-ico-3">
                            </div>
                            <p>Система мотивации и&nbsp;возможность заработать</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

            <div class="main-block-3">
            <div class="container">
                <div class="main-block-3-1">
                    <h2>Ключевое слово <br>FRIEND - друг</h2>
                    <div class="text">
                        <p>
                            FRIENDзона основана на взаимовыгодном сотрудничестве - мы даем вам эксклюзивную информацию и качественную аналитику,
                            вы рекомендуете нас друзьям и получаете вознаграждение, ваши друзья приобретают у нас комфортные квартиры со скидкой,
                            а у нас растет количество клиентов
                        </p>
                        <div class="decoration"></div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="main-block-3-2">
                    <div class="main-block-3-info-item main-item">
                        <h2>FRIENDзона</h2>
                    </div>
                    <div class="main-block-3-info-item image-item">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/block-3-img-1.svg" alt="block-3-img-1">
                    </div>
                    <div class="main-block-3-info-item info-item">
                        <h3>Для тебя</h3>
                        <p>Вознаграждения в размере 25 000 ₽ или 40 000 ₽, возможность заработать на квартиру со скидкой, бонусы и привилегии</p>
                    </div>
                    <div class="main-block-3-info-item image-item">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/block-3-img-2.svg" alt="block-3-img-2">
                    </div>
                    <div class="main-block-3-info-item image-item">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/block-3-img-3.svg" alt="block-3-img-3">
                    </div>
                    <div class="main-block-3-info-item info-item">
                        <h3>Для твоих друзей</h3>
                        <p>Качественные квартиры в Москве, Санкт-Петербурге и на юге России без комиссии и со скидкой</p>
                    </div>
                    <div class="main-block-3-info-item image-item">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/block-3-img-4.svg" alt="block-3-img-4">
                    </div>
                    <div class="main-block-3-info-item info-item">
                        <h3>Для нас</h3>
                        <p>Рост количества довольных клиентов, сообщество единомышленников</p>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="main-block-3-3">
                    <h2>Как работает <br>FRIENDзона?</h2>
                    <div class="text">
                        <p>
                            Участие абсолютно бесплатно, более того, вы получаете вознаграждение за свои рекомендации
                        </p>
                        <div class="decoration"></div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="main-block-3-4">
                    <div class="main-block-3-4-item">
                        <div class="image">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/block-3-image-5.svg" alt="block-3-image-5">
                        </div>
                        <div class="info">
                            <h2>Регистрируйтесь</h2>
                            <p>Зарегистрируйся в личном кабинете и получи уникальный код</p>
                        </div>
                        <div class="decoration">
                            <p>01</p>
                        </div>
                    </div>
                    <div class="main-block-3-4-item">
                        <div class="image">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/block-3-image-6.svg" alt="block-3-image-6">
                        </div>
                        <div class="info">
                            <h2>Рекомендуйте</h2>
                            <p>Рекомендуй нас друзьям, которые ищут квартиру в Москве, Санкт-Петербурге и на юге России</p>
                        </div>
                        <div class="decoration">
                            <p>02</p>
                        </div>
                    </div>
                    <div class="main-block-3-4-item">
                        <div class="image">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/block-3-image-7.svg" alt="block-3-image-7">
                        </div>
                        <div class="info">
                            <h2>Получайте деньги</h2>
                            <p>25 000 или 40 000 ₽ в зависимости от стоимости квартиры после того, как друг совершит покупку</p>
                        </div>
                        <div class="decoration">
                            <p>03</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

            <div class="main-block-4">
            <div class="container">
                <div class="main-block-4-1">
                    <h2>В чем уникальность <br>FRIENDзоны?</h2>
                    <div class="text">
                        <p>
                            Уникальность программы базируется на системе помощи участникам, состоящей из информационного и мотивационного блока
                        </p>
                        <div class="decoration"></div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="main-block-4-2">
                    <div class="image">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/block-4-image-1.svg" alt="block-4-image-1">
                    </div>
                    <div class="info">
                        <div class="info-block">
                            <h2>Информационный блок</h2>
                            <div>
                                <div class="decoration"></div>
                                <p>Эксклюзивная и своевременная инсайдерская информация</p>
                            </div>
                            <div>
                                <div class="decoration"></div>
                                <p>Раскрытие достоинств и недостатков каждого объекта и застройщика</p>
                            </div>
                            <div>
                                <div class="decoration"></div>
                                <p>Качественная инвестиционная аналитика</p>
                            </div>
                            <div>
                                <div class="decoration"></div>
                                <p>Решения часто встречающихся вопросов</p>
                            </div>
                        </div>
                        <div class="info-block">
                            <h2>Мотивационный блок</h2>
                            <div>
                                <div class="decoration"></div>
                                <p>Возможность стабильного дополнительного дохода без отрыва от работы</p>
                            </div>
                            <div>
                                <div class="decoration"></div>
                                <p>Вознаграждение за рекомендацию в размере 25&nbsp;000 или 40&nbsp;000 рублей в зависимости от того, какую квартиру купил ваш друг</p>
                            </div>
                            <div>
                                <div class="decoration"></div>
                                <p>Скидка 300 000 рублей на покупку собственной квартиры, при накоплении необходимого количества баллов</p>
                            </div>
                            <div>
                                <div class="decoration"></div>
                                <p>VIP-статус с постоянными льготами, скидками и&nbsp;бонусами</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

            <div class="main-block-5">
            <div class="container">
                <div class="main-block-5-info">
                    <h2>Присоединяйся к сообществу <br>FRIENDзона прямо сейчас!</h2>
                    <button class="registration-button">Регистрация</button>
                </div>
                <div class="main-block-5-image">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/block-5-img-1.svg" alt="block-5-img-1">
                </div>
            </div>
        </div>

            <div class="main-block-6">
            <div class="container">
                <div class="main-block-6-1">
                    <h2>Ответы на вопросы</h2>
                    <div class="text">
                        <p>
                            Вы можете посмотреть ответы на самые популярные вопросы ниже или отправить нам свой вопрос через форму обратной связи
                        </p>
                        <div class="decoration"></div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="main-block-6-2">
                    <div class="item-question">
                        <h2>Здесь нужно разместить текст какого-нибудь вопроса?</h2>
                        <p>
                            Каждый платёж по кредиту состоит из двух частей: одна часть идёт на погашение основного долга,
                            другая — на погашение банковских процентов по нему (той самой ставки по кредиту).
                            Большинство банков в России сейчас работают с аннуитетными платежами:
                            в этом случае банк сначала стремится получить все выплаты по процентам,
                            которые вы должны, и только потом - по основному телу долга.
                            Через несколько лет выплаты кредита основное тело долга может уменьшиться совсем немного,
                            так как основная часть взносов идёт на погашение процентов.
                        </p>
                        <div class="close">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icon-cross.svg" alt="icon-cross">
                        </div>
                    </div>
                    <div class="item-question brief">
                        <h2>Здесь нужно разместить текст какого-нибудь вопроса?</h2>
                        <p>
                            Каждый платёж по кредиту состоит из двух частей: одна часть идёт на погашение основного долга,
                            другая — на погашение банковских процентов по нему (той самой ставки по кредиту).
                            Большинство банков в России сейчас работают с аннуитетными платежами:
                            в этом случае банк сначала стремится получить все выплаты по процентам,
                            которые вы должны, и только потом - по основному телу долга.
                            Через несколько лет выплаты кредита основное тело долга может уменьшиться совсем немного,
                            так как основная часть взносов идёт на погашение процентов.
                        </p>
                        <div class="close">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icon-cross.svg" alt="icon-cross">
                        </div>
                    </div>
                    <div class="item-question brief">
                        <h2>Здесь нужно разместить текст какого-нибудь вопроса?</h2>
                        <p>
                            Каждый платёж по кредиту состоит из двух частей: одна часть идёт на погашение основного долга,
                            другая — на погашение банковских процентов по нему (той самой ставки по кредиту).
                            Большинство банков в России сейчас работают с аннуитетными платежами:
                            в этом случае банк сначала стремится получить все выплаты по процентам,
                            которые вы должны, и только потом - по основному телу долга.
                            Через несколько лет выплаты кредита основное тело долга может уменьшиться совсем немного,
                            так как основная часть взносов идёт на погашение процентов.
                        </p>
                        <div class="close">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icon-cross.svg" alt="icon-cross">
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="main-block-6-3">
                    <div class="main-block-6-video">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/play.svg" alt="play-video-button" id="play-video-button-big">
                        <video poster="<?php echo get_template_directory_uri(); ?>/assets/images/test-image.jpg" id="video-container-big" id="video-container-big">
                            <source src="<?php echo get_template_directory_uri(); ?>/assets/images/test-video.mp4" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"'>
                            Тег video не поддерживается вашим браузером.
                            <a href="<?php echo get_template_directory_uri(); ?>/assets/images/test-video.mp4">Скачайте видео</a>.
                        </video>
                    </div>
                    <div class="main-block-6-button">
                        <button>Смотреть еще</button>
                    </div>
                </div>
            </div>
        </div>

            <div class="main-block-7">
            <div class="container">
                <div class="main-block-7-1">
                    <h2>Избранные новости</h2>
                    <div class="text">
                        <p>
                            Следите за новостями компании, получайте полезную информацию и будьте в курсе всех актуальных событий
                        </p>
                        <div class="decoration"></div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="main-block-7-2">
                    <div class="main-block-7-news">
                        <div class="item-news">
                            <div class="image">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/test-image.jpg" alt="test-image">
                            </div>
                            <p>8 февраля 2021</p>
                            <h2>Оформление новостройки в собственность</h2>
                        </div>
                        <div class="item-news">
                            <div class="image">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/test-image.jpg" alt="test-image">
                            </div>
                            <p>8 февраля 2021</p>
                            <h2>Новостройка или вторичка? Муки выбора</h2>
                        </div>
                        <div class="item-news">
                            <div class="image">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/test-image.jpg" alt="test-image">
                            </div>
                            <p>8 февраля 2021</p>
                            <h2>Как купить квартиру без первоначального взноса по ипотеке</h2>
                        </div>
                    </div>
                    <div class="main-block-7-button">
                        <a href="http://bynextpr.ru/news/">Все новости</a>
                    </div>
                </div>
            </div>
        </div>

            <div class="main-block-8">
            <div class="container">
                <div class="about">
                    <h2>Хотите узнать больше?</h2>
                    <div>
                        <p>Телефон: <a href="tel:+79825377331">+7 982 537-73-31</a></p>
                        <p>Почта: <a href="mailto:frend.zona2020@mail.ru">frend.zona2020@mail.ru</a></p>
                    </div>
                    <a href="#">Адреса наших офисов</a>
                </div>
                <div class="registration">
                    <div class="text">
                        <h2>Ждем вас в нашей команде</h2>
                        <button class="registration-button">Зарегистрироваться</button>
                    </div>
                    <div class="image">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/block-8-img-1.svg" alt="block-8-img-1">
                    </div>
                </div>
            </div>
        </div>

        </div>

	</main><!-- #main -->

<?php
// get_sidebar();
get_footer();
