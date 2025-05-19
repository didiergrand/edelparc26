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
	<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
</article><!-- #post-<?php the_ID(); ?> -->
