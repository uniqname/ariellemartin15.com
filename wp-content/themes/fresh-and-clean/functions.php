<?php
/**
 * Fresh and Clean functions and definitions
 *
 * @package Fresh and Clean
 */

// Set the content width based on the theme's design and stylesheet.
if ( ! isset( $content_width ) )
	$content_width = fresh_and_clean_attachment_width();

if ( ! function_exists( 'fresh_and_clean_setup' ) ):

// Sets up theme defaults and registers support for various WordPress features.
function fresh_and_clean_setup() {

	// Make theme available for translation
	load_theme_textdomain( 'fresh-and-clean', get_template_directory() . '/languages' );

	$locale = get_locale();
	$locale_file = get_template_directory() . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	 // Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'fresh-and-clean' ),
	) );

	// This theme allows users to set a custom background.
	add_custom_background();

	// This theme allows users to upload a custom header.
	define( 'HEADER_TEXTCOLOR', '000000' );
	define( 'HEADER_IMAGE', '' );
	define( 'HEADER_IMAGE_WIDTH', 920 ); // use width and height appropriate for your theme
	define( 'HEADER_IMAGE_HEIGHT', 116 );

	// Add a way for the custom header to be styled in the admin panel that controls
	// custom headers. See fresh_and_clean_admin_header_style(), below.
	add_custom_image_header( 'fresh_and_clean_header_style', 'fresh_and_clean_admin_header_style' );

	// This theme uses Featured Images
	add_theme_support( 'post-thumbnails' );

	// Set thumbnail size.
	add_image_size( 'fresh-and-clean-thumbnail', 160, 120, true );
	add_image_size( 'large-feature', 840, 280, true );

	// Define the minimum image width for the featured slider
	define ( 'FEATURED_IMAGE_WIDTH', 840 );
}
endif; // fresh-and-clean_setup

// Tell WordPress to run fresh-and-clean_setup() when the 'after_setup_theme' hook is run.
add_action( 'after_setup_theme', 'fresh_and_clean_setup' );

/**
* Add custom header support
*/
if ( ! function_exists( 'fresh_and_clean_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 */
function fresh_and_clean_header_style() {
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
		#branding {
			background: url(<?php header_image(); ?>);
		}
	<?php
		endif;

		// Has the text been hidden?
		if ( 'blank' == get_header_textcolor() ) :
	?>
		#site-title,
		#site-description {
 	 		position: absolute !important;
			clip: rect(1px 1px 1px 1px); /* IE6, IE7 */
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		// If the user has set a custom color for the text use that
		else :
	?>
		#site-title a,
		#site-description {
			color: #<?php echo get_header_textcolor(); ?> !important;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif;

if ( ! function_exists( 'fresh_and_clean_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_custom_image_header() in fresh_and_clean_setup().
 *
 */
function fresh_and_clean_admin_header_style() {
?>
	<style type="text/css">
	.appearance_page_custom-header #headimg {
		background-color: #<?php echo ( '' != get_background_color() ? get_background_color() : 'fff' ); ?>;
		border: none;
		width: 920px;
		height: 116px;
		text-align: left;
	}
	#headimg h1 {
		font: 30px 'Pacifico', "Georgia", serif;
		margin-bottom: 0;
		padding: 15px 15px 0;
	}
	#headimg h1 a {
		text-decoration: none;
	}
	#desc {
		font: 12px 'Droid Sans', Verdana, serif;
		font-weight: normal;
		margin: 0;
		padding: 0 15px;
	}
	<?php
		// If the user has set a custom color for the text use that
		if ( HEADER_TEXTCOLOR != get_header_textcolor() ) :
	?>
		#site-title a,
		#site-description {
			color: #<?php echo get_header_textcolor(); ?>;
		}
	<?php endif; ?>
	</style>
<?php
}
endif;

// Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
function fresh_and_clean_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'fresh_and_clean_page_menu_args' );


// Register widgetized area and update sidebar with default widgets
function fresh_and_clean_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Sidebar 1', 'fresh-and-clean' ),
		'id' => 'sidebar-1',
		'description' => __( 'Drag widgets here to activate the sidebar.', 'fresh-and-clean' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );
}
add_action( 'init', 'fresh_and_clean_widgets_init' );

if ( ! function_exists( 'fresh_and_clean_content_nav' ) ):

// Display navigation to next/previous pages when applicable
function fresh_and_clean_content_nav( $nav_id ) {
	global $wp_query;

	?>
	<?php if ( ! is_page() ) : ?>
		<nav id="<?php echo $nav_id; ?>">
			<h1 class="assistive-text section-heading"><?php _e( 'Post navigation', 'fresh-and-clean' ); ?></h1>

		<?php if ( is_single() ) : // navigation links for single posts ?>

			<?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( '&laquo;', 'Previous post link', 'fresh-and-clean' ) . '</span> %title' ); ?>
			<?php next_post_link( '<div class="nav-next">%link</div>', '%title <span class="meta-nav">' . _x( '&raquo;', 'Next post link', 'fresh-and-clean' ) . '</span>' ); ?>

		<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&laquo;</span> Older posts', 'fresh-and-clean' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&raquo;</span>', 'fresh-and-clean' ) ); ?></div>
			<?php endif; ?>

		<?php endif; ?>

		</nav><!-- #<?php echo $nav_id; ?> -->
	<?php endif;
}
endif; // fresh_and_cleans_content_nav


if ( ! function_exists( 'fresh_and_clean_comment' ) ) :

// Template for comments and pingbacks. Used as a callback by wp_list_comments() for displaying the comments.
function fresh_and_clean_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'fresh-and-clean' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'fresh-and-clean' ), ' ' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<footer>
				<div class="comment-author vcard">
					<?php echo get_avatar( $comment, 32 ); ?>
					<?php printf( __( '%s <span class="says">says:</span>', 'fresh-and-clean' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
				</div><!-- .comment-author .vcard -->
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em><?php _e( 'Your comment is awaiting moderation.', 'fresh-and-clean' ); ?></em>
					<br />
				<?php endif; ?>

				<div class="comment-meta commentmetadata">
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><time pubdate datetime="<?php comment_time( 'c' ); ?>">
					<?php
						/* translators: 1: date, 2: time */
						printf( __( '%1$s at %2$s', 'fresh-and-clean' ), get_comment_date(), get_comment_time() ); ?>
					</time></a>
					<?php edit_comment_link( __( '(Edit)', 'fresh-and-clean' ), ' ' );
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
endif; // ends check for fresh_and_clean_comment()

function fresh_and_clean_post_meta() {
	if ( is_singular() ) :
		/* translators: used between list items, there is a space after the comma */
		$category_list = get_the_category_list( __( ', ', 'fresh-and-clean' ) );

		/* translators: used between list items, there is a space after the comma */
		$tag_list = get_the_tag_list( '', ', ' );

		if ( ! fresh_and_clean_categorized_blog() ) {
			// This blog only has 1 category so we just need to worry about tags in the meta text
			if ( '' != $tag_list ) {
				$meta_text = __( 'This entry was posted on %5$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'fresh-and-clean' );
			} else {
				$meta_text = __( 'This entry was posted on %5$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'fresh-and-clean' );
			}

		} else {
			// But this blog has loads of categories so we should probably display them here
			if ( '' != $tag_list ) {
				$meta_text = __( 'This entry was posted on %5$s, in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'fresh-and-clean' );
			} else {
				$meta_text = __( 'This entry was posted on %5$s, in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'fresh-and-clean' );
			}

		} // end check for categories on this blog

		printf(
			$meta_text,
			$category_list,
			$tag_list,
			get_permalink(),
			the_title_attribute( 'echo=0' ),
			esc_attr( get_the_date() )
		);
	else :
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( __( ', ', 'fresh-and-clean' ) );
		$tags_list = get_the_tag_list( '', __( ', ', 'fresh-and-clean' ) );

		if ( $categories_list && fresh_and_clean_categorized_blog() ) {
			$meta_text = __( '<span class="cat-links">Posted on %1$s, in %2$s.</span>', 'fresh-and-clean' );
		} // End if $categories_list

		if ( $tags_list ) {
			$meta_text = __( '<span class="tag-links">Posted on %1$s, and tagged %3$s.</span>', 'fresh-and-clean' );
		} // End if $tags_list

		printf(
			$meta_text,
			esc_attr( get_the_date() ),
			$categories_list,
			$tags_list
		);
	endif;
}

/**
 * Add special classes to the WordPress body class.
 */
function fresh_and_clean_body_classes( $classes ) {

	// If we have one sidebar active we have secondary content
	if ( ! is_active_sidebar( 'sidebar-1' ) )
		$classes[] = 'one-column';

	return $classes;
}
add_filter( 'body_class', 'fresh_and_clean_body_classes' );

/**
 * Returns a "Continue Reading" link for excerpts
 */
function fresh_and_clean_reading_link() {
	return ' <span class="more-link"><a href="'. esc_url( get_permalink() ) . '">' . __( 'Continue reading &raquo;', 'fresh-and-clean' ) . '</a></span>';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and fresh_and_clean_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 */
function fresh_and_clean_auto_excerpt_more( $more ) {
	return ' &hellip;' . fresh_and_clean_reading_link();
}
add_filter( 'excerpt_more', 'fresh_and_clean_auto_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 */
function fresh_and_clean_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= fresh_and_clean_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'fresh_and_clean_custom_excerpt_more' );

// Returns true if a blog has more than 1 category
function fresh_and_clean_categorized_blog() {
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
		// This blog has more than 1 category so fresh-and-clean_categorized_blog should return true
		return true;
	} else {
		// This blog has only 1 category so fresh-and-clean_categorized_blog should return false
		return false;
	}
}

// Flush out the transients used in fresh-and-clean_categorized_blog
function fresh_and_clean_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'fresh_and_clean_transient_flusher' );
add_action( 'save_post', 'fresh_and_clean_transient_flusher' );

// Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
function fresh_and_clean_enhanced_image_navigation( $url ) {
	global $post, $wp_rewrite;

	$id = (int) $post->ID;
	$object = get_post( $id );
	if ( wp_attachment_is_image( $post->ID ) && ( $wp_rewrite->using_permalinks() && ( $object->post_parent > 0 ) && ( $object->post_parent != $id ) ) )
		$url = $url . '#main';

	return $url;
}
add_filter( 'attachment_link', 'fresh_and_clean_enhanced_image_navigation' );

// Enqueue font styles
function fresh_and_clean_fonts() {
	wp_enqueue_style( 'pacifico', 'http://fonts.googleapis.com/css?family=Pacifico' );
	wp_enqueue_style( 'droid sans', 'http://fonts.googleapis.com/css?family=Droid+Sans:400' );
	wp_enqueue_style( 'droid serif', 'http://fonts.googleapis.com/css?family=Droid+Serif:400' );
}
add_action( 'wp_enqueue_scripts', 'fresh_and_clean_fonts' );
add_action( 'admin_print_styles-appearance_page_custom-header', 'fresh_and_clean_fonts' );

// Dequeue font styles
function fresh_and_clean_dequeue_fonts() {
	/**
	 * We don't want to enqueue the font scripts if the blog
	 * has WP.com Custom Design.
	 *
	 */
	if ( class_exists( 'TypekitData' ) ) {
		if ( TypekitData::get( 'upgraded' ) ) {
			$customfonts = TypekitData::get( 'families' );
			if ( ! $customfonts )
				return;
			$headings = $customfonts['headings'];
			$sitetitle = $customfonts['site-title'];
			$bodytext = $customfonts['body-text'];

			if ( $headings['id'] ) {
				wp_dequeue_style( 'droid serif' );
			}
			if ( $sitetitle['id'] ) {
				wp_dequeue_style( 'pacifico' );
			}
			if ( $bodytext['id'] ) {
				wp_dequeue_style( 'droid sans' );
			}
		}
	}
}
add_action( 'wp_enqueue_scripts', 'fresh_and_clean_dequeue_fonts' );

function fresh_and_clean_header_css() {
	// Make #branding tall enough to fit the header image if the user adds a custom header image
	if ( '' != get_header_image() ) : ?>
	<style type="text/css">
		#branding {
			min-height: 116px;
		}
		#branding .header-link {
			display: block;
			position: absolute;
			width: 80%;
			min-height: 116px;
		}
	</style>
	<?php endif;
}
add_action( 'wp_head', 'fresh_and_clean_header_css' );

// Set a default theme color array for WP.com.
$themecolors = array(
	'bg' => 'f6f6f6',
	'border' => '707070',
	'text' => '707070',
	'link' => '0099ff',
	'url' => '0099ff',
);

// Seth $content_width based on the presence of widgets in sidebar-1
function fresh_and_clean_attachment_width() {

	if ( ! is_active_sidebar( 'sidebar-1' ) || is_attachment()  )
		return 863;
	else
		return 580;
}