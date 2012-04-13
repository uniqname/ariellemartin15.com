<?php
/**
 * Template Name: News Template
 *
 * This page lists a featured section at the top and pulls in the sidebar-feature.php
 * file to sit beside the featured area. In the normal content area, posts are listed by category. These
 * categories must be selected in the 'Home Template Settings' section of the 'News Settings' page. After
 * the category highlight section, a more articles section displays a set number of posts.
 *
 * @package Nuntius
 * @since Nuntius 1.0
 */

/* Set up a default array for posts we're not duplicating. */
$do_not_duplicate = array();
get_header(); ?>

	<?php
		/**
		 * Begin the featured posts section.
		 * See if we have any sticky posts and use them to create our featured posts.
		 */
		$sticky = get_option( 'sticky_posts' );

		$featured_args = array(
			'post__in' => $sticky,
			'posts_per_page' => 6,
			'post_status' => 'publish',
		);

		// The Featured Posts query.
		$featured = new WP_Query( $featured_args );
		$class = '';

		if ( $sticky ) :

			// Determine post count so we can hide the slideshow if only 1 sticky post.
			$post_count = $featured->post_count;
			if ( $post_count > 1 )
				$class = ' class="active-sticky"';
			?>
			<div id="feature"<?php echo $class; ?>>

				<div class="slideshow-set">
					<div class="slideshow-items">

						<?php while ( $featured->have_posts() ) : $featured->the_post(); $i = 0;

							if ( $post_count > 1 ) : // hide slideshow if only 1 sticky post
								 $do_not_duplicate[] = get_the_ID();
							?>
								<div class="hentry post slide-show-item item item-<?php echo ++$i; ?>">

									<?php if ( has_post_thumbnail() ) :
										// A featured image will only show if the post is sticky, has a thumbnail image and the thumbnail is at least as wide as FEATURED_IMAGE_WIDTH.
										$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'nuntius-slideshow-large' ); // get the thumbnail image
										// If the thumbnail image is at least as wide as our minimum featured image width, display it along with the post excerpt.
										if ( $image >= FEATURED_IMAGE_WIDTH ) :
									?>
										<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php _e( 'Permanent Link to' , 'nuntius' ) ?> <?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'nuntius-slideshow-large' ); ?></a>

										<?php endif; // end check for thumbnail size ?>
									<?php endif // end check for existence of post thumbnails ?>

									<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'nuntius' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
									<div class="slideshow-caption">
										<div class="entry-summary slideshow-caption-text"><?php the_excerpt(); ?></div>
									</div><!-- .slideshow-caption -->
								</div><!-- .hentry -->

							<?php endif; // end check for post count ?>

						<?php endwhile; ?>

					</div><!-- .slideshow-items -->

					<div class="slideshow-controls">
						<div class="slideshow-pager"></div>
						<div class="slideshow-nav">
							<a class="slider-prev"><?php _e( 'Previous', 'nuntius' ); ?></a>
							<a class="slider-next"><?php _e( 'Next', 'nuntius' ); ?></a>
						</div>
					</div><!-- .slideshow-controls -->

				</div><!-- .slideshow-set -->

				<?php get_sidebar( 'feature' ); ?>

			</div><!-- #feature -->

		<?php endif; // End check for sticky posts ?>

	<div id="content">
		<div class="hfeed">
			<?php
				$options = nuntius_get_theme_options();
				$primary_category = $options['primary_category'];
				$categories = array();
			?>

			<?php if ( ! empty( $primary_category ) ) { ?>

				<!-- Begin category section. -->
				<div id="category-highlight">

				<?php
					/* We need to first get the blog category IDs. Category IDs are stored inside a stdClass object.
					/* Let's cycle through get_categories() and place into an array the IDs of categories that are either the primary
					/* featured category OR categories that are children of the primary featured category. */

					foreach ( get_categories() as $object ) {
						if ( cat_is_ancestor_of( $primary_category, $object->term_id ) || $object->term_id == $primary_category ) :
							array_push( $categories, $object->term_id );
						endif;
					}

					/* Now that we have our featured categories, let's display their posts in a nice
					/* news-like block. We're listing categories in alphabetical order and
					/* will display up to 6 posts in each block. If a post has already appeared in the slider, it WON'T
					/* be duplicated here. */

					foreach ( $categories as $cat ) {

						$loop = new WP_Query( array( 'category__in' => $cat, 'posts_per_page' => 6, 'post__not_in' => $do_not_duplicate ) );

						if ( $loop->have_posts() ) :
				?>
							<div class="section category-section">
								<div class="section-wrap category-section-wrap">

								<?php $term = get_term( $cat, 'category' ); ?>

								<h2 class="category-title section-title"><a href="<?php echo get_term_link( $term, 'category' ); ?>" title="<?php echo esc_attr( $term->name ); ?>"><?php echo $term->name; ?></a></h2>

								<?php $i = 0;

								while ( $loop->have_posts() ) : $loop->the_post();

									$do_not_duplicate[] = get_the_ID();

									/* Let's show a thumbnail, larger title, and excerpt for the
									/* first post in each block. */

									if ( ++$i == 1 ) {
								?>

									<div <?php post_class(); ?>>
										<h3 class="entry-title">
											<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'nuntius' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
										</h3><!-- .entry-title -->

										<?php the_post_thumbnail( 'nuntius-thumbnail', array( 'class' => 'nuntius-thumbnail', 'alt' => get_the_title(), 'title' => get_the_title() ) ); ?>

										<div class="entry-summary">
											<?php the_excerpt(); ?>
											<?php edit_post_link( __( 'Edit', 'nuntius' ), '<span class="edit-link">', '</span>' ); ?>
										</div><!-- .entry-summary -->
									</div><!-- .hentry -->

									<?php } else {

										/* For all other posts, let's just show their post titles as list items. */

											if ( $i == 2 )
												echo '<ul class="xoxo post-list">'; // If second post, open the list.
									?>
											<li>
												<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a>
												<div class="entry-meta">
													<?php
														printf( __( '<span class="entry-date"><a href="%1$s" rel="bookmark" title="%3$s">%2$s</a></span>', 'nuntius' ),
															get_permalink(),
															get_the_date(),
															esc_attr( get_the_time() )
														);
													?>
													<?php if ( comments_open() || ( '0' != get_comments_number() && ! comments_open() ) ) : ?>
														<span class="comments-link">// <?php comments_popup_link( __( 'Leave a comment', 'nuntius' ), __( '1 Comment', 'nuntius' ), __( '% Comments', 'nuntius' ) ); ?></span>
													<?php endif; ?>

													<?php edit_post_link( __( '(Edit)', 'nuntius' ), '<span class="edit-link">', '</span>' ); ?>
												</div><!-- .entry-meta -->
											</li>

									<?php } //end the check to see if this is the first post ?>

								<?php endwhile; // end the loop ?>

								<?php if ( $i > 1 )
									echo '</ul>'; // If there is more than one post, close the list after the loop. ?>

								</div><!-- .section-wrap -->
							</div><!-- .section -->

						<?php endif; //end the check for existence of posts ?>

					<?php } //end foreach ?>

				</div><!-- .category-highlight -->

			<?php } // end check for primary category option ?>

			<!-- Begin more articles section. -->
			<?php $loop = new WP_Query( array( 'posts_per_page' => 10, 'post__not_in' => $do_not_duplicate ) ); ?>

			<?php if ( $loop->have_posts() ) : ?>

				<div id="more-articles" class="section">
					<div class="section-wrap">

					<h2 class="section-title"><?php _e( 'More Articles', 'nuntius' ); ?></h2>

					<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

						<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

							<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php echo esc_attr( sprintf( __( 'Permanent Link to %s', 'nuntius' ), the_title_attribute( 'echo=0' ) ) ); ?>">
								<?php the_post_thumbnail( 'nuntius-thumbnail', array( 'class' => 'nuntius-thumbnail', 'alt' => get_the_title(), 'title' => get_the_title() ) ); ?>
							</a>

							<h2 class="entry-title">
								<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'nuntius' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
							</h2><!-- .entry-title -->

							<div class="byline">
								<?php nuntius_archive_post_meta(); ?>

								<?php if ( comments_open() || ( '0' != get_comments_number() && ! comments_open() ) ) : ?>
									<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'nuntius' ), __( '1 Comment', 'nuntius' ), __( '% Comments', 'nuntius' ) ); ?></span>
								<?php endif; ?>

								<?php edit_post_link( __( 'Edit', 'nuntius' ), '<span class="edit-link">', '</span>' ); ?>

							</div><!-- .byline -->

							<div class="entry-summary">
								<?php the_excerpt(); ?>
							</div><!-- .entry-content -->

						</div><!-- #post-<?php the_ID(); ?> -->

					<?php endwhile; ?>

					</div><!-- .section-wrap -->
				</div><!-- .section -->

			<?php endif; ?>

		</div><!-- .hfeed -->
	</div><!-- #content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>