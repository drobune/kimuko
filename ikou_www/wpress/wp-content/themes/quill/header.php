<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Quill
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php if ( get_theme_mod('site_favicon') ) : ?>
	<link rel="shortcut icon" href="<?php echo esc_url(get_theme_mod('site_favicon')); ?>" />
<?php endif; ?>
<?php if ( get_theme_mod('apple_touch_144') ) : ?>
	<link rel="apple-touch-icon" sizes="144x144" href="<?php echo esc_url(get_theme_mod('apple_touch_144')); ?>" />
<?php endif; ?>
<?php if ( get_theme_mod('apple_touch_114') ) : ?>
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo esc_url(get_theme_mod('apple_touch_114')); ?>" />
<?php endif; ?>
<?php if ( get_theme_mod('apple_touch_72') ) : ?>
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo esc_url(get_theme_mod('apple_touch_72')); ?>" />
<?php endif; ?>
<?php if ( get_theme_mod('apple_touch_57') ) : ?>
	<link rel="apple-touch-icon" href="<?php echo esc_url(get_theme_mod('apple_touch_57')); ?>" />
<?php endif; ?>

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'quill' ); ?></a>

	<?php if (is_front_page() && get_theme_mod('slider_display')) : ?>
		<?php echo quill_slider_template(); ?>
		<?php $active_slider = "active-slider"; ?>
	<?php else : ?>
		<?php $active_slider = ""; ?>
	<?php endif; ?>
	<?php if (!is_front_page() && get_header_image()) : ?>
		<?php $has_banner = "has-banner"; ?>
	<?php else : ?>
		<?php $has_banner = ""; ?>
	<?php endif; ?>

	<header id="masthead" class="site-header <?php echo $active_slider; ?> <?php echo $has_banner; ?>" role="banner">
		<?php if (!is_front_page()) : ?>
			<div class="header-overlay"></div>
		<?php endif; ?>
		<nav id="site-navigation" class="main-navigation" role="navigation">
			<button class="menu-toggle"><i class="fa fa-bars"></i></button>
			<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
		</nav><!-- #site-navigation -->

		<div class="site-branding">
			<?php if ( get_theme_mod('site_logo') ) : ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php bloginfo('name'); ?>"><img class="logo-image" src="<?php echo esc_url(get_theme_mod('site_logo')); ?>" alt="<?php bloginfo('name'); ?>" /></a>
			<?php else : ?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
			<?php endif; ?>
		</div>
	</header><!-- #masthead -->

	<?php if (!is_page_template('page_front-page.php') || ( 'posts' == get_option( 'show_on_front' ) ) ) : ?>
		<?php $container = "container"; ?>
	<?php else : ?>
		<?php $container = ""; ?>
	<?php endif; ?>

	<?php if ( !is_front_page() && !is_home() ) : ?>
		<?php echo quill_page_title(); ?>
	<?php endif; ?>

	<div id="content" class="site-content clearfix <?php echo $container; ?>">
