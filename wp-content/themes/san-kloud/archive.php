<?php
/**
 * @package San Kloud
 */

global $wp_query;
 get_header(); ?>
<div class="container-12 content">
	<div class="grid-1"></div>
	<div class="grid-8">
		<h1 class="archive-title">
			<?php if ( is_day() ) : ?>
				<?php printf( __( 'Daily Archives: <span>%s</span>', 'san-kloud' ), get_the_date() ); ?>
			<?php elseif ( is_month() ) : ?>
				<?php printf( __( 'Monthly Archives: <span>%s</span>', 'san-kloud' ), get_the_date( 'F Y' ) ); ?>
			<?php elseif ( is_year() ) : ?>
				<?php printf( __( 'Yearly Archives: <span>%s</span>', 'san-kloud' ), get_the_date( 'Y' ) ); ?>
			<?php elseif ( is_author() ): ?>
				<?php printf( __( 'Author Archives: %s', 'san-kloud' ), '<span class="vcard">' . get_the_author() . '</span>' ); ?>
			<?php elseif ( is_category() ): ?>
				<?php printf( __( 'Category Archives: %s', 'san-kloud' ), '<span>' . single_cat_title( '', false ) . '</span>' ); ?>
			<?php elseif ( is_tag() ): ?>
				<?php printf( __( 'Tag Archives: %s', 'san-kloud' ), '<span>' . single_tag_title( '', false ) . '</span>' ); ?>
			<?php else : ?>
				<?php _e( 'Blog Archives', 'san-kloud' ); ?>
			<?php endif; ?>
		</h1>
		<?php if ( have_posts() ): ?>

			<?php while ( have_posts() ): the_post(); ?>

				<?php get_template_part( 'content', 'archive' ); ?>

			<?php endwhile; ?>

		<?php else : ?>

			<p><?php _e( 'No posts were found matching your criteria. Please try a different search.', 'san-kloud' ); ?></p>

		<?php endif; ?>
		<div class="navigation">
			<div class="left"><?php next_posts_link( __( ' &larr; Older Posts', 'san-kloud' ) ); ?></div>
			<div class="right"><?php previous_posts_link( __( 'Newer Posts &rarr;', 'san-kloud' ) ); ?></div>
		</div>
	</div>

<?php get_sidebar();?>
<?php get_footer();?>