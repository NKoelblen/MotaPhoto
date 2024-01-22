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
    wp_register_script('photos-filter-script', get_template_directory_uri() . '/assets/js/photos-filter.js', [ 'jquery' ], false, true);
    wp_enqueue_script('photos-filter-script');
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

  	// Requête des photos
    $photos_args = json_decode(stripslashes($_POST[ 'query' ]), true);
    $photos_args['paged'] = $_POST['currentPage'];
    $photos_loop = new WP_Query( $photos_args );

  	// Préparer le HTML des photos
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

/**
 * Filter photos
 */
add_action( 'wp_ajax_photos_filter', 'photos_filter' );
add_action( 'wp_ajax_nopriv_photos_filter', 'photos_filter' );

function photos_filter() {
  
	// Vérification de sécurité
  	if( 
		! isset( $_REQUEST['nonce'] ) or 
       	! wp_verify_nonce( $_REQUEST['nonce'], 'photos_filter' ) 
    ) {
    	wp_send_json_error( "Vous n’avez pas l’autorisation d’effectuer cette action.", 403 );
  	}

  	// Utilisez sanitize_text_field() pour les chaines de caractères. 
    $category = sanitize_text_field( $_POST['category'] );
    $format = sanitize_text_field( $_POST['format'] );
    $sort = sanitize_text_field( $_POST['sort'] );

  	// Requête des photos
    $photos_args = [
        'post_type' => 'photo',
        'post_status' => 'published',
        'orderby' => 'date',
        'posts_per_page' => '8',
    ];

    if ($category) :
        $photos_args['tax_query'][] = [
            'taxonomy' => 'photo-categorie',
            'field' => 'slug',
            'terms' => [$category],
        ];
    endif;
    if ($format) :
        $photos_args['tax_query'][] = [
            'taxonomy' => 'format',
            'field' => 'slug',
            'terms' => [$format],
        ];
    endif;
    if ($sort) :
        $photos_args['order'] = $sort;
    endif;

    $photos_loop = new WP_Query( $photos_args );

  	// Préparer le HTML des photos
    if ( $photos_loop->have_posts() ) :
        ob_start();
        while ( $photos_loop->have_posts() ) :
            $photos_loop->the_post();
            get_template_part( 'template-parts/photos-loop' );
        endwhile;
        wp_reset_postdata();
        wp_send_json_success([ob_get_clean(), $photos_loop->max_num_pages, $photos_loop->query]); // Envoyer les données au navigateur
    endif;	
}