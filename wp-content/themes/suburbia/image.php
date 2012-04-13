<?php
/**
 * @package Suburbia
 */
?>
<?php get_header(); ?>

<?php $metadata = wp_get_attachment_metadata(); ?>

<?php while ( have_posts() ) : the_post(); ?>
	<div id="post-<?php the_ID(); ?>" <?php post_class( 'image-attachment' ); ?>>
		<div id="single">
			<h1 class="entry-title"><?php the_title(); ?></h1>

			<div class="entry-attachment">
				<div class="attachment">
					<?php
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
					$attachment_size = apply_filters( 'suburbia_attachment_size', 1200 );
					echo wp_get_attachment_image( $post->ID, array( $content_width, $content_width ) );
					?></a>
				</div><!-- .attachment -->

				<?php if ( ! empty( $post->post_excerpt ) ) : ?>
				<div class="entry-caption">
					<?php the_excerpt(); ?>
				</div>
				<?php endif; ?>
			</div><!-- .entry-attachment -->
			<?php the_content(); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'suburbia' ), 'after' => '</div>' ) ); ?>
			<?php
				if ( comments_open() || '0' != get_comments_number() )
					comments_template( '', true );
			?>
		</div><!-- #single -->
	</div><!-- #post-<?php the_ID(); ?> -->
	<div class="meta">
		<h3><?php _e( 'Information', 'suburbia' ); ?></h3>
		<?php
			printf( __( 'Published on <abbr class="published" title="%1$s">%2$s</abbr> at <a href="%3$s" title="Link to full-size image">%4$s &times; %5$s</a> in <a href="%6$s" title="Return to %7$s" rel="gallery">%7$s</a>', 'suburbia' ),
				esc_attr( get_the_time() ),
				get_the_date(),
				wp_get_attachment_url(),
				$metadata['width'],
				$metadata['height'],
				get_permalink( $post->post_parent ),
				get_the_title( $post->post_parent )
			);
		?>
		<h3><?php _e( 'Navigation', 'suburbia' ); ?></h3>
		<div class="nav-previous"><?php previous_image_link( false, __( 'Previous image' , 'suburbia' ) ); ?></div>
		<div class="nav-next"><?php next_image_link( false, __( 'Next image' , 'suburbia' ) ); ?></div>
		<?php edit_post_link( __( 'Edit this entry', 'suburbia' ), '<h3 class="edit-link">', '</h3>' ); ?>
	</div><!-- .meta -->
<?php endwhile; ?>

<div id="bottom-wrapper" class="clear">
	<?php get_template_part( 'sidebar-bottom' ); ?>
</div>

<?php get_footer(); ?>