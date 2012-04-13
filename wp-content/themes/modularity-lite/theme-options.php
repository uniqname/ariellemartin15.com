<?php
/**
 * @package WordPress
 * @subpackage Modularity
 */

add_action( 'admin_init', 'theme_options_init' );
add_action( 'admin_menu', 'theme_options_add_page' );

function modularity_admin_enqueue_scripts( $hook_suffix ) {
	wp_enqueue_style( 'modularity-theme-options', get_template_directory_uri() . '/library/styles/theme-options.css', false, '2011-11-15' );
	if ( is_rtl() ) {
		wp_enqueue_style( 'modularity-theme-options-rtl', get_template_directory_uri() . '/library/styles/theme-options-rtl.css', false, '2011-11-15' );
	}
}
add_action( 'admin_print_styles-appearance_page_theme_options', 'modularity_admin_enqueue_scripts' );

/**
 * Init plugin options to white list our options
 */
function theme_options_init(){
	register_setting( 'modularity_options', 'modularity_theme_options', 'theme_options_validate' );
}

/**
 * Load up the menu page
 */
function theme_options_add_page() {
	add_theme_page( __( 'Theme Options' ), __( 'Theme Options' ), 'edit_theme_options', 'theme_options', 'theme_options_do_page' );
}

/**
 * Return array for our color schemes
 */
function modularity_color_schemes() {
	$color_schemes = array(
		'dark' => array(
			'value' =>	'dark',
			'label' => __( 'Dark (Default)', 'modularity' )
		),
		'light' => array(
			'value' =>	'light',
			'label' => __( 'Light', 'modularity' )
		),
	);

	return $color_schemes;
}

/**
 * Create the options page
 */
function theme_options_do_page() {
	global $select_options, $radio_options;

	if ( ! isset( $_REQUEST['settings-updated'] ) )
		$_REQUEST['settings-updated'] = false;

	?>
	<div class="wrap">
		<?php screen_icon(); echo "<h2>" . get_current_theme() . __( ' Theme Options' ) . "</h2>"; ?>

		<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
		<div class="updated fade"><p><strong><?php _e( 'Options saved' ); ?></strong></p></div>
		<?php endif; ?>

		<form method="post" action="options.php">
			<?php settings_fields( 'modularity_options' ); ?>
			<?php $options = get_option( 'modularity_theme_options' ); ?>

			<h3><?php _e( 'Color Schemes, Optional Sidebar and Slideshow', 'modularity' ); ?></h3>
			<p><?php _e( 'A dark or light color scheme? A one-column layout or a two-column layout with sidebar? How about a home page slideshow featuring 950px by 425px image attachments from your most recent posts? The choice is yours.', 'modularity' ); ?></p>

			<table class="form-table">

				<?php
				/**
				 * Color Scheme Option
				 */
				?>
				<tr valign="top" id="modularity-colors"><th scope="row"><?php _e( 'Color Scheme', 'modularity' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Color Scheme', 'modularity' ); ?></span></legend>
						<?php
							if ( ! isset( $checked ) )
								$checked = '';
							foreach ( modularity_color_schemes() as $option ) {
								$radio_setting = $options['color_scheme'];

								if ( '' != $radio_setting ) {
									if ( $options['color_scheme'] == $option['value'] ) {
										$checked = "checked=\"checked\"";
									} else {
										$checked = '';
									}
								}
								?>
								<div class="layout">
								<label class="description">
									<input type="radio" name="modularity_theme_options[color_scheme]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php echo $checked; ?> />
									<span>
										<img src="<?php echo get_template_directory_uri(); ?>/images/<?php echo $option['value']; ?>.png"/>
										<?php echo $option['label']; ?>
									</span>
								</label>
								</div>
								<?php
							}
						?>
						</fieldset>
					</td>
				</tr>

				<?php
				/**
				 * Sidebar option
				 */
				?>
				<tr valign="top"><th scope="row"><?php _e( 'Sidebar', 'modularity' ); ?></th>
					<td>
						<input id="modularity_theme_options[sidebar]" name="modularity_theme_options[sidebar]" type="checkbox" value="1" <?php checked( '1', $options['sidebar'] ); ?> />
						<label class="description" for="modularity_theme_options[sidebar]"><?php _e( 'Yes! I&rsquo;d like to enable the optional sidebar', 'modularity' ); ?></label>
					</td>
				</tr>

				<?php
				/**
				 * Slideshow option
				 */
				?>
				<tr valign="top"><th scope="row"><?php _e( 'Slideshow', 'modularity' ); ?></th>
					<td>
						<input id="modularity_theme_options[slideshow]" name="modularity_theme_options[slideshow]" type="checkbox" value="1" <?php checked( '1', $options['slideshow'] ); ?> />
						<label class="description" for="modularity_theme_options[slideshow]"><?php _e( 'Yes! I&rsquo;d like to enable the optional home page slideshow', 'modularity' ); ?></label>
					</td>
				</tr>

			</table>

			<h3><?php _e( 'Welcome Message', 'modularity' ); ?></h3>
			<p><?php _e( 'Fill out the following Title and Content fields to enable a Welcome Message on the home page of your site.', 'modularity' ); ?></p>

			<table class="form-table">

				<?php
				/**
				 * Welcome box title
				 */
				?>
				<tr valign="top"><th scope="row"><?php _e( 'Welcome Message Title' ); ?></th>
					<td>
						<input id="modularity_theme_options[welcome_title]" class="regular-text" type="text" name="modularity_theme_options[welcome_title]" value="<?php echo esc_attr( stripslashes( $options['welcome_title'] ) ); ?>" />
					</td>
				</tr>

				<?php
				/**
				 * Welcome box content
				 */
				?>
				<tr valign="top"><th scope="row"><?php _e( 'Welcome Message Content' ); ?></th>
					<td>
						<textarea id="modularity_theme_options[welcome_content]" class="large-text" cols="50" rows="10" name="modularity_theme_options[welcome_content]"><?php echo esc_textarea( $options['welcome_content'] ); ?></textarea>
					</td>
				</tr>

			</table>

			<p class="submit">
				<input type="submit" class="button-primary" value="<?php esc_attr_e( 'Save Options', 'modularity' ); ?>" />
			</p>
		</form>
	</div>
	<?php
}

/**
 * Sanitize and validate input. Accepts an array, return a sanitized array.
 */
function theme_options_validate( $input ) {
	global $select_options, $radio_options;

	// Our sidebar checkbox value is either 0 or 1
	if ( ! isset( $input['sidebar'] ) )
		$input['sidebar'] = 0;
	$input['sidebar'] = ( $input['sidebar'] == 1 ? 1 : 0 );

	// Our slideshow checkbox value is either 0 or 1
	if ( ! isset( $input['slideshow'] ) )
		$input['slideshow'] = 0;
	$input['slideshow'] = ( $input['slideshow'] == 1 ? 1 : 0 );

	// Our welcome_box checkbox value is either 0 or 1
	if ( ! isset( $input['welcome_box'] ) )
		$input['welcome_box'] = null;
	$input['welcome_box'] = ( $input['welcome_box'] == 1 ? 1 : 0 );

	// Say our text option must be safe text with no HTML tags
	$input['welcome_title'] = wp_filter_nohtml_kses( $input['welcome_title'] );

	// Say our textarea option must be safe text with the allowed tags for posts
	$input['welcome_content'] = wp_filter_post_kses( $input['welcome_content'] );

	if ( ! array_key_exists( $input['color_scheme'], modularity_color_schemes() ) )
		$input['color_scheme'] = 'dark';

	return $input;
}

// adapted from http://planetozh.com/blog/2009/05/handling-plugins-options-in-wordpress-28-with-register_setting/