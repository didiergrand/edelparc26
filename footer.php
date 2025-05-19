<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package EDELPARC26
 */
	

?>
    <!-- Footer Widget Area -->
	<div id="footer-widget">
		<div class="container">
			<div class="footer-widget-area">
				<?php
				if (is_active_sidebar('footer-1')) {
					dynamic_sidebar('footer-1');
				}
				?>
			</div>
		</div>
    </div>
	<footer id="colophon" class="site-footer">
		<div class="site-info">
		74ème giron des musiques de la Veveyse | <img src="/wp-content/uploads/2023/08/dg-logo.png" height="12" width="12" style="border-radius: 0" /> webdesign &amp; code : Didier Grand - <a href="https://www.digitalgarage.ch?ref=EDELPARC26">digitalgarage.ch</a>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
