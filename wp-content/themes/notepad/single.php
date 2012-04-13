<?php
/**
 * @package WordPress
 * @subpackage Notepad
 */
?>
<?php get_header(); ?>

	<div id="content">

		<p class="post-nav">
			<span class="previous">
				<?php previous_post_link('%link') ?>
			</span>
			<span class="next">
				<?php next_post_link('%link') ?>
			</span>
		</p>

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

		<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
			<h2 class="post-title">
				<?php the_title(); ?>
			</h2>
			<p class="post-date">
				<?php the_time( get_option( 'date_format' ) ) ?>
			</p>
			<p class="post-data">
				<span class="postauthor">
					<?php the_author_link(); ?>
				</span>
				<span class="postcategory">
					<?php the_category( ', ' ) ?>
				</span>
				<?php the_tags( '<span class="posttag">', ', ', '</span>' ); ?>
				<span class="postcomment">
					<?php comments_popup_link(__( 'Leave a comment','notepad-theme' ), __( '1 Comment','notepad-theme' ), __( '% Comments','notepad-theme' ) ); ?>
				</span>
				<?php edit_post_link(__( '[Edit]','notepad-theme' ) ); ?>
			</p>
			<div class="post-content">
				<?php the_content(__( 'More','notepad-theme' ) ); ?>
			</div>
			<?php wp_link_pages( array( 'before' => '<p><strong>'.__( 'Pages:','notepad-theme' ).'</strong> ', 'after' => '</p>', 'next_or_number' => 'number') ); ?>
		</div>
		<!--/post -->

		<?php comments_template(); ?>

		<p class="post-nav">
			<span class="previous">
				<?php previous_post_link( '%link' ) ?>
			</span>
			<span class="next">
				<?php next_post_link( '%link' ) ?>
			</span>
		</p>

	<?php endwhile; else: ?>

		<p>Sorry, no posts matched your criteria.</p>

	<?php endif; ?>


	</div>
	<!--/content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>