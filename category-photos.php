<?php
/**
 * Template for the "photos" category archive — no sidebar, cards grid
 *
 * @package EDELPARC26
 */

get_header();
?>

	<main id="primary" class="site-main">
		<?php if ( have_posts() ) : ?>

			<header class="page-header container">
				<?php
				the_archive_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="archive-description">', '</div>' );
				?>
			</header><!-- .page-header -->

			<div id="giron-cards">
				<div class="container">
					<div class="cards-grid">
						<?php
						while ( have_posts() ) :
							the_post();
							get_template_part( 'template-parts/content', 'photos' );
						endwhile;
						?>
					</div><!-- .cards-grid -->
					<?php the_posts_navigation(); ?>
				</div><!-- .container -->
			</div><!-- #giron-cards -->

		<?php else : ?>

			<?php get_template_part( 'template-parts/content', 'none' ); ?>

		<?php endif; ?>

	</main><!-- #main -->

<?php
get_footer();
