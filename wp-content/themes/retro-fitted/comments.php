<?php
/**
 * Comments Template
 *
 * Lists comments and calls the comment form.  Individual comments have their own templates.  The
 * hierarchy for these templates is $comment_type.php, comment.php.
 *
 * @package Retro-fitted
 * @subpackage Template
 */

if ( post_password_required() )
	return;

?>

<div id="comments-template">

	<div class="comments-wrap">

		<div id="comments">

			<?php if ( have_comments() ) : ?>

				<h3 id="comments-number" class="comments-header"><?php comments_number( __( 'No Responses', 'retro-fitted' ), __( 'One Response', 'retro-fitted' ), __( '% Responses', 'retro-fitted' ) ); ?></h3>

				<ol class="comment-list">
					<?php wp_list_comments( array(
						'style'        => 'ol',
						'type'         => 'all',
						'avatar_size'  => 80,
						'callback'     => 'retro_fitted_comments_callback',
					) ); ?>
				</ol><!-- .comment-list -->

			<?php endif; ?>

		</div><!-- #comments -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
			<nav id="nav-comments" class="paged-navigation contain">
				<h1 class="assistive-text"><?php _e( 'Comments navigation', 'retro-fitted' ); ?></h1>
				<div class="nav-older"><?php previous_comments_link(); ?></div>
				<div class="nav-newer"><?php next_comments_link(); ?></div>
			</nav>
		<?php endif; ?>

		<?php comment_form(); // Loads the comment form. ?>

	</div><!-- .comments-wrap -->

</div><!-- #comments-template -->