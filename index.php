<?php

/**
 * NMota main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 */

get_header(); ?>

<?php if (is_home() || is_front_page()) : ?>
	<header class="page-header">
		<?php $photos = new WP_Query( [
    		'post_type' => 'photo',
    		'orderby' => 'rand',
    		'posts_per_page' => '1',
		]);
		if ( $photos->have_posts() ) :
    		while ( $photos->have_posts() ) :
        		$photos->the_post(); ?>
            	<?php the_post_thumbnail( 'full' ); ?>
			<?php endwhile;
    		wp_reset_postdata();
		endif; ?>
		<h1 class="page-title">Photograph event</h1>
	</header><!-- .page-header -->
    <section class="photos-container">
		<form action="<?php echo admin_url( 'admin-ajax.php' ); ?>" method="post" id="js-photos-filter">
			<input type="hidden" name="nonce" value="<?php echo wp_create_nonce( 'photos_filter' ); ?>"> 
        	<input type="hidden" name="action" value="photos_filter">
			<?php $categories = get_terms(
				[
					'taxonomy' => 'photo-categorie',
					'orderby' => 'name',
					'order' => 'ASC',
					'hide_empty' => true,
				]
			); ?>
			<select name="category" id="category">
				<option value="">Catégories</option>
				<option value=""></option>
				<?php foreach($categories as $category) : ?>
					<option value="<?= $category->slug; ?>"><?= $category->name; ?></option>
				<?php endforeach; ?>
			</select>
			<?php $formats = get_terms(
				[
					'taxonomy' => 'format',
					'orderby' => 'name',
					'order' => 'ASC',
					'hide_empty' => true,
				]
			); ?>
			<select name="format" id="format">
				<option value="">Formats</option>
				<option value=""></option>
				<?php foreach($formats as $format) : ?>
					<option value="<?= $format->slug; ?>"><?= $format->name; ?></option>
				<?php endforeach; ?>
			</select>
			<select name="sort" id="sort">
				<option value="">Trier par dates</option>
				<option value="DSC">à partir des plus récentes</option>
				<option value="ASC">à partir des plus anciennes</option>
			</select>
		</div>
        <?php $photos_args = [
			'post_type' => 'photo',
			'post_status' => 'published',
			'orderby' => 'date',
			'order' => 'ASC',
			'posts_per_page' => '8'
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
		<?php endif;
		global $photos_loop;
		if( 1 < $photos_loop->max_num_pages ) : ?>
    		<button
	    		class="js-loadmore-photos"
				data-max-page="<?= $photos_loop->max_num_pages ?>"
        		data-nonce="<?= wp_create_nonce('loadmore_photos'); ?>"
        		data-action="loadmore_photos"
        		data-ajaxurl="<?= admin_url( 'admin-ajax.php' ); ?>"
    		>
        		Charger plus
    		</button>
		<?php endif; ?>
	</section>
<?php endif; ?>

<?php get_footer();
