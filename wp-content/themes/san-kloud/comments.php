<?php
/**
 * @package San Kloud
 */

global $sankloud;
?>
			<div id="comments">
<?php if ( post_password_required() ) : ?>
				<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'san-kloud' ); ?></p>
			</div><!-- #comments -->
<?php
		/* Stop the rest of comments.php from being processed,
		 * but don't kill the script entirely -- we still have
		 * to fully load the template.
		 */
		return;
	endif;
?>

<?php
	// You can start editing here -- including this comment!
?>

<?php if ( have_comments() ): ?>
			<h3 id="comments-title"><?php echo get_comments_number(); ?> <?php _e( 'Comment(s)', 'san-kloud' ); ?></h3>

<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			<div class="navigation">
				<div class="left"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments', 'san-kloud' ) ); ?></div>
				<div class="right"><?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>', 'san-kloud' ) ); ?></div>
			</div> <!-- .navigation -->
<?php endif; // check for comment navigation ?>

			<ol class="commentlist">
				<?php
					wp_list_comments( array( 'callback' => array( &$sankloud, 'comment_walker' ) ) );
				?>
			</ol>

<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			<div class="navigation">
				<div class="left"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments', 'san-kloud' ) ); ?></div>
				<div class="right"><?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>', 'san-kloud' ) ); ?></div>
			</div><!-- .navigation -->
<?php endif; // check for comment navigation ?>

<?php else : // or, if we don't have comments:

	/* If there are no comments and comments are closed,
	 * let's leave a little note, shall we?
	 */
	if ( !comments_open() && ! is_page() ):
?>

<?php endif; // end ! comments_open(); ?>

<?php endif; // end have_comments(); ?>

<?php comment_form(); ?>

</div><!-- #comments -->
