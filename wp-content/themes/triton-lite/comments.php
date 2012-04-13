<?php
/**
* @package Triton Lite
*/
?>

<div id="comments">

	<?php if ( post_password_required() ) : ?>

			<p class="nopassword">
				<?php _e( 'This post is password protected. Enter the password to view any comments.', 'triton-lite' ); ?>
			</p><!-- .nopassword -->
		</div><!-- #comments -->

	<?php return; endif; // post_password_required ?>

	<?php if ( have_comments() ) : ?>

		<h2 id="comments-title">
			<?php
				printf( _n( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'triton-lite' ),
				number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
			?>
		</h2><!-- #comments-title -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>

			<div id="comment-nav-above">
				<h1 class="assistive-text">
					<?php _e( 'Comment navigation', 'triton-lite' ); ?>
				</h1><!-- .assistive-text -->
				<div class="comment-nav-previous">
					<?php previous_comments_link( __( '&larr; Older Comments', 'triton-lite' ) ); ?>
				</div><!-- .nav-previous -->
				<div class="comment-nav-next">
					<?php next_comments_link( __( 'Newer Comments &rarr;', 'triton-lite' ) ); ?>
				</div><!-- .comment-nav-next -->
			</div><!-- #comment-nav-above -->

		<?php endif; // check for comment navigation ?>

			<ol class="commentlist">
				<?php wp_list_comments( array( 'callback' => 'triton_lite_comment' ) ); ?>
			</ol>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>

			<div id="comment-nav-below">
				<h1 class="assistive-text">
					<?php _e( 'Comment navigation', 'triton-lite' ); ?>
				</h1><!-- .assistive-text -->
				<div class="comment-nav-previous">
					<?php previous_comments_link( __( '&larr; Older Comments', 'triton-lite' ) ); ?>
				</div><!-- .nav-previous -->
				<div class="comment-nav-next">
					<?php next_comments_link( __( 'Newer Comments &rarr;', 'triton-lite' ) ); ?>
				</div><!-- .comment-nav-next -->
			</div><!-- #comment-nav-below -->

		<?php endif; // check for comment navigation ?>

	<?php endif; // have_comments() ?>

	<?php if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>

		<p class="nocomments">
			<?php _e( 'Comments are closed.', 'triton-lite' ); ?>
		</p><!-- .nocomments -->

	<?php endif; ?>

	<?php comment_form(); ?>

</div><!-- #comments -->