<article class="single-photo">
    <?php the_post_thumbnail( 'medium_large' ); ?>
    <img src="<?= get_template_directory_uri() . '/assets/images/fullscreen.svg'; ?> " alt="ouvrir en plein écran">
    <a href="<?php the_permalink() ?>"><img src="<?= get_template_directory_uri() . '/assets/images/eye.svg'; ?> " alt="accéder aux informations de la photo"></a>
    <?php the_title('<h3 class="entry-title">', '</h3>'); ?>
    <p>
        <?php $photos_loop_categories = get_the_terms(get_the_id(), 'photo-categorie' );
        if ( !empty( $photos_loop_categories ) ) :
            $photos_loop_categories_names = [];
            foreach ( $photos_loop_categories as $photos_loop_category ) :
                $photos_loop_categories_names[] = $photos_loop_category->name;
            endforeach;
        echo implode(', ',$photos_loop_categories_names);
        endif; ?>
    </p>
</article>