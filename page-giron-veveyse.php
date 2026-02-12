<?php
/**
 * Template Name: Giron Veveyse
 * 
 * Template pour la page Giron de la Veveyse.
 * Affiche le contenu de la page (intro) suivi des articles
 * de la catégorie "Card" en grille 3 colonnes.
 *
 * @package EDELPARC26
 */

get_header();
?>

	<main id="primary" class="site-main page-giron-veveyse">

		<?php
		// Afficher le contenu de la page (intro)
		while ( have_posts() ) :
			the_post();
			?>
			<section class="giron-intro">
				<div class="container">
					<?php
					the_content();
					?>
				</div>
			</section>
			<?php
		endwhile;
		?>

		<?php
		// Requête pour les articles de la catégorie "Card"
		$args_cards = array(
			'post_type'      => 'post',
			'orderby'        => 'date',
			'order'          => 'DESC',
			'posts_per_page' => -1,
			'category_name'  => 'card',
		);

		$query_cards = new WP_Query( $args_cards );

		if ( $query_cards->have_posts() ) :
			?>
			<section id="giron-cards">
				<div class="container">
					<div class="cards-grid">
						<?php
						while ( $query_cards->have_posts() ) :
							$query_cards->the_post();
							get_template_part( 'template-parts/content', 'actus' );
						endwhile;
						?>
					</div>
				</div>
			</section>
			<?php
		endif;

		wp_reset_postdata();
		?>

	</main><!-- #main -->

<?php
get_footer();
