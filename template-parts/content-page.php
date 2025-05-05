<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Giron_St-Martin_2024
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php
		if (has_post_thumbnail()) {
			?>
	<div class="intro-container">
		<div class="intro-text">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		</div>
			<div class="intro-image">
			<?php
			stmartin2024_post_thumbnail(); // Affiche l'image mise en avant avec la fonction stmartin2024_post_thumbnail()
			?>
			</div>
	</div>

			<?php
		}
		?>		<?php
		if (!has_post_thumbnail()) {
			?>
	<div class="background-title">
		
	<div class="container intro-container 
		">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</div>
	</div>

			<?php
		}
		?>
	<div class="container">

	<div class="entry-content">
		<?php
		the_content();

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'stmartin2024' ),
				'after'  => '</div>',
			)
		);
		?>
	</div><!-- .entry-content -->

	<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer">
			<?php
			edit_post_link(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Edit <span class="screen-reader-text">%s</span>', 'stmartin2024' ),
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