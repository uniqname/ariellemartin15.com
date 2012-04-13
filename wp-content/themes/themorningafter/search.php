<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package WordPress
 * @subpackage The Morning After
 */
get_header(); ?>

<?php get_template_part( 'top-banner' ); ?>

<?php $content_width = 540; // to override $content_width for the narrower column ?>

<div id="arch_content" class="column full-width">

	<?php if ( have_posts() ) : ?>

		<div class="column archive-info first">

			<h2 class="archive_name"><?php _e( 'Search Results','woothemes' );?></h2>

			<div class="archive_meta">

				<div class="archive_number">
					<?php
						printf( __( 'You searched for "%1$s". Your search returned %2$s results.', 'woothemes' ),
							get_search_query(),
							$NumResults = $wp_query->found_posts
						);
					?>
				</div>

			</div>

		</div><!-- end .archive-info -->

		<div class="column mid-column">

			<?php while ( have_posts() ) : the_post(); ?>

				<div class="archive_post_block clear-fix">

					<h3 class="archive_title" id="post-<?php the_ID(); ?>"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php printf( esc_attr__( 'Permalink to %s', 'woothemes' ), the_title_attribute( 'echo=0' ) ); ?>"><?php the_title(); ?></a></h3>

					<div class="archive_post_meta">
						<?php morning_after_post_meta(); ?>
						<?php if ( comments_open() || ( '0' != get_comments_number() && ! comments_open() ) ) : ?>
							<span class="comment-link"><span class="dot">&sdot;</span> <?php comments_popup_link( __( 'Leave a Comment', 'woothemes' ), __( '1 Comment', 'woothemes' ), __( '% Comments', 'woothemes' ) ); ?></span>
						<?php endif; ?>
					</div>

					<?php the_excerpt(); ?>
				</div>

			<?php endwhile; ?>

			<?php if (  $wp_query->max_num_pages > 1 ) : ?>
				<div id="nav-below" class="post-navigation clear-fix">
					<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&laquo;</span> Older posts', 'woothemes' ) ); ?></div>
					<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&raquo;</span>', 'woothemes' ) ); ?></div>
				</div>
			<?php endif; ?>

		</div><!-- end .mid-column -->

		<?php get_sidebar(); ?>

	<?php else : ?>

		<div class="column archive-info first">

			<h2 class="archive_name"><?php _e( 'Search Results','woothemes' );?></h2>

			<div class="archive_meta">

				<div class="archive_number">
					<?php
						printf( __( 'You searched for "%1$s". Your search returned %2$s results.', 'woothemes' ),
							get_search_query(),
							$NumResults = $wp_query->found_posts
						);
					?>
				</div>

			</div>

		</div><!-- end .archive-info -->

		<div class="column mid-column">
			<h3><?php _e( 'Sorry, no posts matched your criteria.', 'woothemes' ); ?></h3>
		</div><!-- end .mid-column -->

		<?php get_sidebar(); ?>

	<?php endif; ?>

</div><!-- end #arch_content -->

<?php get_footer(); ?>