<?php
/**
 * MotaPhotos functions and definitions
 */

/**
 * Enqueue scripts and styles
 */

add_action('wp_enqueue_scripts', 'theme_enqueue_styles');
function theme_enqueue_styles()
{
	wp_enqueue_style('main-style', get_template_directory_uri() . '/style.css', array(), '');
}

add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');
function theme_enqueue_scripts()
{
    wp_register_script('menu-mobile-script', get_template_directory_uri() . '/assets/js/menu-mobile.js', array(), false, true);
    wp_enqueue_script('menu-mobile-script');
    wp_register_script('contact-script', get_template_directory_uri() . '/assets/js/contact.js', array(), false, true);
    wp_enqueue_script('contact-script');
    if(is_home()) :
        wp_register_script('loadmore-photos-script', get_template_directory_uri() . '/assets/js/loadmore-photos.js', [ 'jquery' ], false, true);
        wp_enqueue_script('loadmore-photos-script');
        wp_register_script('photos-filter-script', get_template_directory_uri() . '/assets/js/photos-filter.js', [ 'jquery' ], false, true);
        wp_enqueue_script('photos-filter-script');
    endif;
    wp_register_script('photos-loop-script', get_template_directory_uri() . '/assets/js/photos-loop.js', array(), false, true);
    wp_enqueue_script('photos-loop-script');
    wp_register_script('lightbox-script', get_template_directory_uri() . '/assets/js/lightbox.js', [ 'jquery' ], false, true);
    wp_enqueue_script('lightbox-script');
}

/**
 * Define Constants
 */

 define('MOTAPHOTO_DIR', trailingslashit(get_theme_file_path()));


/**
 * Includes
 */
require_once MOTAPHOTO_DIR . 'inc/support.php';
require_once MOTAPHOTO_DIR . 'inc/nav-menu.php';
require_once MOTAPHOTO_DIR . 'inc/photos-filter.php';
require_once MOTAPHOTO_DIR . 'inc/loadmore-photos.php';