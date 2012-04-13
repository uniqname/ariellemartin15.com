<?php
/**
 * The template for displaying image attachments.
 *
 * @package WordPress
 * @subpackage Bold_Life
 */

get_header(); ?>

<div class="single-column">

	<?php while ( have_posts() ) : the_post(); ?>

	<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="entry">
			<div class="entry-inner">
				<div id="attachment-navigation">
					<h3 class="screen-reader-text">
						<?php _e( 'Image Navigation', 'bold-life' ); ?>
					</h3>
					<div class="nav-previous">
						<?php previous_image_link( false, __( '&larr; Previous Image' , 'boldlife' ) ); ?>
					</div><!-- .nav-previous -->
					<div class="nav-next">
						<?php next_image_link( false, __( 'Next Image &rarr;' , 'boldlife' ) ); ?>
					</div><!-- .nav-next -->
				</div><!-- #attachment-navigation -->
				<h2 class="post-title">
					<?php the_title(); ?>
				</h2>
				<div class="entry-meta">
					<?php
						$metadata = wp_get_attachment_metadata();
						printf( __( '<span class="meta-prep meta-prep-entry-date">Published </span> <span class="entry-date"><abbr class="published" title="%1$s">%2$s</abbr></span> at <a href="%3$s" title="Link to full-size image">%4$s &times; %5$s</a> in <a href="%6$s" title="Return to %7$s" rel="gallery">%7$s</a>', 'boldlife' ),
							esc_attr( get_the_time() ),
							get_the_date(),
							esc_url( wp_get_attachment_url() ),
							$metadata['width'],
							$metadata['height'],
							esc_url( get_permalink( $post->post_parent ) ),
							get_the_title( $post->post_parent )
						);
					?>
				</div><!-- .entry-meta -->
				<div class="entry-attachment">
					<?php
						/**
						 * Grab the IDs of all the image attachments in a gallery so we can get the URL of the next adjacent image in a gallery,
						 * or the first image (if we're looking at the last image in a gallery), or, in a gallery of one, just the link to that image file
						 */
						$attachments = array_values( get_children( array( 'post_parent' => $post->post_parent, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID' ) ) );
						foreach ( $attachments as $k => $attachment ) {
							if ( $attachment->ID == $post->ID )
								break;
						}
						$k++;
						// If there is more than 1 attachment in a gallery
						if ( count( $attachments ) > 1 ) {
							if ( isset( $attachments[ $k ] ) )
								// get the URL of the next image attachment
								$next_attachment_url = get_attachment_link( $attachments[ $k ]->ID );
							else
								// or get the URL of the first image attachment
								$next_attachment_url = get_attachment_link( $attachments[ 0 ]->ID );
						} else {
							// or, if there's only 1 image, get the URL of the image
							$next_attachment_url = wp_get_attachment_url();
						}
					?>
					<a href="<?php echo esc_url( $next_attachment_url ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>" rel="attachment"><?php
					$attachment_size = apply_filters( 'boldlife_attachment_size', 658 );
					echo wp_get_attachment_image( $post->ID, array( $attachment_size, 1024 ) ); // filterable image width with 1024px limit for image height.
					?></a>
					<?php if ( ! empty( $post->post_excerpt ) ) : ?>
					<div class="entry-caption">
						<?php the_excerpt(); ?>
					</div>
					<?php endif; ?>
				</div><!-- .entry-attachment -->
				<div class="entry-description">
					<?php the_content(); ?>
					<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'boldlife' ) . '</span>', 'after' => '</div>' ) ); ?>
				</div><!-- .entry-description -->
				<?php edit_post_link( __( 'Edit', 'bold-life' ), '<div class="edit-link">', '</div>' ); ?>
			</div><!-- .entry-inner -->
		</div><!-- .entry -->
		<?php comments_template(); ?>
	</div><!-- #post-<?php the_ID(); ?> -->

	<?php endwhile; ?>

</div><!-- .post-wrapper -->

<?php get_footer(); ?>