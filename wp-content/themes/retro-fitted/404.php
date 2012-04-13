<?php
/**
 * 404 Template
 *
 * The 404 template is used when a reader visits an invalid URL on your site. By default, the template will
 * display a generic message.
 *
 * @package Retro-fitted
 * @subpackage Template
 * @link http://codex.wordpress.org/Creating_an_Error_404_Page
 */
?>

<?php get_header(); ?>

	<div id="content">

		<div class="hfeed">

			<div id="error-404" class="hentry">

				<h1 class="error-404-title entry-title"><?php _e( 'Not Found', 'retro-fitted' ); ?></h1>

				<div class="entry-content">

					<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'retro-fitted' ); ?></p>

					<?php get_search_form(); ?>

				</div><!-- .entry-content -->

			</div><!-- .hentry -->

		</div><!-- .hfeed -->

	</div><!-- #content -->

<?php get_footer(); ?>