<?php
/**
 * Template part for a photo album card (category-photos archive)
 *
 * @package EDELPARC26
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if ( has_post_thumbnail() ) : ?>
	<div class="home_actus-img">
		<a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
			<?php the_post_thumbnail( 'squared-size' ); ?>
		</a>
	</div>
	<?php endif; ?>

	<div class="home_actus-content">
		<a href="<?php the_permalink(); ?>">
			<?php the_title( '<h4 class="entry-title">', '</h4>' ); ?>
		</a>
		<a href="<?php the_permalink(); ?>" class="card-link">
			<?php esc_html_e( 'Voir les photos', 'edelparc26' ); ?>
		</a>
	</div>

</article>
