<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta http-equiv="x-ua-compatible" content="ie=edge" />
	<meta name="format-detection" content="telephone=no" />
	<meta name="viewport" content="width=device-width">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
	<![endif]-->
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<div id="wrapper" class="mod-pageWrapper">
<?php
	$header_image = get_header_image();
	if ( ! empty( $header_image ) ) :
?>
		<header id="scalingImage" class="mod-pageHeader" role="banner">
			<div class="mod-pageHeader-visual">
				<img class="visual" src="<?php echo esc_url( $header_image ); ?>" alt="" />
			</div>
<?php else: ?>
		<header class="mod-pageHeader noVisual" role="banner">
<?php endif; ?>
			<div class="mod-pageHeader-inner">
				<h1 class="mod-pageHeader-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<h2 class="mod-pageHeader-description"><?php bloginfo( 'description' ); ?></h2>
			</div>
		</header>
		<!--/mod-pageHeader-->
		<nav id="navGlobal" class="mod-navGlobal" role="navigation">
			<h3 class="mod-navGlobal-toggle"><span><?php _e( 'MENU', 'sonoichi' ); ?></span></h3>
			<a class="assistive-text" href="#content" title="Skip to content"><?php _e( 'Skip to content', 'sonoichi' ); ?></a>
			<?php wp_nav_menu( array('theme_location' => 'primary' ) ); ?>
		</nav>
		<!--/mod-navGlobal-->
