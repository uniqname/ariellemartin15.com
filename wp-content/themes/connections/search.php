<?php get_header() ?>
	<div id="main">
	<div id="content">
	<?php if ($posts) { ?>
		<?php $post = $posts[0]; /* Hack. Set $post so that the_date() works. */ ?>
		<h3>Search Results for '<?php the_search_query(); ?>'</h3>
		<div class="post-info"><?php _e('Did you find what you wanted ?') ?></div>
		<br/>
		<?php foreach ($posts as $post) : the_post(); ?>
			<?php require('post.php'); ?>
		<?php endforeach; ?>
		<div class="navigation">
			<div class="alignleft"><?php posts_nav_link('', '', __('&laquo; Older Entries')) ?></div>
			<div class="alignright"><?php posts_nav_link('', __('Newer Entries &raquo;'), '') ?></div>
		</div>
	<?php } else { ?>
		<h2 class="center"><?php _e('Not Found') ?></h2>
		<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
		<?php get_search_form(); ?>
	<?php } ?>
	</div>
	<div id="sidebar">
		<h2><?php _e('Currently Browsing') ?></h2>
		<ul>
			<li><p><?php printf( __( 'You have searched the archives for %1$s. If you are unable to find anything in these search results, you can try one of these links.', 'connections' ), '<strong>' . get_search_query() . '</strong>' ); ?></p></li>
		</ul>
		<?php get_sidebar(); ?>
	</div>
<?php get_footer(); ?>
</div>
</div>
</body>
</html>
