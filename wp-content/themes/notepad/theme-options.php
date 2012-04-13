<?php
/**
 * @package WordPress
 * @subpackage Notepad
 */
add_action( 'admin_init', 'theme_options_init' );
add_action( 'admin_menu', 'theme_options_add_page' );

/**
 * Init plugin options to white list our options
 */
function theme_options_init(){
	register_setting( 'notepad_options', 'notepad_theme_options', 'theme_options_validate' );
}

/**
 * Load up the menu page
 */
function theme_options_add_page() {
	add_theme_page( __( 'Theme Options', 'notepad-theme' ), __( 'Theme Options', 'notepad-theme' ), 'edit_theme_options', 'theme_options', 'theme_options_do_page' );
}

/**
 * Create the options page
 */
function theme_options_do_page() {
	if ( !isset( $_REQUEST['settings-updated'] ) ) {
		//If not isset set as false
		$_REQUEST['settings-updated'] = 'false';
	}
	?>
	<div class="wrap">
	    <?php screen_icon(); echo "<h2>" . get_current_theme() . __( ' Theme Options', 'notepad-theme' ) . "</h2>"; ?>

		<?php if( $_REQUEST['settings-updated'] == 'true' ) : ?>
		<div class="updated fade"><p><strong><?php _e( 'Options saved', 'notepad-theme' ); ?></strong></p></div>
		<?php endif; ?>

		<p><?php _e( 'Add the URLs of your other personal sites on the web to show links to them in your header. You can also choose to display links to your email and RSS feed.', 'notepad-theme' ); ?></p>

		<form method="post" action="options.php">
			<?php
				settings_fields( 'notepad_options' );
				$options = wp_parse_args( get_option( 'notepad_theme_options' ), notepad_get_default_options() );
			?>

			<table class="form-table">

				<tr valign="top">
					<th scope="row"><label for="notepad-twitterurl"><?php echo __( 'Twitter', 'notepad-theme' ) ?></label></th>
					<td><input id="notepad-twitterurl" class="regular-text" type="text" name="notepad_theme_options[twitterurl]" value="<?php echo esc_url( $options['twitterurl'] ); ?>" /></td>
				</tr>

				<tr valign="top">
					<th scope="row"><label for="notepad-facebookurl"><?php echo __( 'Facebook', 'notepad-theme' ) ?></label></th>
					<td><input id="notepad-facebookurl" class="regular-text" type="text" name="notepad_theme_options[facebookurl]" value="<?php echo esc_url( $options['facebookurl'] ); ?>" /></td>
				</tr>

				<tr valign="top">
					<th scope="row"><label for="notepad-flickrurl"><?php echo __( 'Flickr', 'notepad-theme' ) ?></label></th>
					<td><input id="notepad-flickrurl" class="regular-text" type="text" name="notepad_theme_options[flickrurl]" value="<?php echo esc_url( $options['flickrurl'] ); ?>" /></td>
				</tr>

				<tr valign="top">
					<th scope="row"><?php _e( 'RSS', 'notepad-theme' ); ?></th>
					<td>
						<input id="notepad-rss" name="notepad_theme_options[rss]" type="checkbox" value="1" <?php checked( $options['rss'] ); ?> />
						<label class="description" for="notepad-rss"><?php _e( 'Show a link to your RSS feed in the header', 'notepad' ); ?></label>
					</td>
				</tr>

			</table>

			<p class="submit">
				<input type="submit" class="button-primary" value="<?php esc_attr_e( 'Save Options' ); ?>" />
			</p>
		</form>
	</div>
	<?php
}

/**
 * Sanitize and validate input. Accepts an array, return a sanitized array.
 */
function theme_options_validate( $dirty ) {

	$clean = notepad_get_default_options();
	$dirty = wp_parse_args( $dirty, $clean );

	foreach ( $dirty as $key => $value ) {
		if ( 'rss' == $key )
			continue;

		$clean[$key] = esc_url_raw( $value );
	}

	$clean['rss'] = ( empty( $dirty['rss'] ) ) ? 0 : 1;

	return $clean;
}

function notepad_get_default_options() {

	$options = array(
		'rss'         => 0,
		'twitterurl'  => '',
		'facebookurl' => '',
		'flickrurl'   => '',
	);

	return $options;
}

// adapted from http://planetozh.com/blog/2009/05/handling-plugins-options-in-wordpress-28-with-register_setting/