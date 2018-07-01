<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package  basepress
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">

	<?php
	
	do_action( 'basepress_before_header' ); ?>

	<header id="masthead" class="site-header" role="banner">

		<div class="main-header">
		
			<div class="container">
				<?php
					/**
					 * Functions hooked into basepress_header action
					 *
					 * @hooked basepress_skip_links				- 0
					 * @hooked basepress_site_branding			- 10
					 * @hooked basepress_primary_navigation		- 20
					 */
					do_action( 'basepress_header' );
				?>
			</div> <!-- .container -->

			<?php
			/**
			 * Functions hooked into basepress_header action
			 *
			 * @hooked basepress_category_navigation	- 0
			 */
			do_action( 'basepress_category_menu' );
			?>

		</div>
		<div id="header-catcher"></div>

	</header><!-- #masthead -->

	<?php
	
	do_action( 'basepress_after_header' ); ?>

	<?php
		// TODO: Need to check and apply class in body tag
		$class = '';
		if (is_page()) {
			if ( is_page_template( 'page-left-sidebar.php' )) {
				$class = ' left-sidebar';
			}
		}
	?>

	<div id="content" class="site-content">
		
		<div class="container">
			<?php
			/**
			 * Functions hooked in to basepress_content_top
			 *
			 */
			do_action( 'basepress_content_top' );
			
