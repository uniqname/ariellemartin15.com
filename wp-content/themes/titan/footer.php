<?php
/**
 * @package Titan
 */
?>
</div><!--end wrapper-->
</div><!--end content-background-->

<div id="footer">
	<div class="wrapper clear">
		<?php if ( is_active_sidebar( 'footer_left' ) || is_active_sidebar( 'footer_center' ) || is_active_sidebar( 'footer_right' ) ) : ?>
			<div id="footer-first" class="footer-column">
				<ul>
					<?php
						if ( is_active_sidebar( 'footer_left' ) )
							dynamic_sidebar( 'footer_left' );
						else
							echo '&nbsp;';
					?>
				</ul>
			</div>
	
			<div id="footer-second" class="footer-column">
				<ul>
					<?php
						if ( is_active_sidebar( 'footer_center' ) )
							dynamic_sidebar( 'footer_center' );
						else
							echo '&nbsp;';
					?>
				</ul>
			</div>
	
			<div id="footer-third" class="footer-column">
				<ul>
					<?php
						if ( is_active_sidebar( 'footer_right' ) )
							dynamic_sidebar( 'footer_right' );
						else
							echo '&nbsp;';
					?>
				</ul>
			</div>
		<?php endif; ?>

		<div id="copyright">
			<p class="copyright-notice"><a href="http://wordpress.com/" rel="generator">Get a free blog at WordPress.com</a> | <?php printf( __( 'Theme: %1$s by %2$s.', 'titan' ), 'Titan', '<a href="http://thethemefoundry.com/" rel="designer">The Theme Foundry</a>' ); ?></p>
		</div>
	</div><!--end wrapper-->
</div><!--end footer-->

<?php wp_footer(); ?>
</body>
</html>