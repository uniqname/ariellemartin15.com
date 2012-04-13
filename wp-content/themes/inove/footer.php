<?php
/**
 * @package INove
 */
?>
	</div>
	<!-- main END -->

	<?php
		$options = get_option('inove_options');
		global $inove_nosidebar;
		if(!$options['nosidebar'] && !$inove_nosidebar) {
			get_sidebar();
		}
	?>
	<div class="fixed"></div>
</div>
<!-- content END -->

<!-- footer START -->
<div id="footer">
	<a id="gotop" href="#" onclick="MGJS.goTop();return false;"><?php _e('Top', 'inove'); ?></a>
	<a id="powered" href="http://wordpress.com/">WordPress</a>
	<div id="themeinfo">
		<a href="http://wordpress.com/" rel="generator">Get a free blog at WordPress.com</a>. <?php printf( __( 'Theme: %1$s by %2$s.', 'inove' ), 'INove', '<a href="http://www.neoease.com/" rel="designer">NeoEase</a>' ); ?>
	</div>
</div>
<!-- footer END -->

</div>
<!-- container END -->
</div>
<!-- wrap END -->

<?php wp_footer(); ?>

</body>
</html>
