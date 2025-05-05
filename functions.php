<?php
/**
 * EDELPARC26 functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package EDELPARC26
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.2' );
}

if ( ! function_exists( 'EDELPARC26_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function EDELPARC26_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on EDELPARC26, use a find and replace
		 * to change 'EDELPARC26' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'EDELPARC26', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'EDELPARC26' ),
				'social-1' => esc_html__( 'Social', 'EDELPARC26' )
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'EDELPARC26_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'EDELPARC26_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function EDELPARC26_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'EDELPARC26_content_width', 640 );
}
add_action( 'after_setup_theme', 'EDELPARC26_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function EDELPARC26_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'EDELPARC26' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'EDELPARC26' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

    // Footer widget
    register_sidebar(
        array(
            'name'          => esc_html__( 'Footer', 'EDELPARC26' ),
            'id'            => 'footer-1',
            'description'   => esc_html__( 'Add widgets here.', 'EDELPARC26' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );
}
add_action( 'widgets_init', 'EDELPARC26_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function EDELPARC26_scripts() {
	wp_enqueue_style( 'EDELPARC26-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'EDELPARC26-style', 'rtl', 'replace' );

	wp_enqueue_script( 'EDELPARC26-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	wp_enqueue_script( 'EDELPARC26-homepage', get_template_directory_uri() . '/js/homepage.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'EDELPARC26_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

// custom_header_size : fonction pour définir la taille de l'image d'en-tête
function custom_header_size() {
    add_theme_support( 'custom-header', array(
        'width'         => 2000, // Remplacez par la largeur souhaitée
        'height'        => 700, // Remplacez par la hauteur souhaitée
        'flex-width'    => true,
        'flex-height'   => true,
    ) );
}
add_action( 'after_setup_theme', 'custom_header_size' );


add_image_size( 'squared-size', 800, 800, true ); // 800 pixels wide by 600 pixels tall, hard crop mode
