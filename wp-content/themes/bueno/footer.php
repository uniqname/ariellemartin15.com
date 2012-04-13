<?php
/**
 * @package WordPress
 * @subpackage Bueno
 */
?>

	<?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) ) : ?>
		<div id="extended-footer">

			<div class="col-full">

				<div class="block one">
					<?php
						if ( is_active_sidebar( 'footer-1' ) )
							dynamic_sidebar( 'footer-1' );
						else
							echo '&nbsp;';
					?>
				</div><!-- /.block -->

				<div class="block two">
					<?php
						if ( is_active_sidebar( 'footer-2' ) )
							dynamic_sidebar( 'footer-2' );
						else
							echo '&nbsp;';
					?>
				</div><!-- /.block -->

				<div class="block three">
					<?php
						if ( is_active_sidebar( 'footer-3' ) )
							dynamic_sidebar( 'footer-3' );
						else
							echo '&nbsp;';
					?>
				</div><!-- /.block -->

			</div><!-- /.col-full -->

		</div><!-- /#extended-footer -->
	<?php endif; ?>

	<div id="footer">

		<div class="col-full">

			<div id="copyright" class="col-left">
				<a href="http://wordpress.com/" rel="generator">Get a free blog at WordPress.com</a>
			</div>

			<div id="credit" class="col-right">
				<?php printf( __( 'Theme: %1$s by %2$s.', 'woothemes' ), 'Bueno', '<a href="http://www.woothemes.com/" rel="designer">WooThemes</a>' ); ?>
			</div>

		</div><!-- /.col-full -->

	</div><!-- /#footer -->

</div><!-- /#container -->
<?php wp_footer(); ?>

</body>
</html>