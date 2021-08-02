<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package pv-friendZONE
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<header class="header">
    <div class="header-fixed">
        <div class="header-progress-bar">
            <div class="header-progress-bar-line"></div>
        </div>
        <div class="container">
            <div class="header-logo">
                <a class="header-logo-image" href="http://peresvet-friendzona/">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.svg" alt="FRIENDзона">
                </a>
            </div>
            <div class="header-buttons">
                <div class="header-login d-flex">
                    <button class="header-button-login login-button">Войти</button>
                    <button class="header-button-reg registration-button">Зарегистрироваться</button>
                </div>
                <div class="login d-none">
                    <div class="avatar">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/user-avatar.svg" alt="user-avatar">
                    </div>
                    <div class="user">Иван</div>
                    <div class="actions">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/chevron-down-black.svg" alt="chevron-down">
                    </div>
                </div>
                <div class="close d-none">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icon-cross.svg" alt="icon-cross">
                </div>
                <div class="header-burger-menu">
                    <div class="header-burger-menu-line"></div>
                    <div class="header-burger-menu-line"></div>
                </div>
            </div>
        </div>
    </div>
</header>
<body <?php body_class(); ?>>
<?php //wp_body_open(); ?>
<!--<div id="page" class="site">-->

