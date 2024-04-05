<?php

/**
 * MotaPhotos main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 */

get_header(); ?>


<?php if (is_home() || is_front_page()): ?>


	<header class='page-header'>
		<?php $photos = new WP_Query([
			'post_type' => 'photo',
			'orderby' => 'rand',
			'posts_per_page' => '1',
		]);
		if ($photos->have_posts()):
			while ($photos->have_posts()):
				$photos->the_post(); ?>
				<?php the_post_thumbnail('full'); ?>
			<?php endwhile;
			wp_reset_postdata();
		endif; ?>
		<h1 class='page-title'>Photograph event</h1>
	</header><!-- .page-header -->


	<section class='photos-container'>


		<!-- FILTRES -->

		<form action='<?php echo admin_url('admin-ajax.php'); ?>' method='post' id='js-photos-filter'>

			<!-- nonce && action -->
			<input type='hidden' name='nonce' value='<?php echo wp_create_nonce('photos_filter'); ?>'>
			<input type='hidden' name='action' value='photos_filter'>

			<!-- Filtre Catégories -->
			<?php $categories = get_terms(
				[
					'taxonomy' => 'photo-categorie',
					'orderby' => 'name',
					'order' => 'ASC',
					'hide_empty' => true,
				]
			); ?>
			<div id='categories' class='select'>
				<p><span class='default'>Catégories</span><span class='checked'>Catégories</span></p>
				<ul class='options'>
					<li>
						<label for='category-empty'></label>
						<input type='radio' id='category-empty' name='category' value='' />
					</li>
					<?php foreach ($categories as $category): ?>
						<li>
							<label for='<?= $category->slug; ?>'>
								<?= $category->name; ?>
							</label>
							<input type='radio' id='<?= $category->slug; ?>' name='category' value='<?= $category->slug; ?>' />
						</li>
					<?php endforeach; ?>
				</ul>
			</div><!-- #categories -->

			<!-- Filtre Formats -->
			<?php $formats = get_terms(
				[
					'taxonomy' => 'format',
					'orderby' => 'name',
					'order' => 'ASC',
					'hide_empty' => true,
				]
			); ?>
			<div id='formats' class='select'>
				<p><span class='default'>Formats</span><span class='checked'>Formats</span></p>
				<ul class='options'>
					<li>
						<label for='format-empty'></label>
						<input type='radio' id='format-empty' name='format' value='' />
					</li>
					<?php foreach ($formats as $format): ?>
						<li>
							<label for='<?= $format->slug; ?>'>
								<?= $format->name; ?>
							</label>
							<input type='radio' id='<?= $format->slug; ?>' name='format' value='<?= $format->slug; ?>' />
						</li>
					<?php endforeach; ?>
				</ul>
			</div><!-- #formats -->

			<!-- Tri -->
			<div id='sort' class='select'>
				<p><span class='default'>Trier par</span><span class='checked'>Trier par</span></p>
				<ul class='options'>
					<li>
						<label for='DESC'>à partir des plus récentes</label>
						<input type='radio' id='DESC' name='sort' value='DESC' />
					</li>
					<li>
						<label for='ASC'>à partir des plus anciennes</label>
						<input type='radio' id='ASC' name='sort' value='ASC' />
					</li>
				</ul>
			</div><!-- #sort -->

		</form><!-- #js-photos-filter -->


		<!-- PHOTOS -->

		<?php $photos_args = [
			'post_type' => 'photo',
			'post_status' => 'publish',
			'orderby' => 'date',
			'order' => 'ASC',
			'posts_per_page' => '8'
		];
		$photos_loop = new WP_Query($photos_args);

		if ($photos_loop->have_posts()): ?>
			<div class='photos-wrapper'>
				<?php while ($photos_loop->have_posts()):
					$photos_loop->the_post();

					get_template_part('template-parts/photos-loop');

				endwhile;
				wp_reset_postdata(); ?>
			</div>
		<?php endif;


		/** CHARGER PLUS */

		if (1 < $photos_loop->max_num_pages): ?>
			<button class='js-loadmore-photos' data-query='<?= json_encode($photos_loop->query) ?>' data-nextpage='2'
				data-maxpage='<?= $photos_loop->max_num_pages ?>' data-nonce='<?= wp_create_nonce('loadmore_photos'); ?>'
				data-action='loadmore_photos' data-ajaxurl='<?= admin_url('admin-ajax.php'); ?>'>
				Charger plus
			</button>
		<?php endif; ?>


	</section><!-- .photos-container -->


<?php endif; // home || front_page   ?>


<?php get_footer();
