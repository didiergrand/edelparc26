<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package EDELPARC26
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
	<!-- Google tag (gtag.js) -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-49XFM0N23Y"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'G-49XFM0N23Y');
	</script>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'EDELPARC26' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="site-branding">

        <?php
			if ( is_front_page() && is_home() ) :
				?>
				<img src="/wp-content/uploads/2025/05/Logo-EDELPARC26.png" alt="EDELPARC26 Logo" class="home-logo">
				<img src="<?php echo get_template_directory_uri(); ?>/images/Logo-EDELPARC26-baseline.png" alt="EDELPARC26 Logo" class="home-baseline">
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php
			else :
				?>		
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				<img src="/wp-content/uploads/2025/05/Logo-EDELPARC26.png" alt="EDELPARC26 Logo" class="home-logo">
	</a>				<img src="<?php echo get_template_directory_uri(); ?>/images/Logo-EDELPARC26-baseline.png" alt="EDELPARC26 Logo" class="home-baseline">

				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php
			endif;
			$EDELPARC26_description = get_bloginfo( 'description', 'display' );
			if ( $EDELPARC26_description || is_customize_preview() ) :
				?>
				<p class="site-description"><?php echo $EDELPARC26_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
			<?php endif; ?>

			<nav id="site-navigation" class="main-navigation">
				<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
					<div class="menu-label">
						<span class="close-menu">Fermer le menu</span>
						<span class="open-menu">Menu</span>
					</div>
					<div class="burger">
						<div class="bar1"></div>
					<div class="bar2"></div>
					<div class="bar3"></div>
					</div>
				</button>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'menu-1',
						'menu_id'        => 'primary-menu',
					)
				);
				?>
			</nav><!-- #site-navigation -->
		</div><!-- .site-branding -->

	</header><!-- #masthead -->
