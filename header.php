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
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-4GG1EEKVW0"></script>
	<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());

	gtag('config', 'G-4GG1EEKVW0');
	</script>


	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<!-- Meta Pixel Code -->
	<script>
	!function(f,b,e,v,n,t,s)
	{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
	n.callMethod.apply(n,arguments):n.queue.push(arguments)};
	if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
	n.queue=[];t=b.createElement(e);t.async=!0;
	t.src=v;s=b.getElementsByTagName(e)[0];
	s.parentNode.insertBefore(t,s)}(window, document,'script',
	'https://connect.facebook.net/en_US/fbevents.js');
	fbq('init', '1720693061927750');
	fbq('track', 'PageView');
	</script>
	<noscript><img height="1" width="1" style="display:none"
	src="https://www.facebook.com/tr?id=1720693061927750&ev=PageView&noscript=1"
	/></noscript>
	<!-- End Meta Pixel Code -->
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
		</div><!-- .site-branding -->

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
			<div id="social">
				<a href="https://www.instagram.com/edelparc26/" target="_blank">
					<img src="<?php echo get_template_directory_uri(); ?>/images/instagram.svg" alt="EDELPARC26 Instagram" class="instagram" width="24" height="24">
				</a>
				<a href="https://www.facebook.com/edelparc26/" target="_blank">
					<img src="<?php echo get_template_directory_uri(); ?>/images/facebook.svg" alt="EDELPARC26 Facebook" class="facebook" width="24" height="24">
				</a>
			</div>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-menu',
				)
			);
			?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->
