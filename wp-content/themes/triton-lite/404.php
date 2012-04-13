<?php
/**
 * @package Triton Lite
 */
get_header(); ?>

<div class="container">
	<div class="error-page">
		<div class="fourofour">
			<a><?php _e( '404', 'triton-lite' ); ?></a>
		</div><!-- .fourofour -->

		<div class="post">
			<h2>
				<?php _e( 'Not Found', 'triton-lite' ); ?>
			</h2>
			<p>
				<?php _e( 'Apologies, but the page you requested could not be found. Perhaps searching will help.', 'triton-lite' ); ?>
			</p>
			<?php get_search_form(); ?>
		</div><!-- .post -->
	</div><!-- .error-page -->
</div><!-- .container -->

<?php get_footer(); ?>