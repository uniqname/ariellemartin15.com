<?php get_header(); ?>

<div id="content" class="archive">

<?php if (have_posts() ) : ?>

	<h2><?php printf( __( 'Search Results for %s', 'blix' ), '<em>' . get_search_query() . '</em>' ); ?></h2>

<?php while (have_posts() ) : the_post(); ?>

	<div id="post-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?>>

		<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

		<?php ($post->post_excerpt != "")? the_excerpt() : BX_shift_down_headlines( get_the_content() ); ?>

		<p class="info"><?php if ($post->post_excerpt != "") { ?><a href="<?php the_permalink(); ?>" class="more"><?php _e( 'Continue Reading', 'blix' ); ?></a><?php } ?>
   		<?php if ( 'post' == get_post_type() ) : ?>
   			<?php blix_posted_on(); ?>
   		<?php endif; ?>
   		<?php blix_posted_by(); ?>
		<?php if ( comments_open() || ( '0' != get_comments_number() && ! comments_open() ) ) : ?>
			<em class="comments-popup">
			<?php comments_popup_link( __( 'Leave a comment' ), __( '1 comment' ), __( '% comments' ), __( 'commentlink', 'blix' ), '' ); ?>
			</em>
		<?php endif; ?>
   		<?php edit_post_link( 'Edit', '<span class="editlink">', '</span>' ); ?>
   		</p>

	</div>


<?php endwhile; ?>

	<p>
		<span class="previous"><?php next_posts_link( __( 'Older Posts', 'blix' ) ); ?></span>
		<span class="next"><?php previous_posts_link( __( 'Newer Posts', 'blix' ) ); ?></span>
	</p>

<?php else : ?>

	<h2><?php _e( 'Not Found', 'blix' ); ?></h2>
	<p><?php _e( 'Sorry, but you are looking for something that isn&rsquo;t here.' ); ?></p>

<?php endif; ?>

</div> <!-- /content -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
