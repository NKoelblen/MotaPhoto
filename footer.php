<?php
/**
 * MotaPhotos template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 */

		global $photos_loop; ?>
		<div id="lightbox">
			<button class="close-btn">
		    	<img src="<?= get_template_directory_uri() . '/assets/images/lightbox-close.svg'; ?> " alt="fermer la visionneuse de photo">
		    </button>
		    <div class="nav-link nav-previous">
		    	<img src="<?= get_template_directory_uri() . '/assets/images/lightbox-prev.svg'; ?> " alt="photo précédente">
		    	<span>Précédente</span>
			</div>
		    <div class="photo-container">
				<div class="photo animated"></div>
		    	<div class="informations"></div>
		    </div>
		    <div class="nav-link nav-next">
		    	<span>Suivante</span>
		    	<img src="<?= get_template_directory_uri() . '/assets/images/lightbox-next.svg'; ?> " alt="photo suivante">
			</div>
		</div>
    </main><!-- #main -->

	<footer id="colophon" class="site-footer">
			<nav class="footer-navigation">
				<ul class="footer-navigation-wrapper">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'footer',
							'items_wrap'     => '%3$s',
							'container'      => false,
							'depth'          => 1,
							'link_before'    => '<span>',
							'link_after'     => '</span>',
							'fallback_cb'    => false,
						)
					);
					?>
				</ul><!-- .footer-navigation-wrapper -->
			</nav><!-- .footer-navigation -->
	</footer><!-- #colophon -->

<?php wp_footer(); ?>

</body>
</html>
