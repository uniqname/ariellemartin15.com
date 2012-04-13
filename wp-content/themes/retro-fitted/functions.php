<?php

if ( ! isset( $content_width ) )
	$content_width = 930;


if ( ! function_exists( 'retro_fitted_setup' ) ) {
	/**
	 * Setup Retro-fitted.
	 *
	 * Hooks into the "after_setup_theme" action.
	 */
	function retro_fitted_setup() {
		add_action( 'widgets_init', 'retro_fitted_register_sidebar' );
		add_action( 'wp_enqueue_scripts', 'retro_fitted_reply_script' );

		add_custom_image_header( 'retro_fitted_header_style', 'retro_fitted_admin_header_style', 'retro_fitted_admin_header_div' );
		add_custom_background( 'retro_fitted_background' );

		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'menus' );

		define( 'HEADER_TEXTCOLOR', '04648d' );
		define( 'HEADER_IMAGE', '' );
		define( 'HEADER_IMAGE_WIDTH', 1020 );
		define( 'HEADER_IMAGE_HEIGHT', 150 );

		register_nav_menus( array( 'primary' => 'Primary' ) );
	}
}
add_action( 'after_setup_theme', 'retro_fitted_setup' );


/**
 * Toggle layout in select templates.
 *
 * Hooks into the "body_class" filter.
 */
function retro_fitted_body_class( $classes ) {
	$layout = 'single-column';
	if ( is_active_sidebar( 'sidebar-1' ) && ! wp_attachment_is_image() && ! is_404() )
		$layout = 'content-sidebar';

	$classes[] = $layout;

	return $classes;
}
add_filter( 'body_class', 'retro_fitted_body_class' );


/**
 * All entries should contain floats.
 *
 * Hooks into the "post_class" filter.
 */
function retro_fitted_post_class( $classes ) {
	$classes[] = 'contain';

	return $classes;
}
add_filter( 'post_class', 'retro_fitted_post_class' );


/**
 * Adjust $content width if a sidebar is present in select templates.
 *
 * 404.php and image.php will never have a sidebar.
 *
 * Hooks into the "template_redirect" action.
 */
function retro_fitted_content_width() {
	if ( is_404() || wp_attachment_is_image() )
		return;

	if ( is_active_sidebar( 'sidebar-1' ) ) {
		global $content_width;
		$content_width = 620;
	}
}
add_action( 'template_redirect', 'retro_fitted_content_width' );


/**
 * Custom background CSS for public-facing templates.
 */
function retro_fitted_background() {
	$background = get_background_image();
	$color = get_background_color();
	if ( ! $background && ! $color )
		return;

	$style = $color ? "background-color: #$color;" : '';

	if ( $background ) {
		$image = " background-image: url('$background');";

		$repeat = get_theme_mod( 'background_repeat', 'repeat' );
		if ( ! in_array( $repeat, array( 'no-repeat', 'repeat-x', 'repeat-y', 'repeat' ) ) )
			$repeat = 'repeat';
		$repeat = " background-repeat: $repeat;";

		$position = get_theme_mod( 'background_position_x', 'left' );
		if ( ! in_array( $position, array( 'center', 'right', 'left' ) ) )
			$position = 'left';
		$position = " background-position: top $position;";

		$attachment = get_theme_mod( 'background_attachment', 'scroll' );
		if ( ! in_array( $attachment, array( 'fixed', 'scroll' ) ) )
			$attachment = 'scroll';
		$attachment = " background-attachment: $attachment;";

		$style .= $image . $repeat . $position . $attachment;
	} else {
		$style .= " background-image: none;";
	}
?>
<style type="text/css">
body.custom-background #main{ <?php echo trim( $style ); ?> }
</style>
<?php
}


/**
 * Custom header CSS for public-facing templates.
 */
function retro_fitted_header_style() {
?>
	<style>
	<?php if ( get_header_image() ) : ?>
		#branding {
			display: block;
			background: transparent url( "<?php header_image(); ?>" ) 0 0 no-repeat;
			padding: 20px;
			text-decoration: none;
			width: 980px;
			height: 110px;
		}
	<?php endif; ?>
		#site-title,
		#site-title a,
		#site-description {
			<?php if ( retro_fitted_has_header_text() ) : ?>
				color: <?php retro_fitted_text_color(); ?>;
			<?php else : ?>
				display: none;
			<?php endif;?>
		}
	</style>
<?php
}


/**
 * Custom markup for the Appearance -> Header screen.
 */
function retro_fitted_admin_header_div() {
?>
<div id="retro-fitted-header">
	<div id="retro-fitted-header-top">
		<div id="headimg">
			<h1><a id="name" onclick="return false;" href="#"><?php bloginfo( 'name' ); ?></a></h1>
			<div id="desc"><?php bloginfo( 'description' ); ?></div>
			<div id="retro-fitted-header-border"></div>
		</div>
	</div>
</div>
<?php
}


/**
 * Custom CSS for the Appearance -> Header screen.
 */
function retro_fitted_admin_header_style() {
?>
<style>
@font-face {
	font-family: 'ChunkFiveRegular';
	src: url( "<?php echo esc_url( get_template_directory_uri() . '/fonts/Chunkfive-webfont.eot' ); ?>" );
	src: url( "<?php echo esc_url( get_template_directory_uri() . '/fonts/Chunkfive-webfont.eot?#iefix' ); ?>" ) format('embedded-opentype'),
		url( "<?php echo esc_url( get_template_directory_uri() . '/fonts/Chunkfive-webfont.woff' ); ?>" ) format('woff'),
		url( "<?php echo esc_url( get_template_directory_uri() . '/fonts/Chunkfive-webfont.ttf' ); ?>" ) format('truetype'),
		url( "<?php echo esc_url( get_template_directory_uri() . '/fonts/Chunkfive-webfont.svg#ChunkFiveRegular' ); ?>" ) format('svg');
	font-weight: normal;
	font-style: normal;
}
#retro-fitted-header {
	background-image: url( "<?php echo esc_url( get_template_directory_uri() . '/images/sandy-tile.jpg' ); ?>" );
	border: 1px solid #ccc;
	min-height: 160px;
}
#retro-fitted-header-top {
	padding: 20px;
	background: url( "<?php echo esc_url( get_template_directory_uri() . '/images/pink-plaid-tile.png' ); ?>" );
	border-bottom: 10px solid #ce3000;
}
#retro-fitted-header #headimg {
	border: none;
	<?php if ( get_header_image() ) : ?>
		background-image: url( "<?php echo esc_url( get_header_image() ); ?>" );
		width: 980px;
		height: 110px;
		padding: 20px;
	<?php else : ?>
		height: auto;
		min-height: 0;
		padding-bottom: 1em;
	<?php endif; ?>
}
#retro-fitted-header h1 {
	line-height: 1;
	margin: 0 0 10px;
	padding: 0;
}
#retro-fitted-header h1 a {
	text-decoration: none !important;
}
#name {
	<?php if ( retro_fitted_has_header_text() ) : ?>
		color: <?php retro_fitted_text_color(); ?>;
	<?php else : ?>
		display: none;
	<?php endif;?>
	color: #04648d;
	font-family: ChunkFiveRegular, Georgia, Times, 'Times New Roman', serif;
	font-size: 36px;
	font-weight: normal;
	letter-spacing: 1px;
	margin: 0 0 5px 0;
	text-decoration: none;
}
#name:hover {
	text-decoration: underline;
}
#desc {
	<?php if ( retro_fitted_has_header_text() ) : ?>
		color: <?php retro_fitted_text_color(); ?>;
	<?php else : ?>
		display: none;
	<?php endif;?>

	font-family: Georgia,Times,'Times New Roman',serif;
	font-size: 15px;
	font-style: italic;
	margin: 0;
	padding: 0;
	line-height:1;
}

</style>
<?php
}


/**
 * Has the user defined a custom Header text color?
 *
 * @return bool.
 */
function retro_fitted_has_header_text() {
	if ( 'blank' == get_theme_mod( 'header_textcolor', HEADER_TEXTCOLOR ) )
		return false;

	if ( '' == get_theme_mod( 'header_textcolor', HEADER_TEXTCOLOR ) )
		return false;

	if ( defined( 'NO_HEADER_TEXT' ) && NO_HEADER_TEXT )
		return false;

	return true;
}


/**
 * Print the user-defined color for the Site Title and Tagline.
 */
function retro_fitted_text_color() {
	$color = get_theme_mod( 'header_textcolor', HEADER_TEXTCOLOR );
	if ( preg_match( '/^#?([a-f0-9]{3}){1,2}$/i', $color ) )
		echo '#' . strtolower( ltrim( $color, '#' ) );
}


/**
 * Register Sidebar.
 *
 * Hooks into the 'widgets_init' action.
 */
function retro_fitted_register_sidebar() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'retro-fitted' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}


/**
 * Comment Reply Script.
 *
 * Hooks into the 'wp_enqueue_scripts' filter.
 */
function retro_fitted_reply_script() {
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
}


/**
 * Callback for wp_list_comments().
 */
function retro_fitted_comments_callback( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	$GLOBALS['comment_depth'] = $depth;
?>
	<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>

		<div class="comment-wrap">

			<?php echo get_avatar( $comment, 80 ); ?>

			<div class="comment-meta">
				<span class="fn comment-author"><?php comment_author_link(); ?></span>
				<?php
					printf( '<a class="comment-permalink" href="%1$s" title="%2$s"><time pubdate datetime="%3$s">%4$s</time></a>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						esc_attr__( 'Permalink to this comment', 'retro-fitted' ),
						esc_attr( get_comment_time( 'c' ) ),
						/* translators: 1: date, 2: time */
						sprintf( __( '%1$s at %2$s', 'retro-fitted' ), get_comment_date(), get_comment_time() )
					);

					edit_comment_link( __( 'Edit', 'retro-fitted' ), __( ' | ', 'retro-fitted' ) );

					comment_reply_link( array_merge( $args, array(
						'before'    => __( ' | ', 'retro-fitted' ),
						'depth'     => $depth,
						'max_depth' => $args['max_depth'],
					) ) );
				?>
			</div><!-- .comment-meta -->

			<div class="comment-content comment-text">
				<?php if ( '0' == $comment->comment_approved ) : ?>
					<p class="alert moderation"><?php _e( 'Your comment is awaiting moderation.', 'retro-fitted' ); ?></p>
				<?php endif; ?>

				<?php comment_text( $comment->comment_ID ); ?>
			</div><!-- .comment-content .comment-text -->

		</div><!-- .comment-wrap -->
<?php
}


/**
 * Theme colors array for WordPress.com.
 */
if ( ! isset( $themecolors ) ) {
	$themecolors = array(
		'bg'     => 'ffffff',
		'text'   => '333333',
		'link'   => '00648d',
		'border' => 'e7e1d4',
		'url'    => '00648d',
	);
}