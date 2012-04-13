<?php
/**
 * @package Triton Lite
 */

    /**
     * Begin the featured posts section.
     *
     * See if we have any sticky posts and use them to create our featured posts.
     * We limit the featured posts at ten.
     */
    $sticky = get_option( 'sticky_posts' );

    // Proceed only if sticky posts exist.
    if ( ! empty( $sticky ) ) :

    $featured_args = array(
    	'post__in' => $sticky,
    	'post_status' => 'publish',
    	'posts_per_page' => 10,
    	'no_found_rows' => true
    );

    // The Featured Posts query.
    $featured = new WP_Query( $featured_args );

    // Proceed only if published posts exist
    if ( $featured->have_posts() ) :

    /**
     * We will need to count featured posts starting from zero
     * to create the slider navigation.
     */
	$counter_slider = 0;
?>
	<div class="featured-posts">
		<?php
			// Let's roll.
			while ( $featured->have_posts() ) : $featured->the_post();

			if ( has_post_thumbnail() ) {

				// Now let's check the image.
				$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'triton-lite-950-cropped' );

				// If it is smaller than 950 in width, let's skip
				if ( $image[1] < 950 )
					continue;

				// Increase the counter.
				$counter_slider++;
			}

			else {
				continue;
			}
		?>
		<?php
			if ( 1 == $counter_slider )
				echo '';
		?>
			<div class="featured" id="featured-post-<?php echo $counter_slider; ?>">
				<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'triton-lite' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_post_thumbnail( 'triton-lite-950-cropped' ); ?></a>
				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<div class="entry-header">
						<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'triton-lite' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
					</div><!-- .entry-header -->
				
					<div class="entry-summary">
						<?php the_excerpt(); ?>
					</div><!-- .entry-content -->
				</div><!-- #post-<?php the_ID(); ?> -->
			</div>
		<?php endwhile;	?>

		<?php
			// Show slider only if we have more than one featured post.
			if ( $featured->post_count > 1 ) :
		?>
		<div class="feature-slider">
			<ul>
			<?php
				// Reset the counter so that we end up with matching elements
		    	$counter_slider = 0;

				// Begin from zero
		    	rewind_posts();

				// Let's roll again.
		    	while ( $featured->have_posts() ) : $featured->the_post();

			if ( has_post_thumbnail() ) {

				// Now let's check the image.
				$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'triton-lite-950-cropped' );

				// If it is smaller than 950 in width, let's skip
				if ( $image[1] < 950 )
					continue;
							// Increase the counter.
				$counter_slider++;
			}

			else {
				continue;
			}

					if ( 1 == $counter_slider )
						$class = 'class="active"';
					else
						$class = '';
		    	?>
				<li><a href="#featured-post-<?php echo $counter_slider; ?>" title="<?php printf( esc_attr__( 'Featuring: %s', 'triton-lite' ), the_title_attribute( 'echo=0' ) ); ?>" <?php echo $class; ?>><?php echo $counter_slider; ?></a></li>
			<?php endwhile;	?>
			</ul>
		</div>
		<?php endif; // End check for more than one sticky post. ?>
		</div><!-- .featured-posts -->
		<?php endif; // End check for published posts. ?>
		<?php endif; // End check for sticky posts. ?>