<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package pv-friendZONE
 */

get_header();
?>
<?php
$post = get_post();
// print_r($post);
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
$args = array(
    'date_query' => $post->post_date,
    'numberposts' => 3,
    'exclude' => $post->ID,
);
$posts_by_date = get_posts($args);
$tags = wp_get_post_tags($post->ID);
$is_free = false;
$tag_list = '';
foreach ($tags as $tag) {
    $tag_list .= $tag->slug . ', ';
    if ($tag->slug === 'free') {
        $is_free = true;
    }
}
$tag_list = substr($tag_list, 0, -2);
$args = array(
    'tag' => $tag_list,
    'numberposts' => 4,
    'exclude' => $post->ID,
);
$posts_by_tags = get_posts($args);
?>

    <main id="primary" class="site-main">

        <div class="breadcrumbs">
            <div class="container">
                <div class="image">
                    <a href="<?php echo home_url(); ?>/news/">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/arrow-left.svg"
                             alt="arrow-left">
                    </a>
                </div>
                <div class="link">
                    <a href="<?php echo home_url(); ?>/news/">Вернуться к новостям</a>
                </div>
            </div>
        </div>

        <div class="main">

            <div class="main-articles">
                <div class="container">
                    <div class="article">
                        <h3>
                            <?php
                            $date = DateTime::createFromFormat('Y-m-d H:i:s', $post->post_date);
                            echo str_replace($date->format('.m.'), " " . $monthsList[$date->format('.m.')] . " ", $date->format('j.m.Y'));
                            ?>
                        </h3>
                        <h1><?php print $post->post_title; ?></h1>
                        <div class="post-content">
                            <?php
                            if (is_user_logged_in() || $is_free) {
                                print $post->post_content;
                            } else {
                                print '<p>' . $post->post_excerpt . '</p>';
                            }
                            ?>
                        </div>

                        <?php
                        if (is_user_logged_in() || $is_free) { ?>

                        <?php } else { ?>

                            <div class="lock">
                                <div class="d-none"><?php var_dump($tags); ?></div>
                                <div class="d-none"><?php var_dump($is_free); ?></div>
                                <div class="text">
                                    <h2>Зарегистрируйтесь, чтобы получить доступ к полной статье</h2>
                                    <button class="registration-button">Зарегистрироваться</button>
                                </div>
                                <div class="image">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/lock.svg"
                                         alt="lock">
                                </div>
                            </div>

                        <?php }
                        ?>

                    </div>
                    <div class="mini-articles">

                        <?php
                        foreach ($posts_by_tags as $p) { ?>

                            <div class="mini-art">
                                <a class="image" href="<?php echo get_permalink($p->ID); ?>">
                                    <img src="<?php echo get_the_post_thumbnail_url($p->ID); ?>" alt="test-image">
                                </a>
                                <h3>
                                    <?php
                                    $date = DateTime::createFromFormat('Y-m-d H:i:s', $p->post_date);
                                    echo str_replace($date->format('.m.'), " " . $monthsList[$date->format('.m.')] . " ", $date->format('j.m.Y'));
                                    ?>
                                </h3>
                                <h2><?php print $p->post_title; ?></h2>
                                <?php
                                if (!is_user_logged_in()) { ?>
                                    <div class="lock">
                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/lock.svg"
                                             alt="lock">
                                    </div>
                                <?php }
                                ?>

                            </div>

                        <?php }
                        ?>

                        <!--                        <div class="mini-art">-->
                        <!--                            <div class="image">-->
                        <!--                                <img src="-->
                        <?php //echo get_template_directory_uri(); ?><!--/assets/images/test-image.jpg" alt="test-image">-->
                        <!--                            </div>-->
                        <!--                            <h3>8 февраля 2021</h3>-->
                        <!--                            <h2>Оформление новостройки в собственность</h2>-->
                        <!--                        </div>-->
                        <!---->
                        <!--                        <div class="mini-art">-->
                        <!--                            <div class="image">-->
                        <!--                                <img src="-->
                        <?php //echo get_template_directory_uri(); ?><!--/assets/images/test-image.jpg" alt="test-image">-->
                        <!--                            </div>-->
                        <!--                            <h3>8 февраля 2021</h3>-->
                        <!--                            <h2>Новостройка или вторичка? Муки выбора</h2>-->
                        <!--                        </div>-->
                        <!---->
                        <!--                        <div class="mini-art">-->
                        <!--                            <div class="image">-->
                        <!--                                <img src="-->
                        <?php //echo get_template_directory_uri(); ?><!--/assets/images/test-image.jpg" alt="test-image">-->
                        <!--                            </div>-->
                        <!--                            <h3>8 февраля 2021</h3>-->
                        <!--                            <h2>«Развидеть эти косяки я уже не мог»</h2>-->
                        <!--                            <div class="lock">-->
                        <!--                                <img src="-->
                        <?php //echo get_template_directory_uri(); ?><!--/assets/images/lock.svg" alt="lock">-->
                        <!--                            </div>-->
                        <!--                        </div>-->
                        <!---->
                        <!--                        <div class="mini-art">-->
                        <!--                            <div class="image">-->
                        <!--                                <img src="-->
                        <?php //echo get_template_directory_uri(); ?><!--/assets/images/test-image.jpg" alt="test-image">-->
                        <!--                            </div>-->
                        <!--                            <h3>8 февраля 2021</h3>-->
                        <!--                            <h2>Электронные сделки с недвижимостью: как это работает и стоит ли бояться мошенников</h2>-->
                        <!--                            <div class="lock">-->
                        <!--                                <img src="-->
                        <?php //echo get_template_directory_uri(); ?><!--/assets/images/lock.svg" alt="lock">-->
                        <!--                            </div>-->
                        <!--                        </div>-->

                    </div>
                </div>
            </div>

            <div class="main-additional-articles">
                <div class="container">
                    <div class="title">
                        <h2>К другим новостям</h2>
                        <div class="decoration"></div>
                    </div>
                    <div class="art-info">

                        <?php
                        foreach ($posts_by_date as $p) { ?>

                            <div class="art">
                                <h3>
                                    <?php
                                    $date = DateTime::createFromFormat('Y-m-d H:i:s', $p->post_date);
                                    echo str_replace($date->format('.m.'), " " . $monthsList[$date->format('.m.')] . " ", $date->format('j.m.Y'));
                                    ?>
                                </h3>
                                <h2><?php print $p->post_title; ?></h2>
                                <div class="link">
                                    <a href="<?php echo get_permalink($p->ID); ?>">Читать статью</a>
                                    <a href="<?php echo get_permalink($p->ID); ?>">
                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/arrow-right-red.svg"
                                             alt="arrow-right-red">
                                    </a>
                                </div>
                            </div>

                        <?php }
                        ?>

                        <!--                        <div class="art">-->
                        <!--                            <h3>8 февраля 2021</h3>-->
                        <!--                            <h2>Как купить квартиру без первоначального взноса по ипотеке</h2>-->
                        <!--                            <div class="link">-->
                        <!--                                <a href="#">Читать статью</a>-->
                        <!--                                <a href="#">-->
                        <!--                                    <img src="-->
                        <?php //echo get_template_directory_uri(); ?><!--/assets/images/arrow-right-red.svg" alt="arrow-right-red">-->
                        <!--                                </a>-->
                        <!--                            </div>-->
                        <!--                        </div>-->
                        <!---->
                        <!--                        <div class="art">-->
                        <!--                            <h3>8 февраля 2021</h3>-->
                        <!--                            <h2>Стоит ли вкладывать материнский капитал в покупку недвижимости и какие тут подводные камни</h2>-->
                        <!--                            <div class="link">-->
                        <!--                                <a href="#">Читать статью</a>-->
                        <!--                                <a href="#">-->
                        <!--                                    <img src="-->
                        <?php //echo get_template_directory_uri(); ?><!--/assets/images/arrow-right-red.svg" alt="arrow-right-red">-->
                        <!--                                </a>-->
                        <!--                            </div>-->
                        <!--                        </div>-->
                        <!---->
                        <!--                        <div class="art">-->
                        <!--                            <h3>8 февраля 2021</h3>-->
                        <!--                            <h2>Рефинансирование ипотеки. Пошаговая инструкция</h2>-->
                        <!--                            <div class="link">-->
                        <!--                                <a href="#">Читать статью</a>-->
                        <!--                                <a href="#">-->
                        <!--                                    <img src="-->
                        <?php //echo get_template_directory_uri(); ?><!--/assets/images/arrow-right-red.svg" alt="arrow-right-red">-->
                        <!--                                </a>-->
                        <!--                            </div>-->
                        <!--                        </div>-->

                    </div>
                </div>
            </div>

        </div>

    </main><!-- #main -->

<?php
// get_sidebar();
get_footer();
