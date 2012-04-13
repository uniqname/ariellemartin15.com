<!-- begin footer -->
<hr />
	<div id="footer">
	<p><?php printf( __( 'Theme: %1$s by %2$s', 'greenmarinee' ), 'Green Marinee', '<a href="http://e-lusion.com" rel="designer">Ian Main</a>' ); ?> &#8212; <a href="http://wordpress.com/" rel="generator">Get a free blog at WordPress.com</a></p>
		<div class="extras">
			<ul>
				<li><a href="<?php bloginfo('rss2_url'); ?>" title="<?php esc_attr_e( 'Subscribe to RSS feed', 'greenmarinee' ); ?>">RSS</a></li>
				<li><a href="<?php bloginfo('comments_rss2_url'); ?>" title="<?php esc_attr_e( 'Subscribe to Comments RSS feed', 'greenmarinee' ); ?>"><?php _e('Comments RSS','greenmarinee'); ?></a></li>
				<li><?php _e('<a href="http://wordpress.com/" title="Powered by the lovely WordPress.com">WP</a>','greenmarinee'); ?></li>
			</ul>
		</div>
	</div>
	</div>
	</div>
	</div>
	</div>
</div>
<?php wp_footer(); ?>
</body>
</html>