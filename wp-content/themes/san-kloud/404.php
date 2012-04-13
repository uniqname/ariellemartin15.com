<?php
/**
 * @package San Kloud
 */

get_header();
?>
<div class="container-12 content">
	<div class="grid-9">
		<div class="four-oh-four">
			<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/404.png" />
			<h1 class="archive-title"><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'san-kloud' ); ?></h1>
			<p><?php get_search_form(); ?></p>
		</div>
	</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>