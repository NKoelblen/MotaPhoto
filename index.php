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
		<form>
			<?php $categories = get_terms(
				[
					'taxonomy' => 'photo-categorie',
					'orderby' => 'name',
					'order' => 'ASC',
					'hide_empty' => true,
				]
			); ?>
			<select name="categories" id="categories">
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
			<select name="formats" id="formats">
				<option value="">Formats</option>
				<option value=""></option>
				<?php foreach($formats as $format) : ?>
					<option value="<?= $format->slug; ?>"><?= $format->name; ?></option>
				<?php endforeach; ?>
			</select>
			<select name="tri" id="tri">
				<option value="">Trier par date</option>
				<option value="DSC">à partir des plus récentes</option>
				<option value="ASC">à partir des plus anciennes</option>
			</select>
		</form>
        <?php get_template_part( 'template-parts/photos-loop' ); ?>
		<button>Charger plus</button>
	</section>
<?php endif; ?>

<?php get_footer();