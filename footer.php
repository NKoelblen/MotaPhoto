<?php
/**
 * NModa template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 */

?>
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
