<?php
add_action( 'wp_ajax_lightbox', 'lightbox' );
add_action( 'wp_ajax_nopriv_lightbox', 'lightbox' );

function lightbox() {
  
	// Vérification de sécurité
  	if( 
		! isset( $_REQUEST['nonce'] ) or 
       	! wp_verify_nonce( $_REQUEST['nonce'], 'lightbox' ) 
    ) {
    	wp_send_json_error( "Vous n’avez pas l’autorisation d’effectuer cette action.", 403 );
  	}

  	// Requête des photos
    $current_photo = intval($_POST[ 'currentPhoto' ]);
    $photos_args = json_decode(stripslashes($_POST[ 'query' ]), true);
    $photos_args['posts_per_page'] = $_POST['postsPerPage'];
    $photos_loop = new WP_Query( $photos_args );
  
    // Préparer le HTML des photos
    if ( $photos_loop->have_posts() ) :
        while ( $photos_loop->have_posts() ) :
            $photos_loop->the_post();
            $i = $photos_loop->current_post;
                ob_start();
                $photos_loop_format = array_pop(get_the_terms(get_the_id(), 'format' ));
                the_post_thumbnail( 'full', array('class' => $photos_loop_format->slug));
                $datas[$i]['photo'] = ob_get_clean();
                ob_start(); ?>
                <div class="informations">
                    <?php the_title('<h2 class="entry-title">', '</h2>'); ?>
		    	    <p class="categorie">
                        <?php $photos_loop_categories = get_the_terms(get_the_id(), 'photo-categorie' );
                        if ( !empty( $photos_loop_categories ) ) :
                            $photos_loop_categories_names = [];
                            foreach ( $photos_loop_categories as $photos_loop_category ) :
                                $photos_loop_categories_names[] = $photos_loop_category->name;
                            endforeach;
                            echo implode(', ',$photos_loop_categories_names);
                        endif; ?>
                    </p>
                    </div>
                <?php $datas[$i]['informations'] = ob_get_clean();
        endwhile;
        wp_reset_postdata();
        wp_send_json_success(['photos' => $datas, 'current-photo' => $current_photo]); // Envoyer les données au navigateur
    endif;	
}