<?php
/**
 * Header Template
 *
 * The header template is generally used on every page of your site. Nearly all other templates call it
 * somewhere near the top of the file. It is used mostly as an opening wrapper, which is closed with the
 * footer.php file. It also executes key functions needed by the theme, child themes, and plugins.
 *
 * @package Retro-fitted
 * @subpackage Template
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>" />
<title><?php wp_title(); ?> <?php bloginfo( 'name' ); ?></title>

<link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" type="text/css" media="all" />
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

	<div id="container">
	<?php do_action( 'before' ); ?>

		<div id="header" class="contain">

			<div class="wrap">

				<?php if ( '' == get_header_image() ) : ?>
					<div id="branding">
						<h1 id="site-title"><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
						<div id="site-description"><?php bloginfo( 'description' ); ?></div><!-- #site-description -->
					</div><!-- #branding -->
				<?php else : ?>
					<a id="branding" href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
						<h1 id="site-title"><?php bloginfo( 'name' ); ?></h1>
						<div id="site-description"><?php bloginfo( 'description' ); ?></div><!-- #site-description -->
					</a><!-- #branding -->

				<?php endif; ?>

			</div><!-- .wrap -->
		</div><!-- #header -->

		<div id="main">

			<div class="wrap contain">

				<div id="access">
					<?php wp_nav_menu( array(
						'theme_location'  => 'primary',
						'container_class' => 'menu',
					) ); ?>
				</div><!-- #access -->