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
        <div class="container">
        <h3>Dernières actualités</h3>
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
        <div class="presentation">
        <p>Du 21 au 24 mai 2026, le village de Semsales accueillera pour la 8e fois le Giron des musiques de la Veveyse, organisé par la fanfare l’Edelweiss. Cet événement, nommé EDEL’PARC 26, promet d’offrir à la région une fête des musiques hors du commun, sous le slogan évocateur : «Sensations musicales garanties».</p>
        <p>EDEL’PARC, inspiré de l’ambiance festive et chaleureuse des parcs d’attraction, vise à créer des moments simples et rassembleurs. En mettant à l’honneur toutes les générations, cette fête accorde une place toute particulière aux enfants en leur offrant un programme personnalisé qui contribuera à forger des souvenirs magiques et enrichissants.</p>
        </div>

	</main><!-- #main -->

<?php
get_footer();
