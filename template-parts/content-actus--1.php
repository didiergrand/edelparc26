<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Giron_St-Martin_2024
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>	
	<div class="home_actus-img">
		<a href="<?php the_permalink(); ?>" class="btn btn-primary"><?php
			if ( has_post_thumbnail() ){
				the_post_thumbnail('squared-size');
			}
			?></a>

	</div>

	<div class="home_actus-content">
		<a href="<?php the_permalink(); ?>" class="btn btn-primary"><header class="entry-header">
			<?php
				the_title( '<h3 class="entry-title">', '</h3>' );
		?>
			</header><!-- .entry-header --></a>
		<?php
			the_excerpt();
		?>
		<a href="<?php the_permalink(); ?>" class="btn btn-primary">Lire la suite</a>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->
