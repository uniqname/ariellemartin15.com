<form method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
	<div>
		<input type="text" name="s" id="s" placeholder="<?php esc_attr_e( 'Search', 'ocean-mist' ); ?>" />
		<input type="image" src="<?php bloginfo('stylesheet_directory'); ?>/images/button-search<?php if ( is_rtl() ) echo '-rtl';?>.gif" id="searchsubmit" value="<?php esc_attr_e( 'Search', 'ocean-mist' ); ?>" />
	</div>
</form>
