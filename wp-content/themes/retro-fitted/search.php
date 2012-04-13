<?php
/**
 * Search Template
 *
 * The search template is loaded when a visitor uses the search form to search for something
 * on the site.
 *
 * @package Retro-fitted
 * @subpackage Template
 */

get_header(); // Loads the header.php template. ?>

	<div id="content">

		<div class="hfeed">

			<div class="loop-meta">

				<h1 class="loop-title"><?php _e( 'Search Results', 'retro-fitted' ); ?></h1>

				<div class="loop-description">
					<?php if ( have_posts() ) : ?>
						<p><?php printf( __( 'You are browsing the search results for &quot;%1$s&quot;.', 'retro-fitted' ), get_search_query() ); ?></p>
					<?php else : ?>
						<p><?php printf( __( 'No results found for &quot;%1$s&quot;.', 'retro-fitted' ), get_search_query() ); ?></p>
					<?php endif; ?>

				</div><!-- .loop-description -->

			</div><!-- .loop-meta -->

			<?php while ( have_posts() ) : the_post(); ?>

				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<?php the_title( '<h1 class="entry-title"><a href="' . esc_attr( get_permalink() ) . '" title="' . the_title_attribute( array( 'echo' => 0 ) ) . '" rel="bookmark">', '</a></h1>' ); ?>

					<div class="entry-summary">
						<?php the_excerpt(); ?>
					</div><!-- .entry-summary -->

					<div class="entry-meta">
						<a class="permalink" href="<?php echo esc_url( get_permalink() ); ?>"><time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>" title="<?php echo esc_attr( sprintf( __( 'Posted at %1$s', 'retro-fitted' ), get_the_time( get_option( 'time_format' ) ) ) ); ?>" pubdate><?php echo get_the_time( get_option( 'date_format' ) ); ?></time></a>
					</div>

				</div><!-- .hentry -->

			<?php endwhile; ?>

		</div><!-- .hfeed -->

		<?php get_template_part( 'nav-posts' ); ?>

	</div><!-- #content -->

	<?php get_sidebar(); ?>

<?php get_footer(); ?>