<?php
/**
 * @package Suburbia
 */
?>
<?php get_header(); ?>

<?php if ( have_posts() ) : ?>

	<?php while ( have_posts() ) : the_post(); ?>
		<div <?php post_class( 'grid one' ); ?>>
			<div class="featured-image">
			<?php if ( has_post_thumbnail() ) : ?>
				<div class="preview">
					<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'suburbia' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
						<?php the_post_thumbnail( 'suburbia-thumbnail' ); ?>
					</a>
				</div><!-- .preview -->
			<?php endif; ?>
			</div><!-- .featured-image -->
			<h2><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'suburbia' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
			<?php the_excerpt(); ?>
			<div class="time">
				<?php the_time( get_option( 'date_format' ) ); ?>
				<?php if ( comments_open() || ( '0' != get_comments_number() && ! comments_open() ) ) : ?>
					&middot; <?php comments_popup_link(
						__( 'Leave a Comment', 'suburbia' ),
						__( '1 Comment',       'suburbia' ),
						__( '% Comments',      'suburbia' )
					); ?>
				<?php endif; ?>
				<?php edit_post_link( __( 'Edit', 'suburbia' ), '&middot; <span class="edit-link">', '</span>' ); ?>
			</div><!-- .time -->
		</div><!-- #post-<?php the_ID(); ?> -->
	<?php endwhile; ?>

<?php else : ?>
	<div id="post-0" class="post no-results not-found">
		<div id="single">
			<h1><?php _e( 'This is somewhat embarrassing, isn&rsquo;t it?', 'suburbia' ); ?></h1>
			<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'suburbia' ); ?></p>
			<?php get_search_form(); ?>
		</div><!-- #single -->
	</div><!-- #post-0 -->
<?php endif; ?>

<div id="bottom-wrapper" class="clear">
	<?php get_template_part( 'sidebar-bottom' ); ?>
</div>

<?php get_footer(); ?>