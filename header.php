<?php
/**
 * NMota header.
 *
 * This is the template that displays all of the <head> section and everything up until main.
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<?php wp_head(); ?>
</head>

<!-- body_class() = class="page page-id-2 page-parent page-template-default logged-in" -->
<body <?php body_class(); ?>>
    <header id="masthead" class="site-header">
        <img class="site-logo" src="<?= get_template_directory_uri() . '/assets/images/logo.png'; ?> " alt="logo">
        <nav id="site-navigation" class="primary-navigation">
                <button id="primary-mobile-menu" class="button" aria-controls="primary-menu-list" aria-expanded="false">
                    <span class="dropdown-icon open">
                        <img src="<?= get_template_directory_uri() . '/assets/images/menu_open.png'; ?> " alt="ouvrir le menu">
                    </span>
                    <span class="dropdown-icon close">
                        <img src="<?= get_template_directory_uri() . '/assets/images/menu_close.png'; ?> " alt="fermer le menu">
                    </span>
                </button><!-- #primary-mobile-menu -->
            <?php
            wp_nav_menu(
                array(
                    'theme_location'  => 'primary',
                    'menu_class'      => 'menu-wrapper',
                    'container_class' => 'primary-menu-container',
                    'items_wrap'      => '<ul id="primary-menu-list" class="%2$s">%3$s</ul>',
                    'fallback_cb'     => false,
                )
            );
            ?>
        </nav><!-- #site-navigation -->
        <?php get_template_part( 'template-parts/contact' ); ?>
    </header><!-- #masthead -->
	<main id="main" class="site-main">
