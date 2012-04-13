<?php
/*
 * @package San Kloud
 *
 */
?>

<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="post-top">
		<div class="post-format-icon"></div>
	</div>

	<div class="post-middle">

		<div class="single-post-title">
			<?php if ( get_the_title() ): ?>
				<h2>
					<?php the_title(); ?>
				</h2>
				<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'san-kloud' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><span class="post-date"><?php echo the_date(); ?></span></a>
			<?php else: ?>
				<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'san-kloud' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><span class="post-date no-title"><?php echo the_date(); ?></span></a>
			<?php endif; ?>
		</div>
		<div class="post-content">
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'san-kloud' ) ); ?>
			<br class="clear" />
			<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'san-kloud' ) . '</span>', 'after' => '</div>' ) ); ?>
			<p class="post-meta">
				<?php _e( 'Posted by', 'san-kloud' ); ?> <?php the_author_posts_link(); ?> <?php _e( 'in', 'san-kloud' ); ?> <?php the_category( ', ' ); ?> <?php the_tags( __( 'Tags: ', 'san-kloud ' ), ', ', '' ); ?> <?php edit_post_link( __( 'Edit', 'san-kloud' ), '<span class="sep">|</span> <span class="edit-link">', '</span>' ); ?>
			</p>
		</div>

	</div>

	<div class="post-bottom">
	</div>

</div>
<div class="navigation">
	<div class="left"><?php next_post_link( '%link', __( '&larr; Previous', 'san-kloud' ) ); ?></div>
	<div class="right"><?php previous_post_link( '%link', __( 'Next &rarr;', 'san-kloud' ) ); ?></div>
</div>