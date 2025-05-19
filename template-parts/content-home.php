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


	<?php edelparc26_post_thumbnail(); ?>
	<div class="container">
	<div class="entry-content">	
		<header class="entry-header">
			<?php
				the_title( '<h3 class="entry-title">', '</h3>' );
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
	</div><!-- .entry-content -->
	</div>
</article><!-- #post-<?php the_ID(); ?> -->
