<?php
/**
 * The Header for our theme.
 *
 * @package Splendio
 */
?><!DOCTYPE html>
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 9]>
<html id="ie9" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'splendio' ), max( $paged, $page ) );

	?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<div id="wrapper" class="hfeed">
		<?php do_action( 'before' ); ?>
		<div id="header">
			<div id="branding">
				<header id="masthead" role="banner">
					<hgroup>
						<h1 class="site-title"><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
						<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
					</hgroup>

					<nav role="navigation" class="site-navigation">
						<h1 class="assistive-text"><?php _e( 'Main menu', 'splendio' ); ?></h1>
						<div class="assistive-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'splendio' ); ?>"><?php _e( 'Skip to content', 'splendio' ); ?></a></div>

						<?php wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary' ) ); ?>
					</nav>
				</header>
			</div><!-- #branding -->

			<div id="header-auxiliary">
				<div class="header-search">
					<form method="get" action="#">
						<fieldset>
							<p class="search-title"><?php _e( 'Search', 'splendio' ); ?></p>
							<input type="text" value="" name="s" /><button type="submit"><?php _e( 'GO', 'splendio');?></button>
						 </fieldset>
					 </form>
				 </div><!-- .header-search -->

				<?php /* Display the social icons depending on the configuration the user has entered on the theme options page */

				$options = splendio_get_theme_options();

				if ( 'off' != $options['show_rss_link'] || '' != $options['twitter_url'] || '' != $options['facebook_url'] ) :
				?>
					 <div class="syndicate">
						  <ul class="fade">
							<?php if ( 'off' != $options['show_rss_link'] ) : ?>
								<li><a class="rss-link" href="<?php bloginfo( 'rss2_url' ); ?>" title="<?php esc_attr_e( 'RSS', 'splendio' ); ?>"><span><?php _e( 'RSS Feed', 'splendio' );?></span></a></li>
							<?php endif; ?>

							<?php if ( ''!= $options['twitter_url'] ) : ?>
								<li><a class="twitter-link" href="<?php echo esc_url( $options['twitter_url'] ); ?>" title="<?php esc_attr_e( 'Twitter', 'splendio' ); ?>"><span><?php _e( 'Twitter', 'splendio' );?></span></a></li>
							<?php endif; ?>

							<?php if ( ''!= $options['facebook_url'] ) : ?>
								<li><a class="facebook-link" href="<?php echo esc_url( $options['facebook_url'] ); ?>" title="<?php esc_attr_e( 'Facebook', 'splendio' ); ?>"><span><?php _e( 'Facebook', 'splendio' );?></span></a></li>
							<?php endif; ?>
						</ul>
					 </div><!-- .syndicate -->
				<?php endif; ?>
			</div><!-- #header-auxiliary -->

			<div id="header-image" role="banner">
				<?php
					// The header image
					// Check if this is a post or page, if it has a thumbnail, and if it's a big one
					if ( is_singular() &&
							has_post_thumbnail( $post->ID ) &&
							( /* $src, $width, $height */ $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), array( HEADER_IMAGE_WIDTH, HEADER_IMAGE_WIDTH ) ) ) &&
							$image[1] >= HEADER_IMAGE_WIDTH ) :
						// Houston, we have a new header image!
						echo get_the_post_thumbnail( $post->ID, 'post-thumbnail' );
					else : ?>
					<img src="<?php header_image(); ?>" width="<?php echo HEADER_IMAGE_WIDTH; ?>" height="<?php echo HEADER_IMAGE_HEIGHT; ?>" alt="" />
				<?php endif; // end check for featured image or standard header ?>
			</div><!-- #header-image -->
		</div><!-- #header -->

		<div id="container">