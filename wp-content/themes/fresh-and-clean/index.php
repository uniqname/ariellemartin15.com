<?php
/**
 * The main template file.
 *
 * @package Fresh & Clean
 */

get_header(); ?>

		<div id="content" role="main">

			<?php if ( is_archive() ) : ?>
			<header class="archive-header">
				<h1 class="archive-title">
					<?php if ( is_day() ) : ?>
						<?php printf( __( 'Posted on %s &hellip;', 'fresh-and-clean' ), '<span>' . get_the_date() . '</span>' ); ?>
					<?php elseif ( is_month() ) : ?>
						<?php printf( __( 'Posted in %s &hellip;', 'fresh-and-clean' ), '<span>' . get_the_date( 'F Y' ) . '</span>' ); ?>
					<?php elseif ( is_year() ) : ?>
						<?php printf( __( 'Posted in %s &hellip;', 'fresh-and-clean' ), '<span>' . get_the_date( 'Y' ) . '</span>' ); ?>
					<?php elseif( is_author() ) : ?>
						<?php printf( __( 'Posted by %s &hellip;', 'fresh-and-clean' ), '<span>' . get_the_author() . '</span>' ); ?>
					<?php elseif ( is_category() ) : ?>
						<?php printf( __( 'Filed under %s &hellip;', 'fresh-and-clean' ), '<span>' . single_cat_title( '', false ) . '</span>' ); ?>
					<?php elseif ( is_tag() ) : ?>
						<?php printf( __( 'Tagged with %s &hellip;', 'fresh-and-clean' ), '<span>' . single_tag_title( '', false ) . '</span>' ); ?>
					<?php endif; ?>
				</h1>
			</header><!-- .archive-header -->
			<?php endif; ?>
			<?php if ( is_search() ) : ?>
			<header class="archive-header">
				<h1 class="archive-title">
					<?php printf( __( 'Matches for: &ldquo;%s&rdquo; &hellip;', 'fresh-and-clean' ), '<span>' . get_search_query() . '</span>' ); ?>
				</h1>
			</header><!-- .archive-header -->
			<?php endif; ?>

			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); /* Start the Loop */
					// We want to exclude posts that are prominently shown as featured
					if ( is_sticky() && has_post_thumbnail() && is_home() ) {
							// Let's check the image.
							$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large-feature' );
							// If it is bigger or equal to featured width, let's skip this post
							if ( $image[1] >= FEATURED_IMAGE_WIDTH )
									continue;
					}
						/* Include the Post-Format-specific template for the content.
						 * If you want to overload this in a child theme then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'content', get_post_format() );
					?>

				<?php endwhile; ?>

				<?php fresh_and_clean_content_nav( 'nav-below' ); ?>

			<?php else : ?>

				<article id="post-0" class="hentry error404">
					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'Nothing Found', 'fresh-and-clean' ); ?></h1>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'fresh-and-clean' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->

			<?php endif; ?>

		</div><!-- #content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>