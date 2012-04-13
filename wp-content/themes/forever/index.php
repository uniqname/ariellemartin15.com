<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Forever
 * @since Forever 1.0
 */

get_header(); ?>

		<?php
		/**
		 * We may need to exclude some posts by ID down the line
		 */
		$posts_to_exclude = array();

		$featured_posts = forever_featured_posts();

		/**
		 * Proceed if we have featured posts
		 */
		if ( is_array( $featured_posts ) ) {

			$featured_args = array(
				'post__in' => $featured_posts,
				'posts_per_page' => 10,
				'ignore_sticky_posts' => 1,
			);

			/**
			 * The Featured Posts query
			 */
			$featured = new WP_Query( $featured_args );

			/**
			 * Proceed only if published posts exist and this is the blog home page
			 */
			if ( ! is_paged() && is_home() ) {

				/**
				 * We will need to count featured posts starting from zero
				 * to create the slider navigation.
				 */
				$post_counter = 0; ?>

				<div id="featured-content">

					<?php
					/**
					 * Let's roll.
					 */
					while ( $featured->have_posts() ) : $featured->the_post();

						/**
						 * Increase the counter.
						 */
						$post_counter++;

						/**
						 * Set up each post as a post to exclude down the line
						 */
						$posts_to_exclude[] = $post->ID;

						/**
						 * Make sure we don't see any posts without thumbnails
						 */
						if ( '' != get_the_post_thumbnail() ) {

						?>

						<div class="featured-post" id="featured-post-<?php echo $post_counter; ?>">
							<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'forever' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark">
								<?php the_post_thumbnail( 'large-feature' ); ?>
							</a>

							<div class="feature-content">
								<h1 class="feature-title">
									<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'forever' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
								</h1>
							</div><!-- .feature-content -->>
						</div>

					<?php
					} // '' != get_the_post_thumbnail()

					endwhile;

					?>

				</div><!-- #featured-content -->

				<?php
				/**
				 * Show slider only if we have more than one featured post.
				 */
				if ( $featured->post_count > 1 ) {

					wp_enqueue_script( 'forever-slider', get_template_directory_uri() . '/js/slider.js', array( 'jquery' ), '13-12-2012' );

					?>

					<nav id="feature-slider">
						<ul>
						<?php

							/**
							 * Reset the counter so that we end up with matching elements
							 */
					    	$post_counter = 0;

							/**
							 * Begin from zero
							 */
					    	rewind_posts();

							/**
							 * Let's roll, again.
							 */
					    	while ( $featured->have_posts() ) : $featured->the_post();

								/**
								 * Make sure we don't see any posts without thumbnails
								 */
								if ( '' != get_the_post_thumbnail() ) {

					    		$post_counter++;
								if ( 1 == $post_counter )
									$class = 'class="active"';
								else
									$class = '';
					    	?>
							<li>
								<a href="#featured-post-<?php echo $post_counter; ?>" title="<?php printf( esc_attr__( 'Featuring: %s', 'forever' ), the_title_attribute( 'echo=0' ) ); ?>" <?php echo $class; ?>>
									<?php the_title(); ?>
								</a>
							</li>
						<?php
						} // '' != get_the_post_thumbnail()

						endwhile;
						?>
						</ul>
					</nav>

				<?php } // $featured->post_count > 1 ?>


				<?php

			} // $featured->have_posts() && ! is_paged() && is_home()

		} // is_array( $featured_posts)
		?>

		<?php
		/**
		 * Display the blog tagline on the blog home page
		 */
		if ( ! is_paged() && is_home() ) : ?>
			<div id="description">
				<h2 id="site-description"><?php bloginfo( 'description' ); ?></h2>
			</div><!-- #description -->
		<?php endif; ?>

		<?php
		/**
		 * Maybe we'll show the latest four posts in a grid!
		 */
		$options = forever_get_theme_options();

		if ( 'on' == $options['posts_in_columns'] ) {
			$args = array(
				'order' => 'DESC',
				'ignore_sticky_posts' => 1,
				'post__not_in' => $posts_to_exclude,
				'posts_per_page' => '4',
				'tax_query' => array(
					array(
						'taxonomy' => 'post_format',
						'terms' => array( 'post-format-status', 'post-format-quote', 'post-format-gallery', 'post-format-image' ),
						'field' => 'slug',
						'operator' => 'NOT IN',
					),
				),
			);
			$latest_content = new WP_Query();
			$latest_content->query( $args );
		}

		if ( 'on' == $options['posts_in_columns'] && ! is_paged() && is_home() ) { ?>
			<div id="recent-content">
				<?php

				while ($latest_content->have_posts()) : $latest_content->the_post();

					/**
					 * Set up each post as a post to exclude down the line
					 */
					$posts_to_exclude[] = $post->ID; ?>

					<article class="recent-post" id="recent-post-<?php echo $post_counter; ?>">
						<?php if ( has_post_thumbnail() ) { ?>
						<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'forever' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark">
							<?php the_post_thumbnail( 'small-feature' ); ?>
						</a>
						<?php } // has_post_thumbnail() ?>

						<header class="recent-header">
							<h1 class="recent-title">
								<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'forever' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
							</h1>
							<div class="entry-meta">
								<?php forever_posted_on(); ?>
							</div><!-- .entry-meta -->
						</header><!-- .recent-header -->

						<div class="recent-summary">
							<?php the_excerpt(); ?>
						</div><!-- .recent-summary -->
					</article>

				<?php endwhile;

				?>
			</div>

		<?php } // $featured->have_posts() ?>

		<div id="primary">
			<div id="content" role="main">

			<?php if ( have_posts() ) : ?>

				<?php forever_content_nav( 'nav-above' ); ?>

				<?php

				/**
				 * Begin from zero
				 */
		    	rewind_posts();

				$paged = get_query_var('paged');

				query_posts( array(
					'order' => 'DESC',
					'paged' => $paged,
					'post__not_in' => $posts_to_exclude,
				) );

				while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', get_post_format() );?>

				<?php endwhile; ?>

				<?php forever_content_nav( 'nav-below' ); ?>

			<?php else : ?>

				<article id="post-0" class="post no-results not-found">
					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'Nothing Found', 'forever' ); ?></h1>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'forever' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->

			<?php endif; ?>

			</div><!-- #content -->
		</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>