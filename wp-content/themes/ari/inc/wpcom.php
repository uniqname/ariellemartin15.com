<?php
/**
 * WordPress.com-specific functions and definitions
 *
 * @package Ari
 * @since Ari 1.1.2
 */

global $themecolors;

/**
 * Set a default theme color array for WP.com.
 *
 * @global array $themecolors
 * @since Ari 1.1.2
 */
$options = ari_get_theme_options();
$current_color_scheme = $options['color_scheme'];
$first_link_color = strtolower( ltrim( $options['first_link_color'], '#' ) );
$text_color = strtolower( ltrim( $options['text_color'], '#' ) );
switch ( $current_color_scheme ) {
	case 'dark' :
		$themecolors = array(
			'bg' => '1b1c1b',
			'border' => '4c4c4c',
			'text' => $text_color,
			'link' => $first_link_color,
			'url' => $first_link_color
		);
	break;
	default :
		$themecolors = array(
			'bg' => 'ffffff',
			'border' => '4c4c4c',
			'text' => $text_color,
			'link' => $first_link_color,
			'url' => $first_link_color
		);
}
// Dequeue the font script if the blog has WP.com Custom Design.
function ari_dequeue_fonts() {
	if ( class_exists( 'TypekitData' ) ) {
		if ( TypekitData::get( 'upgraded' ) ) {
			$customfonts = TypekitData::get( 'families' );

			if ( ! $customfonts )
				return;

			$site_title = $customfonts['site-title'];
			$headings = $customfonts['headings'];
			$body_text = $customfonts['body-text'];

			if ( $site_title['id'] && $headings['id'] && $body_text['id'] ) {
				wp_dequeue_style( 'ari-droid-sans' );
				wp_dequeue_style( 'ari-droid-serif' );
			}
		}
	}
}
add_action( 'wp_enqueue_scripts', 'ari_dequeue_fonts' );
