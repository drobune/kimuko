<?php
/**
 * BasePress Class: The main class of theme
 *
 * @author   ThemeCountry
 * @since    1.0.0
 * @package  basepress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'basepress' ) ) :

	/**
	 * The main BasePress class to init & setup theme
	 * 
	 */

	class BasePress
	{
		private static $structured_data;
		
		function __construct() {

			add_action( 'after_setup_theme',          array( $this, 'setup' ) );
			add_action( 'widgets_init',               array( $this, 'widgets_init' ) );
			add_action( 'wp_enqueue_scripts',         array( $this, 'scripts' ),       10 );
			add_action( 'wp_enqueue_scripts',         array( $this, 'child_scripts' ), 30 ); 

			// After WooCommerce.
			add_filter( 'body_class',                 array( $this, 'body_classes' ) );
			//add_filter( 'wp_page_menu_args',          array( $this, 'page_menu_args' ) );
			add_action( 'wp_footer',                  array( $this, 'get_structured_data' ) );
			
		}

		/**
		 * Sets up theme defaults and registers support for various WordPress features.
		 *
		 * Note that this function is hooked into the after_setup_theme hook, which
		 * runs before the init hook. The init hook is too late for some features, such
		 * as indicating support for post thumbnails.
		 *
		 * @since 1.0.0
		 */
		public function setup() {

			/*
			 * Make theme available for translation.
			 * Translations can be filed in the /languages/ directory.
			 * If you're building a theme based on basepress, use a find and replace
			 * to change 'basepress' to the name of your theme in all the template files.
			 */

			// Loads wp-content/languages/themes/basepress-it_IT.mo.
			load_theme_textdomain( 'basepress', trailingslashit( WP_LANG_DIR ) . 'themes/' );

			// Loads wp-content/themes/child-theme-name/languages/it_IT.mo.
			load_theme_textdomain( 'basepress', get_stylesheet_directory() . '/languages' );

			// Loads wp-content/themes/base/languages/it_IT.mo.
			load_theme_textdomain( 'basepress', get_template_directory() . '/languages' );

			// Add default posts and comments RSS feed links to head.
			add_theme_support( 'automatic-feed-links' );

			/*
			 * Let WordPress manage the document title.
			 * By adding theme support, we declare that this theme does not use a
			 * hard-coded <title> tag in the document head, and expect WordPress to
			 * provide it for us.
			 */
			add_theme_support( 'title-tag' );

			/*
			 * Enable support for Post Thumbnails on posts and pages.
			 *
			 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
			 */

			add_theme_support( 'post-thumbnails' );

			/**
			 * Enable support for site logo
			 */
			// Set up the WordPress core custom logo feature.
			add_theme_support( 'custom-logo', apply_filters( 'basepress_custom_logo_args', array(
					'height'		=> 90,
					'width'			=> 300,
					'flex-width'	=> true,
			) ) );


			// This theme uses wp_nav_menu() in two locations.
			register_nav_menus( array(
				'primary'   => __( 'Primary Menu', 'basepress' ),
				'footer'  	=> __( 'Footer Menu', 'basepress' ),
			) );

			/*
			 * Switch default core markup for search form, comment form, and comments
			 * to output valid HTML5.
			 */
			add_theme_support( 'html5', array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			) );

			
			/**
			 *  Add support for the Site Logo plugin and the site logo functionality in JetPack
			 *  https://github.com/automattic/site-logo
			 *  http://jetpack.me/
			 */
			add_theme_support( 'site-logo', array( 'size' => 'full' ) );

			// Set up the WordPress core custom background feature.
			add_theme_support( 'custom-background', apply_filters( 'basepress_custom_background_args', array(
					'default-color'		=> 'ffffff',
					'default-image'		=> '',
			) ) );

			add_theme_support( 'custom-header', apply_filters( 'basepress_custom_header_args', array(
				'header-text'			=> false,
				'width'					=> 1600,
				'height'				=> 640,
				'flex-height'			=> true,
			) ) );

			// Add thirt party plugin
			$this->_addons_support();

			// Add theme support for selective refresh for widgets.
			add_theme_support( 'customize-selective-refresh-widgets' );
		}

		private function _addons_support() {

			// TODO: will be support on version: 1.2.0
			// Declare WooCommerce support.
			/*add_theme_support( 'woocommerce' );
			add_theme_support( 'wc-product-gallery-zoom' );
			add_theme_support( 'wc-product-gallery-lightbox' );
			add_theme_support( 'wc-product-gallery-slider' );*/

			// Add theme support for BasePress Pro plugin.
			add_theme_support( 'basepress-pro' );


		}

		/**
		 * Register widget area.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
		 * @since 1.0.0
		 */
		public function widgets_init() {

			$sidebar_args['sidebar'] = array(
				'name'          => __( 'Sidebar', 'basepress' ),
				'id'            => 'sidebar-1',
				'description'   => ''
			);

			$sidebar_args['header'] = array(
				'name'        	=> __( 'Below Header', 'basepress' ),
				'id'          	=> 'header-1',
				'description' 	=> __( 'Widgets added to this region will appear beneath the header and above the main content.', 'basepress' ),
			);

			$footer_widget_regions = apply_filters( 'basepress_footer_widget_regions', 4 );

			if ( $footer_widget_regions > 0) {

				for ( $i = 1; $i <= intval( $footer_widget_regions ); $i++ ) {
					$footer = sprintf( 'footer_%d', $i );

					$sidebar_args[ $footer ] = array(
						'name'        => sprintf( __( 'Footer %d', 'basepress' ), $i ),
						'id'          => sprintf( 'footer-%d', $i ),
						'description' => sprintf( __( 'Widgetized Footer Region %d.', 'basepress' ), $i )
					);
				}
			}

			foreach ( $sidebar_args as $sidebar => $args ) {
				$widget_tags = array(
					'before_widget' => '<div id="%1$s" class="widget %2$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<span class="gamma widget-title">',
					'after_title'   => '</span>'
				);

				/**
				 * Dynamically generated filter hooks. Allow changing widget wrapper and title tags. See the list below.
				 *
				 * 'basepress_header_widget_tags'
				 * 'basepress_sidebar_widget_tags'
				 *
				 * basepress_footer_1_widget_tags
				 * basepress_footer_2_widget_tags
				 * basepress_footer_3_widget_tags
				 * basepress_footer_4_widget_tags
				 */
				$filter_hook = sprintf( 'basepress_%s_widget_tags', $sidebar );
				$widget_tags = apply_filters( $filter_hook, $widget_tags );

				if ( is_array( $widget_tags ) ) {
					register_sidebar( $args + $widget_tags );
				}
			}
		}
		/**
		 * Enqueue scripts and styles.
		 *
		 * @since  1.0.0
		 */
		public function scripts() {
			
			global $wp_query, $basepress_version;

			/**
			 * Styles
			 */

			wp_enqueue_style( 'basepress-style', get_template_directory_uri() . '/style.css', '', $basepress_version );
			

			/**
			 * Fonts
			 */
			$google_fonts = apply_filters( 'basepress_google_font_families', array(
				'open-sanse' 	=> 'Open+Sans:300,400,700&subset=latin,latin-ext'
			) );

			if ( $google_fonts ) {

				$query_args = array(
					'family' => implode( '|', $google_fonts )
				);

				$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
				

				wp_enqueue_style( 'basepress-fonts', $fonts_url, array(), null );

			}

			/**
			 * Scripts
			 */
			wp_enqueue_script( 'basepress-navigation', get_template_directory_uri() . '/js/navigation.js', array(), $basepress_version, true );


			wp_enqueue_script( 'basepress-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), $basepress_version, true );
			wp_enqueue_script( 'basepress-script', get_template_directory_uri() . '/js/script.js', array('jquery'), $basepress_version, true);

			if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply' );
			}

		
		}
		/**
		 * Enqueue child theme stylesheet.
		 * A separate function is required as the child theme css needs to be enqueued _after_ the parent theme
		 *
		 * @since  1.0.0
		 */
		public function child_scripts() {
			if ( is_child_theme() ) {
				wp_enqueue_style( 'basepress-child-style', get_stylesheet_uri(), '' );
			}
		}

		/**
		 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
		 *
		 * @param array $args Configuration arguments.
		 * @since  1.0.0
		 * @return array
		 */
		public function page_menu_args( $args ) {
			$args['show_home'] = true;
			return $args;
		}


		/**
		 * Adds custom classes to the array of body classes.
		 *
		 * @param array $classes Classes for the body element.
		 * @since  1.0.0
		 * @return array
		 */
		public function body_classes( $classes ) {
			// Adds a class of group-blog to blogs with more than 1 published author.
			if ( is_multi_author() ) {
				$classes[] = 'group-blog';
			}

			if ( ! function_exists( 'woocommerce_breadcrumb' ) ) {
				$classes[]	= 'no-wc-breadcrumb';
			}

			$cute = apply_filters( 'basepress_make_me_cute', false );

			if ( true === $cute ) {
				$classes[] = 'basepress-cute';
			}

			// If our main sidebar doesn't contain widgets, adjust the layout to be full-width.
			if ( ! is_active_sidebar( 'sidebar-1' ) ) {

				$classes[] = 'basepress-full-width-content';
				
			}

			return $classes;
		}

		/**
		 * Sets `self::structured_data`.
		 *
		 * @param array $json
		 * @since 1.0.0
		 */
		public static function set_structured_data( $json ) {
			if ( ! is_array( $json ) ) {
				return;
			}

			self::$structured_data[] = $json;
		}

		/**
		 * Outputs structured data.
		 *
		 * Hooked into `wp_footer` action hook.
		 *
		 * @since 1.0.0
		 */
		public function get_structured_data() {
			if ( ! self::$structured_data ) {
				return;
			}

			$structured_data['@context'] = 'http://schema.org/';

			if ( count( self::$structured_data ) > 1 ) {
				$structured_data['@graph'] = self::$structured_data;
			} else {
				$structured_data = $structured_data + self::$structured_data[0];
			}

			echo '<script type="application/ld+json">' . wp_json_encode( $this->sanitize_structured_data( $structured_data ) ) . '</script>';
		}

		/**
		 * Sanitizes structured data.
		 *
		 * @param  array $data
		 * @return array
		 * @since 1.0.0
		 */
		public function sanitize_structured_data( $data ) {
			$sanitized = array();

			foreach ( $data as $key => $value ) {
				if ( is_array( $value ) ) {
					$sanitized_value = $this->sanitize_structured_data( $value );
				} else {
					$sanitized_value = sanitize_text_field( $value );
				}

				$sanitized[ sanitize_text_field( $key ) ] = $sanitized_value;
			}

			return $sanitized;
		}

	}

endif;

return new BasePress();