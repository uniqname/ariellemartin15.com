<?php
/**
 * @package WordPress
 * @subpackage Notepad
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
	<head profile="http://gmpg.org/xfn/11">
		<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

		<title><?php wp_title(); ?> <?php bloginfo('name'); ?></title>

		<link href="<?php bloginfo( 'stylesheet_url' ); ?>" media="screen" rel="stylesheet" type="text/css" />
		<link href="<?php bloginfo( 'template_directory' ); ?>/css/print.css" media="print" rel="stylesheet" type="text/css" />
		<!--[if IE]>
		<link href="<?php bloginfo( 'template_directory' ); ?>/ie.css" media="screen" rel="stylesheet" type="text/css" />
		<![endif]-->
		<!--[if lte IE 6]>
		<link href="<?php bloginfo( 'template_directory' ); ?>/ie6.css" media="screen" rel="stylesheet" type="text/css" />
		<![endif]-->

		<link  rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

		<?php if ( is_singular() && comments_open() ) { wp_enqueue_script( 'comment-reply' ); } ?>

		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>
		<div id="pagewrapper">
		<?php do_action( 'before' ); ?>
		<div id="header">
			<h1 id="logo">
				<a href="<?php echo home_url( '/' ); ?>"><?php bloginfo( 'name' ); ?></a>
			</h1>
			<p class="description"><?php bloginfo( 'description' ); ?></p>

			<p class="socialmedia">
				<?php $options = wp_parse_args( get_option( 'notepad_theme_options' ), notepad_get_default_options() ); ?>

				<?php if ( ! empty( $options['twitterurl'] ) ) : ?>
					<a href="<?php echo esc_url( $options['twitterurl'] ); ?>"><img alt="<?php esc_attr_e( 'Twitter', 'notepad-theme' ); ?>" src="<?php echo esc_url( get_template_directory_uri() . '/img/socialmedia/twitter.png' ); ?>"></a>
				<?php endif; ?>

				<?php if ( ! empty( $options['facebookurl'] ) ) : ?>
					<a href="<?php echo esc_url( $options['facebookurl'] ); ?>"><img alt="<?php esc_attr_e( 'Facebook', 'notepad-theme' ); ?>" src="<?php echo esc_url( get_template_directory_uri() . '/img/socialmedia/facebook.png' ); ?>"></a>
				<?php endif; ?>

				<?php if ( ! empty( $options['flickrurl'] ) ) : ?>
					<a href="<?php echo esc_url( $options['flickrurl'] ); ?>"><img alt="<?php esc_attr_e( 'Flickr', 'notepad-theme' ); ?>" src="<?php echo esc_url( get_template_directory_uri() . '/img/socialmedia/flickr.png' ); ?>"></a>
				<?php endif; ?>

				<?php if ( ! empty( $options['rss'] ) ) : ?>
					<a href="<?php bloginfo( 'rss2_url' ); ?>"><img alt="<?php esc_attr_e( 'RSS', 'notepad-theme' ); ?>" src="<?php echo esc_url( get_template_directory_uri() . '/img/socialmedia/rss.png' ); ?>"></a>
				<?php endif; ?>
			</p><!-- socialmedia -->

			<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>

		</div>
		<!--/header -->

		<?php
			// Check to see if the header image has been removed
			$header_image = get_header_image();
			if ( ! empty( $header_image ) ) :
		?>
		<div id="header-image">
			<a class="home-link" href="<?php echo home_url( '/' ); ?>"><?php _e( 'Home', 'notepad-theme' ); ; ?></a>
		</div>
		<?php endif; ?>

		<div id="wrapper">

