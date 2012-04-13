<?php
/**
 * @package WordPress
 * @subpackage Manifest
 */
?>

<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
	<?php if ( is_sticky() ) : ?>
		<h5 class="post-date"><abbr class="published"><?php _e( 'Featured', 'manifest' ); ?></abbr></h5>
	<?php else : ?>
		<h5 class="post-date"><abbr class="published"><a href="<?php the_permalink(); ?>"><?php the_time( get_option( 'date_format' ) ); ?></a></abbr></h5>
	<?php endif; ?>
	<div class="post-content">
		<h3 class="entry-title">
			<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
		</h3>
		<?php if ( is_multi_author() ) : ?>
		<h4 class="vcard author">by <span class="fn"><?php the_author(); ?></span></h4>
		<?php endif; ?>

		<div class="entry-content">
			<?php the_content( __( 'Read the rest of this entry &raquo;', 'manifest' ) ); ?>
			<?php wp_link_pages( array( 'before' => '<p>' . __( 'Pages:', 'manifest' ), 'after' => '</p>' ) ); ?>
		</div>
	</div>
	<div class="post-meta">
		<div class="comments">
		<?php if ( comments_open() || ( '0' != get_comments_number() && ! comments_open() ) ) : ?>
			<?php comments_popup_link( __( 'Leave a comment', 'manifest' ), __( '1 comment', 'manifest' ), __( '% comments', 'manifest' ), '', __( 'Comments closed', 'manifest' ) ); ?>
		<?php endif; ?>
		</div>
	</div>
</div>