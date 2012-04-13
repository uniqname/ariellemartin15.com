<?php
/**
 * @package San Kloud
 */
get_header(); ?>
<div class="container-12 content">
	<div class="grid-1"></div>
	<div class="grid-8">
		<?php while ( have_posts() ) : the_post(); ?>

			<div id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="page-content">
					<div class="page-title">
						<h2>
							<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'san-kloud' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
						</h2>
					</div>
					<?php edit_post_link( __( 'Edit', 'san-kloud' ), '<span class="edit-link post-date">', '</span>' ); ?>
					<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'san-kloud' ) ); ?>
					<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'san-kloud' ) . '</span>', 'after' => '</div>' ) ); ?>
					<br class="clear">
				</div>
				<div class="page-bottom">
				</div>
			</div>

			<?php comments_template( '', true ); ?>
		<?php endwhile; // end of the loop. ?>
	</div>

<?php get_sidebar();?>
<?php get_footer();?>