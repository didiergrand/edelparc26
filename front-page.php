<?php
/**
 * The frontpage template file
 *
 * @package EDELPARC26
 */

get_header();
?>

	<main id="primary" class="site-main">
   <section id="welcome">
      <div class="logohome">
      <?php
        if ( is_front_page() && is_home() ) :
            the_custom_logo();?>
            <img src="<?php echo get_template_directory_uri(); ?>/images/Logo-EDELPARC26-baseline.png" alt="EDELPARC26 Logo" class="home-baseline">
        <?php
        endif;
      ?>
      </div>
		</section>

		<?php
$args2 = array(
    'post_type' => 'post',
    'orderby' => 'date',
    'order' => 'DESC',
    'posts_per_page' => 6,
    'cat' => '3',
    'paged' => get_query_var('paged')
);

$q2 = new WP_Query($args2);

// Vérifier s'il y a des articles disponibles
if ($q2->have_posts()) {
    ?>
    <section id="actus">
        <h3>Dernières actualités</h3>
        <div class="container">
            <?php
            while ($q2->have_posts()) {
                $q2->the_post();
                // Votre boucle
                get_template_part('template-parts/content-actus', get_post_type());
            }
            ?>
        </div>
    </section>
    <?php
}
?>


	</main><!-- #main -->

<?php
get_footer();
