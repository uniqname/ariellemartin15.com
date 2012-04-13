<?php get_header(); ?>

		<div id="content_wrapper">
			<div id="content">

			<?php $author_id = get_queried_object_id(); ?>

			<h1><?php _e( 'About', 'fadtastic' ); ?> <?php the_author_meta( 'display_name', $author_id ); ?></h1>

			<?php
			$description = get_the_author_meta( 'description' );
			if ( ! empty( $description ) )
				echo '<p><strong>' . __( 'Profile:', 'fadtastic' ) . '</strong> ' . $description . '</p>';

			$url = get_the_author_meta( 'url' );
			if ( ! empty( $url ) && 'http://' != $url )
				echo '<p><strong>' . __( 'Website:', 'fadtastic' ) . '</strong> <a href="' . esc_url( $url ) . '">' . esc_html( $url ) . '</a></p>';
			?>

			<h2 class="top_border"><?php _e( 'Latest posts by', 'fadtastic' ); ?> <?php the_author_meta( 'display_name', $author_id ); ?>:</h2>

			<!-- The Loop -->
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			 <p><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php echo esc_attr( sprintf( __( 'Permanent link to %s' ), the_title_attribute( 'echo=0' ) ) ); ?>">
			<?php the_title(); ?></a><br />
			<small><?php the_time( get_option( 'date_format' ) ); ?> <?php _e( 'Filed under:', 'fadtastic' ); ?> <?php the_category( ', ' ); ?> | <?php the_tags( __( 'Tags: ' ), ', ', ' | '); ?> <?php edit_post_link( __( 'Edit This' ) ); ?></small></p>

			  <?php endwhile; else: ?>
				 <p><?php _e( 'No posts by this author.' ); ?></p>

				<?php endif; ?>

			</div>
		</div>

	<?php get_sidebar(); ?>

<?php get_footer(); ?>
