<?php
/**
 * @package San Kloud
 */

get_header();
?>
<div class="container-12 content">
	<div class="grid-9">
		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'single' ); ?>

			<?php comments_template( '', true ); ?>

		<?php endwhile; // end of the loop. ?>

	</div>
<?php get_sidebar();?>
<?php get_footer();?>