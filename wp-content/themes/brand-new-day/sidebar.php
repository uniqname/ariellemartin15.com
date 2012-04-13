<?php
/**
 * @package Brand New Day
 */

$options = brand_new_day_get_theme_options();

$brand_new_day_sidebaroptions = $options['sidebar_options'];
$brand_new_day_quickblog = $options['simple_blog'];

?>

<ul id="sidebar" class="sidebar" <?php if ( "no-sidebar" == $brand_new_day_sidebaroptions || 'on' == $brand_new_day_quickblog ) { echo "style='display: none;'"; } ?>>
	<li id="navmenu" class="navmenu">
		<?php wp_nav_menu( array( 'theme_location' => 'main' ) ); ?>
	</li>
	<?php dynamic_sidebar( __( 'Vertical Sidebar' , 'brand-new-day' ) ); ?>
</ul>
