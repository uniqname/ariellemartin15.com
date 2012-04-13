<?php
/**
 * Nuntius Theme Options
 *
 * @package WordPress
 * @subpackage Nuntius
 */

add_action( 'admin_init', 'nuntius_theme_options_init' );
add_action( 'admin_menu', 'nuntius_theme_options_add_page' );

// Properly enqueue styles and scripts for our theme options page.
function nuntius_admin_enqueue_scripts( $hook_suffix ) {
	wp_enqueue_script( 'farbtastic' );
	wp_enqueue_style( 'farbtastic' );
}
add_action( 'admin_print_styles-appearance_page_theme_options', 'nuntius_admin_enqueue_scripts' );

// Init plugin options to white list our options
function nuntius_theme_options_init() {

	// If we have no options in the database, let's add them now.
	if ( false === nuntius_get_theme_options() )
		add_option( 'nuntius_options', nuntius_get_default_theme_options() );

	register_setting( 'nuntius_options', 'nuntius_theme_options', 'nuntius_theme_options_validate' );
}

// Load up the menu page
function nuntius_theme_options_add_page() {
	add_theme_page( __( 'Theme Options', 'nuntius' ), __( 'Theme Options', 'nuntius' ), 'edit_theme_options', 'theme_options', 'nuntius_theme_options_do_page' );
}

// Return an array of all categories (so that the user can pick one to feature on the news template)
function nuntius_primary_news_category() {
	$primary_category = get_categories();

	return apply_filters( 'nuntius_primary_news_category', $primary_category );
}

/**
 * Returns the default options for Nuntius.
 */
function nuntius_get_default_theme_options() {
	$default_theme_options = array(
		'primary_category' => '1',
		'accent_color' => '#890000',
		'link_color'   => '#dd7a05',
		);

	return apply_filters( 'nuntius_default_theme_options', $default_theme_options );
}

/**
 * Returns the options array for Nuntius.
 */
function nuntius_get_theme_options() {
	return get_option( 'nuntius_theme_options', nuntius_get_default_theme_options() );
}

// Create the options page
function nuntius_theme_options_do_page() {

	if ( ! isset( $_REQUEST['settings-updated'] ) )
		$_REQUEST['settings-updated'] = false;

	?>
	<div class="wrap">
		<?php screen_icon(); echo "<h2>" . get_current_theme() . __( ' Theme Options', 'nuntius' ) . "</h2>"; ?>

		<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
		<div class="updated fade"><p><strong><?php _e( 'Options saved', 'nuntius' ); ?></strong></p></div>
		<?php endif; ?>

		<form method="post" action="options.php">
			<?php settings_fields( 'nuntius_options' ); ?>
			<?php $options = nuntius_get_theme_options(); ?>
			<?php $default_options = nuntius_get_default_theme_options(); ?>

			<table class="form-table">

				<?php // Nuntius Accent Color - Used as the background color for the header and main menu ?>
				<tr valign="top"><th scope="row"><?php _e( 'Select a background color for the header and main menu', 'nuntius' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Select a background color for the header and main menu', 'nuntius' ); ?></span></legend>
						<input type="text" id="nuntius_theme_options_accent_color" name="nuntius_theme_options[accent_color]" value="<?php echo esc_attr( $options['accent_color'] ); ?>" />
						<div id="colorpicker"></div>
						<span><?php printf( __( 'Default color: %s', 'nuntius' ), '<span id="default-color-accent">' . $default_options['accent_color'] . '</span>' ); ?></span>

						<script type="text/javascript">
						jQuery(document).ready(function() {
							jQuery( '#colorpicker' ).farbtastic( '#nuntius_theme_options_accent_color' );
						});
						</script>
						</fieldset>
					</td>
				</tr>

				<?php // Nuntius Link Color ?>
				<tr valign="top"><th scope="row"><?php _e( 'Select a link color', 'nuntius' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Select a link color', 'nuntius' ); ?></span></legend>
						<input type="text" id="link_color" name="nuntius_theme_options[link_color]" value="<?php echo esc_attr( $options['link_color'] ); ?>" />
						<div id="colorpicker2"></div>
						<span><?php printf( __( 'Default color: %s', 'nuntius' ), '<span id="default-color-link">' . $default_options['link_color'] . '</span>' ); ?></span>
						<script type="text/javascript">
						jQuery(document).ready(function() {
							jQuery( '#colorpicker2' ).farbtastic( '#link_color' );
						});
						</script>
						</fieldset>
					</td>
				</tr>

				<?php // Nuntius Featured Categories ?>
				<tr valign="top" id="nuntius-featured-categories"><th scope="row"><?php _e( 'Choose a primary featured category for posts on the News Page template', 'nuntius' ); ?></th>
					<td>
						<div class="category-container">
							<fieldset><legend class="screen-reader-text"><span><?php _e( 'Choose a primary featured category for posts on the News Page template', 'nuntius' ); ?></span></legend>
								<select id="nuntius_primary_category" name="nuntius_theme_options[primary_category]">
								<?php
									if ( ! isset( $selected ) )
										$selected = '';
									foreach ( nuntius_primary_news_category() as $option ) {
										$selected_option = $options['primary_category'];

										if ( '' != $selected_option ) {
											if ( $options['primary_category'] == $option->term_id ) {
												$selected = "selected=\"selected\"";
											} else {
												$selected = '';
											}
										}
										?>
										<option value="<?php echo $option->term_id; ?>" <?php echo $selected; ?> />
											<?php echo $option->name; ?>
										</option>
									<?php } ?>
								</select>
							</fieldset>
						</div>
					</td>
				</tr>
			</table>

			<p class="submit">
				<input type="submit" class="button-primary" value="<?php esc_attr_e( 'Save Options', 'nuntius' ); ?>" />
			</p>
		</form>
	</div>
	<?php
}

// Validate the input options.
function nuntius_theme_options_validate( $input ) {

	$output = $defaults = nuntius_get_default_theme_options();

	// Set the primary category ID to "1" if the input value is not in the array of categories.
	if ( array_key_exists( $input['primary_category'], nuntius_primary_news_category() ) ) :
		$options['primary_category'] = $input['primary_category'];
	else :
		$options['primary_category'] = 1;
	endif;

	// Color values must be either a 3- or 6-digit hexadecimal
	if ( isset( $input['accent_color'] ) && preg_match( '/^#?([a-f0-9]{3}){1,2}$/i', $input['accent_color'] ) )
		$output['accent_color'] = '#' . strtolower( ltrim( $input['accent_color'], '#' ) );

	if ( isset( $input['link_color'] ) && preg_match( '/^#?([a-f0-9]{3}){1,2}$/i', $input['link_color'] ) )
		$output['link_color'] = '#' . strtolower( ltrim( $input['link_color'], '#' ) );

	return $input;
}

// Let's print the color styles
function nuntius_print_color_style() {
	$options = nuntius_get_theme_options();
	$accent = $options['accent_color'];
	$link_color = $options['link_color']
?>
	<style type="text/css">
	/* <![CDATA[ */
		a,
		.breadcrumbs a,
		.post-meta a,
		#sidebar-primary a,
		#respond input[type="text"],
		#respond input[type="email"],
		#respond input[type="url"],
		.category-section .entry-title a,
		#more-articles .entry-title a,
		.archive .entry-title a,
		.search .entry-title a,
		.slideshow-controls .slideshow-pager a.activeSlide {
			color: <?php echo $link_color; ?>;
		}
		#header,
		#menu-primary {
			background-color: <?php echo $accent; ?>;
		}
	/* ]]> */
	</style>
<?php
}
add_action( 'wp_head', 'nuntius_print_color_style' );