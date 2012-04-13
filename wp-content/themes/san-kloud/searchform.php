<?php
/**
 * @package San Kloud
 */
?>
<form method="get" id="searchform" action="<?php echo home_url( '/' ); ?>/">
	<input type="text" placeholder="<?php esc_attr_e( 'Search', 'san-kloud' ); ?>" name="s" id="s" class="search-input"/>
</form>