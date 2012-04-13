<?php
/**
 * @package Suburbia
 */
?>
<?php get_header(); ?>

<div id="post-0" class="post error404 not-found">
	<div id="single">
		<h1><?php _e( 'This is somewhat embarrassing, isn&rsquo;t it?', 'suburbia' ); ?></h1>
		<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'suburbia' ); ?></p>
		<?php get_search_form(); ?>
	</div><!-- #single -->
</div><!-- #post-0 -->

<div id="bottom-wrapper" class="clear">
	<?php get_template_part( 'sidebar-bottom' ); ?>
</div>

<?php get_footer(); ?>