<?php
/**
 * NModa template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 */

?>
    </main><!-- #main -->

	<div id="lightbox">
		<button class="close-btn">
			<img src="<?= get_template_directory_uri() . '/assets/images/lightbox-close.svg'; ?> " alt="fermer la visionneuse de photo">
		</button>
		<button class="nav-previous">
			<img src="<?= get_template_directory_uri() . '/assets/images/lightbox-prev.svg'; ?> " alt="photo précédente">
			<span>Précédente</span>
		</button>
		<div class="photo-container">
			<div class="photo"></div>
			<div class="informations">
				<h2 class="title"></h2>
				<p class="categorie"></p>
			</div>
		</div>
		<button class="nav-next">
			<span>Suivante</span>
			<img src="<?= get_template_directory_uri() . '/assets/images/lightbox-next.svg'; ?> " alt="photo suivante">
		</button>
	</div>

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
