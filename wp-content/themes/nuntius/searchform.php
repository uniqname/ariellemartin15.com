<?php
/**
 * This is the search form template that displays the search form.
 *
 * @package Nuntius
 * @since Nuntius 1.0
 */
?>
<div id="search" class="search">

	<form method="get" class="search-form" id="search-form" action="<?php echo trailingslashit( home_url() ); ?>">
	<div>
		<input class="search-text" type="text" name="s" id="search-text" value="<?php if ( is_search() ) echo esc_attr( get_search_query() ); else esc_attr_e( 'Search this site...', 'nuntius' ); ?>" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" />
		<input class="search-submit button" name="submit" type="submit" id="search-submit" value="<?php esc_attr_e( 'Search', 'nuntius' ); ?>" />
	</div>
	</form><!-- .search-form -->

</div><!-- .search -->