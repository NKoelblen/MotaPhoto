<?php
/**
 * NMota template for displaying all single photos
 */

get_header();

/* Start the Loop */
while ( have_posts() ) :
	the_post();
    global $post ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <section class="">
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
            <?php the_post_thumbnail( 'large' ); ?>
        </section>
        <div class="">
            <section class="">
                <p>Cette photo vous intéresse ?</p>
                <button class="contact-btn">Contact</button>
            </section>
            <?php $next_photo = get_next_post();
            $prev_photo = get_previous_post();
            echo get_the_post_thumbnail($prev_photo->ID,'thumbnail', ['class' => 'preview-nav prev']);
            echo get_the_post_thumbnail($next_photo->ID,'thumbnail', ['class' => 'preview-nav next']);
            the_post_navigation(
		        [
		        	'next_text' => '<img src="' . get_template_directory_uri() . '/assets/images/prev.svg" class="meta-nav" alt="accéder à la photo précédente">',
		        	'prev_text' => '<img src="' . get_template_directory_uri() . '/assets/images/next.svg" class="meta-nav" alt="accéder à la photo précédente">',
		        ]
	        ); ?>
        </div>

    </article>
    <section class="related-photos-container">
        <h2>Vous aimerez aussi</h2>
        <?php get_template_part( 'template-parts/photos-loop' ); ?>
    </section>

<?php endwhile; // End of the loop.

get_footer();