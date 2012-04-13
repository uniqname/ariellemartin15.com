<?php
/**
 * @package Splendio
 */
        // Enqueue showcase script for the slider
        wp_enqueue_script( 'splendio-featured', get_template_directory_uri() . '/js/featured.js', array( 'jquery' ), '2012-01-24' );
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
        'no_found_rows' => true,
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

        if ( $featured->post_count > 1 ) :
?>
        <div class="featured-posts">

        	<span class="featured-title"><strong><?php _e( 'Featured Posts', 'splendio' ); ?></strong></span>

                <?php
                        // Let's roll.
                        while ( $featured->have_posts() ) : $featured->the_post();

                        $counter_slider++;
            	?>
                        <section class="featured" id="featured-post-<?php echo $counter_slider; ?>">

							<?php if ( has_post_thumbnail() ) :
								// A featured image will only show if the post is sticky, has a thumbnail image and the thumbnail is at least as wide as 180px.
                                $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );
								// If the thumbnail image is at least as wide as our minimum featured image width, display it along with the post excerpt.
								if ( $image >= 180 ) :
							?>
								<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'splendio' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><img src="<?php echo 'http://s.wordpress.com/imgpress?fit=180,180&url=' . urlencode( $image[0] ) . '';?>" /></a>

								<?php endif; // end check for thumbnail size ?>
							<?php endif // end check for existence of post thumbnails ?>

							<?php get_template_part( 'content', 'featured' ); ?>
                        </section>
                <?php endwhile; ?>
                <?php
                        // Show slider only if we have more than one featured post.
                        if ( $featured->post_count > 1 ) :
                ?>
                <div id="slider-outer">
					<nav class="feature-slider">
							<dl>
							<?php
									// Reset the counter so that we end up with matching elements
							$counter_slider = 0;
									// Begin from zero
							rewind_posts();
									// Let's roll again.
							while ( $featured->have_posts() ) : $featured->the_post();
								$counter_slider++; 	// Increase the counter.
								if ( 1 == $counter_slider )
										$class = 'class="active"';
								else
										$class = '';
							?>
									<dd><a href="#featured-post-<?php echo $counter_slider; ?>" title="<?php printf( esc_attr__( 'Featuring: %s', 'splendio' ), the_title_attribute( 'echo=0' ) ); ?>" <?php echo $class; ?>><?php echo $counter_slider; ?></a></dd>
							<?php endwhile; ?>
							</dl>
					</nav>
                </div>
                <?php endif; // End check for more than one sticky post. ?>
                </div><!-- .featured-posts -->
                <?php endif; ?>
                <?php endif; // End check for published posts. ?>
                <?php endif; // End check for sticky posts. ?>