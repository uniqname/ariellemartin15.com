<?php
/**
 * Footer Template
 *
 * The footer template is generally used on every page of your site. Nearly all other
 * templates call it somewhere near the bottom of the file. It is used mostly as a closing
 * wrapper, which is opened with the header.php file. It also executes key functions needed
 * by the theme, child themes, and plugins.
 *
 * @package Retro-fitted
 * @subpackage Template
 */
?>

			</div><!-- .wrap -->

		</div><!-- #main -->

		<div id="footer">

			<div class="wrap">
				<p class="credit">
					<a href="http://wordpress.org/" rel="generator">Proudly powered by WordPress</a>
					<?php printf( __( 'Theme: %1$s by %2$s.', 'retro-fitted' ), 'Retro-Fitted', '<a href="http://justintadlock.com/" rel="designer">Justin Tadlock</a>' ); ?>
				</p>
			</div><!-- .wrap -->

		</div><!-- #footer -->

	</div><!-- #container -->

	<?php wp_footer(); ?>

</body>
</html>