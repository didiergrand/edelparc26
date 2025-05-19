<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package EDELPARC26
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>



	<div class="entry-content">	
		<div class="presentation-container">
		<header class="entry-header">
			<?php
				the_title( '<h2 class="entry-title">', '</h2>' );
			?>
		</header><!-- .entry-header -->
		<?php
		the_content(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'edelparc26' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			)
		);

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'edelparc26' ),
				'after'  => '</div>',
			)
		);
		?>
		</div>
	</div><!-- .entry-content -->

	<?php edelparc26_post_thumbnail(); ?>
</article><!-- #post-<?php the_ID(); ?> -->
