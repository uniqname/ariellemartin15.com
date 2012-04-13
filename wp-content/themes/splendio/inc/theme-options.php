<?php
/**
 * Splendio Theme Options
 *
 * @package Splendio
 */

/**
 * Register the form setting for our splendio_options array.
 *
 * This function is attached to the admin_init action hook.
 *
 * This call to register_setting() registers a validation callback, splendio_theme_options_validate(),
 * which is used when the option is saved, to ensure that our option values are complete, properly
 * formatted, and safe.
 *
 * We also use this function to add our theme option if it doesn't already exist.
 *
 * @since _s 1.0
 */
function splendio_theme_options_init() {

	// If we have no options in the database, let's add them now.
	if ( false === splendio_get_theme_options() )
		add_option( 'splendio_theme_options', splendio_get_default_theme_options() );

	register_setting(
		'splendio_options',       // Options group, see settings_fields() call in splendio_theme_options_render_page()
		'splendio_theme_options', // Database option, see splendio_get_theme_options()
		'splendio_theme_options_validate' // The sanitization callback, see splendio_theme_options_validate()
	);

	// Register our settings field group
	add_settings_section(
		'general', // Unique identifier for the settings section
		'', // Section title (we don't want one)
		'__return_false', // Section callback (we don't want anything)
		'theme_options' // Menu slug, used to uniquely identify the page; see splendio_theme_options_add_page()
	);

	// Register our individual settings fields
	add_settings_field(
		'show_rss_link', // Unique identifier for the field for this section
		__( 'RSS Link', 'splendio' ), // Setting field label
		'splendio_settings_field_checkbox', // Function that renders the settings field
		'theme_options', // Menu slug, used to uniquely identify the page; see splendio_theme_options_add_page()
		'general' // Settings section. Same as the first argument in the add_settings_section() above
	);

	add_settings_field( 'twitter_url', __( 'Twitter Link', 'splendio' ), 'splendio_twitter_text_input', 'theme_options', 'general' );
	add_settings_field( 'facebook_url', __( 'Facebook Link', 'splendio' ), 'splendio_facebook_text_input', 'theme_options', 'general' );
}
add_action( 'admin_init', 'splendio_theme_options_init' );

/**
 * Change the capability required to save the 'splendio_options' options group.
 *
 * @see splendio_theme_options_init() First parameter to register_setting() is the name of the options group.
 * @see splendio_theme_options_add_page() The edit_theme_options capability is used for viewing the page.
 *
 * @param string $capability The capability used for the page, which is manage_options by default.
 * @return string The capability to actually use.
 */
function splendio_option_page_capability( $capability ) {
	return 'edit_theme_options';
}
add_filter( 'option_page_capability_splendio_options', 'splendio_option_page_capability' );

/**
 * Add our theme options page to the admin menu, including some help documentation.
 *
 * This function is attached to the admin_menu action hook.
 *
 */
function splendio_theme_options_add_page() {
	$theme_page = add_theme_page(
		__( 'Theme Options', 'splendio' ),   // Name of page
		__( 'Theme Options', 'splendio' ),   // Label in menu
		'edit_theme_options',                    // Capability required
		'theme_options',                         // Menu slug, used to uniquely identify the page
		'splendio_theme_options_render_page' // Function that renders the options page
	);

	if ( ! $theme_page )
		return;
}
add_action( 'admin_menu', 'splendio_theme_options_add_page' );

/**
 * Returns the default options for Splendio.
 */
function splendio_get_default_theme_options() {
	$default_theme_options = array(
		'show_rss_link' => 'off',
	);

	return apply_filters( 'splendio_default_theme_options', $default_theme_options );
}

/**
 * Returns the options array for Splendio.
 *
 */
function splendio_get_theme_options() {
	return get_option( 'splendio_theme_options', splendio_get_default_theme_options() );
}

/**
 * Renders the sample checkbox setting field.
 */
function splendio_settings_field_checkbox() {
	$options = splendio_get_theme_options();
	?>
	<label for="show-rss-link">
		<input type="checkbox" name="splendio_theme_options[show_rss_link]" id="show-rss-link" <?php checked( 'on', $options['show_rss_link'] ); ?> />
		<?php _e( 'Show RSS Link in Header', 'splendio' );  ?>
	</label>
	<?php
}

/**
 * Renders the input setting fields.
 */
function splendio_twitter_text_input() {
	$options = splendio_get_theme_options();
	?>
	<div>
		<input type="text" name="splendio_theme_options[twitter_url]" id="twitter_url" value="<?php echo esc_attr( $options['twitter_url'] ); ?>" />
		<label class="description" for="twitter-url"><?php _e( 'Enter your Twitter URL', 'splendio' ); ?></label>
	</div>
	<?php
}

function splendio_facebook_text_input() {
	$options = splendio_get_theme_options();
	?>
	<div>
		<input type="text" name="splendio_theme_options[facebook_url]" id="facebook_url" value="<?php echo esc_attr( $options['facebook_url'] ); ?>" />
		<label class="description" for="facebook-url"><?php _e( 'Enter your Facebook URL', 'splendio' ); ?></label>
	</div>
	<?php
}

/**
 * Returns the options array for Splendio.
 *
 */
function splendio_theme_options_render_page() {
	?>
	<div class="wrap">
		<?php screen_icon(); ?>
		<h2><?php printf( __( '%s Theme Options', 'splendio' ), get_current_theme() ); ?></h2>
		<?php settings_errors(); ?>

		<h3><?php _e( 'The following options let you configure the social icons in the header. Leave any URL blank to hide its icon.', 'splendio' ); ?></h3>

		<form method="post" action="options.php">
			<?php
				settings_fields( 'splendio_options' );
				do_settings_sections( 'theme_options' );
				submit_button();
			?>
		</form>
	</div>
	<?php
}

/**
 * Sanitize and validate form input. Accepts an array, return a sanitized array.
 *
 * @see splendio_theme_options_init()
 */
function splendio_theme_options_validate( $input ) {
	$output = $defaults = splendio_get_default_theme_options();

	// The sample checkbox should either be on or off
	if ( ! isset( $input['show_rss_link'] ) )
		$input['show_rss_link'] = 'off';
	$output['show_rss_link'] = ( $input['show_rss_link'] == 'on' ? 'on' : 'off' );

	// The text input must be safe text with no HTML tags and encode the URL
	if ( isset( $input['twitter_url'] ) ) :
		$output['twitter_url'] = wp_filter_nohtml_kses( $input['twitter_url'] );
		$output['twitter_url'] = esc_url_raw( $input['twitter_url'] );
	endif;

	if ( isset( $input['facebook_url'] ) ) :
		$output['facebook_url'] = wp_filter_nohtml_kses( $input['facebook_url'] );
		$output['facebook_url'] = esc_url_raw( $input['facebook_url'] );
	endif;

	return apply_filters( 'splendio_theme_options_validate', $output, $input, $defaults );
}
