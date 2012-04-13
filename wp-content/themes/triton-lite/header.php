<?php
/**
 * @package Triton Lite
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php wp_title(); ?> <?php bloginfo( 'name' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>" type="text/css" media="screen" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php if ( is_singular() && get_option( 'thread_comments' ) && comments_open() ) wp_enqueue_script( 'comment-reply' ); ?>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

	<div id="masthead">
		<div class="container">
			<div id="access">
				<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
			</div><!-- #access -->
		</div><!-- .container -->
	</div><!-- #masthead -->

	<div id="header">
		<div class="container">
			<?php
				// If header image exists, output a DIV for it
				$header_image = get_header_image();
				if ( ! empty( $header_image ) ) { ?>
					<div id="header-image">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
					</div><!-- #header-image -->
			<?php } ?>
			<div id="logo">
				<h1>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
				</h1>
				<div class="desc">
					<?php bloginfo( 'description' )?>
				</div><!-- .desc -->
			</div><!-- #logo -->
		</div><!-- .container -->
	</div><!-- #header -->