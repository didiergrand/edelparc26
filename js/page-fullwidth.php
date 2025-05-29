<?php
/**
 * Template Name: Full Width
 */

get_header(); ?>

<main id="primary" class="site-main container">
<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
    <?php
    while ( have_posts() ) :
        the_post();
        the_content();
    endwhile; // End of the loop.
    ?>
</main><!-- #main -->

<?php
get_footer();
