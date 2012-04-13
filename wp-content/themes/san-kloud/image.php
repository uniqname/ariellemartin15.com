<?php
/**
 * @package San Kloud
 */

get_header()
?>
<div class="container-12 content">
	<div class="grid-1"></div>
	<div class="grid-8">
		<?php while ( have_posts() ) : the_post(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<div class="page-content">
					<div class="page-title">
						<?php if ( get_the_title() ): ?>
							<h2>
								<?php the_title(); ?>
							</h2>
							<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'san-kloud' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><span class="post-date"><?php echo the_date(); ?></span></a>
						<?php else: ?>
							<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'san-kloud' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><span class="post-date no-title"><?php echo the_date(); ?></span></a>
						<?php endif; ?>
					</div>
						<div class="entry-meta">
							<?php
								$metadata = wp_get_attachment_metadata();
								printf( __( '<a href="%1$s" title="Link to full-size image">%2$s &times; %3$s</a> in <a href="%4$s" title="Return to %5$s" rel="gallery">%5$s</a>', 'san-kloud' ),
									wp_get_attachment_url(),
									$metadata['width'],
									$metadata['height'],
									get_permalink( $post->post_parent ),
									get_the_title( $post->post_parent )
								);
							?>
							<?php edit_post_link( __( 'Edit', 'san-kloud' ), '<span class="sep">|</span> <span class="edit-link">', '</span>' ); ?>
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

								<a href="<?php echo $next_attachment_url; ?>" title="<?php echo esc_attr( get_the_title() ); ?>" rel="attachment"><?php
								$attachment_size = apply_filters( 'san_kloud_attachment_size', 1200 );
								echo wp_get_attachment_image( $post->ID, array( $attachment_size, $attachment_size ) ); // filterable image width with, essentially, no limit for image height.
								?></a>

							<?php if ( ! empty( $post->post_excerpt ) ) : ?>
							<div class="entry-caption">
								<?php the_excerpt(); ?>
							</div>
							<?php endif; ?>
						</div><!-- .entry-attachment -->

						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'san-kloud' ), 'after' => '</div>' ) ); ?>
						<nav id="image-navigation">
							<div class="left"><?php previous_image_link( false, __( '&larr; Previous' , 'san-kloud' ) ); ?></div>
							<div class="right"><?php next_image_link( false, __( 'Next &rarr;' , 'san-kloud' ) ); ?></div>
						</nav><!-- #image-navigation -->
						<br class="clear" />
				</div>

				<div class="page-bottom">
				</div>
			</div>
			<?php comments_template(); ?>
			<?php endwhile; // end of the loop. ?>
	</div>
<?php get_footer();?>