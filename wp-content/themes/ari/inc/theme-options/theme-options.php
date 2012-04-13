<?php
/**
 * Ari Theme Options
 *
 * @package Ari
 * @since Ari 1.1.2
 */

/**
 * Properly enqueue styles and scripts for our theme options page.
 *
 * This function is attached to the admin_enqueue_scripts action hook.
 *
 * @since Ari 1.1.2
 *
 */
function ari_admin_enqueue_scripts( $hook_suffix ) {
	wp_enqueue_style( 'ari-theme-options', get_template_directory_uri() . '/inc/theme-options/theme-options.css', false, '20120311' );
	wp_enqueue_script( 'ari-theme-options', get_template_directory_uri() . '/inc/theme-options/theme-options.js', array( 'farbtastic' ), '20120311' );
	wp_enqueue_style( 'farbtastic' );
}
add_action( 'admin_print_styles-appearance_page_theme_options', 'ari_admin_enqueue_scripts' );

/**
 * Register the form setting for our ari_options array.
 *
 * This function is attached to the admin_init action hook.
 *
 * This call to register_setting() registers a validation callback, ari_theme_options_validate(),
 * which is used when the option is saved, to ensure that our option values are complete, properly
 * formatted, and safe.
 *
 * We also use this function to add our theme option if it doesn't already exist.
 *
 * @since Ari 1.1.2
 */
function ari_theme_options_init() {

	// If we have no options in the database, let's add them now.
	if ( false === ari_get_theme_options() )
		add_option( 'ari_theme_options', ari_get_default_theme_options() );

	register_setting(
		'ari_options',       // Options group, see settings_fields() call in ari_theme_options_render_page()
		'ari_theme_options', // Database option, see ari_get_theme_options()
		'ari_theme_options_validate' // The sanitization callback, see ari_theme_options_validate()
	);

	// Register our settings field group
	add_settings_section(
		'general', // Unique identifier for the settings section
		'', // Section title (we don't want one)
		'__return_false', // Section callback (we don't want anything)
		'theme_options' // Menu slug, used to uniquely identify the page; see ari_theme_options_add_page()
	);

	add_settings_field( 'color_scheme', __( 'Color Scheme', 'ari' ), 'ari_settings_field_color_scheme', 'theme_options', 'general' );
	add_settings_field( 'first_link_color', __( 'First Link Color', 'ari' ), 'ari_settings_field_first_link_color', 'theme_options', 'general' );
	add_settings_field( 'second_link_color', __( 'Second Link Color', 'ari' ), 'ari_settings_field_second_link_color', 'theme_options', 'general' );
	add_settings_field( 'text_color', __( 'Text Color', 'ari' ), 'ari_settings_field_text_color', 'theme_options', 'general' );
}
add_action( 'admin_init', 'ari_theme_options_init' );

/**
 * Change the capability required to save the 'ari_options' options group.
 *
 * @see ari_theme_options_init() First parameter to register_setting() is the name of the options group.
 * @see ari_theme_options_add_page() The edit_theme_options capability is used for viewing the page.
 *
 * @param string $capability The capability used for the page, which is manage_options by default.
 * @return string The capability to actually use.
 */
function ari_option_page_capability( $capability ) {
	return 'edit_theme_options';
}
add_filter( 'option_page_capability_ari_options', 'ari_option_page_capability' );

/**
 * Add our theme options page to the admin menu.
 *
 * This function is attached to the admin_menu action hook.
 *
 * @since Ari 1.1.2
 */
function ari_theme_options_add_page() {
	$theme_page = add_theme_page(
		__( 'Theme Options', 'ari' ),	// Name of page
		__( 'Theme Options', 'ari' ),	// Label in menu
		'edit_theme_options',			// Capability required
		'theme_options',				// Menu slug, used to uniquely identify the page
		'ari_theme_options_render_page'	// Function that renders the options page
	);
}
add_action( 'admin_menu', 'ari_theme_options_add_page' );

/**
 * Returns an array of sample radio options registered for Ari.
 *
 * @since Ari 1.1.2
 */
function ari_color_schemes() {
	$color_scheme_options = array(
		'light' => array(
			'value' => 'light',
			'label' => __( 'Light', 'ari' ),
			'thumbnail' => get_template_directory_uri() . '/inc/theme-options/images/light.png',
			'default_first_link_color' => '#88c34b',
			'default_second_link_color' => '#999999',
			'default_text_color' => '#4c4c4c'
		),
		'dark' => array(
			'value' => 'dark',
			'label' => __( 'Dark', 'ari' ),
			'thumbnail' => get_template_directory_uri() . '/inc/theme-options/images/dark.png',
			'default_first_link_color' => '#8a8a8a',
			'default_second_link_color' => '#b7b7b7',
			'default_text_color' => '#707070'
		)
	);

	return apply_filters( 'ari_color_schemes', $color_scheme_options );
}

/**
 * Returns the default options for Ari.
 *
 * @since Ari 1.1.2
 */
function ari_get_default_theme_options() {
	$default_theme_options = array(
		'color_scheme' => 'light',
		'first_link_color'  => ari_get_default_first_link_color( 'light' ),
		'second_link_color'  => ari_get_default_second_link_color( 'light' ),
		'text_color'  => ari_get_default_text_color( 'light' )
	);

	return apply_filters( 'ari_default_theme_options', $default_theme_options );
}

/**
 * Returns the default first link color for Ari, based on color scheme.
 *
 * @since Ari 1.1.2
 *
 * @param $string $color_scheme Color scheme. Defaults to the active color scheme.
 * @return $string Color.
*/
function ari_get_default_first_link_color( $color_scheme = null ) {
	if ( null === $color_scheme ) {
		$options = ari_get_theme_options();
		$color_scheme = $options['color_scheme'];
	}

	$color_schemes = ari_color_schemes();
	if ( ! isset( $color_schemes[$color_scheme] ) )
		return false;

	return $color_schemes[$color_scheme]['default_first_link_color'];
}

/**
 * Returns the default second link color for Ari, based on color scheme.
 *
 * @since Ari 1.1.2
 *
 * @param $string $color_scheme Color scheme. Defaults to the active color scheme.
 * @return $string Color.
*/
function ari_get_default_second_link_color( $color_scheme = null ) {
	if ( null === $color_scheme ) {
		$options = ari_get_theme_options();
		$color_scheme = $options['color_scheme'];
	}

	$color_schemes = ari_color_schemes();
	if ( ! isset( $color_schemes[$color_scheme] ) )
		return false;

	return $color_schemes[$color_scheme]['default_second_link_color'];
}

/**
 * Returns the default text color for Ari, based on color scheme.
 *
 * @since Ari 1.1.2
 *
 * @param $string $color_scheme Color scheme. Defaults to the active color scheme.
 * @return $string Color.
*/
function ari_get_default_text_color( $color_scheme = null ) {
	if ( null === $color_scheme ) {
		$options = ari_get_theme_options();
		$color_scheme = $options['color_scheme'];
	}

	$color_schemes = ari_color_schemes();
	if ( ! isset( $color_schemes[$color_scheme] ) )
		return false;

	return $color_schemes[$color_scheme]['default_text_color'];
}

/**
 * Returns the options array for Ari.
 *
 * @since Ari 1.1.2
 */
function ari_get_theme_options() {
	return get_option( 'ari_theme_options', ari_get_default_theme_options() );
}

/**
 * Renders the Color Scheme setting field.
 *
 * @since Ari 1.1.2
 */
function ari_settings_field_color_scheme() {
	$options = ari_get_theme_options();

	foreach ( ari_color_schemes() as $scheme ) {
	?>
	<div class="layout image-radio-option color-scheme">
		<label class="description">
			<input type="radio" name="ari_theme_options[color_scheme]" value="<?php echo esc_attr( $scheme['value'] ); ?>" <?php checked( $options['color_scheme'], $scheme['value'] ); ?> />
			<input type="hidden" class="default-first-link-color" value="<?php echo esc_attr( $scheme['default_first_link_color'] ); ?>" />
			<input type="hidden" class="default-second-link-color" value="<?php echo esc_attr( $scheme['default_second_link_color'] ); ?>" />
			<input type="hidden" class="default-text-color" value="<?php echo esc_attr( $scheme['default_text_color'] ); ?>" />
			<span>
				<img src="<?php echo esc_url( $scheme['thumbnail'] ); ?>" width="136" height="122" alt="" />
				<?php echo $scheme['label']; ?>
			</span>
		</label>
	</div>
	<?php
	}
}

/**
 * Renders the First Link Color setting field.
 *
 * @since Ari 1.1.2
 */
function ari_settings_field_first_link_color() {
	$options = ari_get_theme_options();
	?>
	<input type="text" name="ari_theme_options[first_link_color]" id="first-link-color" value="<?php echo esc_attr( $options['first_link_color'] ); ?>" />
	<a href="#" class="firstpickcolor hide-if-no-js" id="first-link-color-example"></a>
	<input type="button" class="firstpickcolor button hide-if-no-js" value="<?php esc_attr_e( 'Select a Color', 'ari' ); ?>" />
	<div id="firstLinkColorPickerDiv" style="z-index: 100; background:#eee; border:1px solid #ccc; position:absolute; display:none;"></div>
	<br />
	<span><?php printf( __( 'Default color: %s', 'ari' ), '<span id="default-first-link-color">' . ari_get_default_first_link_color( $options['color_scheme'] ) . '</span>' ); ?></span>
	<?php
}

/**
 * Renders the Second Link Color setting field.
 *
 * @since Ari 1.1.2
 */
function ari_settings_field_second_link_color() {
	$options = ari_get_theme_options();
	?>
	<input type="text" name="ari_theme_options[second_link_color]" id="second-link-color" value="<?php echo esc_attr( $options['second_link_color'] ); ?>" />
	<a href="#" class="secondpickcolor hide-if-no-js" id="second-link-color-example"></a>
	<input type="button" class="secondpickcolor button hide-if-no-js" value="<?php esc_attr_e( 'Select a Color', 'ari' ); ?>" />
	<div id="secondLinkColorPickerDiv" style="z-index: 100; background:#eee; border:1px solid #ccc; position:absolute; display:none;"></div>
	<br />
	<span><?php printf( __( 'Default color: %s', 'ari' ), '<span id="default-second-link-color">' . ari_get_default_second_link_color( $options['color_scheme'] ) . '</span>' ); ?></span>
	<?php
}

/**
 * Renders the Text Color setting field.
 *
 * @since Ari 1.1.2
 */
function ari_settings_field_text_color() {
	$options = ari_get_theme_options();
	?>
	<input type="text" name="ari_theme_options[text_color]" id="text-color" value="<?php echo esc_attr( $options['text_color'] ); ?>" />
	<a href="#" class="textpickcolor hide-if-no-js" id="text-color-example"></a>
	<input type="button" class="textpickcolor button hide-if-no-js" value="<?php esc_attr_e( 'Select a Color', 'ari' ); ?>" />
	<div id="textColorPickerDiv" style="z-index: 100; background:#eee; border:1px solid #ccc; position:absolute; display:none;"></div>
	<br />
	<span><?php printf( __( 'Default color: %s', 'ari' ), '<span id="default-text-color">' . ari_get_default_text_color( $options['color_scheme'] ) . '</span>' ); ?></span>
	<?php
}

/**
 * Returns the options array for Ari.
 *
 * @since Ari 1.1.2
 */
function ari_theme_options_render_page() {
	?>
	<div class="wrap">
		<?php screen_icon(); ?>
		<h2><?php printf( __( '%s Theme Options', 'ari' ), wp_get_theme() ); ?></h2>
		<?php settings_errors(); ?>

		<form method="post" action="options.php">
			<?php
				settings_fields( 'ari_options' );
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
 * @see ari_theme_options_init()
 * @todo set up Reset Options action
 *
 * @since Ari 1.1.2
 */
function ari_theme_options_validate( $input ) {
	$output = $defaults = ari_get_default_theme_options();

	// The Color Scheme value must be in our array of radio button values
	if ( isset( $input['color_scheme'] ) && array_key_exists( $input['color_scheme'], ari_color_schemes() ) )
		$output['color_scheme'] = $input['color_scheme'];

	// Our defaults for the first link color may have changed, based on the color scheme.
	$output['first_link_color'] = $defaults['first_link_color'] = ari_get_default_first_link_color( $output['color_scheme'] );

	// Our defaults for the second link color may have changed, based on the color scheme.
	$output['second_link_color'] = $defaults['second_link_color'] = ari_get_default_second_link_color( $output['color_scheme'] );

	// Our defaults for the text color may have changed, based on the color scheme.
	$output['text_color'] = $defaults['text_color'] = ari_get_default_text_color( $output['color_scheme'] );

	// First link color must be 3 or 6 hexadecimal characters
	if ( isset( $input['first_link_color'] ) && preg_match( '/^#?([a-f0-9]{3}){1,2}$/i', $input['first_link_color'] ) )
		$output['first_link_color'] = '#' . strtolower( ltrim( $input['first_link_color'], '#' ) );

	// Second link color must be 3 or 6 hexadecimal characters
	if ( isset( $input['second_link_color'] ) && preg_match( '/^#?([a-f0-9]{3}){1,2}$/i', $input['second_link_color'] ) )
		$output['second_link_color'] = '#' . strtolower( ltrim( $input['second_link_color'], '#' ) );

	// Text color must be 3 or 6 hexadecimal characters
	if ( isset( $input['text_color'] ) && preg_match( '/^#?([a-f0-9]{3}){1,2}$/i', $input['text_color'] ) )
		$output['text_color'] = '#' . strtolower( ltrim( $input['text_color'], '#' ) );

	return apply_filters( 'ari_theme_options_validate', $output, $input, $defaults );
}

/**
 * Enqueue the styles for the current color scheme.
 *
 * @since Ari 1.1.2
 */
function ari_enqueue_color_scheme() {
	$options = ari_get_theme_options();
	$color_scheme = $options['color_scheme'];

	if ( 'dark' == $color_scheme )
		wp_enqueue_style( 'dark', get_template_directory_uri() . '/colors/dark.css', array(), null );

	do_action( 'ari_enqueue_color_scheme', $color_scheme );
}
add_action( 'wp_enqueue_scripts', 'ari_enqueue_color_scheme' );

/**
 * Add a style block to the theme for the current first link color.
 *
 * This function is attached to the wp_head action hook.
 *
 * @since Ari 1.1.2
 */
function ari_print_first_link_color_style() {
	$options = ari_get_theme_options();
	$first_link_color = $options['first_link_color'];
	$default_options = ari_get_default_first_link_color();

	// Don't do anything if the current first link color is the default.
	if ( $default_options == $first_link_color )
		return;
?>
	<style>
		/* First link color */
		a,
		.comment-meta a:hover,
		.entry-meta a:hover,
		.entry-title a:hover,
		.logged-in-as a:hover,
		.main-navigation a:hover,
		.main-navigation li.current_page_item > a,
		.main-navigation li.current_page_ancestor > a,
		.main-navigation li.current-menu-item > a,
		.main-navigation li.current-menu_ancestor > a,
		.post-edit-link:hover,
		.site-footer a:hover,
		.widget a:hover,
		.widget_flickr #flickr_badge_uber_wrapper a:hover {
			color: <?php echo $first_link_color; ?>;
		}
		.bypostauthor .avatar,
		button:hover,
		html input[type="button"]:hover,
		input[type="reset"]:hover,
		input[type="submit"]:hover,
		.widget_calendar #wp-calendar tbody td a {
			background: <?php echo $first_link_color; ?>;
		}
	</style>
<?php
}
add_action( 'wp_head', 'ari_print_first_link_color_style' );

/**
 * Add a style block to the theme for the current second link color.
 *
 * This function is attached to the wp_head action hook.
 *
 * @since Ari 1.1.2
 */
function ari_print_second_link_color_style() {
	$options = ari_get_theme_options();
	$second_link_color = $options['second_link_color'];
	$default_options = ari_get_default_second_link_color();

	// Don't do anything if the current second link color is the default.
	if ( $default_options == $second_link_color )
		return;
?>
	<style>
		/* Second link color */
		.comment-meta a,
		.entry-meta a,
		.logged-in-as a,
		.main-navigation a,
		.main-small-navigation a,
		.post-edit-link,
		.site-footer a,
		.widget a,
		.widget_flickr #flickr_badge_uber_wrapper a {
			color: <?php echo $second_link_color; ?>;
		}
	</style>
<?php
}
add_action( 'wp_head', 'ari_print_second_link_color_style' );

/**
 * Add a style block to the theme for the current text color.
 *
 * This function is attached to the wp_head action hook.
 *
 * @since Ari 1.1.2
 */
function ari_print_text_color_style() {
	$options = ari_get_theme_options();
	$text_color = $options['text_color'];
	$default_options = ari_get_default_text_color();

	// Don't do anything if the current text color is the default.
	if ( $default_options == $text_color )
		return;
?>
	<style>
		/* Text color */
		body,
		.entry-title a,
		.widget-title a {
			color: <?php echo $text_color; ?>;
		}
	</style>
<?php
}
add_action( 'wp_head', 'ari_print_text_color_style' );