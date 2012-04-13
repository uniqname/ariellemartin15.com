<?php
/**
 * Template Name: Full-width, no sidebar
 * @package Suburbia
 */
?>
<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>
	<div id="post-<?php the_ID(); ?>" <?php post_class( 'full-width' ); ?>>
		<div id="single">
			<h1><?php the_title(); ?></h1>
			<?php the_content(); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'suburbia' ), 'after' => '</div>' ) ); ?>
			<?php edit_post_link( __( 'Edit this entry', 'suburbia' ), '<h3 class="edit-link">', '</h3>' ); ?>
			<?php
				if ( comments_open() || '0' != get_comments_number() )
					comments_template( '', true );
			?>
		</div><!-- #single -->
	</div><!-- #post-<?php the_ID(); ?> -->
<?php endwhile; ?>

<div id="bottom-wrapper" class="clear">
	<?php get_template_part( 'sidebar-bottom' ); ?>
</div>

<?php get_footer(); ?>