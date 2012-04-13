<?php
/**
 * Forever functions and definitions
 *
 * @package Forever
 * @since Forever 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 640; /* pixels */

if ( ! function_exists( 'forever_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function forever_setup() {
	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 */
	load_theme_textdomain( 'forever', get_template_directory() . '/languages' );

	$locale = get_locale();
	$locale_file = get_template_directory() . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	/**
	 * Load up our theme options page and related code.
	 */
	require( get_template_directory() . '/inc/theme-options.php' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'forever' ),
	) );

	/**
	 * Add support for the Aside and Gallery Post Formats
	 */
	add_theme_support( 'post-formats', array( 'gallery', 'image', 'status', 'quote' ) );

	/**
	 * Enqueue font styles.
	 */
	function forever_fonts() {
		wp_enqueue_style( 'raleway', 'http://fonts.googleapis.com/css?family=Raleway:100' );
	}
	add_action( 'wp_enqueue_scripts', 'forever_fonts' );
	add_action( 'admin_print_styles-appearance_page_custom-header', 'forever_fonts' );

	/**
	 * Enqueue scripts
	 */
	function forever_masonry() {
		if ( is_page_template( 'guestbook.php') ) {
			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'masonry', get_template_directory_uri() . '/js/jquery.masonry.min.js', 'jquery', '28-12-2011', true );
			wp_enqueue_script( 'guestbook', get_template_directory_uri() . '/js/guestbook.js', 'jquery', '28-12-2011', true );
		}
	}
	add_action( 'wp_enqueue_scripts', 'forever_masonry' );

	/**
	 * This theme uses Featured Images (also known as post thumbnails)
	 */
	add_theme_support( 'post-thumbnails' );

	/**
	 * Add an image size for our featured images
	 */
	add_image_size( 'large-feature', 888, 355, true );
	add_image_size( 'small-feature', 195, 124, true );

	/**
	 * Add support for custom backgrounds
	 */
	add_custom_background();

	/**
	 * The default header text color
	 */
	define( 'HEADER_TEXTCOLOR', '1982d1' );

	/**
	 * By leaving empty, we allow for random image rotation.
	 */
	define( 'HEADER_IMAGE', '' );

	/**
	 * The height and width of our custom header.
	 */
	define( 'HEADER_IMAGE_WIDTH', 885 );
	define( 'HEADER_IMAGE_HEIGHT', 252 );	/**
	 * Turn on random header image rotation by default.
	 */
	add_theme_support( 'custom-header', array( 'random-default' => true ) );

	/**
	 * Add a way for the custom header to be styled in the admin panel that controls custom headers.
	 */
	add_custom_image_header( 'forever_header_style', 'forever_admin_header_style', 'forever_admin_header_image' );

}
endif; // forever_setup

/**
 * Tell WordPress to run forever_setup() when the 'after_setup_theme' hook is run.
 */
add_action( 'after_setup_theme', 'forever_setup' );

if ( ! function_exists( 'forever_header_style' ) ) :
/**
 * Custom styles for our blog header
 */
function forever_header_style() {
	// If no custom options for text are set, let's bail
	$header_image = get_header_image();
	if ( empty( $header_image ) && '' == get_header_textcolor() )
		return;
	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
	#masthead img {
		float: left;
		margin: 1.615em 0 0;
	}
	<?php
		// Has the text been hidden? Let's hide it then.
		if ( 'blank' == get_header_textcolor() ) :
	?>
		#site-title {
			position: absolute !important;
			clip: rect(1px 1px 1px 1px); /* IE6, IE7 */
			clip: rect(1px, 1px, 1px, 1px);
		}
		#masthead img {
			margin: -0.8075em 0 0;
		}
	<?php
		// If the user has set a custom color for the text use that
		else :
	?>
		#site-title a {
			color: #<?php echo get_header_textcolor(); ?> !important;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif; // forever_header_style()

if ( ! function_exists( 'forever_admin_header_style' ) ) :
/**
 * Custom styles for the custom header page in the admin
 */
function forever_admin_header_style() {
?>
	<style type="text/css">
	#headimg {
		background: #fff;
		text-align: center;
		max-width: 885px;
	}
	#headimg .masthead {
		padding: 48px 0 0;
	}
	.appearance_page_custom-header #headimg {
		border: none;
	}
	#headimg h1 {
		font-family: Raleway, "Helvetica Neue", Arial, Helvetica, "Nimbus Sans L", sans-serif;
		line-height: 1.17;
		margin-bottom: 0;
		padding-top: 0;
		font-size: 60px;
		line-height: 1.212;
	}
	#headimg h1 a {
		text-decoration: none;
	}
	#headimg h1 a:hover,
	#headimg h1 a:focus,
	#headimg h1 a:active {
	}
	#headimg #desc {
	}
	#headimg img {
		background: #fff;
		border: 1px solid #bbb;
		float: left;
		height: auto;
		margin: 21px 0 0;
		max-width: 100%;
		padding: 1px;
	}
	<?php
		// If the user has set a custom color for the text use that
		if ( get_header_textcolor() != HEADER_TEXTCOLOR ) :
	?>
		#headimg h1 a {
			color: #<?php echo get_header_textcolor(); ?>;
		}
	<?php endif; ?>
	<?php
		// Has the text been hidden?
		if ( 'blank' == get_header_textcolor() ) :
	?>
	#headimg .masthead {
		display: none;
	}
	<?php endif; ?>
	</style>
<?php
}
endif; // forever_admin_header_style

if ( ! function_exists( 'forever_admin_header_image' ) ) :
/**
 * Custom markup for the custom header admin page
 */
function forever_admin_header_image() { ?>
	<div id="headimg">
		<?php
		if ( 'blank' == get_theme_mod( 'header_textcolor', HEADER_TEXTCOLOR ) || '' == get_theme_mod( 'header_textcolor', HEADER_TEXTCOLOR ) )
			$style = ' style="display:none;"';
		else
			$style = ' style="color:#' . get_theme_mod( 'header_textcolor', HEADER_TEXTCOLOR ) . ';"';
		?>
		<div class="masthead">
			<h1><a id="name" onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
		</div>
		<?php $header_image = get_header_image();
		if ( ! empty( $header_image ) ) : ?>
			<img src="<?php echo esc_url( $header_image ); ?>" alt="" />
		<?php endif; ?>
	</div>
<?php }
endif; // forever_admin_header_image

/**
 * Sets the post excerpt length to 40 words.
 */
function forever_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'forever_excerpt_length' );

/**
 * Returns a "Continue Reading" link for excerpts
 */
function forever_continue_reading_link() {
	return ' <a class="more-link" href="'. esc_url( get_permalink() ) . '">' . __( 'Continue&nbsp;reading&nbsp;<span class="meta-nav">&rarr;</span>', 'forever' ) . '</a>';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and forever_continue_reading_link().
 */
function forever_auto_excerpt_more( $more ) {
	return ' &hellip;' . forever_continue_reading_link();
}
add_filter( 'excerpt_more', 'forever_auto_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 */
function forever_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= forever_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'forever_custom_excerpt_more' );

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function forever_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'forever_page_menu_args' );

/**
 * Register widgetized area and update sidebar with default widgets
 */
function forever_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Sidebar', 'forever' ),
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );

	register_sidebar( array(
		'name' => __( 'Footer Widget Area One', 'forever' ),
		'description' => __( 'An optional footer widget area.', 'forever' ),
		'id' => 'sidebar-2',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );

	register_sidebar( array(
		'name' => __( 'Footer Widget Area Two', 'forever' ),
		'description' => __( 'An optional footer widget area.', 'forever' ),
		'id' => 'sidebar-3',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );

	register_sidebar( array(
		'name' => __( 'Footer Widget Area Three', 'forever' ),
		'description' => __( 'An optional footer widget area.', 'forever' ),
		'id' => 'sidebar-4',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );

	register_sidebar( array(
		'name' => __( 'Footer Widget Area Four', 'forever' ),
		'description' => __( 'An optional footer widget area.', 'forever' ),
		'id' => 'sidebar-5',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );
}
add_action( 'init', 'forever_widgets_init' );

if ( ! function_exists( 'forever_content_nav' ) ):
/**
 * Display navigation to next/previous pages when applicable
 *
 * @since Forever 1.0
 */
function forever_content_nav( $nav_id ) {
	global $wp_query;

	?>
	<nav id="<?php echo $nav_id; ?>">
		<h1 class="assistive-text section-heading"><?php _e( 'Post navigation', 'forever' ); ?></h1>

	<?php if ( is_single() ) : // navigation links for single posts ?>

		<?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'forever' ) . '</span> %title' ); ?>
		<?php next_post_link( '<div class="nav-next">%link</div>', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'forever' ) . '</span>' ); ?>

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

		<?php if ( get_next_posts_link() ) : ?>
		<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'forever' ) ); ?></div>
		<?php endif; ?>

		<?php if ( get_previous_posts_link() ) : ?>
		<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'forever' ) ); ?></div>
		<?php endif; ?>

	<?php endif; ?>

	</nav><!-- #<?php echo $nav_id; ?> -->
	<?php
}
endif; // forever_content_nav


if ( ! function_exists( 'forever_comment' ) ) :
/**
 * Template for comments and pingbacks.
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Forever 1.0
 */
function forever_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'forever' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '[Edit]', 'forever' ), ' ' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<footer>
				<div class="comment-author vcard">
					<?php
					$comment_avatar_size = 54;
					if ( 0 != $comment->comment_parent )
						$comment_avatar_size = 28;

					echo get_avatar( $comment, $comment_avatar_size );
					?>
					<cite class="fn"><?php comment_author_link(); ?></cite>
				</div><!-- .comment-author .vcard -->
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em><?php _e( 'Your comment is awaiting moderation.', 'forever' ); ?></em>
					<br />
				<?php endif; ?>

				<div class="comment-meta commentmetadata">
					<a class="comment-time" href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><time pubdate datetime="<?php comment_time( 'c' ); ?>">
					<?php
						/* translators: 1: date, 2: time */
						printf( __( '%1$s at %2$s', 'forever' ), get_comment_date(), get_comment_time() ); ?>
					</time></a>
					<?php edit_comment_link( __( '[Edit]', 'forever' ), ' ' );
					?>
				</div><!-- .comment-meta .commentmetadata -->
			</footer>

			<div class="comment-content"><?php comment_text(); ?></div>

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->

	<?php
			break;
	endswitch;
}
endif; // ends check for forever_comment()

if ( ! function_exists( 'forever_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 *
 * @since Forever 1.0
 */
function forever_posted_on() {
	printf( __( '<span class="sep">Posted on </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a><span class="byline"> <span class="sep"> by </span> <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'forever' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'forever' ), get_the_author() ) ),
		esc_html( get_the_author() )
	);
}
endif;

/**
 * Adds custom classes to the array of body classes.
 *
 * @since Forever 1.0
 */
function forever_body_classes( $classes ) {
	// Adds a class of single-author to blogs with only 1 published author
	if ( ! is_multi_author() ) {
		$classes[] = 'single-author';
	}

	// Adds a class of index to views that are not posts or pages or search
	if ( ! is_singular() && ! is_search() ) {
		$classes[] = 'indexed';
	}

	return $classes;
}
add_filter( 'body_class', 'forever_body_classes' );

/**
 * Count the number of footer sidebars to enable dynamic classes for the footer
 */
function forever_footer_sidebar_class() {
	$count = 0;

	if ( is_active_sidebar( 'sidebar-2' ) )
		$count++;

	if ( is_active_sidebar( 'sidebar-3' ) )
		$count++;

	if ( is_active_sidebar( 'sidebar-4' ) )
		$count++;

	if ( is_active_sidebar( 'sidebar-5' ) )
		$count++;

	$class = '';

	switch ( $count ) {
		case '1':
			$class = 'one';
			break;
		case '2':
			$class = 'two';
			break;
		case '3':
			$class = 'three';
			break;
		case '4':
			$class = 'four';
			break;
	}

	if ( $class )
		echo 'class="' . $class . '"';
}

/**
 * Returns true if a blog has more than 1 category
 *
 * @since Forever 1.0
 */
function forever_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so forever_categorized_blog should return true
		return true;
	} else {
		// This blog has only 1 category so forever_categorized_blog should return false
		return false;
	}
}

/**
 * Flush out the transients used in forever_categorized_blog
 *
 * @since Forever 1.0
 */
function forever_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'forever_category_transient_flusher' );
add_action( 'save_post', 'forever_category_transient_flusher' );

/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 */
function forever_enhanced_image_navigation( $url ) {
	global $post, $wp_rewrite;

	$id = (int) $post->ID;
	$object = get_post( $id );
	if ( wp_attachment_is_image( $post->ID ) && ( $wp_rewrite->using_permalinks() && ( $object->post_parent > 0 ) && ( $object->post_parent != $id ) ) )
		$url = $url . '#main';

	return $url;
}
add_filter( 'attachment_link', 'forever_enhanced_image_navigation' );

/**
 * WP.com: Set a default theme color array.
 */
$themecolors = array(
	'bg' => 'ffffff',
	'border' => 'eeeeee',
	'text' => '444444',
);

/**
 * Test to see if any posts meet our conditions for featuring posts
 */
function forever_featured_posts() {
	if ( false === ( $featured_posts_with_thumbnail = get_transient( 'featured_posts_with_thumbnail' ) ) ) {

			$featured_posts_with_thumbnail = false;

			// See if we have any sticky posts with featured images and use them to create our featured posts area
			$sticky = get_option( 'sticky_posts' );

			// Proceed only if sticky posts exist.
			if ( ! empty( $sticky ) ) :

				$featured_args = array(
					'post__in' => $sticky,
					'post_status' => 'publish',
					'no_found_rows' => true,
					'ignore_sticky_posts' => 1,
				);

				// The Featured Posts query.
				$featured = new WP_Query( $featured_args );

				// Proceed only if published posts exist
				if ( $featured->have_posts() ) :

					// loop through once to see if any posts meet our conditions for featuring posts
					// in this case, sticky posts ($featured) that have a thumbnail (has_post_thumbnail())
					// that's bigger than 888px (our area width)
					while ( $featured->have_posts() ) : $featured->the_post();
						if ( '' != get_the_post_thumbnail() ) {
							$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large-feature' );

							if ( $image[1] >= 888 ) {
								$featured_posts_with_thumbnail[] = get_the_ID();
								set_transient( 'featured_posts_with_thumbnail', $featured_posts_with_thumbnail );
							}
						}
					endwhile;

				endif; // have_posts()

			endif; // $sticky

		} // checking for the featured post transient

		return $featured_posts_with_thumbnail;
}

/**
 * Flush out the transients used in forever_featured_posts()
 */
function forever_featured_post_checker_flusher() {
	// Vvwooshh!
	delete_transient( 'featured_posts_with_thumbnail' );
}
add_action( 'save_post', 'forever_featured_post_checker_flusher' );

/**
 * This theme was built with PHP, Semantic HTML, CSS, and love.
 */