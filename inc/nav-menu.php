<?php
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
	    $items .= '<li class="menu-item menu-item-type-post_type menu-item-object-page"><button class="contact-btn">Contact</button></li>';
    }
    if( $args->theme_location == 'footer' ){
        $items .= '<li class="menu-item menu-item-type-post_type menu-item-object-page">Tous droits réservés</li>';
    }
	return $items;
}
add_filter( 'wp_nav_menu_items', 'add_items_to_nav_menu', 10, 2 );
