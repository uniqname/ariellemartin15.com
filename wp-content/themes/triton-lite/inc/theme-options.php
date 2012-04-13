<?php
/**
 * Triton Lite Theme Options
 *
 * @package Triton Lite
 */

/**
 * Properly enqueue styles and scripts for our theme options page.
 *
 * This function is attached to the admin_enqueue_scripts action hook.
 */
function triton_lite_admin_enqueue_scripts( $hook_suffix ) {
	wp_enqueue_style( 'triton-lite-theme-options', get_template_directory_uri() . '/inc/theme-options.css', false, '2012-03-06' );
	wp_enqueue_script( 'triton-lite-theme-options', get_template_directory_uri() . '/inc/theme-options.js', array( 'farbtastic' ), '2012-03-06' );
	wp_enqueue_style( 'farbtastic' );
	
	/**
	 * Check if current locale is RTL.
	 */
	if ( is_rtl() ) {
		wp_enqueue_style( 'triton-lite-theme-options-rtl', get_template_directory_uri() . '/inc/theme-options-rtl.css', false, '2012-03-06' );
	}
}
add_action( 'admin_print_styles-appearance_page_theme_options', 'triton_lite_admin_enqueue_scripts' );

/**
 * Register the form setting for our triton_lite_options array.
 *
 * This function is attached to the admin_init action hook.
 *
 * This call to register_setting() registers a validation callback, triton_lite_theme_options_validate(),
 * which is used when the option is saved, to ensure that our option values are complete, properly
 * formatted, and safe.
 *
 * We also use this function to add our theme option if it doesn't already exist.
 */
function triton_lite_theme_options_init() {

	// If we have no options in the database, let's add them now.
	if ( false === triton_lite_get_theme_options() )
		add_option( 'triton_lite_theme_options', triton_lite_get_default_theme_options() );

	register_setting(
		'triton_lite_options', // Options group, see settings_fields() call in theme_options_render_page()
		'triton_lite_theme_options', // Database option, see triton_lite_get_theme_options()
		'triton_lite_theme_options_validate' // The sanitization callback, see triton_lite_theme_options_validate()
	);
}
add_action( 'admin_init', 'triton_lite_theme_options_init' );

/**
 * Change the capability required to save the 'triton_lite_options' options group.
 *
 * @see triton_lite_theme_options_init() First parameter to register_setting() is the name of the options group.
 * @see triton_lite_theme_options_add_page() The edit_theme_options capability is used for viewing the page.
 *
 * By default, the options groups for all registered settings require the manage_options capability.
 * This filter is required to change our theme options page to edit_theme_options instead.
 * By default, only administrators have either of these capabilities, but the desire here is
 * to allow for finer-grained control for roles and users.
 *
 * @param string $capability The capability used for the page, which is manage_options by default.
 * @return string The capability to actually use.
 */
function triton_lite_option_page_capability( $capability ) {
	return 'edit_theme_options';
}
add_filter( 'option_page_capability_triton_lite_options', 'triton_lite_option_page_capability' );

/**
 * Add our theme options page to the admin menu.
 *
 * This function is attached to the admin_menu action hook.
 */
function triton_lite_theme_options_add_page() {
	$theme_page = add_theme_page(
		__( 'Theme Options', 'triton-lite' ), // Name of page
		__( 'Theme Options', 'triton-lite' ), // Label in menu
		'edit_theme_options', // Capability required
		'theme_options', // Menu slug, used to uniquely identify the page
		'triton_lite_theme_options_render_page' // Function that renders the options page
	);

	if ( ! $theme_page )
		return;
}
add_action( 'admin_menu', 'triton_lite_theme_options_add_page' );

/**
 * Returns the default options for Triton Lite.
 */
function triton_lite_get_default_theme_options() {
	$default_theme_options = array(
		'accent_color' => '#171717',
		'link_color' => '#333'
	);
	
	return apply_filters( 'triton_lite_default_theme_options', $default_theme_options );
}

/**
 * Returns the options array for Triton Lite.
 */
function triton_lite_get_theme_options() {
	return get_option( 'triton_lite_theme_options', triton_lite_get_default_theme_options() );
}

/**
 * Creates the Theme Options page for Triton Lite.
 */
function triton_lite_theme_options_render_page() {

	if ( ! isset( $_REQUEST[ 'settings-updated' ] ) )
		$_REQUEST[ 'settings-updated' ] = false;

	?>
	<div class="wrap" id="triton-lite-theme-options">
		<?php screen_icon(); ?>
		<h2>
			<?php printf( __( '%s Theme Options', 'triton-lite' ), get_current_theme() ); ?>
		</h2>
		
		<?php if ( false !== $_REQUEST[ 'settings-updated' ] ) : ?>
			<div id="message" class="updated">
				<p>
					<?php _e( 'Options Saved', 'triton-lite' ); ?>
				</p>
			</div><!-- .updated -->
		<?php endif; ?>

		<form method="post" action="options.php">
			<?php
				settings_fields( 'triton_lite_options' );
				$options = triton_lite_get_theme_options();
				$default_options = triton_lite_get_default_theme_options();
			?>

			<table class="form-table">
				<tbody>
					<tr valign="top" id="triton-lite-accent-colors">
						<th scope="row">
							<?php _e( 'Accent Color', 'triton-lite' ); ?>
						</th>
						<td>
							<fieldset>
								<legend class="screen-reader-text">
									<span><?php _e( 'Accent Color', 'triton-lite' ); ?></span>
								</legend>
								
								<input type="text" name="triton_lite_theme_options[accent_color]" id="accent-primary-color" value="<?php echo esc_attr( $options[ 'accent_color' ] ); ?>" />
								<a href="#" class="accent-pickcolor hide-if-no-js" id="accent-link-color-example"></a>
								<input type="button" class="accent-pickcolor button hide-if-no-js" value="<?php esc_attr_e( 'Select a Color', 'triton-lite' ); ?>" />
								<div id="accent-colorPickerDiv" style="z-index: 100; background:#eee; border:1px solid #ccc; position:absolute; display:none;"></div>
								<br />
								<span><?php printf( __( 'The default accent color for Triton Lite is %1$s.', 'triton-lite' ), '<span id="accent-default-color">#171717</span>' ); ?></span>
							</fieldset>
						</td>
					</tr><!-- #triton-lite-accent-colors -->
				
					<tr valign="top" id="triton-lite-link-colors">
						<th scope="row">
							<?php _e( 'Link Color', 'triton-lite' ); ?>
						</th>
						<td>
							<fieldset>
								<legend class="screen-reader-text">
									<span><?php _e( 'Link Color', 'triton-lite' ); ?></span>
								</legend>
								<input type="text" name="triton_lite_theme_options[link_color]" id="primary-color" value="<?php echo esc_attr( $options[ 'link_color' ] ); ?>" />
								<a href="#" class="pickcolor hide-if-no-js" id="link-color-example"></a>
								<input type="button" class="pickcolor button hide-if-no-js" value="<?php esc_attr_e( 'Select a Color', 'triton-lite' ); ?>" />
								<div id="colorPickerDiv" style="z-index: 100; background:#eee; border:1px solid #ccc; position:absolute; display:none;"></div>
								<br />
								<span><?php printf( __( 'The default link color for Triton Lite is %1$s.', 'triton-lite' ), '<span id="default-color">#333</span>' ); ?></span>
							</fieldset>
						</td>
					</tr><!-- #triton-lite-link-colors -->
					
				</tbody>
			</table>

			<p class="submit">
				<?php submit_button( __( 'Save Options', 'triton-lite' ), 'primary', 'submit', false ); ?>
				<?php submit_button( __( 'Reset Options', 'triton-lite' ), 'secondary', 'triton_lite_theme_options[reset]', false, array( 'id' => 'reset' ) ); ?>
			</p>
		</form>
	</div><!-- #wrap -->
	<?php
}

/**
 * Sanitize and validate form input. Accepts an array, return a sanitized array.
 */
function triton_lite_theme_options_validate( $input ) {
	$output = $defaults = triton_lite_get_default_theme_options();

	// Accent color must be 3 or 6 hexadecimal characters
	if ( isset( $input[ 'accent_color' ] ) && preg_match( '/^#?([a-f0-9]{3}){1,2}$/i', $input[ 'accent_color' ] ) )
		$output[ 'accent_color' ] = '#' . strtolower( ltrim( $input[ 'accent_color' ], '#' ) );
	
	// Link color must be 3 or 6 hexadecimal characters
	if ( isset( $input[ 'link_color' ] ) && preg_match( '/^#?([a-f0-9]{3}){1,2}$/i', $input[ 'link_color' ] ) )
		$output[ 'link_color' ] = '#' . strtolower( ltrim( $input[ 'link_color' ], '#' ) );

	// Reset theme options
	if ( ! empty( $input[ 'reset' ] ) ) {
		$output = $defaults = triton_lite_get_default_theme_options();
		foreach ( $output as $field => $value ) {
			if ( isset( $defaults[ $field ] ) )
				$output[ $field ] = $defaults[ $field ] ;
			else
				unset( $output[ $field ] );
		}
	}
	
	return apply_filters( 'triton_lite_theme_options_validate', $output, $input, $defaults );
}

/**
 * Add a style block to Triton Lite for the current link color.
 */
function triton_lite_print_color_styles() {
	$options = triton_lite_get_theme_options();
	$accent_color = $options[ 'accent_color' ];
	$link_color = $options[ 'link_color' ];

	$default_options = triton_lite_get_default_theme_options();

	// Don't do anything if both the current Link Color and Accent Color are set to their defaults.
	if ( $default_options[ 'link_color' ] == $link_color && $default_options[ 'accent_color' ] == $accent_color )
		return; ?>

	<style type="text/css">
	/* <![CDATA[ */
		/*
		 * Link color
		 */
		<?php if ( $link_color != $default_options[ 'link_color' ] ) : ?>
			a,
			.post-wrap a,
			.by-author a,
			#posts .post-content .post-foot a {
				color: <?php echo $link_color; ?>;
			}
		<?php endif; ?>
		
		<?php if ( $accent_color != $default_options[ 'accent_color' ] ) : ?>
			#masthead,
			#access ul ul,
			#comments .form-submit input,
			#comments .form-submit input:hover,
			#footer {
				background-color: <?php echo $accent_color; ?>;
			}
			#access .current-menu-item > a,
			#access .current-menu-ancestor > a,
			#access .current_page_item > a,
			#access .current_page_ancestor > a {
				background: rgba( 0, 0, 0, 0.3 );
			}
			#access a,
			#access ul ul a,
			#comments .form-submit input,
			#footer {
				color: rgba( 255, 255, 255, 0.7 );
			}
			#access ul ul a {
				border-bottom: 1px solid rgba( 0, 0, 0, 0.2 );
			}
			#access ul ul a:hover,
			#access ul ul :hover > a {
				background: rgba( 0, 0, 0, 0.3 );
				color: rgba( 255, 255, 255, 1 );
			}
			#access .current-menu-item > a,
			#access .current-menu-ancestor > a,
			#access .current_page_item > a,
			#access .current_page_ancestor > a,
			#footer a { /* Top-level current links */
				color: rgba( 255, 255, 255, 1 );
			}
			#access ul ul .current-menu-item > a,
			#access ul ul .current-menu-ancestor > a,
			#access ul ul .current_page_item > a,
			#access ul ul .current_page_ancestor > a { /* Sub-level current links */
				background: rgba( 0, 0, 0, 0.3 );
				color: rgba( 255, 255, 255, 1 );
			}
			#access ul ul .current-menu-ancestor > a,
			#access ul ul .current_page_ancestor > a {
				background: rgba( 0, 0, 0, 0.3 );
			}
			#access ul ul .current-menu-ancestor > a:hover,
			#access ul ul .current_page_ancestor > a:hover {
				background: rgba( 0, 0, 0, 0.3 );
			}
		<?php endif; ?>
	/* ]]> */
	</style>
<?php
}
add_action( 'wp_head', 'triton_lite_print_color_styles' );