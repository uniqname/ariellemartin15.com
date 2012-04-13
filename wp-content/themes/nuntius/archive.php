<?php
/**
 * This is the template for displaying Archives
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
					<?php if ( is_day() ) : ?>
						<?php printf( __( 'Archive | %s', 'nuntius' ), get_the_date() ); ?>
					<?php elseif ( is_month() ) : ?>
						<?php printf( __( 'Archive | %s', 'nuntius' ), get_the_date( 'F Y' ) ); ?>
					<?php elseif ( is_year() ) : ?>
						<?php printf( __( 'Archive | %s', 'nuntius' ), get_the_date( 'Y' ) ); ?>
					<?php elseif ( is_author() ) : ?>
						<?php printf( __( '%s', 'nuntius' ), get_the_author() ); ?>
					<?php elseif ( is_category() ) : ?>
						<?php printf( __( '%s', 'nuntius' ), single_cat_title( '', false) ); ?>
					<?php elseif ( is_tag() ) : ?>
						<?php printf( __( 'Tag Archive | %s', 'nuntius' ), single_tag_title( '', false ) ); ?>
					<?php else :
						_e( 'Archives', 'new' ); ?>
					<?php endif; ?>
				</h1>

				<?php if ( is_day() || is_month() || is_year() ) : ?>
					<div class="archive-description">
						<p><?php _e( 'You are browsing the site archives by date.', 'nuntius' ); ?></p>
					</div><!-- .archive-description -->
				<?php endif; ?>
			</div><!-- .archive-header -->

			<?php rewind_posts(); ?>

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
						<?php wp_link_pages( array( 'before' => '<p class="page-links">' . __( 'Pages:', 'nuntius' ), 'after' => '</p>' ) ); ?>
					</div><!-- .entry-summary -->

				</div><!-- #post-<?php the_ID(); ?> -->

				<?php endwhile; ?>

			<?php endif; ?>

		</div><!-- .hfeed -->

		<?php nuntius_content_nav( 'nav-below' ); ?>

	</div><!-- #content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>