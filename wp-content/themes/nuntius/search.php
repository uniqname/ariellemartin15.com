<?php
/**
 * This is the template for displaying Search Results
 *
 * @package Nuntius
 * @since Nuntius 1.0
 */

get_header(); ?>

	<div id="content">
		<div class="hfeed">

			<?php if ( have_posts() ) : ?>

			<div class="archive-header">
				<h1 class="archive-title">
					<?php printf( __( '%s', 'nuntius' ), '<span>' . get_search_query() . '</span>' ); ?>
				</h1>

				<div class="archive-description">
					<p><?php printf( __( 'You are browsing the search results for: %s.', 'nuntius' ), get_search_query() ); ?></p>
				</div><!-- .archive-description -->
			</div><!-- .archive-header -->

			<?php /* Start the Loop */ ?>

			<?php while ( have_posts() ) : the_post(); ?>

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

						<?php edit_post_link( __( '(Edit)', 'nuntius' ), '<span class="edit-link">', '</span>' ); ?>

					</div><!-- .byline -->

					<div class="entry-summary">
						<?php the_excerpt(); ?>
					</div><!-- .entry-content -->

				</div><!-- #post-<?php the_ID(); ?> -->

				<?php endwhile; ?>

			<?php else : ?>

				<div id="post-0" class="post no-results not-found">
					<h2 class="entry-title"><?php _e( 'Nothing Found', 'nuntius' ); ?></h2><!-- .entry-title -->

					<div class="entry-summary">
						<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'nuntius' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				</div><!-- #post-0 -->

			<?php endif; ?>

		</div><!-- .hfeed -->

		<?php nuntius_content_nav( 'nav-below' ); ?>

	</div><!-- #content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>