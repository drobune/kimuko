<?php
/**
 * Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @author   ThemeCountry
 * @package  basepress
 */

/**
 * Assign the basepress version to a var
 */

$theme              = wp_get_theme( 'basepress' );
$basepress_version = $theme['Version'];


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */

function basepress_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'basepress_content_width', 640 );
}
add_action( 'after_setup_theme', 'basepress_content_width', 0 );

$basepress = (object) array(
	'version' => $basepress_version,

	/**
	 * Initialize all the things.
	 */
	'main'       => require 'inc/class-base.php',
	'customizer' => require 'inc/customizer/class-basepress-customizer.php',
);

require 'inc/base-functions.php';
require 'inc/base-template-hooks.php';
require 'inc/base-template-functions.php';