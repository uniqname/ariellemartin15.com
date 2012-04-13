<?php
/**
 * Sample implementation of the Custom Header feature
 * http://codex.wordpress.org/Custom_Headers
 *
 * @package Ari
 * @since Ari 1.1.2
 */

function ari_custom_header_setup() {
	$options = ari_get_theme_options();
	$current_color_scheme = $options['color_scheme'];
	switch ( $current_color_scheme ) {
		case 'dark' :
			$header_color = '8a8a8a';
			break;
		default:
			$header_color = '88c34b';
			break;
	}

	// The default header text color
	define( 'HEADER_TEXTCOLOR', $header_color );

	// By leaving empty, we allow for random image rotation.
	define( 'HEADER_IMAGE', '' );

	// The height and width of your custom header.
	// Add a filter to ari_header_image_width and ari_header_image_height to change these values.
	define( 'HEADER_IMAGE_WIDTH', apply_filters( 'ari_header_image_width', 240 ) );
	define( 'HEADER_IMAGE_HEIGHT', apply_filters( 'ari_header_image_height', 75 ) );

	// Add a way for the custom header to be styled in the admin panel that controls custom headers
	add_custom_image_header( 'ari_header_style', 'ari_admin_header_style', 'ari_admin_header_image' );
}
add_action( 'after_setup_theme', 'ari_custom_header_setup' );

if ( ! function_exists( 'ari_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @since Ari 1.1.2
 */
function ari_header_style() {

	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
	<?php
		// Has the text been hidden?
		if ( 'blank' == get_header_textcolor() ) :
	?>
		.site-title,
		.site-description {
			position: absolute !important;
			clip: rect(1px 1px 1px 1px); /* IE6, IE7 */
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		// If the user has set a custom color for the text use that
		else :
	?>
		.site-title a {
			color: #<?php echo get_header_textcolor(); ?> !important;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif; // ari_header_style

if ( ! function_exists( 'ari_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_custom_image_header() in ari_setup().
 *
 * @since Ari 1.1.2
 */
function ari_admin_header_style() {
	$options = ari_get_theme_options();
	$current_color_scheme = $options['color_scheme'];
	$text_color = $options['text_color'];

	if ( '' != get_background_color() && '' == get_background_image() ) :
		$background_color = get_background_color();
	else :
		switch ( $current_color_scheme ) {
			case 'dark' :
				$background_color = '1b1c1b';
				break;
			default:
				$background_color = 'ffffff';
				break;
		}
	endif;
?>
	<style type="text/css">
	.appearance_page_custom-header #headimg {
		background-color: #<?php echo $background_color; ?>;
		border: none;
		max-width: 240px;
		padding: 10px 10px 6px 10px;
	}
	#headimg h1 {
		font-family: 'Droid Sans', Arial, sans-serif;
		font-size: 30px;
		line-height: 35px;
		margin: 0 0 5px 0;
	}
	#headimg h1 a {
		color: #<?php echo get_header_textcolor(); ?>;
		text-decoration: none;
	}
	#desc {
		color: <?php echo $text_color; ?> !important;
		font-family: 'Droid Serif', Times, serif;
		font-size: 13px;
		font-style: italic;
		line-height: 18px;
		margin: 0 0 10px 0;
	}
	</style>
<?php
}
endif; // ari_admin_header_style

if ( ! function_exists( 'ari_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_custom_image_header() in ari_setup().
 *
 * @since Ari 1.1.2
 */
function ari_admin_header_image() { ?>
	<div id="headimg">
		<?php
		if ( 'blank' == get_theme_mod( 'header_textcolor', HEADER_TEXTCOLOR ) || '' == get_theme_mod( 'header_textcolor', HEADER_TEXTCOLOR ) )
			$style = ' style="display:none;"';
		else
			$style = ' style="color:#' . get_theme_mod( 'header_textcolor', HEADER_TEXTCOLOR ) . ';"';
		?>
		<h1><a id="name"<?php echo $style; ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
		<div id="desc"<?php echo $style; ?>><?php bloginfo( 'description' ); ?></div>
		<?php $header_image = get_header_image();
		if ( ! empty( $header_image ) ) : ?>
			<img src="<?php echo esc_url( $header_image ); ?>" alt="" />
		<?php endif; ?>
	</div>
<?php }
endif; // ari_admin_header_image