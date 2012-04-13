<?php
/**
 * @package San Kloud
 */
?>
<div id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="page-content">
		<?php if ( get_the_title() ): ?>
			<div class="page-title">
				<h2>
					<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'san-kloud' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
				</h2>
			</div>
			<?php the_excerpt(); ?>
			<?php if ( comments_open() || ( '0' != get_comments_number() && ! comments_open() ) ) : ?>
			<div class="comment-count">
				<?php comments_popup_link( "<span class='leave-reply'>" . __( 'Reply', 'san-kloud' ) . "</span>", __( '1 comment', 'san-kloud' ), __( '% comments', 'san-kloud' ) ); ?>
			</div>
			<?php endif; ?>
		<?php else : ?>
			<a class="no-header" href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'san-kloud' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
				<?php the_excerpt(); ?>
			</a>
			<?php if ( comments_open() || ( '0' != get_comments_number() && ! comments_open() ) ) : ?>
			<div class="comment-count">
				<?php comments_popup_link( "<span class='leave-reply'>" . __( 'Reply', 'san-kloud' ) . "</span>", __( '1 comment', 'san-kloud' ), __( '% comments', 'san-kloud' ) ); ?>
			</div>
			<?php endif; ?>
			<br class="clear" />
		<?php endif; ?>

		<br class="clear">
	</div>
	<div class="page-bottom">
	</div>
</div>