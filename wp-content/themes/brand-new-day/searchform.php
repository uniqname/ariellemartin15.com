<?php
/**
 * @package Brand New Day
 */
?>

<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="s" class="assistive-text"><?php _e( 'Search:' , 'brand-new-day' ); ?></label>
	<input type="text" class="field" name="s" id="s" size="8" />
	<input type="submit" class="submit" name="submit" id="searchsubmit" value="<?php esc_attr_e( 'Go' , 'brand-new-day' ); ?>" />
</form>
