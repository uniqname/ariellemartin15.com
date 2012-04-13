<?php
/**
 * @package San Kloud
 */

/**
*
* San Kloud
*
* This is our base class which defines all the theme options, settings,
* behavior, sidebars, etc. The class is initialized into a global
* $sankloud object upon after_setup_theme (see bottom of class).
*
*/

// Set the content width, for videos and photos for defaults
if ( ! isset( $content_width ) )
	$content_width = 540;

// Set default theme colors
if ( ! isset( $themecolors ) ) {

	$themecolors = array(
		'bg' => 'd8e8e7',
		'text' => '000000',
		'link' => '3d4b4e',
		'border' => 'CCCCCC',
		'url' => '99AA88',
	);

}

class San_Kloud {
	var $options = array();
	var $defaults = array();

	/*
	* Constructor
	*
	* Fired at Wordpress after_setup_theme (see add_action at the end
	* of the class), registers the theme capabilities, navigation menus,
	* as well as the set of actions and filters used by San Kloud.
	*
	* $this->options is used to store all the theme options, while
	* $this->defaults holds their default values.
	*
	*/
	function __construct() {

		// Load San Kloud text domain
		load_theme_textdomain( 'san-kloud', get_template_directory() . '/languages' );

		// Default options, lower-level ones are added during first run

		$this->defaults = array(
			'color-scheme' => 'default'
		);

		// Enables support for custom backgrounds
		add_custom_background();

		// Theme supports
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'custom-header', array( 'random-default' => true ) );
		add_theme_support( 'post-formats', array( 'aside', 'link', 'gallery', 'status', 'quote', 'image', 'chat', 'video', 'audio' ) );

		// Load options
		$this->load_options();

		// Register our primary navigation (top left) and 404 page links
		add_theme_support( 'nav_menus' );
		register_nav_menu( 'primary', __( 'Primary Navigation Menu', 'san-kloud' ) );

		/*
		* Actions
		*
		* Registers sidebars for widgets, registers admin settings, adds the menu options,
		* color scheme preview scripts (sidebar), custom header
		*
		*/

		add_action( 'widgets_init', array( &$this, 'register_sidebars' ) );
		add_action( 'admin_init', array( &$this, 'register_admin_settings' ) );
		add_action( 'admin_menu', array( &$this, 'add_admin_options' ) );
		add_action( 'wp_enqueue_scripts', array( &$this, 'color_scheme_scripts' ) );
		add_action( 'admin_print_styles-appearance_page_theme-options', array( &$this, 'admin_styles' ) );
		add_action( 'after_setup_theme',  array( &$this, 'san_kloud_custom_header_setup' ), 11 );

	}

	/*
	* Load Options
	*
	* Fired during theme setup, loads all the options into $options
	* array accessible from all other functions.
	* @uses get_option()
	*/
	function load_options(){
		$this->options = (array) get_option( 'sankloud-options', $this->defaults );
	}

	/*
	* Register Sidebars
	*
	* Registers a single right sidebar ready for widgets.
	*
	*/
	function register_sidebars() {
		register_sidebar( array(
			'name'          => __( 'Sidebar', 'san-kloud' ),
			'id'            => 'sidebar-1',
			'description'   => 'Main sidebar displayed on every page',
			'before_widget' => '<div class="widget %1s %2s">',
			'after_widget' => '</div>',
			'before_title' => '<h3>',
			'after_title' => '</h3>',
		) );
	}

	/*
	* Valid Color Schemes
	*
	* This function returns an array of available color schemes, where
	* an array key is the value used in the database and the HTML layout,
	* and value is used for captions. The function is used for theme settins
	* page as well as options validation. Default is blue.
	*
	*/
	function get_valid_color_schemes() {
		$color_schemes = array(
			'default' => array(
				'name' => __( 'Default', 'san-kloud' ),
				'preview' => get_template_directory_uri() . '/colors/default/preview.png'
			),
			'orange' => array(
				'name' => __( 'Orange', 'san-kloud' ),
				'preview' => get_template_directory_uri() . '/colors/orange/preview.png'
			),
			'green' => array(
				'name' => __( 'Green', 'san-kloud' ),
				'preview' => get_template_directory_uri() . '/colors/green/preview.png'
			)
		);

		return apply_filters( 'sankloud_color_schemes', $color_schemes );
	}

	/*
	* Color Schemes Head
	*
	* Enqueue any scripts or style necessary to display the chosen color
	* scheme. This is passed through an action too for child themes.
	*
	*/
	function color_scheme_scripts() {

		if ( isset( $this->options['color-scheme'] ) ) {
			if ( $this->options['color-scheme'] == 'default' ) {
				wp_enqueue_style( 'sankloud-default', get_template_directory_uri() . '/colors/default/default.css', array(), null );
			} elseif ( $this->options['color-scheme'] == 'orange' ) {
				wp_enqueue_style( 'sankloud-orange', get_template_directory_uri() . '/colors/orange/orange.css', array(), null );
			} elseif ( $this->options['color-scheme'] == 'green' ) {
				wp_enqueue_style( 'sankloud-green', get_template_directory_uri() . '/colors/green/green.css', array(), null );
			}

			do_action( 'sankloud_enqueue_color_scheme', $this->options['color-scheme'] );
		} else {
			wp_enqueue_style( 'default', get_template_directory_uri() . '/colors/default/default.css', array(), null );
		}

		wp_register_style( 'sankloud-fonts', 'http://fonts.googleapis.com/css?family=Hammersmith+One|Kreon:300,700|Arvo:700' );
		wp_enqueue_style( 'sankloud-fonts' );

		wp_enqueue_style( 'style', get_stylesheet_uri() );

	}


	/*
	* Register Settings
	*
	* Fired during admin_init, this function registers the settings used
	* in the Theme options section, as well as attaches a validator to
	* clean up the icoming data.
	*
	*/
	function register_admin_settings() {
		register_setting( 'sankloud-options', 'sankloud-options', array( &$this, 'validate_options' ) );

		// Settings fields and sections
		add_settings_section( 'section_general', ' ', '__return_null', 'sankloud-options' ); //Theme only has one section, therefore $callback is null
		add_settings_field( 'color-scheme', __( 'Color Scheme', 'san-kloud' ), array( &$this, 'setting_color_scheme' ), 'sankloud-options', 'section_general' );
	}

	/*
	* Options Validation
	*
	* This function is used to validate the incoming options, mostly from
	* the Theme Options admin page.
	*
	*/
	function validate_options($options) {
		// Theme options.
		$options['color-scheme'] = array_key_exists( $options['color-scheme'], $this->get_valid_color_schemes() ) ? $options['color-scheme'] : 'default';

		return $options;
	}

	/*
	* Add Menu Options
	*
	* Registers a Theme Options page that appears under the Appearance
	* menu in the WordPress dashboard. Uses the theme_options to render
	* the page contents, requires edit_theme_options capabilities.
	*
	*/
	function add_admin_options() {
		add_theme_page( __( 'Theme Options', 'san-kloud' ), __( 'Theme Options', 'san-kloud' ), 'edit_theme_options', 'theme-options', array( &$this, 'theme_options' ) );
	}

	/*
	* Comment walker
	*
	* This is used in the comments template, does the comments rendering.
	* Taken from Twenty Ten and localized. Nothing much here.
	*
	*/
	function comment_walker($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment;
		switch ($comment->comment_type):
			case'':
		?>
		<li <?php comment_class(); ?>>
			<div class="comment-wrapper" id="comment-<?php comment_ID(); ?>">
				<div class="comment-body">
					<p class="comment-author-name">
						<?php echo get_comment_author_link(); ?>
					</p>

					<p class="comment-author-meta">
						<?php echo get_avatar( $comment, 40 ); ?>
						<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
							<?php
								/* translators: 1: date, 2:time*/
								printf( __( '%1$s at %2$s', 'san-kloud' ), get_comment_date(), get_comment_time() );
							?>
						</a>
						<?php edit_comment_link( __( '(Edit)', 'san-kloud' ), ' ' );?>
					</p>

					<?php if($comment->comment_approved == '0' ): ?>
						<em><?php _e( 'Your comment is awaiting moderation.', 'san-kloud' ); ?></em>
					<?php endif; ?>
					<div class="comment-body-text"><?php comment_text(); ?></div>
					<div class="reply">
						<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
					</div><!-- .reply -->
					<br class="clear" />
				</div>
				<div class="reply-wrapper"></div>
				<br class="clear" />
			</div><!-- #comment-## -->
		<!--</li>-->

		<?php
				break;
			case 'pingback':
			case 'trackback':
		?>
		<li class="post pingpack">
			<p><?php _e( 'Pingback:', 'san-kloud' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'san-kloud' ), ' ' ); ?></p>
		</li>
		<?php
				break;
		endswitch;
	}

	/*
	* Theme Options
	*
	* This is the function that renders the Theme Options page under
	* the Appearence menu in the admin section.
	*
	* The rest is handled by Settings API and some HTML magic.
	*
	*/
	function theme_options() {
	?>
		<div class="wrap">
			<div id="icon-themes" class="icon32"><br></div>
			<h2><?php _e( 'San Kloud Options', 'san-kloud' ); ?></h2>
			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php wp_nonce_field( 'update-options' ); ?>
				<?php settings_fields( 'sankloud-options' ); ?>
				<?php do_settings_sections( 'sankloud-options' ); ?>
				<p class="submit">
					<input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes', 'san-kloud' ); ?>" />
				</p >
			</form>
		</div>
		<?php
	}

	/*
	* Settings: Admin Styles
	*/
	function admin_styles() {
		wp_register_style( 'san_kloud_admin_styles', get_template_directory_uri() . '/css/admin.css' );
		wp_enqueue_style( 'san_kloud_admin_styles' );
	}

	/*
	* Settings: Color Scheme
	*
	* Outputs a select box with available color schemes for the Theme
	* Options page, as well as sets the selected color scheme as defined
	* in $options.
	*
	*/
	function setting_color_scheme() {
	?>
		<?php
			$color_schemes = $this->get_valid_color_schemes();
			foreach ( $color_schemes as $value => $scheme ):
		?>
		<div class="sc-color-scheme-item">
			<input <?php checked( $value == $this->options['color-scheme'] ); ?> type="radio" name="sankloud-options[color-scheme]" id="sankloud-color-scheme-<?php echo $value; ?>" value="<?php echo $value; ?>" />
			<label for="sankloud-color-scheme-<?php echo $value; ?>" class="sc-color-scheme-label">
				<img src="<?php echo $scheme['preview']; ?>" /><br />
				<span class="description"><?php echo $scheme['name']; ?></span>
			</label>
		</div>
		<?php
			endforeach;
		?>
		<br class="clear" />
		<span class="description"><?php _e( 'Browse to your home page to see the new color scheme in action.', 'san-kloud' ); ?></span>
		<?php
	}

	/*
	* Custom Header Support
	*/
	function san_kloud_custom_header_setup() {
		// The default header text color

		$options = $this->options;
		$color = $options['color-scheme'];

		if ( isset( $color ) ) {

			if ( 'green' == $color ) {
				$san_kloud_header_color = 'bc214a';
			}
			else if ( 'orange' == $color ) {
				$san_kloud_header_color = 'fd853e';
			}
			else {
				$san_kloud_header_color = 'f9984d';
			}

		}

		define( 'HEADER_TEXTCOLOR', $san_kloud_header_color );

		// By leaving empty, we allow for random image rotation.
		define( 'HEADER_IMAGE', '' );

		// The height and width of your custom header.
		// Add a filter to header_image_width and header_image_height to change these values.
		define( 'HEADER_IMAGE_WIDTH', apply_filters( 'header_image_width', 940 ) );
		define( 'HEADER_IMAGE_HEIGHT', apply_filters( 'header_image_height', 250 ) );

		// Add a way for the custom header to be styled in the admin panel that controls custom headers
		add_custom_image_header( array( &$this, 'san_kloud_header_style' ), array( &$this, 'san_kloud_admin_header_style' ), array( &$this, 'san_kloud_admin_header_image' ) );

	}

	/**
	 * Styles the header image and text displayed on the blog
	 *
	 *
	 */
	function san_kloud_header_style() {

		// If no custom options for text are set, let's bail
		// get_header_textcolor() options: HEADER_TEXTCOLOR is default, hide text (returns 'blank' ) or any hex value
		if ( HEADER_TEXTCOLOR == get_header_textcolor() )
			return;
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
			.site-title-wrapper {
				height: auto;
			}
		<?php
			// If the user has set a custom color for the text use that
			else :
		?>
			.site-title a,
			.site-description {
				color: #<?php echo get_header_textcolor(); ?> !important;
			}
		<?php endif; ?>
		</style>
		<?php
	}

	/**
	 * Styles the header image displayed on the Appearance > Header admin panel.
	 *
	 * Referenced via add_custom_image_header() in setup().
	 *
	 */
	function san_kloud_admin_header_style() {
		wp_register_style( 'sankloud-fonts', 'http://fonts.googleapis.com/css?family=Hammersmith+One|Kreon:300,700|Arvo:700' );
		wp_enqueue_style( 'sankloud-fonts' );
	?>
		<style type="text/css">
		.appearance_page_custom-header #headimg {
			border: none;
		}
		#headimg h1,
		#desc {
		}
		#headimg h1,
		#headimg h1 a {
			font-family: 'Arvo', Georgia, Times, serif;
			font-size: 50px;
			text-align: center;
			text-decoration: none;
			text-transform: uppercase;
			line-height: normal;
		}
		#desc {
			display: block;
			font-size: 20px;
			font-weight: 700;
			text-decoration: none;
			text-transform: none;
		}
		#headimg img {
			border-radius: 15px;
			margin: 0px auto;
			display: block;
		}
		</style>
	<?php
	}

	/**
	 * Custom header image markup displayed on the Appearance > Header admin panel.
	 *
	 * Referenced via add_custom_image_header() in setup().
	 *
	 */
	function san_kloud_admin_header_image() { ?>
		<div id="headimg">
			<?php
			if ( 'blank' == get_theme_mod( 'header_textcolor', HEADER_TEXTCOLOR ) || '' == get_theme_mod( 'header_textcolor', HEADER_TEXTCOLOR ) )
				$style = ' style="display:none;"';
			else
				$style = ' style="color:#' . get_theme_mod( 'header_textcolor', HEADER_TEXTCOLOR ) . ';"';
			?>
			<?php $header_image = get_header_image();
			if ( ! empty( $header_image ) ) : ?>
				<img src="<?php echo esc_url( $header_image ); ?>" alt="" />
			<?php endif; ?>
			<h1><a id="name"<?php echo $style; ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
			<div id="desc"<?php echo $style; ?>><?php bloginfo( 'description' ); ?></div>
		</div>
	<?php }

};

function create_sankloud_object () {
	global $sankloud;
	$sankloud = new San_Kloud();
}
// Initialize the above class after theme setup
add_action( 'after_setup_theme', 'create_sankloud_object' );