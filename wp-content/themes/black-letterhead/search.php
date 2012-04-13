<?php get_header(); ?>
<!-- borrowed directly from Kubrick -->

	<div id="content" class="narrowcolumn">

	<?php if (have_posts()) : ?>

		<h2 class="pagetitle"><?php _e('Search Results'); ?></h2>

		<div class="navigation">
			<div class="alignleft"><?php next_posts_link(__('&laquo; Older Entries')) ?></div>
			<div class="alignright"><?php previous_posts_link(__('Newer Entries &raquo;')) ?></div>
		</div>


		<?php while (have_posts()) : the_post(); ?>

			<div <?php post_class(); ?>>
				<h2 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h2>
				<small><?php the_time(get_option("date_format")); ?></small>

				<div class="entry">
					<?php the_excerpt() ?>
				</div>

				<p class="postmetadata">
					<?php
						if ( 'post' == get_post_type() )
							_e( 'Posted in ' ); the_category( ', ' );
						
						edit_post_link( __( 'Edit' ), ' | ', '' );
						
						if ( comments_open() || '0' != get_comments_number() ) :
							if ( 'post' == get_post_type() || current_user_can( 'edit_posts' ) )
								_e( ' | ' );
							comments_popup_link( __( 'Leave a Comment &#187;' ), __( '1 Comment &#187;' ), __( '% Comments &#187;' ) );
						endif;
					?>
				</p>

			</div>

		<?php endwhile; ?>

		<div class="navigation">
			<div class="alignleft"><?php next_posts_link(__('&laquo; Older Entries')) ?></div>
			<div class="alignright"><?php previous_posts_link(__('Newer Entries &raquo;')) ?></div>
		</div>

	<?php else : ?>

		<h2 class="center"><?php _e('Not Found'); ?></h2>
		<?php get_search_form(); ?>

	<?php endif; ?>

	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
