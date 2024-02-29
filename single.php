<?php
/**
 * MotaPhotos template for displaying all single posts
 */

get_header();

while (have_posts()):
	the_post(); ?>

	<article id='post-<?php the_ID(); ?>' <?php post_class(); ?>>

		<header class='entry-header alignwide'>
			<?php the_title('<h1 class="entry-title">', '</h1>');
			the_post_thumbnail('medium_large'); ?>
		</header><!-- .entry-header -->

		<div class='entry-content'>
			<?php the_content(); ?>
		</div><!-- .entry-content -->

	</article>

<?php endwhile; // End of the loop.

get_footer();
