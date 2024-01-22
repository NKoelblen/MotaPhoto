<?php
/**
 * NMota functions and definitions
 */

/**
 * Enable support for Post Thumbnails on posts and pages
 */
add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 1568, 9999 );

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
	    $items .= '<li><button class="contact-btn">Contact</button></li>';
    }
    if( $args->theme_location == 'footer' ){
        $items .= '<li>Tous droits réservés</li>';
    }
	return $items;
}
add_filter( 'wp_nav_menu_items', 'add_items_to_nav_menu', 10, 2 );

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
    wp_register_script('loadmore-photos-script', get_template_directory_uri() . '/assets/js/loadmore-photos.js', [ 'jquery' ], false, true);
    wp_enqueue_script('loadmore-photos-script');
}

/**
 * Load more photos
 */
add_action( 'wp_ajax_loadmore_photos', 'loadmore_photos' );
add_action( 'wp_ajax_nopriv_loadmore_photos', 'loadmore_photos' );
function loadmore_photos() {
  
	// Vérification de sécurité
  	if(!isset($_REQUEST['nonce']) || !wp_verify_nonce($_REQUEST['nonce'], 'loadmore_photos')) :
    	wp_send_json_error( "Vous n’avez pas l’autorisation d’effectuer cette action.", 403 );
    endif;

  	// Requête des commentaires
    $photos_args = [
        'post_type' => 'photo',
        'post_status' => 'published',
        'orderby' => 'date',
        'order' => 'ASC',
        'posts_per_page' => '8',
        'paged' => $_POST['currentPage'],
    ];
    $photos_loop = new WP_Query( $photos_args );

  	// Préparer le HTML des commentaires
    if ( $photos_loop->have_posts() ) :
        ob_start();
        while ( $photos_loop->have_posts() ) :
            $photos_loop->the_post();
            get_template_part( 'template-parts/photos-loop' );
        endwhile;
        wp_reset_postdata();
        wp_send_json_success(ob_get_clean()); // Envoyer les données au navigateur
    endif;	
}