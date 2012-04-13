<?php
/**
 * @package Triton Lite
 */
?>
	<?php if ( is_active_sidebar( 'sidebar-2' ) ) : ?>
		<div id="midrow">
			<div class="container">
				<div class="widgets">
					<ul>
						<?php dynamic_sidebar( 'sidebar-2' ); ?>
					</ul>
				</div><!-- .widgets -->
			</div><!-- .container -->
		</div><!-- #midrow -->
	<?php endif; ?>

	<div id="footer">
		<?php if ( is_active_sidebar( 'sidebar-3' ) ) : ?>
			<div class="container">
				<div class="widgets">
					<ul>
						<?php dynamic_sidebar( 'sidebar-3' ); ?>
					</ul>
				</div><!-- .widgets -->
			</div><!-- .container -->
		<?php endif; ?>

		<div id="copyright">
			<div class="container">
				<div class="copytext">
					<a href="http://wordpress.org/" rel="generator">Proudly powered by WordPress</a>
					<?php printf( __( 'Theme: %1$s by %2$s.', 'triton-lite' ), 'Triton Lite', '<a href="http: //www.towfiqi.com/" rel="designer"> Towfiq I</a>' ); ?>
				</div><!-- copytext -->
			</div><!-- .container -->
		</div><!-- #copyright -->
	</div><!-- #footer -->
<?php wp_footer(); ?>
</body>
</html>