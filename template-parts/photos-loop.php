<?php $categories = get_the_terms( get_the_id(), 'photo-categorie' );
if ( !empty( $categories ) ){
    $categories_names = [];
    foreach ( $categories as $category ) :
        $categories_names[] = $category->name;
    endforeach;
}
$photos_args = [
    'post_type' => 'photo',
    'post__not_in' => [get_the_ID()],
];
if(is_home() || is_front_page()) :
    $photos_args['orderby'] = 'date';
    $photos_args['order'] = 'ASC';
    $photos_args['posts_per_page'] = '8';
else :
    $photos_args['orderby'] = 'rand';
    $photos_args['posts_per_page'] = '2';
    $photos_args['tax_query'] = [
        [
            'taxonomy' => 'photo-categorie',
            'field' => 'slug',
            'terms' => $categories_names,
        ],
    ];
endif;
$photos_loop = new WP_Query( $photos_args );
if ( $photos_loop->have_posts() ) : ?>
    <div class="photos-wrapper">
        <?php while ( $photos_loop->have_posts() ) :
            $photos_loop->the_post(); ?>
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
        <?php endwhile;
        wp_reset_postdata(); ?>
    </div>
<?php endif; ?>