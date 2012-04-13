<?php
/**
 * Feature Sidebar Template
 *
 * The Feature sidebar first checks for an active sidebar of 'utility-feature'. If this sidebar isn't
 * active, it displays a list of top articles from the month.
 *
 * @package Nuntius
 * @since Nuntius 1.0
 */

if ( is_active_sidebar( 'sidebar-3' ) ) : ?>

	<div id="sidebar-feature" class="sidebar utility">

		<?php dynamic_sidebar( 'sidebar-3' ); ?>

	</div><!-- #sidebar-feature .utility -->

<?php else : ?>

	<div id="sidebar-feature" class="sidebar utility">

		<div class="widget widget-top-articles">

			<div class="widget-inside">

				<h3 class="widget-title"><?php _e( 'Top Articles', 'nuntius' ); ?></h3>

			<?php $loop = new WP_Query( array( 'meta_key' => 'Views', 'orderby' => 'meta_value', 'monthnum' => date( 'm' ), 'posts_per_page' => 3 ) ); ?>

			<?php if ( !$loop->have_posts() )
					$loop = new WP_Query( array( 'orderby' => 'comment_count', 'posts_per_page' => 4, 'caller_get_posts' => true ) );
			?>

				<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

					<div <?php post_class(); ?>>

						<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php echo esc_attr( sprintf( __( 'Permanent Link to %s', 'nuntius' ), the_title_attribute( 'echo=0' ) ) ); ?>">
							<?php the_post_thumbnail( 'nuntius-thumbnail', array( 'class' => 'nuntius-thumbnail', 'alt' => get_the_title(), 'title' => get_the_title() ) ); ?>
						</a>

						<h2 class="entry-title">
							<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'nuntius' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
						</h2><!-- .entry-title -->

						<div class="byline">
							<?php
								printf( __( '<span class="entry-date"><a href="%1$s" rel="bookmark" title="%3$s">%2$s</a></span>', 'nuntius' ),
									get_permalink(),
									get_the_date(),
									esc_attr( get_the_time() )
								);
							?>
							<?php if ( comments_open() || ( '0' != get_comments_number() && ! comments_open() ) ) : ?>
								<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'nuntius' ), __( '1 Comment', 'nuntius' ), __( '% Comments', 'nuntius' ) ); ?></span>
							<?php endif; ?>

							<?php edit_post_link( __( '(Edit)', 'nuntius' ), '<span class="edit-link">', '</span>' ); ?>

						</div><!-- .byline -->

					</div><!-- .hentry -->

				<?php endwhile; ?>

			</div><!-- .widget-inside -->

		</div><!-- .widget -->

		<?php wp_reset_query(); ?>

	</div><!-- #sidebar-feature .utility -->

<?php endif; ?>