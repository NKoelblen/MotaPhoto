<?php
add_action('wp_ajax_photos_filter', 'photos_filter');
add_action('wp_ajax_nopriv_photos_filter', 'photos_filter');

function photos_filter()
{

    // Security Check && Error response
    if (
        !isset($_REQUEST['nonce']) ||
        !wp_verify_nonce($_REQUEST['nonce'], 'photos_filter')
    ) {
        wp_send_json_error('Vous n’avez pas l’autorisation d’effectuer cette action.', 403);
    }

    // Sanitize fields
    $category = sanitize_text_field($_POST['category']);
    $format = sanitize_text_field($_POST['format']);
    $sort = sanitize_text_field($_POST['sort']);

    // Query
    $photos_args = [
        'post_type' => 'photo',
        'post_status' => 'published',
        'orderby' => 'date',
        'order' => 'ASC',
        'posts_per_page' => '8',
    ];

    if ($category):
        $photos_args['tax_query'][] = [
            'taxonomy' => 'photo-categorie',
            'field' => 'slug',
            'terms' => [$category],
        ];
    endif;

    if ($format):
        $photos_args['tax_query'][] = [
            'taxonomy' => 'format',
            'field' => 'slug',
            'terms' => [$format],
        ];
    endif;

    if ($sort):
        $photos_args['order'] = $sort;
    endif;

    $photos_loop = new WP_Query($photos_args);

    // Success response : HTML / Number of pages / Query
    if ($photos_loop->have_posts()):

        ob_start();

        while ($photos_loop->have_posts()):
            $photos_loop->the_post();

            get_template_part('template-parts/photos-loop');

        endwhile;
        wp_reset_postdata();

        wp_send_json_success(['photos' => ob_get_clean(), 'max-page' => $photos_loop->max_num_pages, 'query' => $photos_loop->query]);

    endif;
}