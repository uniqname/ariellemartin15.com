<?php
/**
 * @package Duotone
 */

if ( ! isset( $content_width ) )
	$content_width = 315;

if ( ! defined( 'MIN_WIDTH' ) )
	define( 'MIN_WIDTH', 560 );

if ( ! defined( 'MAX_WIDTH' ) )
	define( 'MAX_WIDTH', 840 );

if ( ! function_exists( 'duotone_setup' ) ) {
	function duotone_setup() {
		require_once( get_template_directory() . '/inc/duotone.php' );
		Duotone::init();
		add_custom_background();
		add_theme_support( 'automatic-feed-links' );
		register_sidebar( array( 'name' => __( 'Sidebar', 'duotone' ) ) );

		add_image_size( 'duotone_archive', 75, 75, true );
		add_image_size( 'duotone_singular', 840, 0, true );

		register_nav_menus( array(
			'primary' => __( 'Primary Navigation', 'duotone' )
		) );
	}
}
add_action( 'after_setup_theme', 'duotone_setup' );

/**
 * Fallback for primary navigation menu.
 */
function duotone_page_menu() {
	$recent = get_posts( array(
		'numberposts' => 1,
	) );

	$year = date( 'Y' );

	if ( is_array( $recent ) ) {
		$last = array_shift( $recent );
		if ( isset( $last->post_date ) )
			$year = substr( $last->post_date, 0, 4 );
	}
?>
	<ul>
		<li><a href="<?php echo esc_url( get_year_link( $year ) ); ?>"><?php _e( 'archive', 'duotone' ); ?></a></li>
		<?php wp_list_pages( array(
			'title_li' => '',
		) ); ?>
	</ul>
<?php
}

function duotone_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	extract( $args, EXTR_SKIP );
?>
<li <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID(); ?>">
	<div id="div-comment-<?php comment_ID(); ?>">
		<div class="comment-author vcard">
		<div class="gravatar"><?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'] ); ?></div>
		<div class="comment-meta commentmetadata metadata">
			<a href="#comment-<?php comment_ID(); ?>" title=""><?php comment_date( 'j M Y' ); ?> at <?php comment_time(); ?></a>
			<cite class="fn"><?php comment_author_link(); ?></cite>
			<?php edit_comment_link( __( 'edit', 'duotone' ), '<br />', '' ); ?>
			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => 'reply', 'add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div>
		</div>
		</div>
		<div class="content">

			<?php if ($comment->comment_approved == '0') : ?>
			<p><em><?php _e( 'Your comment is awaiting moderation.', 'duotone' ); ?></em></p>
			<?php endif; ?>
			<?php comment_text(); ?>
		</div>
		<div class="clear"></div>
	</div>
<?php
}