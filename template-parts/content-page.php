<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package EDELPARC26
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		
	<div class="container">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<div class="entry-content">
			<div class="content-grid">
				<div class="thumbnail">
					<?php
					if (has_post_thumbnail()) {
						edelparc26_post_thumbnail();
					}
					?>
				</div>
				<div class="content">
					<?php
					the_content();

					wp_link_pages(
						array(
							'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'edelparc26' ),
							'after'  => '</div>',
						)
					);
					?>
				</div>
			</div>
		</div><!-- .entry-content -->

	<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer">
			<?php
			edit_post_link(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Edit <span class="screen-reader-text">%s</span>', 'edelparc26' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				),
				'<span class="edit-link">',
				'</span>'
			);
			?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>
</div>

</article><!-- #post-<?php the_ID(); ?> -->