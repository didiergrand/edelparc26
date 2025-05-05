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
			the_custom_logo();
			endif;
      ?>
      </div>
			<div class="hotnews">
        <div class="hotnews-container">
          <h2>Hot news</h2>
          <?php
              $args2 = array(
                'post_type' => 'post' ,
                'orderby' => 'date' ,
                'order' => 'DESC' ,
                'posts_per_page' => 1,
                'cat'         => '4',
                'paged' => get_query_var('paged')
              );
              $q2 = new WP_Query($args2);
              if ($q2->have_posts()) {
                  while ($q2->have_posts()) {
                      $q2->the_post();
                      // your loop
                      get_template_part('template-parts/content-home', get_post_type());
                  }
              }
            ?>
            </div>
				</div>
		</section>
		<section id="presentation">
			<?php
          $args2 = array(
            'post_type' => 'post' ,
            'orderby' => 'date' ,
            'order' => 'DESC' ,
            'posts_per_page' => 1,
            'cat'         => '5',
            'paged' => get_query_var('paged')
          );
          $q2 = new WP_Query($args2);
          if ($q2->have_posts()) {
              while ($q2->have_posts()) {
                  $q2->the_post();
                  // your loop
                  get_template_part('template-parts/content-presentation', get_post_type());
              }
          }
        ?>
			</section>
		
      <section id="motpresident">
			<?php
          $args2 = array(
            'post_type' => 'post' ,
            'orderby' => 'date' ,
            'order' => 'DESC' ,
            'posts_per_page' => 1,
            'cat'         => '10',
            'paged' => get_query_var('paged')
          );
          $q2 = new WP_Query($args2);
          if ($q2->have_posts()) {
              while ($q2->have_posts()) {
                  $q2->the_post();
                  // your loop
                  get_template_part('template-parts/content-home', get_post_type());
              }
          }
        ?>
			</section>
		
		
		<?php
$args2 = array(
    'post_type' => 'post',
    'orderby' => 'date',
    'order' => 'DESC',
    'posts_per_page' => 3,
    'cat' => '6',
    'paged' => get_query_var('paged')
);

$q2 = new WP_Query($args2);

// Vérifier s'il y a des articles disponibles
if ($q2->have_posts()) {
    ?>
    <section id="actus">
        <h2>Dernières actualités</h2>
        <div class="container-small actus3cols">
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
