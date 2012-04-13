<?php
/**
 * @package WordPress
 * @subpackage Structure
 */
get_header();
?>

<div id="content">

	<div id="contentleft" class="narrowcolumn">

		<!-- This sets the $curauth variable -->

		<?php $author_id = get_queried_object_id(); ?>

		<div class="posttitle">
			<h3><?php the_author_meta( 'display_name', $author_id ); ?></h3>
        </div>

        <p><?php if(function_exists('get_avatar')) { echo get_avatar($author, '120'); } ?></p>
		<p><strong><?php _e("Profile:", 'structuretheme'); ?></strong> <?php the_author_meta( 'user_description', $author_id ); ?></p>
		<h5><?php _e("Posts by", 'structuretheme'); ?> <?php the_author_meta( 'display_name', $author_id ); ?>:</h5>

		<ul>

			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
				<?php the_title(); ?></a>
			</li>
			<?php endwhile; else: ?>
			<p><?php _e('No posts by this author.'); ?></p>
			<?php endif; ?>

		</ul>

	</div>

	<?php get_sidebar( 'right' ); ?>

</div>

<!-- The main column ends  -->

<?php get_footer(); ?>