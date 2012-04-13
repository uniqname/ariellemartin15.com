<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Splendio
 */

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @since splendio 1.0
 */
function splendio_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'splendio_page_menu_args' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @since splendio 1.0
 */
function splendio_body_classes( $classes ) {
	// Adds a class of single-author to blogs with only 1 published author
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}
add_filter( 'body_class', 'splendio_body_classes' );

/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 *
 */
function splendio_enhanced_image_navigation( $url, $id ) {
	if ( ! is_attachment() && ! wp_attachment_is_image( $id ) )
		return $url;

	$image = get_post( $id );
	if ( ! empty( $image->post_parent ) && $image->post_parent != $id )
		$url .= '#main';

	return $url;
}
add_filter( 'attachment_link', 'splendio_enhanced_image_navigation', 10, 2 );

/**
 * Sets the post excerpt length to 55 words.
 *
 */
function splendio_excerpt_length( $length ) {
	return 55;
}
add_filter( 'excerpt_length', 'splendio_excerpt_length' );

/**
 * Returns a "Continue Reading" link for excerpts
 *
 */
function splendio_continue_reading_link() {
	return ' <a href="'. get_permalink() . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'splendio' ) . '</a>';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and splendio_continue_reading_link().
 *
 */
function splendio_auto_excerpt_more( $more ) {
	return ' &hellip;' . splendio_continue_reading_link();
}
add_filter( 'excerpt_more', 'splendio_auto_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 */
function splendio_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= splendio_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'splendio_custom_excerpt_more' );

/**
 * Removes the default styles that are packaged with the Recent Comments widget.
 *
 */
function splendio_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}
add_action( 'widgets_init', 'splendio_remove_recent_comments_style' );