<?php
/**
 * Loop Nav Template
 *
 * This template is used to show your your next/previous
 * post links in templates that display multiple posts.
 *
 * @package Retro-fitted
 * @subpackage Template
 */
?>

<nav id="nav-posts" class="paged-navigation contain">
	<h1 class="assistive-text"><?php _e( 'Posts navigation', 'retro-fitted' ); ?></h1>
	<div class="nav-older"><?php next_posts_link( __( '&larr; Older', 'retro-fitted' ) ); ?></div>
	<div class="nav-newer"><?php previous_posts_link( __( 'Newer &rarr;', 'retro-fitted' ) ); ?></div>
</nav>
