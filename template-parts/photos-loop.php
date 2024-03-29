<?php
/**
 * MotaPhotos Template part for displaying Photos 
 */

global $photos_loop; ?>

<article class='single-photo'>

    <!-- Photo -->
    <?php the_post_thumbnail('medium_large'); ?>

    <!-- Overlay -->
    <div class='overlay'>

        <button class='js-lightbox' data-currentphoto=<?= $photos_loop->current_post; ?>>
            <img src='<?= get_template_directory_uri() . '/assets/images/fullscreen.svg'; ?>'
                alt='ouvrir en plein écran'>
        </button>

        <a href='<?php the_permalink() ?>'><img src='<?= get_template_directory_uri() . '/assets/images/eye.svg'; ?> '
                alt='accéder aux informations de la photo'></a>

        <div class='informations'>

            <?php the_title('<h3 class="entry-title">', '</h3>'); ?>

            <p class='category'>
                <?php $photos_loop_categories = get_the_terms(get_the_id(), 'photo-categorie');
                if (!empty($photos_loop_categories)):
                    $photos_loop_categories_names = [];
                    foreach ($photos_loop_categories as $photos_loop_category):
                        $photos_loop_categories_names[] = $photos_loop_category->name;
                    endforeach;
                endif;
                if (!empty($photos_loop_categories)):
                    echo implode(', ', $photos_loop_categories_names);
                endif; ?>
            </p>

        </div><!-- .informations -->

    </div><!-- .overlay -->

</article><!-- .single-photo -->