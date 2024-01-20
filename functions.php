<?php
/**
 * NMota functions and definitions
 */


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
	    $items .= '<li><a href="" class="contact">Contact</a></li>';
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