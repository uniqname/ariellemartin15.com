<?php
/**
 * @package Triton Lite
 */
get_header(); ?>

<div class="container">
	<div class="search-term">
		<h2 class="archive-title">
			<?php printf( __( 'Search Results for: %s', 'triton-lite' ), '<span>' . get_search_query() . '</span>' ); ?>
		</h2>
		<?php get_search_form(); ?>
	</div><!-- .search-term -->
	<?php get_template_part( 'loop', 'search' ); ?>
</div><!-- .container -->

<?php get_footer(); ?>