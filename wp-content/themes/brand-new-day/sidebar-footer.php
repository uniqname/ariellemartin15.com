<?php
/**
 * @package Brand New Day
 */
?>

<?php if ( is_active_sidebar( 'footer-sidebar1' ) ) : ?>
	<ul id="footer-sidebar1" class="footer-sidebar">
	<?php dynamic_sidebar( 'footer-sidebar1' ); ?>
	</ul>
<?php endif; ?>

<?php if ( is_active_sidebar( 'footer-sidebar2' ) ) : ?>
	<ul id="footer-sidebar2" class="footer-sidebar">
	<?php dynamic_sidebar( 'footer-sidebar2' ); ?>
	</ul>
<?php endif; ?>

<?php if ( is_active_sidebar( 'footer-sidebar3' ) ) : ?>
	<ul id="footer-sidebar3" class="footer-sidebar">
	<?php dynamic_sidebar( 'footer-sidebar3' ); ?>
	</ul>
<?php endif; ?>

<?php if ( is_active_sidebar( 'footer-sidebar4' ) ) : ?>
	<ul id="footer-sidebar4" class="footer-sidebar">
	<?php dynamic_sidebar( 'footer-sidebar4' ); ?>
	</ul>
<?php endif; ?>