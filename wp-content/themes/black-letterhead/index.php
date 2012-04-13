<?php get_header();  ?>

<div id="content" class="narrowcolumn">
<?php if (have_posts()) : ?>
	<?php while (have_posts()) : the_post(); ?>
	<?php require('post.php'); ?>
<?php endwhile; ?>

<div class="navigation">
			<div class="alignleft"><?php next_posts_link(__('&laquo; Older Entries', 'black-letterhead')) ?></div>
			<div class="alignright"><?php previous_posts_link(__('Newer Entries &raquo;', 'black-letterhead')) ?></div>
		</div>

	<?php else : ?>

		<h2 class="center"><?php _e('Not Found', 'black-letterhead'); ?></h2>
		<p class="center"><?php _e("Sorry, but you are looking for something that isn't here.", 'black-letterhead'); ?></p>
		<?php get_search_form(); ?>

	<?php endif; ?>

	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
