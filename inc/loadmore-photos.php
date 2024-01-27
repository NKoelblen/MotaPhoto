<?php
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