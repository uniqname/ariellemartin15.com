<?php
/**
 * Search Form Template
 *
 * The search form template displays the search form.
 *
 * @package Retro-fitted
 * @subpackage Template
 */
?>

<div class="search">
	<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<label for="s" class="assistive-text"><?php _e( 'Search', 'retro-fitted' ); ?></label>
		<input type="text" class="field" name="s" id="s" placeholder="<?php esc_attr_e( 'Search', 'retro-fitted' ); ?>" value="<?php the_search_query(); ?>" />
		<input type="submit" class="submit" name="submit" id="searchsubmit" value="<?php esc_attr_e( 'Search', 'retro-fitted' ); ?>" />
	</form>
</div><!-- .search -->