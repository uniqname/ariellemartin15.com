<?php get_header(); ?>
<div id="content">
	<?php if (have_posts()) :?>
		<?php $postCount=0; ?>
		<?php while (have_posts()) : the_post();?>
			<?php $postCount++;?>
	<div <?php post_class('entry entry-' . $postCount); ?> id="post-<?php the_ID(); ?>">
		<div class="entrytitle">
			<h2><a href="<?php echo get_permalink( $post->post_parent ); ?>" rev="attachment"><?php echo get_the_title( $post->post_parent ); ?></a> &raquo; <?php the_title(); ?></h2>
			<?php if ( !is_page() ) { ?>
			<?php } ?>
		</div>
		<div class="entrybody">
			<div class="attachment">
			<p><a href="<?php echo wp_get_attachment_url( $post->ID ); ?>"><?php echo wp_get_attachment_image( $post->ID, 'auto' ); ?></a></p>
			<p class="caption"></p></p><?php if ( !empty( $post->post_excerpt ) ) the_excerpt(); ?></p>
			<p class="image-description"><?php if ( !empty( $post->post_content ) ) the_content(); ?></p>

				<div class="navigation">
					<p class="alignleft"><?php previous_image_link(); ?></p>
					<p class="alignright"><?php next_image_link(); ?></p>
				</div>
			</div>
		</div>

		<div class="entrymeta"><?php edit_post_link( __( 'Edit','treba' ), '', ' | ' ); ?> <?php comments_popup_link( __( 'Leave a Comment &#187;', 'treba' ), __( '1 Comment', 'treba' ), __( '% Comments', 'treba' ) ); ?><br /><?php the_tags( __( 'Tags: ', 'treba' ), ', ', '<br />' ); ?></p>
		</div>

	</div>
	<div class="commentsblock">
		<?php comments_template(); ?>
	</div>
		<?php endwhile; ?>
		<div class="navigation">
			<div class="alignleft"><?php next_posts_link(__('&laquo; Previous Entries','treba')); ?></div>
			<div class="alignright"><?php previous_posts_link(__('Next Entries &raquo;','treba')); ?></div>
		</div>

	<?php else : ?>

		<h2><?php _e( 'Not Found', 'treba' ); ?></h2>
		<div class="entrybody"><?php _e( "Sorry, but you are looking for something that isn't here.", 'treba' ); ?></div>

	<?php endif; ?>
	<?php get_footer(); ?>
	</div>

<?php get_sidebar(); ?>

</div>
<?php wp_footer(); ?>
</body>
</html>
