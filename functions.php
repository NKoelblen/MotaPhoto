<?php
/**
 * NMota functions and definitions
 */

/**
 * Enqueue scripts and styles
 */

add_action('wp_enqueue_scripts', 'theme_enqueue_styles');
function theme_enqueue_styles()
{
	wp_enqueue_style( 'header-style', get_template_directory_uri() . '/assets/css/header.css', array(), '');
    wp_enqueue_style( 'contact-style', get_template_directory_uri() . '/assets/css/contact.css', array(), '');
}

add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');
function theme_enqueue_scripts()
{
    wp_register_script('menu-mobile-script', get_template_directory_uri() . '/assets/js/menu-mobile.js', array(), false, true);
    wp_enqueue_script('menu-mobile-script');
    wp_register_script('contact-script', get_template_directory_uri() . '/assets/js/contact.js', array(), false, true);
    wp_enqueue_script('contact-script');
}

/**
 * Register navigation menu locations
 */
register_nav_menus(
    array(
        'primary' => 'Primary menu',
        'footer'  => 'Secondary menu',
    )
);

/**
 * Add items to nav menus
 */
function add_items_to_nav_menu( $items, $args ) {
    if( $args->theme_location == 'primary' ){
	    $items .= '<li><button class="contact-btn" aria-expanded="false">Contact</button></li>';
    }
    if( $args->theme_location == 'footer' ){
        $items .= '<li>Tous droits réservés</li>';
    }
	return $items;
}
add_filter( 'wp_nav_menu_items', 'add_items_to_nav_menu', 10, 2 );

/*
 * Enable support for Post Thumbnails on posts and pages
 */
add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 1568, 9999 );