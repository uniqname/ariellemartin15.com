<?php
/**
 * @package WordPress
 * @subpackage Fjords
 */
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>" />
<title><?php wp_title(); ?> <?php bloginfo( 'name' ); ?></title>


	<style type="text/css" media="screen">
		@import url(<?php bloginfo( 'stylesheet_url' ); ?>);
	</style>

	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<?php
	if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
	wp_head();
	?>

</head>

<body <?php body_class(); ?>>

<div id="wrapper">
		<a href="<?php echo home_url( '/' ); ?>" class="header-link"></a>

	<div id="content">

		<div id="hode">
		<h4><a href="<?php echo home_url( '/' ); ?>"><?php bloginfo( 'title' ); ?></a></h4>
		<span><?php bloginfo( 'description' ); ?></span>
		</div>