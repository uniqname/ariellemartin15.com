<?php
/**
 * @package San Kloud
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php wp_title(); ?> <?php bloginfo( 'name' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<!--[if IE]>
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/ie.css" />
<![endif]-->

<?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>
<?php wp_head(); ?>
</head>
	<body <?php body_class(); ?>>
		<div class="page-wrapper">
			<div class="container-12 header">
				<div class="grid-1"></div>
				<div class="grid-11">
					<div class="nav-menu">
						<?php wp_nav_menu( array( 'menu' => 'primary', 'menu_id' => 'menu-header', 'theme_location' => 'primary', 'depth' => 3 ) ); ?>
					</div>
				</div>
				<br class="clear" />
				<?php $header_image = get_header_image();
				if ( ! empty( $header_image ) ) { ?>
				<div class="headerimg">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
						<img src="<?php header_image(); ?>" width="<?php echo HEADER_IMAGE_WIDTH; ?>" height="<?php echo HEADER_IMAGE_HEIGHT; ?>" alt="" />
					</a>
				</div>
				<?php } // if ( ! empty( $header_image ) ); ?>
				<div class="grid-12 site-title-wrapper">
					<div class="site-title">
						<div class="site-title-left"></div>
						<div class="site-title-middle"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></div>
						<div class="site-title-right"></div>
					</div>
				</div>
				<div class="grid-1"></div>
				<div class="grid-11 site-description">
					<?php bloginfo( 'description' ); ?>
				</div>
				<br class="clear" />
			</div>