<?php
/**
 * MotaPhotos template for displaying the footer
 *
 * Contains the closing of main and all content after.
 */


/** LIGHTBOX **/

global $photos_loop; ?>

<!-- Lightbox -->
<div id='lightbox'>

	<button class='close-btn'>
		<img src='<?= get_template_directory_uri() . '/assets/images/lightbox-close.svg'; ?> '
			alt='fermer la visionneuse de photo'>
	</button>

	<div class='nav-link nav-previous'>
		<img src='<?= get_template_directory_uri() . '/assets/images/lightbox-prev.svg'; ?> ' alt='photo précédente'>
		<span>Précédente</span>
	</div>

	<div class='photo-container animated'>
		<div class='photo'></div>
		<div class='informations'>
			<p class='entry-title'></p>
			<p class='category'></p>
		</div>
	</div>

	<div class='nav-link nav-next'>
		<span>Suivante</span>
		<img src='<?= get_template_directory_uri() . '/assets/images/lightbox-next.svg'; ?> ' alt='photo suivante'>
	</div>

</div><!-- Lightbox -->


</main><!-- #main -->


<!-- COLOPHON -->
<footer id='colophon' class='site-footer'>
	<nav class='footer-navigation'>
		<ul class='footer-navigation-wrapper'>
			<?php
			wp_nav_menu(
				[
					'theme_location' => 'footer',
					'items_wrap' => '%3$s',
					'container' => false,
					'depth' => 1,
					'link_before' => '<span>',
					'link_after' => '</span>',
					'fallback_cb' => false,
				]
			);
			?>
		</ul><!-- .footer-navigation-wrapper -->
	</nav><!-- .footer-navigation -->
</footer><!-- #colophon -->


<?php wp_footer(); ?>

</body>

</html>