<?php
/**
 * The template for displaying Comments.
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to nuntius_comment() which is
 * located in the functions.php file.
 *
 * @package Nuntius
 * @since Nuntius 1.0
 */
?>

<div id="comments-template">

	<div class="comments-wrap">

		<div id="comments">

		<?php if ( post_password_required() ) : ?>
			<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'nuntius' ); ?></p>
		</div><!-- #comments -->
			<?php
					/* Stop the rest of comments.php from being processed,
					 * but don't kill the script entirely -- we still have
					 * to fully load the template.
					 */
					return;
				endif;
			?>

			<?php if ( have_comments() ) : ?>

				<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
					<div id="comment-nav-above">
						<h1 class="assistive-text section-heading"><?php _e( 'Comment navigation', 'nuntius' ); ?></h1>
						<span class="nav-next"><?php next_comments_link( __( '&larr; Older Comments', 'nuntius' ) ); ?></span>
						<span class="nav-previous"><?php previous_comments_link( __( 'Newer Comments &rarr;', 'nuntius' ) ); ?></span>
					</div>
				<?php endif; // check for comment navigation ?>

				<h3 id="comments-number" class="comments-header">
					<?php
						printf( _n( 'One comment on &ldquo;%2$s&rdquo;', '%1$s comments on &ldquo;%2$s&rdquo;', get_comments_number(), 'nuntius' ),
							number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
					?>
				</h3>

				<ol class="commentlist">
					<?php
						/* Loop through and list the comments. Tell wp_list_comments()
						 * to use nuntius_comment() to format the comments.
						 * If you want to overload this in a child theme then you can
						 * define nuntius_comment() and that will be used instead.
						 * See nuntius_comment() in nuntius/functions.php for more.
						 */
						wp_list_comments( array( 'callback' => 'nuntius_comment' ) );
					?>
				</ol>

				<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
					<div id="comment-nav-below">
						<h1 class="assistive-text section-heading"><?php _e( 'Comment navigation', 'nuntius' ); ?></h1>
						<span class="nav-next"><?php next_comments_link( __( '&larr; Older Comments', 'nuntius' ) ); ?></span>
						<span class="nav-previous"><?php previous_comments_link( __( 'Newer Comments &rarr;', 'nuntius' ) ); ?></span>
					</div>
				<?php endif; // check for comment navigation ?>

			<?php endif; // have_comments() ?>

			<?php
				// If comments are closed and there are no comments, let's leave a little note, shall we?
				if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
			?>
				<p class="comments-closed"><?php _e( 'Comments are closed.', 'nuntius' ); ?></p>
			<?php endif; ?>

		</div><!-- #comments -->

		<?php comment_form(); // Load the comment form. ?>

	</div><!-- .comments-wrap -->
</div><!-- #comments-template -->