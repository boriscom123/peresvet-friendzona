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
<?php
    $cat = get_categories(array(
        'orderby' => 'term_id', // сортируем по ID
        'order' => 'DESC', // направление получения данных
        'hide_empty' => '0', // показывать пустые
        'number' => '', // количество необходимых категорий
    ));
    foreach ($cat as $caterory){
        if($caterory->name === 'Вопросы'){
            $cat_id = $caterory->term_id;
        }
    }
    $all_posts = get_posts(array(
        'category' => -$cat_id, // исключаем категорию
        'numberposts' => -1, // снимаем ограничения на показ записей
        'orderby'     => 'date', // сортируем по дате
        'order'       => 'DESC', // порядок сортировки
    ));
    // print_r($all_posts);
    // $count_posts = count($all_posts);
    $monthsList = array(
        ".01." => "января",
        ".02." => "февраля",
        ".03." => "марта",
        ".04." => "апреля",
        ".05." => "мая",
        ".06." => "июня",
        ".07." => "июля",
        ".08." => "августа",
        ".09." => "сентября",
        ".10." => "октября",
        ".11." => "ноября",
        ".12." => "декабря"
    );
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
                        <p>
                            <?php
                                $date = DateTime::createFromFormat('Y-m-d H:i:s', $all_posts[0]->post_date);
                                echo str_replace($date->format('.m.'), " ".$monthsList[$date->format('.m.')]." ", $date->format('j.m.Y'));
                            ?>
                        </p>
                        <h1><?php print $all_posts[0]->post_title; ?></h1>
                        <h2><?php print $all_posts[0]->post_excerpt; ?></h2>
                        <div class="link">
                            <a href="<?php echo get_permalink($all_posts[0]->ID); ?>">Читать статью</a>
                            <a href="<?php echo get_permalink($all_posts[0]->ID); ?>">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/arrow-right-red.svg" alt="arrow-right-red">
                            </a>
                        </div>
                    </div>
                    <div class="image">
                        <img src="<?php echo get_the_post_thumbnail_url($all_posts[0]->ID); ?>" alt="test-image">
                    </div>
                </div>
            </div>

            <div class="brief-news">
                <div class="container">

                    <?php
                        for ($i=1; $i<count($all_posts); $i++){ ?>

                            <div class="item-news <?php if($i>3){echo 'hidden';}?>">
                                <div class="image">
                                    <img src="<?php echo get_the_post_thumbnail_url($all_posts[$i]->ID); ?>" alt="test-image">
                                </div>
                                <p>
                                    <?php
                                        $date = DateTime::createFromFormat('Y-m-d H:i:s', $all_posts[$i]->post_date);
                                        echo str_replace($date->format('.m.'), " ".$monthsList[$date->format('.m.')]." ", $date->format('j.m.Y'));
                                    ?>
                                </p>
                                <h2><?php print $all_posts[$i]->post_title; ?></h2>
                                <h3><?php print $all_posts[$i]->post_excerpt; ?></h3>
                                <div class="link">
                                    <a href="<?php echo get_permalink($all_posts[$i]->ID); ?>">Читать статью</a>
                                    <a href="<?php echo get_permalink($all_posts[$i]->ID); ?>">
                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/arrow-right-red.svg" alt="arrow-right-red">
                                    </a>
                                </div>
                            </div>

                        <?php }
                    ?>
                </div>
            </div>

            <?php
                if( is_user_logged_in() ) { ?>

                    <div class="more-news">
                        <div class="container">
                            <button id="show-more-news">Показать еще</button>
                        </div>
                    </div>

                <?php  } else { ?>

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

                <?php }
            ?>

        </div>

	</main><!-- #main -->

<?php
// get_sidebar();
get_footer();
