<?php
/**
 * Template part for displaying sponsor posts in a single-column layout.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package EDELPARC26
 */

?>
<section class="single-sponsors">
	<div class="background-title">
		<header class="entry-header container">
			<?php
			if ( is_singular() ) :
				the_title( '<h1 class="entry-title">', '</h1>' );
			else :
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			endif;

			if ( 'post' === get_post_type() ) :
				?>
				<div class="entry-meta">
					<?php
					edelparc26_posted_on();
					edelparc26_posted_by();
					?>
				</div>
			<?php endif; ?>
		</header>
	</div>

	<div class="single-content single-content--one-column container">
		<?php if ( is_singular() && has_post_thumbnail() ) : ?>
			<div class="single-featured-image">
				<?php the_post_thumbnail( 'large' ); ?>
			</div>
		<?php endif; ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class( 'single-sponsors__article' ); ?>>
			<div class="entry-content">
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

			<footer class="entry-footer">
				<?php edelparc26_entry_footer(); ?>
			</footer>
		</article>
	</div>
</section>
