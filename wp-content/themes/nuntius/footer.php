<?php
/**
 * Footer Template
 * @package Nuntius
 */
?>
		</div><!-- #container -->

		<div id="footer">
			<div id="menu-footer" class="menu-container">
				<div class="wrap">
				<?php wp_nav_menu( array( 'theme_location' => 'footer-menu', 'container_class' => 'menu', 'menu_class' => '', 'menu_id' => 'menu-footer-items', 'depth' => 1, 'fallback_cb' => '' ) ); ?>
				</div><!-- .wrap -->
			</div><!-- #menu-footer .menu-container -->

			<div id="colophon">
				<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'nuntius' ) ); ?>" title="<?php esc_attr_e( 'Semantic Personal Publishing Platform', 'nuntius' ); ?>" rel="generator"><?php printf( __( 'Proudly powered by %s', 'nuntius' ), 'WordPress' ); ?></a>
				<span class="sep"> | </span>
				<?php printf( __( 'Theme: %1$s.', 'nuntius' ), 'Nuntius' ); ?>
			</div><!-- #colophon -->
		</div><!-- #footer -->
	</div><!-- #body-container -->

	<?php wp_footer(); ?>

</body>
</html>