	<div class="clear"></div>

	<?php
		/* A sidebar in the footer? Yep. You can can customize
		 * your footer with three columns of widgets.
		 */
		if ( ! is_404() )
			get_sidebar( 'footer' );
	?>

</div> <!-- Close Page -->

<hr />

<p id="footer"><small>
	<?php printf( __( 'Theme: %1$s by %2$s.', 'k2_domain' ), 'K2-lite', '<a href="http://getk2.com/" rel="designer">k2 team</a>' ); ?> <a href="http://wordpress.com/" rel="generator">Get a free blog at WordPress.com</a>
	<br />
	<?php printf(__('<a href="%1$s">RSS Entries</a> and <a href="%2$s">RSS Comments</a>','k2_domain'), get_bloginfo('rss2_url'), get_bloginfo('comments_rss2_url')) ?>
</small></p>

	<?php wp_footer(); ?>
</body>
</html>