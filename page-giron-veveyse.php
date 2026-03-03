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
		// Afficher le hero et le contenu de la page (intro)
		while ( have_posts() ) :
			the_post();

			$hero_title       = get_post_meta( get_the_ID(), 'hero_title', true );
			$hero_subtitle    = get_post_meta( get_the_ID(), 'hero_subtitle', true );
			$hero_meta        = get_post_meta( get_the_ID(), 'hero_meta', true );
			$hero_button_text = get_post_meta( get_the_ID(), 'hero_button_text', true );
			$hero_button_url  = get_post_meta( get_the_ID(), 'hero_button_url', true );
			$hero_bg_image    = '';

			if ( empty( $hero_title ) ) {
				$hero_title = get_the_title();
			}

			if ( empty( $hero_button_text ) ) {
				$hero_button_text = 'Voir le programme';
			}

			if ( has_post_thumbnail() ) {
				$hero_bg_image = get_the_post_thumbnail_url( get_the_ID(), 'full' );
			}

			?>
			<section class="giron-hero"<?php if ( ! empty( $hero_bg_image ) ) : ?> style="background-image:url('<?php echo esc_url( $hero_bg_image ); ?>');"<?php endif; ?>>
				<div class="giron-hero__overlay">
					<div class="container giron-hero__content">
						<p class="giron-hero__icon">&#9835;</p>
						<h1 class="giron-hero__title"><?php echo esc_html( $hero_title ); ?></h1>
						<?php if ( ! empty( $hero_subtitle ) ) : ?>
							<p class="giron-hero__subtitle"><?php echo esc_html( $hero_subtitle ); ?></p>
						<?php endif; ?>
						<?php if ( ! empty( $hero_meta ) ) : ?>
							<p class="giron-hero__meta"><?php echo esc_html( $hero_meta ); ?></p>
						<?php endif; ?>
						<?php if ( ! empty( $hero_button_url ) ) : ?>
							<a class="wp-element-button giron-hero__button" href="<?php echo esc_url( $hero_button_url ); ?>">
								<?php echo esc_html( $hero_button_text ); ?>
							</a>
						<?php endif; ?>
					</div>
				</div>
			</section>

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
