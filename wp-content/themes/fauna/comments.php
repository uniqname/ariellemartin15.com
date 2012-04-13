<?php // Do not delete these lines
	if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) {
		echo '<p class="nocomments">' . __( 'This post is password protected. Enter the password to view comments.', 'fauna' ) . '</p>';
		return;
	}
?>

<!-- You can start editing here. -->

<?php if ( $comments ) : ?>
<div class="box">

	<?php include (TEMPLATEPATH . '/template-trackbacks.php'); ?>

	<?php include (TEMPLATEPATH . '/template-comments.php'); ?>

        <div class="navigation">
                <div class="alignleft"><?php previous_comments_link() ?></div>
                <div class="alignright"><?php next_comments_link() ?></div>
        </div>
	<br class="clear" />
	<?php if ( !comments_open() ) : ?>
		<p><?php _e('Comments are not allowed at this time.'); ?></p>
	<?php endif; ?>

<?php else : // If there are no comments yet ?>

	<?php if ( comments_open() ) { ?><div class="box"><?php } ?>
	<?php /* <p><?php _e('No comments yet.'); ?></p> */ ?>

<?php endif; ?>

<?php if ( comments_open() ) : ?>

	<?php comment_form(); ?>

</div>

<?php else : // Comments are closed ?>
	<?php if ( $comments ) { ?></div><!--//.box--><?php } ?>
<?php endif; ?>
