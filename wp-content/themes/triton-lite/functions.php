<?php
/**
 * @package Triton Lite
 */

/**
 * Define Theme Colors for WordPress.com
 */
if ( ! isset( $themecolors ) ) {
	$themecolors = array(
		'bg' => 'edeef0',
		'text' => '7f7f7f',
		'link' => '333',
		'border' => 'dedede',
		'url' => '333',
	);
}

/**
 * Set the content width based on Triton Lite's active widgets
 */
add_action( 'template_redirect', 'triton_lite_set_content_width' );

if ( ! function_exists( 'triton_lite_set_content_width' ) ) :

	function triton_lite_set_content_width() {

		global $content_width;

		if ( ! isset( $content_width ) ) {

			$content_width = 960; /* Default content width, no widgets active */

			if ( is_active_sidebar( 'sidebar-1' ) )

				$content_width = 620; /* Sidebar widget active */

		}
	}

endif; // triton_lite_set_content_width()

/**
 * Theme Setup
 */
add_action( 'after_setup_theme', 'triton_lite_setup' );

if ( ! function_exists ( 'triton_lite_setup' ) ) :

	function triton_lite_setup() {

		/**
		 * Automatic Feed Links
		 */
		add_theme_support( 'automatic-feed-links' );

		/**
		 * Load up our theme options page and related code.
		 */
		require( dirname( __FILE__ ) . '/inc/theme-options.php' );

		/**
		 * I18n
		 */
		load_theme_textdomain( 'triton-lite', get_template_directory_uri() . '/languages' );

		$locale = get_locale();
		$locale_file = get_template_directory_uri() . "/languages/$locale.php";
		if ( is_readable( $locale_file ) )
			require_once( $locale_file );

		/**
		 * Navigation Menus
		 */
		register_nav_menu( 'primary', __( 'Primary Navigation Menu', 'triton-lite' ) );

		/**
		 * Post Thumbnails
		 */
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'triton-lite-290', 290, 9999 ); // 290 pixels wide by virtually unlimited height, resize mode
		add_image_size( 'triton-lite-960', 960, 9999 ); // 960 pixels wide by virtually unlimited height, resize mode
		add_image_size( 'triton-lite-950-cropped', 950, 270, true ); // 960 pixels wide by 270 pixels tall, hard crop mode		

		/**
		 * Custom Background
		 */
		add_custom_background();

		/**
		 * Define constants in order for the custom image header to work
		 */
		define( 'HEADER_IMAGE', '' );
		define( 'HEADER_IMAGE_WIDTH', 960 );
		define( 'HEADER_IMAGE_HEIGHT', 270 );
		define( 'HEADER_TEXTCOLOR', '171717' );

		/**
		 * Add a way for the custom header to be styled in the admin panel that controls custom headers.
		 */
		add_custom_image_header( 'triton_lite_header_style', 'triton_lite_admin_header_style', 'triton_lite_admin_header_image' );

	}
endif; // triton_lite_setup

/**
 * Register our sidebars and widgetized areas.
 */
add_action( 'widgets_init', 'triton_lite_register_sidebars' );

if ( ! function_exists( 'triton_lite_register_sidebars' ) ) :

	function triton_lite_register_sidebars() {
		/*
			Add theme support for widgetized sidebars.
		*/
		register_sidebar( array(
			'name' => __( 'Primary Sidebar', 'triton-lite' ),
			'id' => 'sidebar-1',
			'description' => __( 'Widgets in this sidebar will be displayed adjacent to post and page content.', 'triton-lite' ),
			'before_title' => '<h3 class="widgettitle">',
			'after_title' => '</h3>'
		) );
		register_sidebar( array(
			'name' => __( 'Middle Row', 'triton-lite' ),
			'id' => 'sidebar-2',
			'description' => __( 'Widgets in this area will be displayed in a section just above the site footer.', 'triton-lite' ),
			'before_title' => '<h3 class="widgettitle">',
			'after_title' => '</h3>'
		) );
		register_sidebar( array(
			'name' => __( 'Footer', 'triton-lite' ),
			'id' => 'sidebar-3',
			'description' => __( 'Widgets in this area will be displayed at the very bottom of the page.', 'triton-lite' ),
			'before_title' => '<h3 class="widgettitle">',
			'after_title' => '</h3>'
		) );
	}

endif; // triton_lite_register_sidebars

/**
 * Modify the font sizes of WordPress' tag cloud
 */
if ( ! function_exists( 'triton_lite_widget_tag_cloud_args' ) ) :

	function triton_lite_widget_tag_cloud_args( $args ) {
		$args[ 'smallest' ] = 12;
		$args[ 'largest' ]= 20;
		$args[ 'unit' ]= 'px';
		return $args;
	}
	add_filter( 'widget_tag_cloud_args', 'triton_lite_widget_tag_cloud_args' );

endif; // triton_lite_widget_tag_cloud_args

if ( ! function_exists ( 'triton_lite_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 */
function triton_lite_header_style() {

	$header_image = get_header_image();

	if ( ! empty( $header_image ) ) : ?>
		<style type="text/css">
			#header-image {
				background: url( '<?php echo esc_url( $header_image ); ?>' ) no-repeat;
				float: left;
				margin: 0 0 20px;
				width: 960px;
				height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
			}
			#header-image a {
				display: block;
				text-indent: -9999px;
				width: 100%;
				height: 100%;
			}
		</style>
	<?php endif; // $header_image check ?>

	<?php if ( HEADER_TEXTCOLOR != get_header_textcolor() ) : ?>
		<style type="text/css">
			<?php
				// Has the text been hidden?
				if ( 'blank' == get_header_textcolor() ) :
			?>
				#logo {
					display: none;
				}

			<?php
				// If the user has set a custom color for the text use that
				else :
			?>
				#logo h1 a,
				.desc {
					color: #<?php echo get_header_textcolor(); ?> !important;
				}
			<?php endif; ?>
		</style>
	<?php endif; // custom text color check ?>

<?php }
endif; // triton_lite_header_style

if ( ! function_exists ( 'triton_lite_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_custom_image_header() in triton_lite_setup().
 */
function triton_lite_admin_header_style() { ?>

	<style type="text/css">
		#header-image {
			width: 960px;
		}
		#header {
			text-align: center;
			width: 960px;
		}
		#header-image img {
			display: block;
			margin: 0 0 20px;
		}
		#triton-lite-site-title,
		#desc {
			font-family: Arial, Helvetica, sans-serif;
			text-transform: uppercase;
		}
		#triton-lite-site-title {
			font-size: 32px;
			font-weight: 700;
			line-height: 37.05px;
			margin-bottom: 0;
		}
		#triton-lite-site-title a {
			display: block;
			text-decoration: none;
		}
		#desc {
			font-size: 11px;
			font-weight: 400;
			line-height: 13.3667px;
			margin-bottom: 0;
		}
	</style>

<?php }
endif; // triton_lite_admin_header_style

if ( ! function_exists( 'triton_lite_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_custom_image_header() in triton_lite_setup().
 *
 */
function triton_lite_admin_header_image() { ?>

	<div id="header-image">
		<?php $header_image = get_header_image();
		if ( ! empty( $header_image ) ) : ?>
			<img src="<?php echo esc_url( $header_image ); ?>" alt="" />
		<?php endif; ?>
	</div>
	<?php
	if ( 'blank' == get_theme_mod( 'header_textcolor', HEADER_TEXTCOLOR ) || '' == get_theme_mod( 'header_textcolor', HEADER_TEXTCOLOR ) )
		$style = ' style="display:none;"';
	else
		$style = ' style="color:#' . get_theme_mod( 'header_textcolor', HEADER_TEXTCOLOR ) . ';"';
	?>
	<div id="header">
		<h1 id="triton-lite-site-title"><a id="name"<?php echo $style; ?> onClick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
		<h2 id="desc"<?php echo $style; ?>><?php bloginfo( 'description' ); ?></h2>
	</div><!-- #header -->

<?php }
endif; // triton_lite_admin_header_image

/**
 * Enqueue Triton Lite JavaScript
 */
function triton_lite_scripts() {
	wp_enqueue_script( 'triton-lite-masonry', get_template_directory_uri() . '/js/masonry.js', array( 'jquery' ), 'v2.1.03', true );
	wp_enqueue_script( 'triton-lite-imagesloaded', get_template_directory_uri() . '/js/imagesloaded.js', array( 'jquery' ), 'v2.0.1', true );
	wp_enqueue_script( 'triton-lite-hoverintent', get_template_directory_uri() . '/js/hoverIntent.js', array( 'jquery' ), 'r6', true );
	wp_enqueue_script( 'triton-lite-custom-js', get_template_directory_uri() . '/js/triton-lite.js', array( 'jquery' ), '2012-03-04', true );
}
add_action( 'wp_enqueue_scripts', 'triton_lite_scripts' );

if ( ! function_exists( 'triton_lite_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time.
 * Create your own triton_lite_posted_on to override in a child theme
 */
function triton_lite_posted_on() {
	printf( __( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a>', 'triton-lite' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);
}
endif;

if ( ! function_exists( 'triton_lite_posted_by' ) ) :
/**
 * Prints HTML with meta information for the current author on multi-author blogs
 */
function triton_lite_posted_by() {
	if ( is_multi_author() ) {
		printf( __( '<span class="by-author"><span class="sep">by</span> <span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span> </span>', 'triton-lite' ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( __( 'View all posts by %s', 'triton-lite' ), get_the_author_meta( 'display_name' ) ) ),
			esc_attr( get_the_author_meta( 'display_name' ) )
		);
	}
}
endif;

/**
 * Sets the post excerpt length to 33 words.
 */
function triton_lite_excerpt_length( $length ) {
	return 33;
}
add_filter( 'excerpt_length', 'triton_lite_excerpt_length' );

/**
 * Returns a "Read More" link for excerpts
 */
function triton_lite_continue_reading_link() {
	return ' <a class="read-more" href="'. esc_url( get_permalink() ) . '">' . __( 'Read More <span class="meta-nav">&rarr;</span>', 'triton-lite' ) . '</a>';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and triton_lite_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 */
function triton_lite_auto_excerpt_more( $more ) {
	return '&hellip;' . triton_lite_continue_reading_link();
}
add_filter( 'excerpt_more', 'triton_lite_auto_excerpt_more' );

if ( ! function_exists( 'triton_lite_content_nav' ) ):
/**
 * Display navigation to next/previous pages when applicable
 *
 */
function triton_lite_content_nav( $nav_id ) {
	global $wp_query;
	$base = 999999999;
	?>
	<div id="<?php echo $nav_id; ?>">
		<h1 class="assistive-text section-heading"><?php _e( 'Post navigation', 'triton-lite' ); ?></h1>

	<?php if ( is_single() ) : // navigation links for single posts ?>
	
		<div class="nav-wrapper">
	
			<?php if ( get_previous_post() ) { ?>
				<?php previous_post_link( '<div class="nav-previous">&larr; %link</div>', '<span class="meta-nav">' . '</span> %title' ); ?>
			<?php } else { ?>
				<div class="nav-previous">
					&nbsp;
				</div>
			<?php } ?>
	
			<?php if ( get_next_post() ) { ?>
				<?php next_post_link( '<div class="nav-next">%link &rarr;</div>', '%title <span class="meta-nav">' . '</span>' ); ?>
			<?php } else { ?>
				<div class="nav-next">
					&nbsp;
				</div>
			<?php } ?>
			
		</div><!-- .nav-wrapper -->

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

		<div class="nav-paginated">
			<?php
				$args = array(
					'base' => str_replace( $base, '%#%', get_pagenum_link( $base ) ),
					'format' => '?paged=%#%',
					'total' => $wp_query->max_num_pages,
					'current' => max( 1, get_query_var( 'paged' ) ),
					'end_size' => 2,
					'mid_size' => 4,
					'prev_next' => false
				);
				echo paginate_links( $args );
			?>
		</div><!-- .nav-paginated -->

	<?php endif; ?>

	</div><!-- #<?php echo $nav_id; ?> -->
	<?php
}
endif; // triton_lite_content_nav

if ( ! function_exists( 'triton_lite_body_classes' ) ) :
/**
 * Adds custom classes to the array of body classes.
 */
function triton_lite_body_classes( $classes ) {
	/*
	 * Add the following class for single author blogs
	 */
	if ( ! is_multi_author() )
		$classes[] = 'single-author';

	/*
	 * Add widget-dependent classes to body
	 */
	if ( ! is_active_sidebar( 'sidebar-1' ) )
		$classes[] = 'one-column';

	/*
	 * Add broswer-specific classes to body
	 */
	global $is_safari, $is_chrome, $is_gecko, $is_opera, $is_IE;
	
	if ( $is_safari )
		$classes[] = 'safari';
		
	if ( $is_chrome )
		$classes[] = 'chrome';
		
	if ( $is_gecko )
		$classes[] = 'gecko';
		
	if ( $is_opera )
		$classes[] = 'opera';
		
	if ( $is_IE )
		$classes[] = 'ie';

	return $classes;
}
endif;

add_filter( 'body_class', 'triton_lite_body_classes' );

if ( ! function_exists( 'triton_lite_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own triton_lite_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
function triton_lite_comment( $comment, $args, $depth ) {
	$GLOBALS[ 'comment' ] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'triton-lite' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'triton-lite' ), '<span class="edit-comment-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>" class="comment">
			<div class="comment-meta">
				<div class="comment-author vcard">
					<?php
						$avatar_size = 57;
						if ( '0' != $comment->comment_parent )
							$avatar_size = 38;

						echo get_avatar( $comment, $avatar_size );

						/* translators: 1: comment author, 2: date and time */
						printf( __( '%1$s on %2$s <span class="says">said:</span>', 'triton-lite' ),
							sprintf( '<span class="fn">%s</span>', get_comment_author_link() ),
							sprintf( '<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
								esc_url( get_comment_link( $comment->comment_ID ) ),
								get_comment_time( 'c' ),
								/* translators: 1: date, 2: time */
								sprintf( __( '%1$s at %2$s', 'triton-lite' ), get_comment_date(), get_comment_time() )
							)
						);
					?>

					<?php edit_comment_link( __( 'Edit', 'triton-lite' ), '<span class="edit-comment-link">', '</span>' ); ?>
				</div><!-- .comment-author .vcard -->

				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'triton-lite' ); ?></em>
					<br />
				<?php endif; ?>

			</div>

			<div class="comment-content"><?php comment_text(); ?></div>

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply <span>&darr;</span>', 'triton-lite' ), 'depth' => $depth, 'max_depth' => $args[ 'max_depth' ] ) ) ); ?>
			</div><!-- .reply -->
		</div><!-- #comment-## -->

	<?php
			break;
	endswitch;
}
endif; // ends check for triton_lite_comment()