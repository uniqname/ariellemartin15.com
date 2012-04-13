<?php
/**
 * This is the template for Pages
 *
 * @package Nuntius
 * @since Nuntius 1.0
 */

get_header(); ?>

	<div id="content">
		<div class="hfeed">

			<?php while ( have_posts() ) : the_post(); ?>

				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<div class="entry-utility">
						<?php if ( comments_open() || ( '0' != get_comments_number() && ! comments_open() ) ) : ?>
							<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'nuntius' ), __( '1 Comment', 'nuntius' ), __( '% Comments', 'nuntius' ) ); ?></span>
						<?php endif; ?>
						<?php edit_post_link( __( 'Edit', 'nuntius' ), '<span class="edit-link">', '</span>' ); ?>
					</div><!-- .entry-utility -->

					<h2 class="entry-title"><?php the_title(); ?></h2><!-- .entry-title -->

					<div class="entry-content">
						<?php the_content( __( 'Continue Reading' , 'nuntius' ) . ' &raquo;'); ?>
						<?php wp_link_pages( array( 'before' => '<p class="page-links">' . __( 'Pages:', 'nuntius' ), 'after' => '</p>' ) ); ?>
					</div><!-- .entry-content -->
				</div><!-- #post-<?php the_ID(); ?> -->

				<?php
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || '0' != get_comments_number() )
						comments_template( '', true );
				?>

			<?php endwhile; // end of the loop ?>

		</div><!-- .hfeed -->

	</div><!-- #content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>