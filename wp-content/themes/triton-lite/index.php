<?php
/**
 * @package Triton Lite
 */
get_header(); ?>
				
<?php if ( is_front_page() ) : ?>
<div id="slider-wrapper">
	<?php get_template_part( 'slider' ); ?>
</div><!-- #slider-wrapper -->
<?php endif; ?>

<div class="container">
	<?php get_template_part( 'loop', 'index' ); ?>
</div><!-- .container -->

<?php get_footer(); ?>