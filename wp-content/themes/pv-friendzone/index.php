<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package pv-friendZONE
 */

get_header();
?>

	<main id="primary" class="site-main">

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

        <div class="main">

            <div class="main-news">
                <div class="container">
                    <div class="text">
                        <p>8 февраля 2021</p>
                        <h1>Досрочное погашение ипотеки. Как выгоднее и быстрее рассчитаться с банком</h1>
                        <h2>
                            С другой стороны постоянное обеспечение нашей деятельности представляет собой интересный эксперимент проверки систем массового участия.
                            Разнообразный и богатый опыт рамки и место обучения кадров способствует подготовке и реализации направлений прогрессивного развития.
                        </h2>
                        <div class="link">
                            <a href="#">Читать статью</a>
                            <a href="#">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/arrow-right-red.svg" alt="arrow-right-red">
                            </a>
                        </div>
                    </div>
                    <div class="image">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/test-image.jpg" alt="test-image">
                    </div>
                </div>
            </div>

            <div class="brief-news">
                <div class="container">

                    <div class="item-news">
                        <div class="image">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/test-image.jpg" alt="test-image">
                        </div>
                        <p>8 февраля 2021</p>
                        <h2>Оформление новостройки в собственность</h2>
                        <h3>
                            Вашу новую готовую квартиру нужно показать миру.
                            Новоселье и друзья — само собой, но первым делом данные о ней нужно внести в государственный реестр,
                            в котором хранятся записи о квартирах, домах, участках и их собственниках.
                        </h3>
                        <div class="link">
                            <a href="#">Читать статью</a>
                            <a href="#">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/arrow-right-red.svg" alt="arrow-right-red">
                            </a>
                        </div>
                    </div>

                    <div class="item-news">
                        <div class="image">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/test-image.jpg" alt="test-image">
                        </div>
                        <p>8 февраля 2021</p>
                        <h2>Новостройка или вторичка? Муки выбора</h2>
                        <h3>
                            Вы ломаете голову над тем, покупать квартиру на вторичном рынке или лучше вложиться в новостройку. Взвешиваем за и против в этой статье.
                        </h3>
                        <div class="link">
                            <a href="#">Читать статью</a>
                            <a href="#">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/arrow-right-red.svg" alt="arrow-right-red">
                            </a>
                        </div>
                    </div>

                    <div class="item-news">
                        <div class="image">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/test-image.jpg" alt="test-image">
                        </div>
                        <p>8 февраля 2021</p>
                        <h2>«Развидеть эти косяки я уже не мог»</h2>
                        <h3>
                            Дом сдан, и застройщик приглашает вас на приёмку квартиры. Эмоции зашкаливают — своя! Наконец-то!
                            Рассказываем реальную историю нашего героя, как надо принимать квартиру, чтобы потом не переделывать за застройщиком самостоятельно.
                        </h3>
                        <div class="link">
                            <a href="#">Читать статью</a>
                            <a href="#">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/arrow-right-red.svg" alt="arrow-right-red">
                            </a>
                        </div>
                    </div>

                </div>
            </div>

            <div class="promo">
                <div class="container">
                    <div>
                        <div class="text">
                            <h2>Зарегистрируйтесь, чтобы получить доступ ко всем полезным статьям</h2>
                            <button class="registration-button">Зарегистрироваться</button>
                        </div>
                        <div class="image">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/lock.svg" alt="lock">
                        </div>
                    </div>
                </div>
            </div>

            <div class="more-news">
                <div class="container">
                    <button>Показать еще</button>
                </div>
            </div>

        </div>

	</main><!-- #main -->

<?php
// get_sidebar();
get_footer();
