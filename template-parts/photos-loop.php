<?php $photos_loop_categories = get_the_terms(get_the_id(), 'photo-categorie' );
if ( !empty( $photos_loop_categories ) ) :
    $photos_loop_categories_names = [];
    foreach ( $photos_loop_categories as $photos_loop_category ) :
        $photos_loop_categories_names[] = $photos_loop_category->name;
    endforeach;
endif;
global $photos_loop; ?>

<article class="single-photo">
    <?php the_post_thumbnail( 'medium_large' ); ?>
    <div class="overlay">
        <button
	        class="js-lightbox"
            data-query='<?= json_encode($photos_loop->query); ?>'
            data-currentphoto=<?= $photos_loop->current_post; ?>
            data-postsperpage=<?= $photos_loop->post_count; ?>
            data-nonce="<?= wp_create_nonce('lightbox'); ?>"
            data-action="lightbox"
            data-ajaxurl="<?= admin_url('admin-ajax.php'); ?>"
        >
            <img src="<?= get_template_directory_uri() . '/assets/images/fullscreen.svg'; ?> " alt="ouvrir en plein écran">
        </button>
        <a href="<?php the_permalink() ?>"><img src="<?= get_template_directory_uri() . '/assets/images/eye.svg'; ?> " alt="accéder aux informations de la photo"></a>
        <div class="informations">
            <?php the_title('<h3 class="entry-title">', '</h3>'); ?>
            <p>
                <?php if ( !empty( $photos_loop_categories ) ) :
                    echo implode(', ',$photos_loop_categories_names);
                endif; ?>
            </p>
        </div>
    </div>
</article>