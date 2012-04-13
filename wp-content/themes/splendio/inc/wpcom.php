<?php
/**
 * WordPress.com-specific functions and definitions
 *
 * @package Splendio
 */

global $themecolors;

/**
 * Set a default theme color array for WP.com.
 * @global array $themecolors
 */
$themecolors = array(
	'bg' => 'e9e9dc',
	'border' => 'ccccc',
	'text' => '333333',
	'link' => 'ec8500',
	'url' => 'ec8500',
);

// Dequeue font styles
function splendio_dequeue_fonts() {
	/**
	 * We don't want to enqueue the font scripts if the blog
	 * has WP.com Custom Design.
	 *
	*/
	if ( class_exists( 'TypekitData' ) ) {
		if ( TypekitData::get( 'upgraded' ) ) {
			$customfonts = TypekitData::get( 'families' );
			if ( ! $customfonts )
				return;
			$headings = $customfonts['headings'];

			if ( $headings['id'] ) {
				wp_dequeue_style( 'droid sans' );
			}
		}
	}
}
add_action( 'wp_enqueue_scripts', 'splendio_dequeue_fonts' );