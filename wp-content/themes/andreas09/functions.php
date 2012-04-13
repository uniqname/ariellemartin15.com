<?php
/**
 * @package WordPress
 * @subpackage Andreas09
 */

add_filter( 'body_class', '__return_empty_array', 1 );

add_theme_support( 'automatic-feed-links' );

// Custom background
add_custom_background();

function andreas09_custom_background() {
	if ( '' != get_background_color() || '' != get_background_image() ) { ?>
		<style type="text/css">
			#container { background: none; }
		</style>
	<?php }
}
add_action( 'wp_head', 'andreas09_custom_background' );

register_sidebar(array('name' => 'Main Sidebar', 'id' => 'main-sidebar'));
register_sidebar(array('name' => 'Right Sidebar', 'id' => 'right-sidebar'));

// WP-Andreas09 Search Box
function widget_andreas09_search() {
?>
   <li><?php get_search_form(); ?></li>
<?php
}
wp_register_sidebar_widget('search', __('Search'), 'widget_andreas09_search');

// WP-Andreas09 Subscribe
function widget_andreas09_subscribe() {
?>
<li><h2><?php _e('Subscribe','andreas09'); ?></h2>
<ul>
<li class="feed"><a href="<?php bloginfo('rss2_url'); ?>"><?php _e('Entries (RSS)','andreas09'); ?></a></li>
<li class="feed"><a href="<?php bloginfo('comments_rss2_url'); ?>"><?php _e('Comments (RSS)','andreas09'); ?></a></li>
</ul>
</li>
<?php
}
wp_register_sidebar_widget('rss-subscribe', __('RSS Subscribe'), 'widget_andreas09_subscribe');

// WP-Andreas09 Recent Posts
function widget_andreas09_recent_entries() {
	$options = get_option('widget_recent_entries');
	if ( !$number = (int) $options['number'] )
		$number = 10;
        $title = empty($options['title']) ? __('Recent Posts') : apply_filters('widget_title', $options['title']);
?>
<li id="recent-posts"><h2><?php echo $title; ?></h2>
<ul>
<?php wp_get_archives('type=postbypost&limit=' . $number); ?>
</ul>
</li>
<?php
}
wp_register_sidebar_widget('andreas-recent-posts', __('Andreas09 Recent Posts'), 'widget_andreas09_recent_entries');

// WP-Andreas09 Colour Options
load_theme_textdomain('andreas09');

function wp_andreas09_add_theme_page() {

	if ( isset( $_GET['page'] ) && $_GET['page'] == basename(__FILE__) ) {
		if ( 'save' == $_REQUEST['action'] ) {
			update_option( 'wp_andreas09_ImageColour', $_REQUEST[ 'set_ImageColour' ] );
			header("Location: themes.php?page=functions.php&saved=true");
			die;
		} else if( 'reset' == $_REQUEST['action'] ) {
			delete_option( 'wp_andreas09_ImageColour' );
			header("Location: themes.php?page=functions.php&reset=true");
			die;
		}
	}

    add_theme_page(__('Theme Options','andreas09'), __('Theme Options','andreas09'), 'edit_theme_options', basename(__FILE__), 'wp_andreas09_theme_page');
}

function wp_andreas09_theme_page() {
	if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.__('Settings saved.','andreas09').'</strong></p></div>';
	if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.__('Settings reset.','andreas09').'</strong></p></div>';

?>

<div class="wrap">
<h1>WP-Andreas09</h1>
<p>WP-Andreas09 <?php _e('was designed by','andreas09'); ?> <a href="http://andreasviklund.com">Andreas Viklund</a> <?php _e('and Ported to WordPress by','andreas09'); ?> <a href="http://webgazette.co.uk">Ainslie Johnson</a>.</p>

<h3><?php _e('Available Image Colours:','andreas09'); ?></h3>
<style>
ul.horizontal {padding-top: 5px; padding-bottom: 5px; width: 90%;}
.horizontal li {list-style: none; padding: 5px 0 5px 10px; margin: 10px; border: 1px solid #000000; font-weight: bold;}
li.blue { background: url(<?php bloginfo('template_url'); ?>/images/bodybg-blue.jpg);}
li.green { background: url(<?php bloginfo('template_url'); ?>/images/bodybg-green.jpg);}
li.red { background: url(<?php bloginfo('template_url'); ?>/images/bodybg-red.jpg);}
li.orange { background: url(<?php bloginfo('template_url'); ?>/images/bodybg-orange.jpg);}
li.purple { background: url(<?php bloginfo('template_url'); ?>/images/bodybg-purple.jpg);}
li.black { background: url(<?php bloginfo('template_url'); ?>/images/bodybg-black.jpg);}
li.isecore { background: url(<?php bloginfo('template_url'); ?>/images/bodybg-isecore.jpg);}
li.pink { background: url(<?php bloginfo('template_url'); ?>/images/bodybg-pink.jpg);}
li.blue2 { background: url(<?php bloginfo('template_url'); ?>/images/bodybg-blue2.jpg);}
li.green2 { background: url(<?php bloginfo('template_url'); ?>/images/bodybg-green2.jpg);}
li.red2 { background: url(<?php bloginfo('template_url'); ?>/images/bodybg-red2.jpg);}
li.orange2 { background: url(<?php bloginfo('template_url'); ?>/images/bodybg-orange2.jpg);}
li.purple2 { background: url(<?php bloginfo('template_url'); ?>/images/bodybg-purple2.jpg);}
li.black2 { background: url(<?php bloginfo('template_url'); ?>/images/bodybg-black2.jpg);}
.center {text-align: center;}
</style>

<ul class="horizontal">
<li class="blue"><?php _e('Original Blue','andreas09') ?></li>
<li class="green"><?php _e('Original Green','andreas09') ?></li>
<li class="red"><?php _e('Original  Red','andreas09') ?></li>
<li class="orange"><?php _e('Original Orange','andreas09') ?></li>
<li class="purple"><?php _e('Original Purple','andreas09') ?></li>
<li class="black"><?php _e('Original Black','andreas09') ?></li>
<li class="isecore">Isecore <?php _e('Blue - Courtesy of','andreas09') ?> <a href="http://blog.isecore.net/">Isecore</a></li>
<li class="pink"><?php _e('Pretty Pink','andreas09') ?></li>
<li class="blue2"><?php _e('Striped Blue','andreas09') ?></li>
<li class="green2"><?php _e('Striped Green','andreas09') ?></li>
<li class="red2"><?php _e('Striped Red','andreas09') ?></li>
<li class="orange2"><?php _e('Striped Orange','andreas09') ?></li>
<li class="purple2"><?php _e('Striped Purple','andreas09') ?></li>
<li class="black2"><?php _e('Striped Black','andreas09') ?></li>
</ul>
<h3><?php _e('Image Colour Settings','andreas09') ?></h3>
<form method="post">
<p><?php _e('Select colour from list:','andreas09') ?>
<?php
	$value = get_settings( 'wp_andreas09_ImageColour' );
	    echo "<select name=\"set_ImageColour\" style=\"width:200px;\" onchange=\"updateColour( this )\">";
		wp_andreas09_input( "set_ImageColour", "option", __('Original Blue','andreas09'), "blue", $value );
		wp_andreas09_input( "set_ImageColour", "option", __('Original Green','andreas09'), "green", $value );
		wp_andreas09_input( "set_ImageColour", "option", __('Original Red','andreas09'), "red", $value );
		wp_andreas09_input( "set_ImageColour", "option", __('Original Orange','andreas09'), "orange", $value );
		wp_andreas09_input( "set_ImageColour", "option", __('Original Purple','andreas09'), "purple", $value );
		wp_andreas09_input( "set_ImageColour", "option", __('Original Black','andreas09'), "black", $value );
		wp_andreas09_input( "set_ImageColour", "option", __('Isecore Blue','andreas09'), "isecore", $value );
		wp_andreas09_input( "set_ImageColour", "option", __('Pretty Pink','andreas09'), "pink", $value );
		wp_andreas09_input( "set_ImageColour", "option", __('Striped Blue','andreas09'), "blue2", $value );
		wp_andreas09_input( "set_ImageColour", "option", __('Striped Green','andreas09'), "green2", $value );
		wp_andreas09_input( "set_ImageColour", "option", __('Striped Red','andreas09'), "red2", $value );
		wp_andreas09_input( "set_ImageColour", "option", __('Striped Orange','andreas09'), "orange2", $value );
		wp_andreas09_input( "set_ImageColour", "option", __('Striped Purple','andreas09'), "purple2", $value );
		wp_andreas09_input( "set_ImageColour", "option", __('Striped Black','andreas09'), "black2", $value );
		echo "</select>";
?>
</p>

<!-- Save Settings Button -->
<?php wp_andreas09_input( "save", "submit", "", __('Save Settings','andreas09') ); ?>
<input type="hidden" name="action" value="save" />
</form>
<p class="center"><?php _e('With credit to','andreas09'); ?> <a href="http://www.binarymoon.co.uk/" title="Binary Moon - games, web design, and other random nonsense">Ben Gillbanks</a>. <?php _e('I could not have implemented the <strong>Current Theme Options</strong> without his excellent example in the','andreas09'); ?> <a href="http://www.binarymoon.co.uk/regulus/" title="Regulus theme for WordPress">Regulus</a></p>

</div>

<?php
}

add_action('admin_menu', 'wp_andreas09_add_theme_page');

function wp_andreas09_input( $var, $type, $description = "", $value = "", $selected="" ) {
 	echo "\n";
	switch( $type ){
		case "submit":
	 		echo "<p class=\"submit\"><input name=\"$var\" type=\"$type\" value=\"$value\" /></p>";
			break;

		case "option":
			if( $selected == $value ) { $extra = "selected=\"true\""; }
			echo "<option value=\"$value\" $extra >$description</option>";
		    break;
 	}
}

/*
Plugin Name: PageNav
Plugin URI: http://www.adsworth.info/wp-pagesnav
Description: Header Navigation.
Author: Adi Sieker
Version: 0.0.1
Author URI: http://www.adsworth.info/
*/
/*  Copyright 2004  Adi J. Sieker  (email : adi@adsworth.info)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

function wp_andreas09_nav($args = '') {
    global $wp_query;
	parse_str($args, $r);
	if (!isset($r['current']))          $r['current'] = -1;
	if (!isset($r['show_all_parents'])) $r['show_all_parents'] = 0;
	if (!isset($r['show_root']))        $r['show_root'] = 0;
	if (!isset($r['list_tag']))        $r['show_root'] = 1;

    if($r['current'] == "")
        return;

    if($r['current'] == -1 && $wp_query->is_page == true) {
        $r['current'] = $wp_query->post->ID;
    }

    if($r['current'] == -1 && $r['show_root'] != 0) {
        $r['current'] = 0;
    }

	// Query pages.
	$pages = get_pages($args);
	if ( $pages ) {
    	// Now loop over all pages that were selected
    	$page_tree = Array();
    	$parent_page_id = null;
    	$parents= Array();
    	foreach($pages as $page) {
    		// set the title for the current page
    		$page_tree[$page->ID]['title'] = $page->post_title;
    		$page_tree[$page->ID]['parent'] = $page->post_parent;

    		// set the selected date for the current page
    		// depending on the query arguments this is either
    		// the createtion date or the modification date
    		// as a unix timestamp. It will also always be in the
    		// ts field.
    		if (! empty($r['show_date'])) {
    			if ('modified' == $r['show_date'])
    				$page_tree[$page->ID]['ts'] = $page->time_modified;
    			else
    				$page_tree[$page->ID]['ts'] = $page->time_created;
    		}

    		// The tricky bit!!
    		// Using the parent ID of the current page as the
    		// array index we set the curent page as a child of that page.
    		// We can now start looping over the $page_tree array
    		// with any ID which will output the page links from that ID downwards.
    		$page_tree[$page->post_parent]['children'][] = $page->ID;
            if( $r['current'] == $page->ID) {
                if($page->post_parent != 0 || $r['show_root'] == true)
                    $parents[] = $page->post_parent;
            }

    	}

    	$len = count($parents);
    	for($i = 0; $i < $len ; $i++) {
    	    $parent_page_id = $parents[$i];
    	    $parent_page = $page_tree[$parent_page_id];

    	    if(isset($parent_page['parent']) && !in_array($parent_page['parent'], $parents)) {
    	        if($parent_page['parent'] != 0 || $r['show_root'] == true) {
        	        $parents[] = $parent_page['parent'];
        	        $len += 1;
        	        if( $len >= 2 && $r['show_all_parents'] == 0) {
        	            break;
        	        }

        	    }
    	    }
        }

        $parents = array_reverse($parents);

        $level = 0;
        $parent_out == false;
        foreach( $parents as $parent_page_id ) {
            $level += 1;
      		$css_class = 'level' . $level;
      		if( $r['list_tag'] == true || $parent_out == true)
	        	echo "<ul class='". $css_class . "'>";
            foreach( $page_tree[$parent_page_id]['children'] as $page_id) {
        		$cur_page = $page_tree[$page_id];
        		$title = $cur_page['title'];

                $css_class = '';
        		if( $page_id == $r['current']) {
        			$css_class .= ' current';
  	      		}
				if( $page_id == $page_tree[$r['current']]['parent']){
					$css_class .= 'currentparent';
				}
                echo "<li class='" . $css_class . "' ><a href='" . get_page_link($page_id) . "' title='" . esc_attr($title) . "'>" . $title . "</a></li>\n";
            }

	        	echo "</ul>";

	        $parent_out = true;

        }

    	if( is_array($page_tree[$r['current']]['children']) === true ) {
            $level += 1;
      		$css_class = 'level' . $level;
      		if( $r['list_tag'] == true || $parent_out == true)
		       	echo "<ul class='". $css_class . " children'>";
            foreach( $page_tree[$r['current']]['children'] as $page_id) {
        		$cur_page = $page_tree[$page_id];
        		$title = $cur_page['title'];

                echo "<li class='" . $css_class . "'><a href='" . get_page_link($page_id) . "' title='" . esc_attr($title) . "'>" . $title . "</a></li>\n";
            }

	        	echo "</ul>";

        }
     }
}

// Header navigation menu
register_nav_menus( array(
	'primary' => __( 'Primary Navigation', 'andreas09' )
) );

// Fallback for primary navigation
function andreas09_page_menu() { ?>
	<ul class="level1">
		<li<?php if ( is_front_page() ) echo ' class="current_page_item"'; ?>><a href="<?php echo home_url( '/' ); ?>"><?php _e( 'Home', 'andreas09' ); ?></a></li>
		<?php wp_list_pages( 'depth=1&title_li=' ); ?>
	</ul>
<?php }

function andreas09_callback($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);
?>
	<li <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
	<div class="comment-author vcard">
	<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['avatar_size'] ); ?>
	<h3 class="commenttitle"><cite class="fn"><?php comment_author_link(); ?></cite> <span class="says"><?php _e('said','almost-spring'); ?></span></h3>
	</div>
<?php if ($comment->comment_approved == '0') : ?>
	<em><?php _e('Your comment is awaiting moderation.','andreas09'); ?></em>
	<br />
<?php endif; ?>

	<small class="comment-meta commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ) ?>">
	<?php comment_date() ?> <?php _e('at','andreas09'); ?> <?php comment_time() ?></a> <?php edit_comment_link('e','',''); ?></small>

	<?php comment_text(); ?>

	<div class="reply">
	<?php comment_reply_link(array_merge( $args, array('add_below' => 'comment', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
	</div>
<?php
}

function andreas09_comment_form_defaults( $args ) {
	$args['title_reply'] = __( 'Leave a Comment', 'andreas09' );
	return $args;
}

add_filter( 'comment_form_defaults', 'andreas09_comment_form_defaults' );

/**
 * Set the default theme colors based on the current color scheme
 */
$color_scheme = get_settings( 'wp_andreas09_ImageColour' );

switch ( $color_scheme ) {
	case 'green':
		$themecolors = array(
			'bg' => 'fafcff',
			'border' => 'f0f1f3',
			'text' => '2a2a2a',
			'link' => '09b910',
			'url' => '808080',
		);
		break;

	case 'red':
		$themecolors = array(
			'bg' => 'fafcff',
			'border' => 'f0f1f3',
			'text' => '2a2a2a',
			'link' => 'c0090e',
			'url' => '808080',
		);
		break;

	case 'orange':
		$themecolors = array(
			'bg' => 'fafcff',
			'border' => 'f0f1f3',
			'text' => '2a2a2a',
			'link' => 'c9740a',
			'url' => '808080',
		);
		break;

	case 'purple':
		$themecolors = array(
			'bg' => 'fafcff',
			'border' => 'f0f1f3',
			'text' => '2a2a2a',
			'link' => '890abb',
			'url' => '808080',
		);
		break;

	case 'black':
		$themecolors = array(
			'bg' => 'fafcff',
			'border' => 'f0f1f3',
			'text' => '2a2a2a',
			'link' => '5c5c5c',
			'url' => '808080',
		);
		break;

	case 'isecore':
		$themecolors = array(
			'bg' => 'fafcff',
			'border' => 'f0f1f3',
			'text' => '2a2a2a',
			'link' => '536d88',
			'url' => '808080',
		);
		break;

	case 'pink':
		$themecolors = array(
			'bg' => 'fafcff',
			'border' => 'f0f1f3',
			'text' => '2a2a2a',
			'link' => 'd964bf',
			'url' => '808080',
		);
		break;

	case 'blue2':
		$themecolors = array(
			'bg' => 'fafcff',
			'border' => 'f0f1f3',
			'text' => '2a2a2a',
			'link' => '0b6d90',
			'url' => '808080',
		);
		break;

	case 'green2':
		$themecolors = array(
			'bg' => 'fafcff',
			'border' => 'f0f1f3',
			'text' => '2a2a2a',
			'link' => '1d8807',
			'url' => '808080',
		);
		break;

	case 'red2':
		$themecolors = array(
			'bg' => 'fafcff',
			'border' => 'f0f1f3',
			'text' => '2a2a2a',
			'link' => '940c0e',
			'url' => '808080',
		);
		break;

	case 'orange2':
		$themecolors = array(
			'bg' => 'fafcff',
			'border' => 'f0f1f3',
			'text' => '2a2a2a',
			'link' => 'ce750d',
			'url' => '808080',
		);
		break;

	case 'purple2':
		$themecolors = array(
			'bg' => 'fafcff',
			'border' => 'f0f1f3',
			'text' => '2a2a2a',
			'link' => '6c0c91',
			'url' => '808080',
		);
		break;

	case 'black2':
		$themecolors = array(
			'bg' => 'fafcff',
			'border' => 'f0f1f3',
			'text' => '2a2a2a',
			'link' => '4e4e4e',
			'url' => '808080',
		);
		break;

	case 'blue':
		$themecolors = array(
			'bg' => 'fafcff',
			'border' => 'f0f1f3',
			'text' => '2a2a2a',
			'link' => '0a8fbc',
			'url' => '808080',
		);
		break;
}