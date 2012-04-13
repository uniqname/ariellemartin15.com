<?php
/**
 * The template for displaying image attachments.
 *
 * @package Nuntius
 * @since Nuntius 1.0
 */

get_header(); ?>

	<div id="content">
		<div class="hfeed">

			<?php while ( have_posts() ) : the_post(); ?>

				<div id="image-navigation">
					<span class="previous-image"><?php previous_image_link( false, __( '&larr; Previous' , 'nuntius' ) ); ?></span>
					<span class="next-image"><?php next_image_link( false, __( 'Next &rarr;' , 'nuntius' ) ); ?></span>
				</div><!-- #image-navigation -->

				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<div class="entry-utility">
						<?php if ( comments_open() || ( '0' != get_comments_number() && ! comments_open() ) ) : ?>
							<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'nuntius' ), __( '1 Comment', 'nuntius' ), __( '% Comments', 'nuntius' ) ); ?></span>
						<?php endif; ?>

					</div><!-- .entry-utility -->

					<h2 class="entry-title">
						<?php if ( ! is_single() ) : ?>
							<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'nuntius' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
						<?php else : ?>
							<?php the_title(); ?>
						<?php endif; ?>
					</h2><!-- .entry-title -->

					<div class="byline">
						<?php
							$metadata = wp_get_attachment_metadata();
							printf( __( 'Published at <a href="%1$s" title="Link to full-size image">%2$s &times; %3$s</a> in <a href="%4$s" title="Return to %5$s" rel="gallery">%5$s</a>', 'nuntius' ),
								wp_get_attachment_url(),
								$metadata['width'],
								$metadata['height'],
								get_permalink( $post->post_parent ),
								get_the_title( $post->post_parent )
							);
						?>
						<?php edit_post_link( __( '(Edit)', 'nuntius' ), '<span class="edit-link">', '</span>' ); ?>
					</div><!-- .byline -->

					<div class="entry-content">

						<div class="entry-attachment">
							<div class="attachment">
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

								<a href="<?php echo $next_attachment_url; ?>" title="<?php echo esc_attr( get_the_title() ); ?>" rel="attachment"><?php
								$attachment_size = apply_filters( 'nuntius_attachment_size', 1200 );
								echo wp_get_attachment_image( $post->ID, array( $attachment_size, $attachment_size ) ); // filterable image width with, essentially, no limit for image height.
								?></a>
							</div><!-- .attachment -->

							<?php if ( ! empty( $post->post_excerpt ) ) : ?>
							<div class="entry-caption">
								<?php the_excerpt(); ?>
							</div>
							<?php endif; ?>
						</div><!-- .entry-attachment -->

						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'nuntius' ), 'after' => '</div>' ) ); ?>
					</div><!-- .entry-content -->

					<div class="entry-meta">
						<?php if ( comments_open() && pings_open() ) : // Comments and trackbacks open ?>
							<?php printf( __( '<a class="comment-link" href="#respond" title="Post a comment">Post a comment</a> or leave a trackback: <a class="trackback-link" href="%s" title="Trackback URL for your post" rel="trackback">Trackback URL</a>.', 'bouquet' ), get_trackback_url() ); ?>
						<?php elseif ( ! comments_open() && pings_open() ) : // Only trackbacks open ?>
							<?php printf( __( 'Comments are closed, but you can leave a trackback: <a class="trackback-link" href="%s" title="Trackback URL for your post" rel="trackback">Trackback URL</a>.', 'bouquet' ), get_trackback_url() ); ?>
						<?php elseif ( comments_open() && ! pings_open() ) : // Only comments open ?>
							<?php _e( 'Trackbacks are closed, but you can <a class="comment-link" href="#respond" title="Post a comment">post a comment</a>.', 'bouquet' ); ?>
						<?php elseif ( ! comments_open() && ! pings_open() ) : // Comments and trackbacks closed ?>
							<?php _e( 'Both comments and trackbacks are currently closed.', 'bouquet' ); ?>
						<?php endif; ?>
						<?php edit_post_link( __( 'Edit', 'bouquet' ), ' <span class="edit-link">', '</span>' ); ?>
					</div><!-- .entry-meta -->
				</div><!-- #post-<?php the_ID(); ?> -->

				<?php comments_template(); ?>

			<?php endwhile; // end of the loop ?>

		</div><!-- .hfeed -->
	</div><!-- #content -->

<?php get_footer(); ?>