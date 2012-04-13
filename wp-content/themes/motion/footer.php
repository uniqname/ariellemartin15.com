<?php
/**
 * @package Motion
 */
?>

<div id="footer">

	<div class="foot1">
		<ul>
			<?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'footer_left' ) ) : ?>
			<li>
				<h3><?php _e( 'Friends &amp; links' ); ?></h3>
				<ul>
				<?php wp_list_bookmarks( 'title_li=&categorize=0' ); ?>
				</ul>
			</li>
			<?php endif; ?>
		</ul>
	</div>

	<div class="foot2">
		<ul>
			<?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'footer_middle' ) ) : ?>
			<li>
				<h3><?php _e( 'Pages' ); ?></h3>
				<ul>
				<?php wp_list_pages( 'title_li=' ); ?>
				</ul>
			</li>
			<?php endif; ?>
		</ul>
	</div>

	<div class="foot3">
		<ul>
			<?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'footer_right' ) ) : ?>
			<li>
				<h3><?php _e( 'Monthly archives' ); ?></h3>
				<ul>
				<?php wp_get_archives( 'type=monthly&limit=5' ); ?>
				</ul>
			</li>
			<?php endif; ?>
		</ul>
	</div>

</div><!-- /footer -->

<div id="credits">
	<div id="creditsleft"><a href="http://wordpress.com/" rel="generator">Get a free blog at WordPress.com</a> | <?php printf( __( 'Theme: %1$s by %2$s.' ), 'Motion', '<a href="http://www.webdesigncompany.net/motion/" rel="designer">volcanic</a>' ); ?></div>
	<div id="creditsright"><a href="#top">[ <?php _e( 'Back to top' ); ?> ]</a></div>
</div><!-- /credits -->

</div><!-- /wrapper -->

<?php wp_footer(); ?>
</body>
</html>
