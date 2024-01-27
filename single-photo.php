<?php
/**
 * MotaPhotos template for displaying all single photos
 */

get_header();

/* Start the Loop */
while ( have_posts() ) :
	the_post();
    global $post ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <section class="content-container">
            <div class="entry-content">
                <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
                <p>Référence : <span id="reference"><?php the_field('reference'); ?></span></p>
                <p>Catégorie :
                <?php $categories = get_the_terms( $post->ID, 'photo-categorie' );
                if ( !empty( $categories ) ){
                    $categories_names = [];
                    foreach ( $categories as $category ) :
                        $categories_names[] = $category->name;
                    endforeach;
                    echo implode(', ',$categories_names);
                } ?>
                </p>
                <p>Format : 
                <?php $formats = get_the_terms( $post->ID, 'format' );
                if ( !empty( $formats ) ){
                    $formats_names = [];
                    foreach ( $formats as $format ) :
                        $formats_names[] = $format->name;
                    endforeach;
                    echo implode(', ',$formats_names);
                } ?>
                </p>
                <p>Type : <?php the_field('type'); ?></p>
                <?php the_date( 'Y', '<p>Année : ', '</p>' ) ?>
            </div>
            <div class="entry-thumbnail">
                <?php the_post_thumbnail( 'large' ); ?>
            </div>
        </section>
        <div class="contact-navigation-wrapper">
            <section class="contact">
                <p>Cette photo vous intéresse ?</p>
                <button class="contact-btn">Contact</button>
            </section>
            <section class="post-navigation-wrapper">
                <?php $prev_photo = get_previous_post();
                $next_photo = get_next_post();
                if( $prev_photo) :
                    echo get_the_post_thumbnail($prev_photo->ID,'thumbnail', ['class' => 'preview-nav prev']);
                endif;
                if( $next_photo) :
                    echo get_the_post_thumbnail($next_photo->ID,'thumbnail', ['class' => 'preview-nav next']);
                endif;
                the_post_navigation(
		            [
		            	'next_text' => '<img src="' . get_template_directory_uri() . '/assets/images/prev.svg" class="meta-nav" alt="accéder à la photo précédente">',
		            	'prev_text' => '<img src="' . get_template_directory_uri() . '/assets/images/next.svg" class="meta-nav" alt="accéder à la photo précédente">',
		            ]
	            ); ?>
            </section>
        </div>

    </article>
    <section class="related-photos-container">
        <h2>Vous aimerez aussi</h2>
        <?php $photos_args = [
            'post_type' => 'photo',
            'post_status' => 'published',
            'post__not_in' => [get_the_ID()],
            'orderby' => 'rand',
            'posts_per_page' => '2',
            'tax_query' => [
                [
                    'taxonomy' => 'photo-categorie',
                    'field' => 'slug',
                    'terms' => $categories_names,
                ]
            ]
        ];
        $photos_loop = new WP_Query( $photos_args );
        if ( $photos_loop->have_posts() ) : ?>
            <div class="photos-wrapper">
                <?php while ( $photos_loop->have_posts() ) :
                    $photos_loop->the_post();
                    get_template_part( 'template-parts/photos-loop' );
                endwhile;
                wp_reset_postdata(); ?>
            </div>
        <?php endif; ?>
    </section>

<?php endwhile; // End of the loop.

get_footer();