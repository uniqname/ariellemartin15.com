<?php
/**
 * @package Suburbia
 */
?>
<div id="comments">
	<?php if ( post_password_required() ) : ?>
		<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'suburbia' ); ?></p>
</div><!-- #comments -->
	<?php
			return;
		endif;
	?>

	<?php if ( have_comments() ) : ?>
		<h3 id="comments-title">
			<?php
				printf( _n( 'One Comment on &ldquo;%2$s&rdquo;', '%1$s Comments on &ldquo;%2$s&rdquo;', get_comments_number(), 'suburbia' ),
					number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
			?>
		</h3>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
		<div id="comment-nav-above" class="clear">
			<span class="nav-previous"><?php previous_comments_link( __( '&laquo; Older Comments', 'suburbia' ) ); ?></span>
			<span class="nav-next"><?php next_comments_link( __( 'Newer Comments &raquo;', 'suburbia' ) ); ?></span>
		</div>
		<?php endif; ?>

		<ol class="commentlist">
			<?php wp_list_comments( array( 'callback' => 'suburbia_comments' ) ); ?>
		</ol>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
		<div id="comment-nav-below" class="clear">
			<span class="nav-previous"><?php previous_comments_link( __( '&laquo; Older Comments', 'suburbia' ) ); ?></span>
			<span class="nav-next"><?php next_comments_link( __( 'Newer Comments &raquo;', 'suburbia' ) ); ?></span>
		</div>
		<?php endif; ?>

	<?php endif; // have_comments() ?>

	<?php
		if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="nocomments"><?php _e( 'Comments are closed.', 'suburbia' ); ?></p>
	<?php endif; ?>

	<?php comment_form(); ?>

</div><!-- #comments -->