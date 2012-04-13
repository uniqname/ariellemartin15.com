<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Ari
 * @since Ari 1.1.2
 */
?>

<?php if ( has_nav_menu( 'primary' ) ) : ?>
	<nav role="navigation" class="site-navigation main-navigation">
		<h1 class="assistive-text"><?php _e( 'Menu', 'ari' ); ?></h1>
		<div class="assistive-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'ari' ); ?>"><?php _e( 'Skip to content', 'ari' ); ?></a></div>

		<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
	</nav>
<?php endif; ?>

<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
	<div id="secondary" class="widget-area" role="complementary">
		<?php do_action( 'before_sidebar' ); ?>
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
	</div><!-- #secondary .widget-area -->
<?php endif; // end sidebar widget area ?>