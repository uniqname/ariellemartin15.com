<?php
/**
 * @package Suburbia
 */
?><!DOCTYPE html>
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php wp_title(); ?> <?php bloginfo( 'name' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>" type="text/css" media="screen" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php $header_image = get_header_image(); ?>
<div id="wrapper">
	<div class="header clear">
		<div class="space">
			<?php if ( ! empty( $header_image ) ) : ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
					<img src="<?php header_image(); ?>" width="<?php echo HEADER_IMAGE_WIDTH; ?>" height="<?php echo HEADER_IMAGE_HEIGHT; ?>" id="header-image" alt="" />
				</a>
			<?php endif; ?>
		</div><!-- #space -->

		<h1 id="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>

		<div class="desc">
			<p id="site-description"><?php bloginfo( 'description' ); ?></p>
		</div><!-- #desc -->

	</div><!-- #header -->

	<div class="middle clear">
		<div id="access">
			<div class="logo-fix"></div>
			<?php if ( is_day() ) : ?>
				<h3 class="archive-heading"><?php printf( __( 'Daily Archives: %s', 'suburbia' ), esc_html( get_the_date() ) ); ?></h3>
			<?php elseif ( is_month() ) : ?>
				<h3 class="archive-heading"><?php printf( __( 'Monthly Archives: %s', 'suburbia' ), esc_html( get_the_date( __( 'F, Y', 'suburbia' ) ) ) ); ?></h3>
			<?php elseif ( is_year() ) : ?>
				<h3 class="archive-heading"><?php printf( __( 'Yearly Archives: %s', 'suburbia' ), esc_html( get_the_date( __( 'Y', 'suburbia' ) ) ) ); ?></h3>
			<?php elseif ( is_tag() ) : ?>
				<h3 class="archive-heading"><?php printf( __( 'Tag Archives: %s', 'suburbia' ), esc_html( single_tag_title( '', false ) ) ); ?></h3>
			<?php elseif ( is_category() ) : ?>
				<h3 class="archive-heading"><?php printf( __( 'Category Archives: %s', 'suburbia' ), esc_html( single_cat_title( '', false ) ) ); ?></h3>
			<?php elseif ( is_search() ) : ?>
				<h3 class="archive-heading"><?php printf( __( 'Search Results for: %s', 'suburbia' ), get_search_query() ); ?></h3>
			<?php elseif ( is_author() ) : ?>
				<?php the_post(); ?>
				<h3 class="archive-heading"><?php printf( __( 'Author Archives: %s', 'suburbia' ), esc_html( get_the_author() ) ); ?></h3>
			<?php endif; ?>

			<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
		</div>