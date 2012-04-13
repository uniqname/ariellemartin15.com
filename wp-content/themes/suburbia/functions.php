<?php
/**
 * @package Suburbia
 */

// Set the content width based on the theme's design and stylesheet.
function suburbia_set_content_width() {
	global $content_width;
	if ( is_page_template( 'full-width-page.php' ) || ( is_page() && ! is_active_sidebar( 'sidebar-1' ) ) )
		$content_width = 744;
	else
		$content_width = 547;
}
add_action( 'template_redirect', 'suburbia_set_content_width' );

// WP.com: set themecolors array
if ( ! isset( $themecolors ) ) {
	$themecolors = array(
		'bg' => 'ffffff',
		'border' => 'e0e0e0',
		'text' => '333333',
		'link' => '835504',
		'url' => '835504',
	);
}

// Enqueue scripts
function suburbia_scripts() {
	wp_enqueue_script( 'jquery-lazyload', get_template_directory_uri() . '/js/jquery.lazyload.mini.js', array( 'jquery' ), '20120116', true  );
	wp_enqueue_script( 'suburbia-script', get_template_directory_uri() . '/js/script.js', array( 'jquery' ), '20120116', true  );
}
add_action( 'wp_enqueue_scripts', 'suburbia_scripts' );

// Tell WordPress to run suburbia_setup() when the 'after_setup_theme' hook is run. */
if ( ! function_exists( 'suburbia_setup' ) ):

function suburbia_setup() {

	load_theme_textdomain( 'suburbia', get_template_directory() . '/languages' );

	$locale = get_locale();
	$locale_file = get_template_directory() . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	// Load up our theme options page and related code.
	//require( dirname( __FILE__ ) . '/inc/theme-options.php' );

	// Add default posts and comments RSS feed links to <head>.
	add_theme_support( 'automatic-feed-links' );

	// Add support for custom backgrounds
	add_custom_background();

	// The default header text color
	define( 'HEADER_TEXTCOLOR', '835504' );

	// By leaving empty, we allow for random image rotation.
	define( 'HEADER_IMAGE', '%s/images/logo.gif' );

	// The height and width of your custom header.
	// Add a filter to suburbia_header_image_width and suburbia_header_image_height to change these values.
	define( 'HEADER_IMAGE_WIDTH', apply_filters( 'suburbia_header_image_width', 155 ) );
	define( 'HEADER_IMAGE_HEIGHT', apply_filters( 'suburbia_header_image_height', 155 ) );

	// Add a way for the custom header to be styled in the admin panel that controls
	// custom headers. See suburbia_admin_header_style(), below.
	add_custom_image_header( 'suburbia_header_style', 'suburbia_admin_header_style', 'suburbia_admin_header_image' );

	// This theme uses Featured Images
	add_theme_support( 'post-thumbnails' );

	// Set thumbnail size.
	set_post_thumbnail_size( 155, 110, true );

	// Add a custom featured image size.
	add_image_size( 'suburbia-thumbnail', 155, 110, true ); // Set thumbnail size
	add_image_size( 'suburbia-sticky', 350, 248, true ); // Set thumbnail size for sticky posts in archive view

	// This theme uses Custom menu in two locations
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'suburbia' ),
	) );

}
endif;
add_action( 'after_setup_theme', 'suburbia_setup' );

// Styles the header image and text displayed on the blog
function suburbia_header_style() {
	$header_image = get_header_image();
	$header_textcolor = get_header_textcolor();
	if ( ! empty( $header_image ) && HEADER_TEXTCOLOR == $header_textcolor )
		return;
?>
	<style type="text/css">
<?php if ( empty( $header_image ) && 'blank' == $header_textcolor ) : ?>
	.header {
		display: none;
	}
	#access .menu > ul,
	#access ul.menu {
		margin-top: 0;
	}
<?php elseif ( 'blank' == $header_textcolor ) : ?>
	#site-title,
	#site-description {
		position: absolute !important;
		clip: rect(1px 1px 1px 1px); /* IE6, IE7 */
		clip: rect(1px, 1px, 1px, 1px);
	}
	.desc {
		border: none;
	}
<?php elseif ( empty( $header_image ) ) : ?>
	.logo-fix {
		display: none;
	}
<?php else : ?>
	#site-title a,
	#site-description {
		color: #<?php echo get_header_textcolor(); ?> !important;
	}
<?php endif; ?>
	</style>
<?php
}

// Styles the header image displayed on the Appearance > Header admin panel.
function suburbia_admin_header_style() {
?>
	<style type="text/css">
		.appearance_page_custom-header #headimg {
			border: none;
			width: 980px;
		}
		#headimg #header-image-wrap {
			float: left;
			height: 155px;
			width: 155px;
		}
		#headimg h1 {
			float: left;
			font: 300 25px/30px 'Helvetica Neue', Helvetica, Verdana, 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
			margin: 0 0 0 41px;
			padding: 5px 0 0 0;
			width: 350px;
		}
		#headimg h1 a {
			text-decoration: none;
		}
		#desc {
			float: left;
			font-size: 12px;
			line-height: 18px;
			padding: 17px 20px 0 40px;
			width: 337px;
		}
	</style>
<?php
}

// Adds custom markup for the header image displayed on the Appearance > Header admin panel.
function suburbia_admin_header_image() {
?>
	<div id="headimg">
	<?php
		if ( 'blank' == get_theme_mod( 'header_textcolor', HEADER_TEXTCOLOR ) || '' == get_theme_mod( 'header_textcolor', HEADER_TEXTCOLOR ) )
			$style = ' style="display:none;"';
		else
			$style = ' style="color:#' . get_theme_mod( 'header_textcolor', HEADER_TEXTCOLOR ) . ';"';

		$header_image = get_header_image();
	?>
		<div id="header-image-wrap">
	<?php
		if ( ! empty( $header_image ) ) :
	?>
			<img src="<?php echo esc_url( $header_image ); ?>" alt="" />
	<?php endif; ?>
		</div>
		<h1><a id="name"<?php echo $style; ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
		<div id="desc"<?php echo $style; ?>><?php bloginfo( 'description' ); ?></div>
	</div>
<?php
}

// Register a sidebar and four widgetized areas.
if ( function_exists( 'register_sidebar' ) ) {
	register_sidebar(array(
		'name'=> __( 'Sidebar', 'suburbia' ),
		'id' => 'sidebar-1',
		'description' => __( 'An optional sidebar widget area that appears on posts and pages in single view.', 'suburbia' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar(array(
		'name'=> __( 'Bottom Area One', 'suburbia' ),
		'id' => 'sidebar-2',
		'description' => __( 'An optional widget area at the bottom.', 'suburbia' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar(array(
		'name'=> __( 'Bottom Area Two', 'suburbia' ),
		'id' => 'sidebar-3',
		'description' => __( 'An optional widget area at the bottom.', 'suburbia' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar(array(
		'name'=> __( 'Bottom Area Three', 'suburbia' ),
		'id' => 'sidebar-4',
		'description' => __( 'An optional widget area at the bottom.', 'suburbia' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name'=> __( 'Bottom Area Four', 'suburbia' ),
		'id' => 'sidebar-5',
		'description' => __( 'An optional widget area at the bottom.', 'suburbia' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}

// Returns true if a blog has more than 1 category
function suburbia_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );
		$all_the_cool_cats = count( $all_the_cool_cats );
		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		return true;
	} else {
		return false;
	}
}

// Template for comments and pingbacks.
function suburbia_comments( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'suburbia' ); ?> <?php comment_author_link(); ?></p>
		<?php edit_comment_link( __( '(Edit)', 'suburbia' ), ' ' ); ?>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>" class="clear">
			<?php if ( $comment->comment_approved == '0' ) : ?>
				<em><?php _e( 'Your comment is awaiting moderation.', 'suburbia' ); ?></em>
				<br />
			<?php endif; ?>

			<div class="comment-meta">
				<?php comment_author_link(); ?>
				<div class="comment-date"><?php comment_date(); ?></div>
				<?php echo get_avatar( $comment, 55 ); ?>
				<?php edit_comment_link( __( '(Edit)', 'suburbia' ), ' ' ); ?>
			</div><!-- .comment-meta -->

			<div class="comment-content">
				<?php comment_text(); ?>
				<div class="reply">
					<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
				</div><!-- .reply -->
			</div>
		 </div><!-- #comment-<?php comment_ID(); ?> -->
	<?php
			break;
	endswitch;
}

// Sets the post excerpt length to 30 words.
function suburbia_excerpt_length( $length ) {
	return 30;
}
add_filter( 'excerpt_length', 'suburbia_excerpt_length' );

// Returns a "Continue Reading" link for excerpts
function suburbia_continue_reading_link() {
	return ' <a href="'. esc_url( get_permalink() ) . '" class="read-more">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'suburbia' ) . '</a>';
}

// Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and suburbia_continue_reading_link().
function suburbia_auto_excerpt_more( $more ) {
	return ' &hellip;' . suburbia_continue_reading_link();
}
add_filter( 'excerpt_more', 'suburbia_auto_excerpt_more' );

// Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
function suburbia_enhanced_image_navigation( $url ) {
	global $post, $wp_rewrite;

	$id = (int) $post->ID;
	$object = get_post( $id );
	if ( wp_attachment_is_image( $post->ID ) && ( $wp_rewrite->using_permalinks() && ( $object->post_parent > 0 ) && ( $object->post_parent != $id ) ) )
		$url = $url . '#main';

	return $url;
}
add_filter( 'attachment_link', 'suburbia_enhanced_image_navigation' );

// Add special classes to the WordPress body class.
function suburbia_body_classes( $classes ) {

	if ( ! is_active_sidebar( 'sidebar-1' ) )
		$classes[] = 'no-sidebar-widget';

	return $classes;
}
add_filter( 'body_class', 'suburbia_body_classes' );