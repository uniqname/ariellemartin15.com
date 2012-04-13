<?php
/**
 * @package WordPress
 * @subpackage Toni
 */

$content_width = 500;

add_filter( 'body_class', '__return_empty_array', 1 );

if ( ! function_exists('get_option') )
	die("This isn't what you're looking for. Try <a href=\"/\" title=\"Site Root\">this</a>.");

function get_toni_colors() {
	return array(
		'Blue' => '',
		'Gray' => 'gray',
		'Green' => 'green',
		'Purple' => 'purple');
}

function get_toni_color() {
	$toni_color = get_option('toni_color');

	return clean_toni_color($toni_color);
}

function toni_color_select() {
	echo "<select id='toni_color' name='toni_color' size='4'>";
	$colors = get_toni_colors();
	$current_color = get_toni_color();
	foreach ( $colors as $name => $value ) {
		$selected = ($current_color == $value) ? " selected='selected'" : '';
		echo "<option value='$value'$selected>$name</option>";
	}
	echo "</select>\n";
}

function toni_color_radios() {
	$colors = get_toni_colors();
	$current_color = get_toni_color();
	$theme_uri = get_template_directory_uri();
	$i = 0;
	foreach ( $colors as $name => $value ) {
		$checked = ($current_color == $value) ? " checked='checked'" : '';
		$filename = "preview{$value}.jpg";
		echo "<tr valign='middle'><td align='right'><input type='radio' name='toni_color' id='toni_color_{$i}' value='{$value}'$checked /></td><td><label for='toni_color_{$i}'> <img align='middle' src='{$theme_uri}/{$filename}' alt='{$name} Color Sample' /> $name</label></td></tr>\n";
		++$i;
	}
}

function clean_toni_color($toni_color) {
	$toni_colors = get_toni_colors();
	if ( in_array($toni_color, $toni_colors) )
		return $toni_color;
	else
		return '';
}

function toni_color() {
	echo get_toni_color();
}

function toni_css() {
	$toni_color = get_toni_color();

	$url = get_bloginfo('stylesheet_url');

	if ( !empty($toni_color) )
		$url = str_replace('style.css', "style_{$toni_color}.css", $url);

	$url = apply_filters('bloginfo', $url, 'stylesheet_url');
	$url = convert_chars($url);
	echo $url;
}

add_action('admin_menu', 'toni_add_theme_page');

function toni_add_theme_page() {
	global $toni_message;
	if ( isset($_POST['action']) && 'toni_update' == $_POST['action'] ) {
		$color = clean_toni_color($_POST['toni_color']);
		update_option('toni_color', $color);

		$colors = array_flip(get_toni_colors());
		$Color = $colors[$color];
		$message = sprintf( __( "Color changed to %s" ), esc_html( $Color ) );
		$toni_message = "<div style=\"background-color: rgb(207, 235, 247);\" id=\"message\" class=\"updated fade\"><p><strong>$message</strong></p></div>";
	}

	add_theme_page("Theme Options", "Theme Options", 'edit_theme_options', basename(__FILE__), 'toni_theme_page');
}

function toni_theme_page() {
	global $toni_message;
	echo $toni_message;
?>
<div class="wrap">
 <h2>Select a Color</h2>

  <form method="post">
  <table class="optiontable"><tbody>
<?php toni_color_radios(); ?>
  <tr><td> </td><td align="left"><p class="submit left"><input type="submit" name="Submit" value="Apply Color &raquo;" /></p></td></tr>
  </tbody></table>
  <input type="hidden" name="action" value="toni_update" />
  </form>

</div>
<?php
}

if ( function_exists('register_sidebars') )
	register_sidebars(1);

add_theme_support( 'automatic-feed-links' );

/**
 * Set the default theme colors based on the current color scheme
 */
$color_scheme = get_toni_color();

switch ( $color_scheme ) {
	case 'gray':
		$themecolors = array(
			'bg' => 'ffffff',
			'border' => 'cccccc',
			'text' => '666666',
			'link' => '767676',
			'url' => '999999'
		);
		break;

	case 'green':
		$themecolors = array(
			'bg' => 'ffffff',
			'border' => 'e7fbc8',
			'text' => '666666',
			'link' => '728d49',
			'url' => '728d49'
		);
		break;

	case 'purple':
		$themecolors = array(
			'bg' => 'ffffff',
			'border' => 'e2c6e3',
			'text' => '666666',
			'link' => '996699',
			'url' => '996699'
		);
		break;

	default:
		$themecolors = array(
			'bg' => 'ffffff',
			'text' => '333333',
			'link' => '52759a',
			'border' => 'c0d3e2',
			'url' => '52759a',
		);
		break;
}

function toni_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);
?>
<li <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
	<div id="div-comment-<?php comment_ID() ?>" class="vcard">
	<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['avatar_size'] ); ?>
	<?php comment_text() ?>
	<p><cite><?php comment_type(__('Comment'), __('Trackback'), __('Pingback')); ?> <?php _e('by'); ?> <span class="fn"><?php comment_author_link() ?></span> &#8212; <?php comment_date() ?> @ <a href="#comment-<?php comment_ID() ?>"><?php comment_time() ?></a></cite> <?php edit_comment_link(__("Edit This"), ' |'); ?><?php comment_reply_link(array_merge( $args, array('add_below' => 'div-comment', 'before'=>'|', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?></p>
	</div>
<?php
}