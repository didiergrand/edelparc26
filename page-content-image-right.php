<?php
/**
 * Template Name: Portrait présentation
 * Template pour une page avec le contenu à gauche et la photo mise en avant à droite.
 *
 * @package EDELPARC26
 */

get_header();
?>

	<main id="primary" class="site-main page-content-image-right">

		<?php
		while ( have_posts() ) :
			the_post();
			?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >
				<div class="container">
					<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

					<div class="entry-content">
						<div class="content-grid content-grid--right">
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
							<div class="thumbnail thumbnail--decorated">
								<span class="thumbnail-decor thumbnail-decor--panel" aria-hidden="true"></span>
								<span class="thumbnail-decor thumbnail-decor--star thumbnail-decor--star-large" aria-hidden="true"></span>
								<span class="thumbnail-decor thumbnail-decor--star thumbnail-decor--star-medium" aria-hidden="true"></span>
								<span class="thumbnail-decor thumbnail-decor--star thumbnail-decor--star-small" aria-hidden="true"></span>
								<?php
								if ( has_post_thumbnail() ) {
									edelparc26_post_thumbnail();
								}
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

		<?php
		endwhile; // End of the loop.
		?>

	</main><!-- #main -->

<?php
get_footer();
