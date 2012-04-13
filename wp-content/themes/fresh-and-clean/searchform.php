<?php
/**
 * The template for displaying search forms in Fresh & Clean
 *
 * @package Fresh & Clean
 */
?>
	<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<label for="s" class="assistive-text"><?php _e( 'Search', 'fresh-and-clean' ); ?></label>
		<input type="text" class="field" name="s" id="s" placeholder="<?php esc_attr_e( 'Search', 'fresh-and-clean' ); ?>" />
		<input type="submit" class="submit" name="submit" id="searchsubmit" value="<?php esc_attr_e( 'Search', 'fresh-and-clean' ); ?>" />
	</form>
