<div id="sidebar">
<?php do_action( 'before_sidebar' ); ?>

<?php if (!function_exists('dynamic_sidebar')
	|| !dynamic_sidebar()) : ?>

<div class="side-widget side-posts"><div class="side-widget-wrap">
	<h3>Latest Posts</h3>
	<ul>
		<?php wp_get_archives('type=postbypost&limit=10'); ?>
	</ul>
</div></div>

<?php wp_list_bookmarks('category_before=<div class="side-widget side-links">&category_after=</div>&title_before=<h3>&title_after=</h3>'); ?>

<?php endif; ?>

</div><!-- /sidebar -->
