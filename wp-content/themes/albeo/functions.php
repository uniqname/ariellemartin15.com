<?php
/**
 * @package WordPress
 * @subpackage Albeo
 */

$content_width = 480;

$themecolors = array(
	'bg' => 'ffffff',
	'text' => '666666',
	'link' => '4779AC',
	'border' => 'F8F8F2',
	'url' => 'BBD1D8'
);

add_filter( 'body_class', '__return_empty_array', 1 );

add_theme_support( 'automatic-feed-links' );

// Custom background
add_custom_background();

function albeo_custom_background() {
	if ( '' != get_background_color() || '' != get_background_image() ) { ?>
		<style type="text/css">
			.header { background-image: none; }
		<?php if ( '' != get_background_color() && '' == get_background_image() ) { ?>
			body { background-image: none; }
		<?php } ?>
		</style>
	<?php }
}
add_action( 'wp_head', 'albeo_custom_background' );

if ( function_exists('register_sidebar') )
    register_sidebar(array(
        'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-all">',
        'after_widget' => '</div></div>',
        'before_title' => '<h3 class="widgettitle">',
        'after_title' => '</h3>',
    ));

function dp_recent_comments($no_comments = 10, $comment_len = 150) {
    global $wpdb;

	$request = "SELECT * FROM $wpdb->comments";
	$request .= " JOIN $wpdb->posts ON ID = comment_post_ID";
	$request .= " WHERE comment_approved = '1' AND post_status = 'publish' AND post_password =''";
	$request .= " ORDER BY comment_date DESC LIMIT $no_comments";

	$comments = $wpdb->get_results($request);

	if ($comments) {
		foreach ($comments as $comment) {
			ob_start();
			?>
				<li>
					<a href="<?php echo get_permalink( $comment->comment_post_ID ) . '#comment-' . $comment->comment_ID; ?>"><?php echo dp_get_author($comment); ?>:</a>
					<?php echo strip_tags(substr(apply_filters('get_comment_text', $comment->comment_content), 0, $comment_len)); ?>
				</li>
			<?php
			ob_end_flush();
		}
	} else {
		echo '<li>'.__('No comments yet', 'albeo').'</li>';
	}
}

function dp_get_author($comment) {
	$author = "";

	if ( empty($comment->comment_author) )
		$author = __('Anonymous', 'albeo');
	else
		$author = $comment->comment_author;

	return $author;
}

// Widgets!!!

wp_register_sidebar_widget( 'albeo-top-tags',  __('Albeo Top/Latest/Tags', 'albeo') , 'albeo_selector' );
function albeo_selector() { ?>
	<div class="recent-all"><div class="recent">
	 <ul class="tabs">
<?php if (function_exists('display_top_posts')): ?>
	  <li><a href="#r-posts"><span><?php _e('Top Posts', 'albeo'); ?></span></a></li>
<?php endif; ?>
	  <li><a href="#r-com"><span><?php _e('Latest Comments', 'albeo'); ?></span></a></li>
	  <li><a href="#r-tags"><span><?php _e('Tags', 'albeo'); ?></span></a></li>
	 </ul>
	 <br clear="all" />
<?php if (function_exists('display_top_posts')): ?>
	<div id="r-posts">
		<?php display_top_posts(10); ?>
	</div>
<?php endif; ?>
	<ul id="r-com">
	 <?php dp_recent_comments(3); ?>
	</ul>
	<div id="r-tags">
	 <?php wp_tag_cloud(''); ?>
	</div>
	</div></div>
<?php }

wp_register_sidebar_widget( 'albeo-search', __('Albeo Search', 'albeo') , 'albeo_search' );
function albeo_search() { ?>
	<div class="search-all"><div class="search">
	 <h3><?php _e('Search', 'albeo'); ?></h3>
	  <form id="search" action="<?php bloginfo('url'); ?>/">
	    <fieldset>
	    <input type="text" value="<?php the_search_query(); ?>" name="s" style="width: 200px;" />
	    </fieldset>
	    </form>
	</div></div>
<?php }

register_nav_menus( array(
	'primary' => __( 'Primary Navigation' ),
) );

function albeo_page_menu() { // fallback for primary navigation ?>
<ul>
	<li<?php if ( is_front_page() ) echo ' class="current_page_item"'; ?>><a href="<?php echo home_url( '/' ); ?>"><span><?php _e( 'Home', 'albeo' ); ?></span></a></li>
	<?php $pages = wp_list_pages( 'sort_column=menu_order&title_li=&echo=0&depth=1' );
	$pages = preg_replace( '%<a ([^>]+)>%U','<a $1><span>', $pages );
	$pages = str_replace( '</a>','</span></a>', $pages );
	echo $pages; ?>
</ul>
	<?php unset( $pages );
}

function albeo_comment_start( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	extract( $args, EXTR_SKIP );
	?>

	<div <?php comment_class( 'com-entry' ); ?> id="comment-<?php comment_ID(); ?>">
	<div class="com-entry-bot">
		<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/com-top.png" width="100%" height="10" />
		<div class="com-con">
			<p class="commentmetadata">
				<?php if ( $args['avatar_size'] != 0 ) echo '<span class="avatar">'.get_avatar( $comment, $args['avatar_size'] ).'</span>'; ?>
				<span class="com-name"><?php if ( 0 == $comment->comment_parent || !get_option( 'thread_comments' ) ) { global $commentNumber; $commentNumber++; echo $commentNumber; ?> | <?php } comment_author_link(); ?></span><br />
				<span class="com-date"><a href="#comment-<?php comment_ID() ?>"><?php comment_date() ?> <?php _e( 'at', 'albeo' ); ?> <?php comment_time() ?></a>  <?php edit_comment_link( __( 'edit', 'albeo' ), '|&nbsp;', '' ); ?></span>
			</p>

			<?php if ( $comment->comment_approved == '0' ) : ?>
				<p><em><?php _e( 'Your comment is awaiting moderation.', 'albeo' ); ?></em></p>
			<?php endif; ?>
			<?php comment_text(); ?>
			<div class="reply" id="comment-reply-<?php comment_ID(); ?>">
			<?php comment_reply_link( array_merge( $args, array( 'add_below' => 'comment-reply', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div>
<?php }

function albeo_comment_end() { ?>
		</div>
		<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/com-bot.png" width="100%" height="10" />
	</div>
	</div>
<?php
}