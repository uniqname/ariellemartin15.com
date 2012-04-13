<?php
/**
 * The image template.
 *
 * @package Retro-fitted
 * @subpackage Template
 */
?>

<?php get_header(); ?>

	<div id="content">

		<div class="hfeed">

			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

						<div id="image-template" class="entry-content">

							<p id="attachment-image">
								<?php echo wp_get_attachment_image( get_the_ID(), 'full' ); ?>
							</p><!-- .attachment-image -->

							<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

							<?php if ( '' != trim( get_post_field( 'post_excerpt', get_the_id() ) ) ) : ?>
								<div id="image-caption" class="wp-caption-text"><?php the_excerpt(); ?></div>
							<?php endif; ?>

							<div id="image-description"><?php the_content(); ?></div>

							<?php $parent_ID = absint( get_post_field( 'post_parent', get_the_ID() ) ); ?>

							<?php if ( ! empty( $parent_ID ) ) :
								$link_text = __( 'Parent Post', 'retro-fitted' );
								$parent_title = get_the_title( $parent_ID );
								if ( ! empty( $parent_title ) )
									$link_text = $parent_title;

								echo '<div id="return-to-parent">' . sprintf( __( 'Return to: %1$s', 'shaan' ), '<a href="' . esc_url( get_permalink( $parent_ID ) ) . '" title="' . esc_attr( sprintf( __( 'Return to %s', 'shaan' ), strip_tags( $link_text ) ) ) . '">' . $link_text . '</a>' ) . '</div>';
							endif; ?>

						</div><!-- .entry-content -->

					</div><!-- .hentry -->

					<nav id="image-navigation" class="paged-navigation">
						<h1 class="assistive-text"><?php _e( 'Image navigation', 'retro-fitted' ); ?></h1>
						<div class="nav-older"><?php previous_image_link( false, __( '&larr; Previous Image', 'retro-fitted' ) ); ?></div>
						<div class="nav-newer"><?php next_image_link( false, __( 'Next Image &rarr;', 'retro-fitted' ) ); ?></div>
					</nav>

					<?php comments_template(); ?>

				<?php endwhile; ?>

			<?php endif; ?>

		</div><!-- .hfeed -->

		<?php get_template_part( 'nav-posts' ); // Loads the loop-nav.php template. ?>

	</div><!-- #content -->

<?php get_footer(); // Loads the footer.php template. ?>