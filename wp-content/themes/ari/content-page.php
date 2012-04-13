<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Ari
 * @since Ari 1.1.2
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'clear-fix' ); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'ari' ), 'after' => '</div>' ) ); ?>
		<?php edit_post_link( __( 'Edit this page &rarr;', 'ari' ), '<span class="edit-link">', '</span>' ); ?>
	</div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->
