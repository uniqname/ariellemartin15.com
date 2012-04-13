<?php
/**
 * @package Nuntius
 * @since Nuntius 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 * Used to set the width of images and content. Should be equal to the width the theme
 * is designed for, generally via the style.css stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 560;

/**
 * Tell WordPress to run nuntius_setup() when the 'after_setup_theme' hook is run.
 */
add_action( 'after_setup_theme', 'nuntius_setup' );

if ( ! function_exists( 'nuntius_setup' ) ):

function nuntius_setup() {

	// Load the theme options page
	require_once( dirname( __FILE__ ) . '/inc/theme-options.php' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Make theme available for translation
	// Translations can be filed in the /languages/ directory
	load_theme_textdomain( 'nuntius', get_template_directory() . '/languages' );

	$locale = get_locale();
	$locale_file = TEMPLATEPATH . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	// This theme uses wp_nav_menu() in three locations.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'nuntius' ),
		'secondary' => __( 'Secondary Menu', 'nuntius' ),
		'footer-menu' => __( 'Footer Menu', 'nuntius' ),
	) );

	// This theme allows users to set a custom background.
	add_custom_background();

	// This theme allows users to upload a custom header.
	define( 'HEADER_TEXTCOLOR', 'ffffff' );
	define( 'HEADER_IMAGE', '' );
	define( 'HEADER_IMAGE_WIDTH', 980 ); // use width and height appropriate for your theme
	define( 'HEADER_IMAGE_HEIGHT', 155 );

	// Define the minimum image width for the featured slider
	define ( 'FEATURED_IMAGE_WIDTH', 640 );

	// Add a way for the custom header to be styled in the admin panel that controls
	// custom headers. See nuntius_admin_header_style(), below.
	add_custom_image_header( 'nuntius_header_style', 'nuntius_admin_header_style' );

	// This theme uses post thumbnails.
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'nuntius-slideshow-large', 640, 430, true );
	add_image_size( 'nuntius-thumbnail', 100, 75, true );

	// Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
	function nuntius_page_menu_args($args) {
		$args['show_home'] = true;
	return $args;
	}
	add_filter( 'wp_page_menu_args', 'nuntius_page_menu_args' );

}
endif;

// Load the scripts necessary to run our featured posts slider
function nuntius_scripts() {
	wp_enqueue_script( 'jcycle', get_template_directory_uri().'/js/jcycle.js', array( 'jquery'), '201101207' );
	wp_enqueue_script( 'functions-js', get_template_directory_uri().'/js/functions.js', array( 'jquery'), '201101207' );
}
add_action( 'wp_enqueue_scripts', 'nuntius_scripts' );

/**
* Add custom header support
*/
if ( ! function_exists( 'nuntius_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 */
function nuntius_header_style() {
	// If no custom options for text are set, let's bail
	if ( HEADER_TEXTCOLOR == get_header_textcolor() && '' == get_header_image() )
		return;
	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
	<?php
		// Do we have a custom header image?
		if ( '' != get_header_image() ) :
	?>
		#header .wrap {
			background: url(<?php header_image(); ?>) no-repeat;
			width: 980px;
			height: 155px;
		}
		#site-title {
			margin: 48px 12px 0;
		}
	<?php
		endif;

		// Has the text been hidden?
		if ( 'blank' == get_header_textcolor() ) :
	?>
		#site-title {
 	 		position: absolute !important;
			clip: rect(1px 1px 1px 1px); /* IE6, IE7 */
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		// If the user has set a custom color for the text use that
		else :
	?>
		#site-title a {
			background: none !important;
			border: 0 !important;
			color: #<?php echo get_header_textcolor(); ?> !important;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif;

if ( ! function_exists( 'nuntius_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 * Referenced via add_custom_image_header() in nuntius_setup().
 */
function nuntius_admin_header_style() {
?>
	<style type="text/css">
	.appearance_page_custom-header #headimg {
		background-color: #<?php echo ( '' != get_background_color() ? get_background_color() : '800000' ); ?>;
		border: none;
		width: 980px;
		height: 155px;
		text-align: left;
	}
	#headimg h1 {
		float: left;
		font-family: 'Lobster', Georgia, serif;
		font-size: 48px;
		font-weight: normal;
		line-height: 48px;
		margin: 45px 0 0 35px;
		padding: 10px;
	}
	#headimg h1 a {
		color: #fff;
		text-decoration: none;
	}
	#desc {
		display: none;
	}
	<?php
		// If the user has set a custom color for the text use that
		if ( HEADER_TEXTCOLOR != get_header_textcolor() ) :
	?>
		#site-title a {
			color: #<?php echo get_header_textcolor(); ?>;
		}
	<?php endif; ?>
	</style>
<?php
}
endif;

if ( ! function_exists( 'nuntius_content_nav' ) ):

// Display navigation to next/previous pages when applicable
function nuntius_content_nav( $nav_id ) {
	global $wp_query;

	?>
	<div id="<?php echo $nav_id; ?>">
		<h1 class="assistive-text section-heading"><?php _e( 'Post navigation', 'nuntius' ); ?></h1>

	<?php if ( is_single() ) : // navigation links for single posts ?>

		<?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'nuntius' ) . '</span> %title' ); ?>
		<?php next_post_link( '<div class="nav-next">%link</div>', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'nuntius' ) . '</span>' ); ?>

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

		<?php if ( get_next_posts_link() ) : ?>
		<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'nuntius' ) ); ?></div>
		<?php endif; ?>

		<?php if ( get_previous_posts_link() ) : ?>
		<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'nuntius' ) ); ?></div>
		<?php endif; ?>

	<?php endif; ?>

	</div><!-- #<?php echo $nav_id; ?> -->
	<?php
}
endif; // nuntius_content_nav

/**
* Load the custom widgets
*/
require_once( dirname( __FILE__ ) . '/inc/widgets.php' );

/**
 * Register widgetized area and update sidebar with default widgets
 */
function nuntius_widgets_init() {
	register_sidebar( array (
		'name' => __( 'Default sidebar', 'nuntius' ),
		'id' => 'sidebar-1',
		'description' => __( 'Widgets dragged here will appear in the right sidebar.', 'nuntius' ),
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title"><span>',
		'after_title' => '</span></h3>'
	) );

	register_sidebar( array (
		'name' => __( 'Header widget area', 'nuntius' ),
		'id' => 'sidebar-2',
		'description' => __( 'Widgets dragged here will appear inside the header area, to the right of the site title. This widget area works best with only one short widget.', 'nuntius' ),
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title"><span>',
		'after_title' => '</span></h3>'
	) );

	register_sidebar( array (
		'name' => __( 'Feature widget area', 'nuntius' ),
		'id' => 'sidebar-3',
		'description' => __( 'Widgets placed here will appear to the right of the featured slider, if the slider is enabled. This widget area works best with only one short widget.', 'nuntius' ),
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>'
	) );

}
add_action( 'init', 'nuntius_widgets_init' );

/**
 * Removes the default styles that are packaged with the Recent Comments widget.
 */
function nuntius_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}
add_action( 'widgets_init', 'nuntius_remove_recent_comments_style' );

if ( ! function_exists( 'nuntius_single_post_meta' ) ) :
/**
 * Prints HTML with meta information for the current post (author, date, category, and permalink), for use on content.php
 */
function nuntius_single_post_meta() {
	printf( __( '<span class="sep">Posted <span class="sep"> by </span> <span class="author vcard"><a class="url fn n" href="%3$s" title="%4$s">%5$s</a></span> on </span> <span class="entry-date"><a href="%1$s" rel="bookmark" title="%7$s">%2$s</a></span> in <span class="entry-categories">%6$s</span>', 'nuntius' ),
		get_permalink(),
		get_the_date(),
		get_author_posts_url( get_the_author_meta( 'ID' ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'nuntius' ), get_the_author() ) ),
		get_the_author(),
		get_the_category_list( ', ' ),
		esc_attr( get_the_time() )
	);
}
endif;

if ( ! function_exists( 'nuntius_tag_list' ) ) :
/**
 * Prints the tags for the current post
 */
function nuntius_tag_list() {
	$tag_list = get_the_tag_list( '', ', ' );
	if ( '' != $tag_list ) {
		$utility_text = __( '<span class="tag-links">Tags: %1$s</a></span> <span class="entry-permalink"><a href="%2$s" title="Permalink to %3$s" rel="bookmark">Permalink</a></span>', 'nuntius' );
	} else {
		$utility_text = __( '<span class="entry-permalink"><a href="%2$s" title="Permalink to %3$s" rel="bookmark">Permalink</a></span>', 'nuntius' );
	}
	printf(
		$utility_text,
		$tag_list,
		get_permalink(),
		the_title_attribute( 'echo=0' )
	);
}
endif;

if ( ! function_exists( 'nuntius_archive_post_meta' ) ) :
/**
 * Prints HTML with meta information for the current post (author, date, category, and permalink), for use on archive.php, search.php and in the "more articles" section
 */
function nuntius_archive_post_meta() {
	printf( __( '<span class="sep"> By </span> <span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span> <span class="entry-date"><a href="%4$s" rel="bookmark" title="%6$s">%5$s</a></span>', 'nuntius' ),
			get_author_posts_url( get_the_author_meta( 'ID' ) ),
			esc_attr( sprintf( __( 'View all posts by %s', 'nuntius' ), get_the_author() ) ),
			get_the_author(),
			get_permalink(),
			get_the_date(),
			esc_attr( get_the_time() )
		);
}
endif;

if ( ! function_exists( 'nuntius_comment' ) ) :
/**
 * Template for displaying individual comments and pingbacks.
 * To override this walker in a child theme without modifying the comments template
 * simply create your own nuntius_comment(), and that function will be used instead.
 */
function nuntius_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>" class="comment-wrap">
		<div class="comment-head comment-author vcard">
			<?php echo get_avatar( $comment, 48 ); ?>

			<span class="comment-meta commentmetadata">

				<cite class="fn"><?php comment_author_link(); ?></cite>

				<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>" class="comment-date">
				<?php
					/* translators: 1: date, 2: time */
					printf( __( '%1$s at %2$s', 'nuntius' ),
						get_comment_date(),
						get_comment_time()
					); ?>
				</a>
				<?php edit_comment_link( __( 'Edit', 'nuntius' ), '', '' ); ?>

				<?php if ( comments_open() ): ?>
					<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'], 'reply_text' => __( 'Reply', 'nuntius' ) ) ) ); ?></span>
				<?php endif; ?>

			</span><!-- .comment-meta .commentmetadata -->
		</div><!-- .comment-head .comment-author .vcard -->

		<div class="comment-content comment-text">
			<?php if ( $comment->comment_approved == '0' ) : ?>
				<em><?php _e( 'Your comment is awaiting moderation.', 'nuntius' ); ?></em>
				<br />
			<?php endif; ?>
			<?php comment_text(); ?>
		</div><!-- .comment-content -->
	</div><!-- #comment-## -->
<?php }
endif;

if ( ! function_exists( 'nuntius_pings' ) ) :
/**
 * Template for Trackbacks and Pingbacks
 */
function nuntius_pings( $comment, $args, $depth ) {
 $GLOBALS[ 'comment' ] = $comment;
 ?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'nuntius' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'nuntius' ), ' ' ); ?></p>
	</li>
<?php }
endif;

/**
 * Set the theme colors for WordPress.com
 */
$themecolors = array(
	'bg' => 'd9d9d9',
	'border' => '000000',
	'text' => '777777',
	'link' => 'dd7a05',
	'url' => 'dd7a05',
);

// Enqueue font styles
function nuntius_fonts() {
	wp_enqueue_style( 'lobster', 'http://fonts.googleapis.com/css?family=Lobster' );
	wp_enqueue_style( 'oswald', 'http://fonts.googleapis.com/css?family=Oswald' );
}
add_action( 'wp_enqueue_scripts', 'nuntius_fonts' );
add_action( 'admin_print_styles-appearance_page_custom-header', 'nuntius_fonts' );

// Dequeue font styles.
function nuntius_dequeue_fonts() {
	/**
	 * We don't want to enqueue the font scripts if the blog
	 * has WP.com Custom Design and is using a 'Headings' font.
	 */
	if ( class_exists( 'TypekitData' ) ) {
		if ( TypekitData::get( 'upgraded' ) ) {
			$customfonts = TypekitData::get( 'families' );
			if ( ! $customfonts )
				return;
			$headings = $customfonts['headings'];

			if ( $headings['id'] ) {
				wp_dequeue_style( 'lobster' );
				wp_dequeue_style( 'oswald' );
			}
		}
	}
}
add_action( 'wp_enqueue_scripts', 'nuntius_dequeue_fonts' );

// Display a breadcrumb trail that lets users know where they are within the site
if ( ! function_exists( 'nuntius_get_breadcrumbs' ) ) :
function nuntius_get_breadcrumbs() {
	global $wp_query;

?>
	<ul>
		<li><?php _e( 'Browsing: <span class="sep">&raquo;</span> ', 'nuntius' ); ?></li>
	<?php
		/* Add the Home link */
	?>
		<li><a href="<?php echo esc_url( home_url() ); ?>"> <?php _e( ' Home ' , 'nuntius' ); ?></a></li>

		<?php if ( ! is_front_page() ) :
			/* Check for categories, archives, search page, single posts, pages, the 404 page, and attachments */
		?>
		<?php
			if ( is_category() ):
				global $wp_query;
      			$cat_obj = $wp_query->get_queried_object();
     		 	$thisCat = $cat_obj->term_id;
      			$thisCat = get_category($thisCat);
      			$parentCat = get_category($thisCat->parent);
      		?>
      			<li>
      			  	<?php _e( '<span class="sep">&raquo;</span>' , 'nuntius' );

					if ( $thisCat->parent != 0 ) :
						echo( get_category_parents( $parentCat, TRUE, '<span class="sep">&raquo;</span>' ) );
					endif;
					?>
						<?php echo single_cat_title( '', false ); ?>
     			</li>

		<?php elseif ( is_archive() && ! is_category() ) : ?>
			<li><?php _e( '<span class="sep">&raquo;</span> Archives' , 'nuntius' ); ?></a></li>

		<?php elseif ( is_search() ) : ?>
			<li><?php _e( '<span class="sep">&raquo;</span> Search Results' , 'nuntius' ); ?></a></li>

		<?php elseif ( is_404() ): ?>
			<li><?php _e( '<span class="sep">&raquo;</span> 404 Not Found' , 'nuntius'); ?></a></li>

		<?php elseif ( is_singular( 'post' ) ) :

			$category = get_the_category();
			$category_id = get_cat_ID( $category[0]->cat_name ); ?>

				<li>
					<?php _e( '<span class="sep">&raquo;</span>', 'nuntius' ); echo get_category_parents( $category_id, TRUE, '<span class="sep">&raquo;</span>' ); echo the_title( '','', FALSE ); ?>
				</li>

		<?php elseif ( is_singular( 'attachment' ) ) : ?>

				<li>
					<?php _e( '<span class="sep">&raquo;</span>', 'nuntius' ); echo the_title( '','', FALSE ); ?>
				</li>

		<?php elseif ( is_page() ) :
				$post = $wp_query->get_queried_object();

				if ( $post->post_parent == 0 ) : ?>

					<li>
						<?php _e( '<span class="sep">&raquo;</span>', 'nuntius' ); echo the_title( '','', FALSE ); ?>
					</li>

			<?php else:
					$title = the_title( '','', FALSE );
					$ancestors = array_reverse( get_post_ancestors( $post->ID ) );
					array_push( $ancestors, $post->ID );

					foreach ( $ancestors as $ancestor ) :
						if ( $ancestor != end( $ancestors ) ) : ?>

							<li>
								<?php _e( '<span class="sep">&raquo;</span>', 'nuntius' ); ?><a href="<?php echo esc_url( get_permalink( $ancestor ) ); ?>"><?php echo strip_tags( apply_filters( 'single_post_title', get_the_title( $ancestor ) ) ); ?></a>
							</li>

						<?php else : ?>

							<li>
								<?php _e( '<span class="sep">&raquo;</span>', 'nuntius' ); ?><?php echo strip_tags( apply_filters( 'single_post_title', get_the_title( $ancestor ) ) ); ?>
							</li>

						<?php endif;
					endforeach;
				endif;
			endif;
		endif; ?>
		</ul>
<?php }
endif;

function nuntius_header_css() {
	// Hide the theme-provided background image if the user adds a custom background image or color
	if ( '' != get_header_image() ) : ?>
	<style type="text/css">
		#header .wrap {
			margin: 10px auto;
			position: relative;
			z-index: 1;
		}
	</style>
	<?php endif;
}
add_action( 'wp_head', 'nuntius_header_css' );