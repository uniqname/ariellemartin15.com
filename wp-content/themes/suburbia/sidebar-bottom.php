<?php
/**
 * @package Suburbia
 */
?>

<div class="bottom">
	<?php if ( get_next_posts_link() || get_previous_posts_link() ) : ?>
		<div class="navigation">
			<h3><?php _e( 'Navigation', 'suburbia' ); ?></h3>
			<div class="nav-previous"><?php next_posts_link( __( 'Older posts', 'suburbia' ) ); ?></div>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts', 'suburbia' ) ); ?></div>
		</div>
	<?php endif; ?>
</div><!-- .bottom .navigation -->

<?php
	if (   ! is_active_sidebar( 'sidebar-2' )
		&& ! is_active_sidebar( 'sidebar-3' )
		&& ! is_active_sidebar( 'sidebar-4' )
		&& ! is_active_sidebar( 'sidebar-5' )
	)
		return;
?>

<?php if ( is_active_sidebar( 'sidebar-2' ) ) : ?>
	<div class="bottom widget-area">
		<?php dynamic_sidebar( 'sidebar-2' ); ?>
	</div><!-- .bottom .widget-area -->
<?php endif; ?>

<?php if ( is_active_sidebar( 'sidebar-3' ) ) : ?>
	<div class="bottom widget-area">
		<?php dynamic_sidebar( 'sidebar-3' ); ?>
	</div><!-- .bottom .widget-area -->
<?php endif; ?>

<?php if ( is_active_sidebar( 'sidebar-4' ) ) : ?>
	<div class="bottom widget-area">
		<?php dynamic_sidebar( 'sidebar-4' ); ?>
	</div><!-- .bottom .widget-area -->
<?php endif; ?>

<?php if ( is_active_sidebar( 'sidebar-5' ) ) : ?>
	<div class="bottom widget-area">
		<?php dynamic_sidebar( 'sidebar-5' ); ?>
	</div><!-- .bottom .widget-area -->
<?php endif; ?>