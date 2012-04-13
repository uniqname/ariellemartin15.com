<?php
/**
 * The Footer widget areas.
 * @package WordPress
 */
?>

<?php
	/* The footer widget area is triggered if any of the areas
	 * have widgets. So let's check that first.
	 *
	 * If none of the sidebars have widgets, then let's bail early.
	 */
	if (   ! is_active_sidebar( 'sidebar-2' )
		&& ! is_active_sidebar( 'sidebar-3' )
		&& ! is_active_sidebar( 'sidebar-4'  )
		&& ! is_active_sidebar( 'sidebar-5' )
		&& ! is_active_sidebar( 'sidebar-6' )

	)
		return;
	// If we get this far, we have widgets. Let do this.
?>


<div id="footer-widget-area" role="complementary">

<?php if ( is_active_sidebar( 'sidebar-2' ) ) : ?>
	<div id="first" class="widget-area">
		<ul class="fade">
			<?php dynamic_sidebar( 'sidebar-2' ); ?>
		</ul>
	</div><!-- #first .widget-area -->
<?php endif; ?>

<?php if ( is_active_sidebar( 'sidebar-3' ) ) : ?>
	<div id="second" class="widget-area">
		<ul class="fade">
			<?php dynamic_sidebar( 'sidebar-3' ); ?>
		</ul>
	</div><!-- #second .widget-area -->
<?php endif; ?>

<?php if ( is_active_sidebar( 'sidebar-4' ) ) : ?>
	<div id="third" class="widget-area">
		<ul class="fade">
			<?php dynamic_sidebar( 'sidebar-4' ); ?>
		</ul>
	</div><!-- #third .widget-area -->
<?php endif; ?>

<?php if ( is_active_sidebar( 'sidebar-5' ) ) : ?>
	<div id="fourth" class="widget-area">
		<ul class="fade">
			<?php dynamic_sidebar( 'sidebar-5' ); ?>
		</ul>
	</div><!-- #fourth .widget-area -->
<?php endif; ?>

<?php if ( is_active_sidebar( 'sidebar-6' ) ) : ?>
	<div id="fifth" class="widget-area">
		<ul class="fade">
			<?php dynamic_sidebar( 'sidebar-6' ); ?>
		</ul>
	</div><!-- #fifth .widget-area -->
<?php endif; ?>

</div><!-- #footer-widget-area -->
<div id="footer-widget-area-bot"></div>