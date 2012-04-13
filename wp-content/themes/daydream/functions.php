<?php
/**
 * @package WordPress
 * @subpackage Day Dream
 */

$themecolors = array(
	'bg' => 'ffffff',
	'text' => '222222',
	'link' => '006699',
	'border' => 'CCCCCC',
	'url' => '0099CC',
);

$content_width = 426;

add_filter( 'body_class', '__return_empty_array', 1 );

add_theme_support( 'automatic-feed-links' );

add_custom_background();

if ( function_exists('register_sidebar') )
    register_sidebar();

define('HEADER_TEXTCOLOR', 'ffffff');

define('HEADER_IMAGE_WIDTH', 527);
define('HEADER_IMAGE_HEIGHT', 273);

if (get_theme_mod('dd_colour_scheme') == "Green")
	define('HEADER_IMAGE', '%s/images/header_green.jpg'); // %s is theme dir uri

if (get_theme_mod('dd_colour_scheme') == "Pink")
	define('HEADER_IMAGE', '%s/images/header_pink.jpg'); // %s is theme dir uri

if (get_theme_mod('dd_colour_scheme', 'Blue') == "Blue")
	define('HEADER_IMAGE', '%s/images/header_blue.jpg'); // %s is theme dir uri

if (get_theme_mod('dd_colour_scheme') == "Grey")
	define('HEADER_IMAGE', '%s/images/matt-bus-grey.jpg'); // %s is theme dir uri

function daydream_admin_header_style() {
?>
<style type="text/css">
#headimg {
	height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
	width: <?php echo HEADER_IMAGE_WIDTH; ?>px;
}
#headimg h1 {
padding: 160px 20px 0 20px;
margin: 0;
font-size: 44px;
font-weight: normal;
}

#headimg h1 a {
	color:#<?php header_textcolor() ?>;
	border: none;
	font-family: Georgia, "Lucida Sans Unicode", lucida, Verdana, sans-serif;
	font-weight: normal;
	letter-spacing: 1px;
	text-decoration: none;
}
#headimg #desc {
font-family: Georgia, "Lucida Sans Unicode", lucida, Verdana, sans-serif;
margin: 0 35px 0 35px;
color: #<?php header_textcolor() ?>;
font-size: 17px;
}

#headimg h1, #desc {
	text-align: left;
}

<?php if (get_theme_mod('dd_title') == "centre") { ?>

#headimg h1, #desc { text-align: center; }

<?php } else if (get_theme_mod('dd_title') == "right") { ?>

#headimg h1, #desc { text-align: right; }

<?php } ?>

<?php if ( 'blank' == get_header_textcolor() ) { ?>
#headerimg h1, #headerimg #desc {
	display: none;
}
#headimg h1 a, #headimg #desc {
	color:#<?php echo HEADER_TEXTCOLOR ?>;
}
<?php } ?>

</style>
<?php
}

add_custom_image_header('', 'daydream_admin_header_style');

function dd_add_admin() {

	if ( isset( $_POST['dd_action'] ) && 'save' == $_POST['dd_action'] ) {
		// Update Options
		$dd_colour_scheme = preg_replace( '|[^a-z]|i', '', esc_attr($_POST['dd_colour_scheme']) );
		$dd_title = preg_replace( '|[^a-z]|i', '', esc_attr($_POST['dd_title']) );
		set_theme_mod('dd_colour_scheme', $dd_colour_scheme );
		set_theme_mod('dd_title', $dd_title );
	}

	add_theme_page( __( 'Theme Options' ), __( 'Theme Options' ), 'edit_theme_options', 'theme_options', 'dd_admin' );
}

function dd_admin() {
?>

<div class="wrap">
<h2><?php _e('Theme Options'); ?></h2>

	<form id='dd_options' method="post">
			<h3><?php _e('Title'); ?></h3>

				<p>
					<input type="radio" name="dd_title" value="left" <?php if (get_theme_mod('dd_title') == "left") { echo "checked='checked'"; } ?> /> Left Align (default)<br />
					<input type="radio" name="dd_title" value="centre" <?php if (get_theme_mod('dd_title') == "centre") { echo "checked='checked'"; } ?> /> Centre<br />
					<input type="radio" name="dd_title" value="right" <?php if (get_option('dd_title') == "right") { echo "checked='checked'"; } ?> /> Right Align<br />
</p>

		<h3>Colour Schemes</h3>

			<p>
				<label><input type="radio" name="dd_colour_scheme" value="Blue" <?php if (get_theme_mod('dd_colour_scheme', 'Blue') == "Blue") { echo "checked='checked'"; } ?> /> Blue <img src="<?php bloginfo('template_directory'); ?>/images/option_blue.jpg" alt="Blue" /></label>

				<label><input type="radio" name="dd_colour_scheme" value="Green" <?php if (get_theme_mod('dd_colour_scheme') == "Green") { echo "checked='checked'"; } ?> /> Green <img src="<?php bloginfo('template_directory'); ?>/images/option_green.jpg" alt="Green" /></label>
				</p>

				<p>
				<label><input type="radio" name="dd_colour_scheme" value="Pink" <?php if (get_theme_mod('dd_colour_scheme') == "Pink") { echo "checked='checked'"; } ?> /> Pink <img src="<?php bloginfo('template_directory'); ?>/images/option_pink.jpg" alt="Pink" /></label>

				<label><input type="radio" name="dd_colour_scheme" value="Grey" <?php if (get_theme_mod('dd_colour_scheme') == "Grey") { echo "checked='checked'"; } ?> /> Grey <img src="<?php bloginfo('template_directory'); ?>/images/option_grey.jpg" alt="Grey" /></label>
				</p>
		<input type="hidden" name="dd_action" value="save" />
	<p class="submit" style="clear: both"><input name="save" id="save" type="submit" value="<?php esc_attr_e( 'Save Options &raquo;', 'daydream' ); ?>" /></p>
	</form>

</div>
<?php
}

function dd_admin_header() { ?>
<style media="screen" type="text/css">
form#dd_options label {
	width: 140px;
	display: block;
	float: left;
}
</style>
<?php }

add_action('admin_head', 'dd_admin_header');
add_action('admin_menu', 'dd_add_admin');

	/*
	Plugin Name: Nice Categories
	Plugin URI: http://txfx.net/2004/07/22/wordpress-conversational-categories/
	Description: Displays the categories conversationally, like: Category1, Category2 and Category3
	Version: 1.5.1
	Author: Mark Jaquith
	Author URI: http://txfx.net/
	*/

	function get_the_nice_category($normal_separator = ', ', $penultimate_separator = ' and ') {
		$categories = get_the_category();

		  if (empty($categories)) {
			_e('Uncategorized');
			return;
		}

		$thelist = '';
			$i = 1;
			$n = count($categories);
			foreach ($categories as $category) {
				$category->cat_name = $category->cat_name;
					if (1 < $i && $i != $n) $thelist .= $normal_separator;
					if (1 < $i && $i == $n) $thelist .= $penultimate_separator;
				$thelist .= '<a href="' . get_category_link($category->cat_ID) . '" title="' . sprintf(__("View all posts in %s"), $category->cat_name) . '">'.$category->cat_name.'</a>';
						 ++$i;
			}
		return apply_filters('the_category', $thelist, $normal_separator);
	}

// Navigation menu
register_nav_menus( array(
	'primary' => __( 'Primary Navigation', 'daydream' )
) );

// Fallback for primary navigation
function daydream_page_menu() { ?>
	<ul id="nav" class="menu">
		<li><a href="<?php echo home_url( '/' ); ?>"><?php _e( 'Home', 'daydream' );?></a></li>
		<?php wp_list_pages( 'sort_column=menu_order&depth=1&title_li=' ); ?>
	</ul>
<?php }

function daydream_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);
?>
<li <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
	<div id="div-comment-<?php comment_ID() ?>">
	<?php if ($comment->comment_approved == '0') : ?>
	<p class="await_mod"><?php _e('Your comment is awaiting moderation.','daydream'); ?></p>
	<?php endif; ?>

	<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['avatar_size'] ); ?>

	<?php comment_text(); ?>

	<div class="comment-author vcard cmntmeta comment-meta commentmetadata"><span class="fn"><?php comment_author_link() ?></span> - <?php comment_date() ?> <?php _e('at','daydream'); ?> <?php comment_time() ?></a> <?php edit_comment_link('e','',''); ?></div>

	<div class="reply">
		<?php comment_reply_link(array_merge( $args, array('add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
	</div>
	</div>
<?php
}
