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
	<div class="home_actus-img">
		<?php if ( has_post_thumbnail() ){ ?>
			<?php if( get_post_meta($post->ID, "custom_link", true) ): ?>
				<a href="<?php echo get_post_meta( get_the_ID(), 'custom_link', true ); ?>">
					<?php the_post_thumbnail('squared-size'); ?>
				</a>
			<?php else: ?>
			<!-- something can go here if you don't have the custom field, but it's optional -->
				<a href="<?php the_permalink(); ?>">
					<?php the_post_thumbnail('squared-size'); ?>
				</a>
			<?php endif; 
			}
		?>   
	</div>

	<div class="home_actus-content">



	<?php if( get_post_meta($post->ID, "subtitle", true) ): ?>

<p class="subtitle"><?php echo get_post_meta( get_the_ID(), 'subtitle', true ); ?></p>
<?php endif; ?>

	<?php if( get_post_meta($post->ID, "custom_link", true) ): ?>
			<a href="<?php echo get_post_meta( get_the_ID(), 'custom_link', true ); ?>">			<header class="entry-header">
				<?php
				the_title( '<h4 class="entry-title">', '</h4>' );
				?>
			</header></a>
		<?php else: ?>
		<!-- something can go here if you don't have the custom field, but it's optional -->
		<a href="<?php the_permalink(); ?>">
			<header class="entry-header">
				<?php
				the_title( '<h4 class="entry-title">', '</h4>' );
				?>
			</header>
		</a>
		<?php endif; ?>
		<?php
			the_content();
		?>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->
