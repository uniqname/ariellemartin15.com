<?php
/**
 * @package INove
 */

$themecolors = array(
	'bg' => 'ffffff',
	'border' => 'eeeeee',
	'text' => '555555',
	'link' => '2970A6',
	'url' => 'c8c7c7'
);
$content_width = 600;

function inove_body_class( $classes, $class ) {
	return $class;
}

add_filter( 'body_class', 'inove_body_class', 1, 2 );

add_theme_support( 'automatic-feed-links' );

// Custom background
add_custom_background();

function inove_custom_background() {
	if ( '' != get_background_color() || '' != get_background_image() ) { ?>
		<style type="text/css">
			#wrap { background-image: none; }
		<?php if ( '' != get_background_color() && '' == get_background_image() ) { ?>
			body { background-image: none; }
		<?php } ?>
		</style>
	<?php }
}
add_action( 'wp_head', 'inove_custom_background' );

$options = iNoveOptions::getOptions();
if($options['nosidebar'] != false) $content_width = 901;

/** inove options */
class iNoveOptions {

	function getOptions() {
		$options = get_option('inove_options');
		if (!is_array($options)) {
			$options['menu_type'] = 'pages';
			$options['nosidebar'] = false;
			$options['notice'] = false;
			$options['notice_content'] = '';
			$options['banner_registered'] = false;
			$options['banner_commentator'] = false;
			$options['banner_visitor'] = false;
			$options['banner_content'] = '';
			$options['showcase_registered'] = false;
			$options['showcase_commentator'] = false;
			$options['showcase_visitor'] = false;
			$options['showcase_caption'] = false;
			$options['showcase_title'] = '';
			$options['showcase_content'] = '';
			$options['author'] = true;
			$options['categories'] = true;
			$options['tags'] = true;
			$options['ctrlentry'] = false;
			$options['feed_readers'] = true;
			$options['twitter'] = false;
			$options['twitter_username'] = '';
			update_option('inove_options', $options);
		}
		return $options;
	}

	function add() {
		if(isset($_POST['inove_save'])) {
			global $allowedposttags;

			$options = iNoveOptions::getOptions();

			// menu
			$options['menu_type'] = stripslashes($_POST['menu_type']);

			// sidebar
			if ($_POST['nosidebar']) {
				$options['nosidebar'] = (bool)true;
			} else {
				$options['nosidebar'] = (bool)false;
			}

			// notice
			if ($_POST['notice']) {
				$options['notice'] = (bool)true;
			} else {
				$options['notice'] = (bool)false;
			}
			$options['notice_content'] = wp_kses(stripslashes($_POST['notice_content']), $allowedposttags);

			// banner
			if (!$_POST['banner_registered']) {
				$options['banner_registered'] = (bool)false;
			} else {
				$options['banner_registered'] = (bool)true;
			}
			if (!$_POST['banner_commentator']) {
				$options['banner_commentator'] = (bool)false;
			} else {
				$options['banner_commentator'] = (bool)true;
			}
			if (!$_POST['banner_visitor']) {
				$options['banner_visitor'] = (bool)false;
			} else {
				$options['banner_visitor'] = (bool)true;
			}
			$options['banner_content'] =  wp_kses(stripslashes($_POST['banner_content']), $allowedposttags);

			// showcase
			if (!$_POST['showcase_registered']) {
				$options['showcase_registered'] = (bool)false;
			} else {
				$options['showcase_registered'] = (bool)true;
			}
			if (!$_POST['showcase_commentator']) {
				$options['showcase_commentator'] = (bool)false;
			} else {
				$options['showcase_commentator'] = (bool)true;
			}
			if (!$_POST['showcase_visitor']) {
				$options['showcase_visitor'] = (bool)false;
			} else {
				$options['showcase_visitor'] = (bool)true;
			}
			if ($_POST['showcase_caption']) {
				$options['showcase_caption'] = (bool)true;
			} else {
				$options['showcase_caption'] = (bool)false;
			}
			$options['showcase_title'] = wp_kses(stripslashes($_POST['showcase_title']), $allowedposttags);
			$options['showcase_content'] = wp_kses(stripslashes($_POST['showcase_content']), $allowedposttags);

			// author & categories & tags
			if ($_POST['author']) {
				$options['author'] = (bool)true;
			} else {
				$options['author'] = (bool)false;
			}
			if ($_POST['categories']) {
				$options['categories'] = (bool)true;
			} else {
				$options['categories'] = (bool)false;
			}
			if (!$_POST['tags']) {
				$options['tags'] = (bool)false;
			} else {
				$options['tags'] = (bool)true;
			}

			// ctrl + entry
			if ($_POST['ctrlentry']) {
				$options['ctrlentry'] = (bool)true;
			} else {
				$options['ctrlentry'] = (bool)false;
			}

			// feed
			if (!$_POST['feed_readers']) {
				$options['feed_readers'] = (bool)false;
			} else {
				$options['feed_readers'] = (bool)true;
			}

			// twitter
			if ($_POST['twitter']) {
				$options['twitter'] = (bool)true;
			} else {
				$options['twitter'] = (bool)false;
			}
			$options['twitter_username'] = wp_kses(stripslashes($_POST['twitter_username']), '');

			update_option('inove_options', $options);

		} else {
			iNoveOptions::getOptions();
		}

		add_theme_page(__('Theme Options', 'inove'), __('Theme Options', 'inove'), 'edit_theme_options', basename(__FILE__), array('iNoveOptions', 'display'));
	}

	function display() {
		$options = iNoveOptions::getOptions();
?>

<form action="#" method="post" enctype="multipart/form-data" name="inove_form" id="inove_form">
	<div class="wrap">
		<h2><?php _e('iNove Theme Options', 'inove'); ?></h2>

		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row"><?php _e('Menubar', 'inove'); ?></th>
					<td>
						<label style="margin-right:20px;">
							<input name="menu_type" type="radio" value="pages" <?php if($options['menu_type'] != 'categories') echo "checked='checked'"; ?> />
							 <?php _e('Show pages as menu.', 'inove'); ?>
						</label>
						<label>
							<input name="menu_type" type="radio" value="categories" <?php if($options['menu_type'] == 'categories') echo "checked='checked'"; ?> />
							 <?php _e('Show categories as menu.', 'inove'); ?>
						</label>
					</td>
				</tr>
			</tbody>
		</table>

		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row"><?php _e('Sidebar', 'inove'); ?></th>
					<td>
						<label>
							<input name="nosidebar" type="checkbox" value="checkbox" <?php if($options['nosidebar']) echo "checked='checked'"; ?> />
							 <?php _e('Hide sidebar from all pages.', 'inove'); ?>
						</label>
					</td>
				</tr>
			</tbody>
		</table>

		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row">
						<?php _e('Notice', 'inove'); ?>
						<br/>
						<small style="font-weight:normal;"><?php _e('HTML enabled', 'inove'); ?></small>
					</th>
					<td>
						<!-- notice START -->
						<label>
							<input name="notice" type="checkbox" value="checkbox" <?php if($options['notice']) echo "checked='checked'"; ?> />
							 <?php _e('This notice bar will display at the top of posts on homepage.', 'inove'); ?>
						</label>
						<br />
						<label>
							<textarea name="notice_content" id="notice_content" cols="50" rows="10" style="width:98%;font-size:12px;" class="code"><?php echo( esc_textarea( $options['notice_content'] ) ); ?></textarea>
						</label>
						<!-- notice END -->
					</td>
				</tr>
			</tbody>
		</table>

		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row">
						<?php _e('Banner', 'inove'); ?>
						<br/>
						<small style="font-weight:normal;"><?php _e('HTML enabled', 'inove'); ?></small>
					</th>
					<td>
						<!-- banner START -->
						<?php _e('This banner will display at the right of header. (height: 60 pixels)', 'inove'); ?>
						<br/>
						<?php _e('Who can see?', 'inove'); ?>
						<label style="margin-left:10px;">
							<input name="banner_registered" type="checkbox" value="checkbox" <?php if($options['banner_registered']) echo "checked='checked'"; ?> />
							 <?php _e('Registered Users', 'inove'); ?>
						</label>
						<label style="margin-left:10px;">
							<input name="banner_commentator" type="checkbox" value="checkbox" <?php if($options['banner_commentator']) echo "checked='checked'"; ?> />
							 <?php _e('Commentator', 'inove'); ?>
						</label>
						<label style="margin-left:10px;">
							<input name="banner_visitor" type="checkbox" value="checkbox" <?php if($options['banner_visitor']) echo "checked='checked'"; ?> />
							 <?php _e('Visitors', 'inove'); ?>
						</label>
						<br/>
						<label>
							<textarea name="banner_content" id="banner_content" cols="50" rows="10" style="width:98%;font-size:12px;" class="code"><?php echo( esc_textarea( $options['banner_content'] ) ); ?></textarea>
						</label>
						<!-- banner END -->
					</td>
				</tr>
			</tbody>
		</table>

		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row">
						<?php _e('Showcase', 'inove'); ?>
						<br/>
						<small style="font-weight:normal;"><?php _e('HTML enabled', 'inove'); ?></small>
					</th>
					<td>
						<!-- showcase START -->
						<?php _e('This showcase will display at the top of sidebar.', 'inove'); ?>
						<br/>
						<?php _e('Who can see?', 'inove'); ?>
						<label style="margin-left:10px;">
							<input name="showcase_registered" type="checkbox" value="checkbox" <?php if($options['showcase_registered']) echo "checked='checked'"; ?> />
							 <?php _e('Registered Users', 'inove'); ?>
						</label>
						<label style="margin-left:10px;">
							<input name="showcase_commentator" type="checkbox" value="checkbox" <?php if($options['showcase_commentator']) echo "checked='checked'"; ?> />
							 <?php _e('Commentator', 'inove'); ?>
						</label>
						<label style="margin-left:10px;">
							<input name="showcase_visitor" type="checkbox" value="checkbox" <?php if($options['showcase_visitor']) echo "checked='checked'"; ?> />
							 <?php _e('Visitors', 'inove'); ?>
						</label>
						<br/>
						<label>
							<input name="showcase_caption" type="checkbox" value="checkbox" <?php if($options['showcase_caption']) echo "checked='checked'"; ?> />
							 <?php _e('Title:', 'inove'); ?>
						</label>
						 <input type="text" name="showcase_title" id="showcase_title" class="code" size="40" value="<?php echo($options['showcase_title']); ?>" />
						<br/>
						<label>
							<textarea name="showcase_content" id="showcase_content" cols="50" rows="10" style="width:98%;font-size:12px;" class="code"><?php echo( esc_textarea( $options['showcase_content'] ) ); ?></textarea>
						</label>
						<!-- showcase END -->
					</td>
				</tr>
			</tbody>
		</table>

		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row"><?php _e('Posts', 'inove'); ?></th>
					<td>
						<label style="margin-right:20px;">
							<input name="author" type="checkbox" value="checkbox" <?php if($options['author']) echo "checked='checked'"; ?> />
							 <?php _e('Show author on posts.', 'inove'); ?>
						</label>
						<label style="margin-right:20px;">
							<input name="categories" type="checkbox" value="checkbox" <?php if($options['categories']) echo "checked='checked'"; ?> />
							 <?php _e('Show categories on posts.', 'inove'); ?>
						</label>
						<label>
							<input name="tags" type="checkbox" value="checkbox" <?php if($options['tags']) echo "checked='checked'"; ?> />
							 <?php _e('Show tags on posts.', 'inove'); ?>
						</label>
					</td>
				</tr>
			</tbody>
		</table>

		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row"><?php _e('Comments', 'inove'); ?></th>
					<td>
						<label>
							<input name="ctrlentry" type="checkbox" value="checkbox" <?php if($options['ctrlentry']) echo "checked='checked'"; ?> />
							 <?php _e('Submit comments with Ctrl+Enter.', 'inove'); ?>
						</label>
					</td>
				</tr>
			</tbody>
		</table>

		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row"><?php _e('Feed', 'inove'); ?></th>
					<td>
						<label>
							<input name="feed_readers" type="checkbox" value="checkbox" <?php if($options['feed_readers']) echo "checked='checked'"; ?> />
							 <?php _e('Show the feed reader list when mouse over on feed button.', 'inove'); ?>
						</label>
					</td>
				</tr>
			</tbody>
		</table>

		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row"><?php _e('Twitter', 'inove'); ?></th>
					<td>
						<label>
							<input name="twitter" type="checkbox" value="checkbox" <?php if($options['twitter']) echo "checked='checked'"; ?> />
							 <?php _e('Add Twitter button.', 'inove'); ?>
						</label>
						<br />
						 <?php _e('Twitter username:', 'inove'); ?>
						 <input type="text" name="twitter_username" id="twitter_username" class="code" size="40" value="<?php echo($options['twitter_username']); ?>">
					</td>
				</tr>
			</tbody>
		</table>


		<p class="submit">
			<input class="button-primary" type="submit" name="inove_save" value="<?php esc_attr_e( 'Save Changes', 'inove' ); ?>" />
		</p>
	</div>
</form>

<?php
	}
}

// register functions
add_action('admin_menu', array('iNoveOptions', 'add'));


/** l10n */
/*
function theme_init(){
	load_theme_textdomain('inove', get_template_directory() . '/languages');
}
add_action ('init', 'theme_init');
*/

/** widgets */
register_sidebar(array(
	'name' => 'Sidebar',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<h3>',
	'after_title' => '</h3>'
));

register_nav_menus( array(
	'primary' => __( 'Primary Navigation' ),
) );

function inove_home_link( $menuitems, $args ) {
	// inove needs a cool home link
	$homemenu = '<li><a class="home" href="' . home_url( '/' ) . '" title="Home">Home</a></li>';

	// but only in the primary menu--we don't want it showing up in widgets
	if ( $args->theme_location == 'primary' ) {
		$menuitems = $homemenu . $menuitems;
	}

	return $menuitems;
}

add_filter( 'wp_nav_menu_items', 'inove_home_link', 10, 2 );

function inove_page_menu() { // fallback for primary navigation
	global $home_menu;
?>
<ul id="menus">
	<li class="<?php echo( $home_menu ); ?>"><a class="home" title="<?php esc_attr_e( 'Home', 'inove' ); ?>" href="<?php echo home_url( '/' ); ?>"><?php _e( 'Home', 'inove' ); ?></a></li>
	<?php
		global $inove_nosidebar;
		$options = get_option('inove_options');

		if( $options['menu_type'] == 'categories' ) {
			wp_list_categories( 'title_li=0&orderby=name&show_count=0' );
		} else {
			wp_list_pages( 'title_li=0&sort_column=menu_order' );
		}
	?>
	<li><a class="lastmenu" href="javascript:void(0);"></a></li>
</ul>

<?php }

/** Comments */
// comment count
function comment_count( $commentcount ) {
	global $id;
	$_commnets = get_comments('status=approve&post_id=' . $id);
	$comments_by_type = &separate_comments($_commnets);
	return count($comments_by_type['comment']);
}

// custom comments
function custom_comments($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	global $commentcount;
	if(!$commentcount) {
		$commentcount = 0;
	}
?>
	<li <?php comment_class( get_the_author_email() == $comment->comment_author_email ? 'admincomment' : 'regularcomment' ); ?> id="comment-<?php comment_ID() ?>">
		<div class="author">
			<div class="pic">
				<?php echo get_avatar($comment, 32); ?>
			</div>
			<div class="name">
				<?php if (get_comment_author_url()) : ?>
					<a id="commentauthor-<?php comment_ID() ?>" class="url" href="<?php comment_author_url() ?>" rel="external nofollow"><?php comment_author(); ?></a>
				<?php else : ?>
					<span id="commentauthor-<?php comment_ID() ?>"><?php comment_author(); ?></span>
				<?php endif; ?>
			</div>
		</div>

		<div class="info">
			<div class="date">
				<?php printf( __('%1$s at %2$s', 'inove'), get_comment_time(get_option('date_format')), get_comment_time(get_option('time_format')) ); ?>
					 | <a href="#comment-<?php comment_ID() ?>"><?php printf('#%1$s', ++$commentcount); ?></a>
			</div>
			<div class="act">
				<?php echo comment_reply_link(array('depth' => $depth, 'max_depth' => $args['max_depth'], 'after' => ' | ')); ?>
				<a href="javascript:void(0);" onclick="MGJS_CMT.quote('commentauthor-<?php comment_ID() ?>', 'comment-<?php comment_ID() ?>', 'commentbody-<?php comment_ID() ?>', 'comment');"><?php _e('Quote', 'inove'); ?></a>
				<?php edit_comment_link(__('Edit', 'inove'), ' | ', ''); ?>
			</div>
			<div class="fixed"></div>
			<div class="content">
				<?php if ($comment->comment_approved == '0') : ?>
					<p><small><?php _e('Your comment is awaiting moderation.', 'inove'); ?></small></p>
				<?php endif; ?>

				<div id="commentbody-<?php comment_ID() ?>">
					<?php comment_text(); ?>
				</div>
			</div>
		</div>
		<div class="fixed"></div>
	</li>
<?php
}
?>
