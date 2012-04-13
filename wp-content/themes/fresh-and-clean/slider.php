<?php
/**
 * @package Fresh & Clean
 */
        // Enqueue showcase script for the slider
        wp_enqueue_script( 'fresh-and-clean-featured', get_template_directory_uri() . '/js/featured.js', array( 'jquery' ), '2012-01-10' );
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
?>
        <div class="featured-posts">
                <?php
                        // Let's roll.
                        while ( $featured->have_posts() ) : $featured->the_post();
                        if ( has_post_thumbnail() ) {
                                // Now let's check the image.
                                $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large-feature' );
                                // If it is smaller than featured width, let's skip
                                if ( $image[1] < FEATURED_IMAGE_WIDTH )
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
                        <section class="featured" id="featured-post-<?php echo $counter_slider; ?>">
                                <a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'fresh-and-clean' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_post_thumbnail( 'large-feature' ); ?></a>
                                <?php get_template_part( 'content', 'featured' ); ?>
                        </section>
                <?php endwhile; ?>
                <?php
                        // Show slider only if we have more than one featured post.
                        if ( $featured->post_count > 1 ) :
                ?>
                <nav class="feature-slider">
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
                                $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large-feature' );
                                // If it is smaller than featured width, let's skip
                                if ( $image[1] < FEATURED_IMAGE_WIDTH )
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
                                <li><a href="#featured-post-<?php echo $counter_slider; ?>" title="<?php printf( esc_attr__( 'Featuring: %s', 'fresh-and-clean' ), the_title_attribute( 'echo=0' ) ); ?>" <?php echo $class; ?>><?php echo $counter_slider; ?></a></li>
                        <?php endwhile; ?>
                        </ul>
                </nav>
                <?php endif; // End check for more than one sticky post. ?>
                </div><!-- .featured-posts -->
                <?php endif; // End check for published posts. ?>
                <?php endif; // End check for sticky posts. ?>