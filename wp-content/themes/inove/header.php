<?php
/**
 * @package INove
 */
global $inove_nosidebar, $home_menu;
$options = get_option('inove_options');
if (is_home()) {
	$home_menu = 'current_page_item';
} else {
	$home_menu = 'page_item';
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php wp_title(); ?> <?php bloginfo('name'); ?></title>

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<?php if ( strtoupper( get_locale() ) == 'ZH_CN' || strtoupper( get_locale() ) == 'ZH_TW' ) : ?><link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/chinese.css" type="text/css" media="screen" /><?php endif; ?>

<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/base.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/menu.js"></script>

<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php if ( is_singular() ) {
	wp_enqueue_script( 'comment-reply' );
	wp_enqueue_script( 'jquery' );
	}
?>
<?php wp_head(); ?>
</head>
<?php flush(); ?>

<body <?php body_class( is_user_logged_in() ? 'loggedin' : '' ); ?>>
<!-- wrap START -->
<div id="wrap">
<?php do_action( 'before' ); ?>

<!-- container START -->
<div id="container" <?php if($options['nosidebar'] || $inove_nosidebar){echo 'class="one-column"';} ?> >

<!-- header START -->
<div id="header">

	<!-- banner START -->
	<?php if( $options['banner_content'] && (
		($options['banner_registered'] && $user_ID) ||
		($options['banner_commentator'] && !$user_ID && isset($_COOKIE['comment_author_'.COOKIEHASH])) ||
		($options['banner_visitor'] && !$user_ID && !isset($_COOKIE['comment_author_'.COOKIEHASH]))
	) ) : ?>
		<div class="banner">
			<?php echo($options['banner_content']); ?>
		</div>
	<?php endif; ?>
	<!-- banner END -->

	<div id="caption">
		<h1 id="title"><a href="<?php bloginfo('url'); ?>/"><?php bloginfo('name'); ?></a></h1>
		<div id="tagline"><?php bloginfo('description'); ?></div>
	</div>

	<div class="fixed"></div>
</div>
<!-- header END -->

<!-- navigation START -->
<div id="navigation">
	<!-- menus START -->
	<?php wp_nav_menu( array( 'container' => false, 'theme_location' => 'primary', 'menu_id' => 'menus', 'fallback_cb' => 'inove_page_menu' ) ); ?>
	<!-- menus END -->

	<!-- searchbox START -->
	<div id="searchbox">
		<form action="<?php bloginfo('url'); ?>" method="get">
			<div class="content">
				<input type="text" class="textfield" name="s" size="24" value="<?php the_search_query(); ?>" />
				<input type="submit" class="button" value="" />
			</div>
		</form>
	</div>
<script type="text/javascript">
//<![CDATA[
	var searchbox = MGJS.$("searchbox");
	var searchtxt = MGJS.getElementsByClassName("textfield", "input", searchbox)[0];
	var searchbtn = MGJS.getElementsByClassName("button", "input", searchbox)[0];
	var tiptext = "<?php _e('Type text to search here...', 'inove'); ?>";
	if(searchtxt.value == "" || searchtxt.value == tiptext) {
		searchtxt.className += " searchtip";
		searchtxt.value = tiptext;
	}
	searchtxt.onfocus = function(e) {
		if(searchtxt.value == tiptext) {
			searchtxt.value = "";
			searchtxt.className = searchtxt.className.replace(" searchtip", "");
		}
	}
	searchtxt.onblur = function(e) {
		if(searchtxt.value == "") {
			searchtxt.className += " searchtip";
			searchtxt.value = tiptext;
		}
	}
	searchbtn.onclick = function(e) {
		if(searchtxt.value == "" || searchtxt.value == tiptext) {
			return false;
		}
	}
//]]>
</script>
	<!-- searchbox END -->

	<div class="fixed"></div>
</div>
<!-- navigation END -->

<!-- content START -->
<div id="content">

	<!-- main START -->
	<div id="main">
