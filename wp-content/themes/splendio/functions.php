<?php
/**
 * Splendio functions and definitions
 *
 * @package Splendio
 */

// Set the content width based on the theme's design and stylesheet.
if ( ! isset( $content_width ) )
	$content_width = 600;

if ( ! function_exists( 'splendio_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support for post thumbnails.
 *
 */
 function splendio_setup() {

	/**
	 * Custom template tags for this theme.
	 */
	require( get_template_directory() . '/inc/template-tags.php' );

	/**
	 * Custom functions that act independently of the theme templates
	 */
	require( get_template_directory() . '/inc/tweaks.php' );

	/**
	 * Custom Theme Options
	 */
	require( get_template_directory() . '/inc/theme-options.php' );

	/**
	 * WordPress.com-specific functions and definitions
	 */
	require( get_template_directory() . '/inc/wpcom.php' );

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 */
	load_theme_textdomain( 'splendio', get_template_directory() . '/languages' );

	$locale = get_locale();
	$locale_file = get_template_directory() . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'splendio' ),
	) );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );

	// This theme allows users to set a custom background.
	add_custom_background();

	// This theme allows users to upload a custom header.
	define( 'NO_HEADER_TEXT', true );
	define( 'HEADER_IMAGE', '' );
	define( 'HEADER_IMAGE_WIDTH', 980 ); // use width and height appropriate for your theme
	define( 'HEADER_IMAGE_HEIGHT', 174 );

	// We'll be using post thumbnails for custom header images on posts and pages.
	// We want them to be the size of the header image that we just defined
	// Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
	set_post_thumbnail_size( HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT, true );

	// Add a way for the custom header to be styled in the admin panel that controls
	// custom headers. See fresh_and_clean_admin_header_style(), below.
	add_custom_image_header( '', 'splendio_admin_header_style' );

	// Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.
	register_default_headers( array(
		'geometric-1' => array(
			'url' => '%s/images/headers/geometric-1.jpg',
			'thumbnail_url' => '%s/images/headers/geometric-1-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Geometric 1', 'splendio' )
		),
		'geometric-2' => array(
			'url' => '%s/images/headers/geometric-2.jpg',
			'thumbnail_url' => '%s/images/headers/geometric-2-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Geometric 2', 'splendio' )
		),
		'geometric-3' => array(
			'url' => '%s/images/headers/geometric-3.jpg',
			'thumbnail_url' => '%s/images/headers/geometric-3-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Geometric 3', 'splendio' )
		),
		'geometric-4' => array(
			'url' => '%s/images/headers/geometric-4.jpg',
			'thumbnail_url' => '%s/images/headers/geometric-4-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Geometric 4', 'splendio' )
		),
		'geometric-5' => array(
			'url' => '%s/images/headers/geometric-5.jpg',
			'thumbnail_url' => '%s/images/headers/geometric-5-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Geometric 5', 'splendio' )
		),
		'path' => array(
			'url' => '%s/images/headers/path.jpg',
			'thumbnail_url' => '%s/images/headers/path-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Path', 'splendio' )
		)
	) );

	// This theme uses Featured Images
	add_theme_support( 'post-thumbnails' );
}
endif; // splendio_setup
add_action( 'after_setup_theme', 'splendio_setup' );

/**
 * Register widgetized area and update sidebar with default widgets
 *
 */
function splendio_widgets_init() {

	// Area 1, located at the top of the sidebar.
	register_sidebar( array(
		'name' => __( 'Sidebar', 'splendio' ),
		'id' => 'sidebar-1',
		'description' => __( 'The sidebar widget area', 'splendio' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );

	// Area 2, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'First Footer Widget Area', 'splendio' ),
		'id' => 'sidebar-2',
		'description' => __( 'The first footer widget area', 'splendio' ),
		'before_widget' => '<aside id="%1$s" class="widget-container">',
		'after_widget' => '</aside>',
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );
	register_sidebar( array(
		'name' => __( 'Second Footer Widget Area', 'splendio' ),
		'id' => 'sidebar-3',
		'description' => __( 'The second footer widget area', 'splendio' ),
		'before_widget' => '<aside id="%1$s" class="widget-container">',
		'after_widget' => '</aside>',
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );
	register_sidebar( array(
		'name' => __( 'Third Footer Widget Area', 'splendio' ),
		'id' => 'sidebar-4',
		'description' => __( 'The third footer widget area', 'splendio' ),
		'before_widget' => '<aside id="%1$s" class="widget-container">',
		'after_widget' => '</aside>',
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );
	register_sidebar( array(
		'name' => __( 'Fourth Footer Widget Area', 'splendio' ),
		'id' => 'sidebar-5',
		'description' => __( 'The fourth footer widget area', 'splendio' ),
		'before_widget' => '<aside id="%1$s" class="widget-container">',
		'after_widget' => '</aside>',
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );
	register_sidebar( array(
		'name' => __( 'Fifth Footer Widget Area', 'splendio' ),
		'id' => 'sidebar-6',
		'description' => __( 'The fifth footer widget area', 'splendio' ),
		'before_widget' => '<aside id="%1$s" class="widget-container">',
		'after_widget' => '</aside>',
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );
}
/** Register sidebars by running splendio_widgets_init() on the widgets_init hook. */
add_action( 'widgets_init', 'splendio_widgets_init' );

function splendio_admin_header_style() {}