<?php // Do not delete these lines
	$req = get_option('require_name_email'); // Checks if fields are required.

	if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die (__('Please do not load this page directly. Thanks!'));

	if ( post_password_required() ) {
		echo '<div><p class="nocomments">' . __('This post is password protected. Enter the password to view comments.')  . '</p></div>';
		return;
	}

	/* This variable is for alternating comment background */
	$oddcomment = 'alt';
?>

<!-- You can start editing here. -->

<?php if (have_comments()) : ?>
		<div class="title">
		<h2 id="comments"><?php _e('Responses'); ?></h2>
		</div>
		<ol class="commentlist">
		<?php wp_list_comments(array('callback' => 'oceanmist_comment')); ?>
		</ol>

		<div class="navigation">
			<div class="alignleft"><?php previous_comments_link() ?></div>
			<div class="alignright"><?php next_comments_link() ?></div>
		</div>
		<br />

<?php endif; ?>

<?php if (comments_open()) : ?>

<?php comment_form(); ?>

<?php endif; // if you delete this the sky will fall on your head ?>