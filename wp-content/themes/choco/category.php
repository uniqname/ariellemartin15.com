<?php
/**
 * The template for displaying Category Archive pages.
 *
 * @package WordPress
 * @subpackage Choco
 */

get_header(); ?>

					<h1 class="page-title"><?php printf( __( 'Category Archives: %s', 'choco' ), '<span>' . single_cat_title( '', false ) . '</span>' );?></h1>
					<div class="list-page">
					<?php
						$category_description = category_description();
						if ( ! empty( $category_description ) )
						echo '<div class="archive-meta">' . $category_description . '</div>';

					/* Run the loop for the category page to output the posts.
					* If you want to overload this in a child theme then include a file
					* called loop-category.php and that will be used instead.
					*/
						get_template_part( 'loop', 'category' );
					?>
					</div><!-- #list-page -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>