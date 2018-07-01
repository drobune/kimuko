<?php
/**
 * BasePress Customizer Class
 *
 * @author   ThemeCountry
 * @package  basepress
 * @since    1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'BasePress_Customizer' ) ) :

	/**
	 * The BasePress Customizer class
	 */
	class BasePress_Customizer {

		/**
		 * Contruct class.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			add_action( 'customize_register',       array( $this, 'customize_register' ), 10 );
			add_filter( 'body_class',               array( $this, 'layout_class' ) );
			add_action( 'wp_enqueue_scripts',              array( $this, 'add_customizer_css' ), 130 );
			add_action( 'customize_controls_print_styles', array( $this, 'customizer_custom_control_css' ) );
			add_action( 'customize_register',       array( $this, 'edit_default_customizer_settings' ), 99 );
			add_action( 'init',                     array( $this, 'default_theme_mod_values' ), 10 );
			add_action( 'after_switch_theme',       array( $this, 'set_basepress_style_theme_mods' ) );
			add_action( 'customize_save_after',     array( $this, 'set_basepress_style_theme_mods' ) );

			/* On the frontend */
				$layout = get_theme_mod( 'basepress_layout' );


				if ( $layout === 'none' ) {

					remove_action( 'basepress_sidebar', 'basepress_get_sidebar', 10 );
					
				} else {

					add_action( 'basepress_sidebar',     'basepress_get_sidebar', 10 );

				}
			

		}

		/**
		 * Returns an array of the desired default BasePress Options
		 *
		 * @return array
		 * @since 1.0.0
		 */
		public static function get_basepress_default_setting_values() {

			return apply_filters( 'basepress_setting_default_values', $args = array(
				'basepress_heading_color'               => '#333333',
				'basepress_text_color'                  => '#333333',
				'basepress_accent_color'                => '#cb2027',
				'basepress_footer_background_color'     => '#ffffff',
				'basepress_footer_heading_color'        => '#333333',
				'basepress_footer_text_color'           => '#333333',
				'basepress_footer_link_color'           => '#cb2027',
				'basepress_layout'                      => 'right',
				'background_color'                      => 'f5f5f5',
			) );
		}

		/**
		 * Adds a value to each basepress setting if one isn't already present.
		 *
		 * @uses get_basepress_default_setting_values()
		 */
		public function default_theme_mod_values() {

			foreach ( self::get_basepress_default_setting_values() as $mod => $val ) {

				add_filter( 'theme_mod_' . $mod, array( $this, 'get_theme_mod_value' ), 10 );
			}
		}

		/**
		 * Get theme mod value.
		 *
		 * @param string $value
		 * @return string
		 */
		public function get_theme_mod_value( $value ) {

			$key = substr( current_filter(), 10 );

			$set_theme_mods = get_theme_mods();

			if ( isset( $set_theme_mods[ $key ] ) ) {

				return $value;
			}

			$values = $this->get_basepress_default_setting_values();

			return isset( $values[ $key ] ) ? $values[ $key ] : $value;
		}

		/**
		 * Set Customizer setting defaults.
		 * These defaults need to be applied separately as child themes can filter basepress_setting_default_values
		 *
		 * @param  array $wp_customize the Customizer object.
		 * @uses   get_basepress_default_setting_values()
		 */
		public function edit_default_customizer_settings( $wp_customize ) {


			foreach ( self::get_basepress_default_setting_values() as $mod => $val ) {

				if (! empty( $wp_customize->get_setting( $mod )->default ) ) {

					$wp_customize->get_setting( $mod )->default = $val;

				} else {

					echo $mod . '<br/>';

				}

			}
		}


		/**
		 * Register Theme Customize
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 * @since 1.0.0
		 * @return void
		 */
		public function customize_register( $wp_customize ) {

			// Move background color setting alongside background image.
			$wp_customize->get_control( 'background_color' )->section   = 'background_image';
			$wp_customize->get_control( 'background_color' )->priority  = 20;

			// Change background image section title & priority.
			$wp_customize->get_section( 'background_image' )->title     = __( 'Background', 'basepress' );
			$wp_customize->get_section( 'background_image' )->priority  = 30;

			// Change header image section title & priority.
			$wp_customize->get_section( 'header_image' )->title         = __( 'Header', 'basepress' );
			$wp_customize->get_section( 'header_image' )->priority      = 25;

			// Selective refresh.
			if ( function_exists( 'add_partial' ) ) {
				$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
				$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';

				$wp_customize->selective_refresh->add_partial( 'custom_logo', array(
					'selector'        => '.site-branding',
					'render_callback' => array( $this, 'get_site_logo' ),
				) );

				$wp_customize->selective_refresh->add_partial( 'blogname', array(
					'selector'        => '.site-title.beta a',
					'render_callback' => array( $this, 'get_site_name' ),
				) );

				$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
					'selector'        => '.site-description',
					'render_callback' => array( $this, 'get_site_description' ),
				) );
			}

			/**
			 * Custom controls
			 */
			require_once dirname( __FILE__ ) . '/class-basepress-customizer-control-radio-image.php';
			require_once dirname( __FILE__ ) . '/class-basepress-customizer-control-arbitrary.php';

			/**
			 * Add the typography section
			 */
			$wp_customize->add_section( 'basepress_typography' , array(
				'title'      			=> __( 'Color', 'basepress' ),
				'priority'   			=> 45,
			) );

			/**
			 * Heading color
			 */
			$wp_customize->add_setting( 'basepress_heading_color', array(
				'default'           	=> apply_filters( 'basepress_default_heading_color', '#333333' ),
				'sanitize_callback' 	=> 'sanitize_hex_color',
			) );

			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'basepress_heading_color', array(
				'label'	   				=> __( 'Primary color', 'basepress' ),
				'section'  				=> 'basepress_typography',
				'settings' 				=> 'basepress_heading_color',
				'priority' 				=> 20,
			) ) );

			/**
			 * Accent Color
			 */
			$wp_customize->add_setting( 'basepress_accent_color', array(
				'default'				=> apply_filters( 'basepress_default_accent_color', '#cb2027' ),
				'sanitize_callback'		=> 'sanitize_hex_color',
			) );

			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'basepress_accent_color', array(
				'label'					=> __( 'Secondary color', 'basepress' ),
				'section'				=> 'basepress_typography',
				'settings'				=> 'basepress_accent_color',
				'priority'				=> 30,
			) ) );

			/**
			 * Text Color
			 */
			$wp_customize->add_setting( 'basepress_text_color', array(
				'default'           	=> apply_filters( 'basepress_default_text_color', '#333333' ),
				'sanitize_callback' 	=> 'sanitize_hex_color',
			) );

			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'basepress_text_color', array(
				'label'					=> __( 'Body text color', 'basepress' ),
				'section'				=> 'basepress_typography',
				'settings'				=> 'basepress_text_color',
				'priority'				=> 40,
			) ) );

			$wp_customize->add_control( new Arbitrary_BasePress_Control( $wp_customize, 'basepress_header_image_heading', array(
				'section'				=> 'header_image',
				'type'					=> 'heading',
				'label'					=> __( 'Header background image', 'basepress' ),
				'priority'				=> 6,
			) ) );

			/**
			 * Footer section
			 */
			$wp_customize->add_section( 'basepress_footer' , array(
				'title'					=> __( 'Footer', 'basepress' ),
				'priority'				=> 28,
				'description'			=> __( 'Customise the look & feel of your web site footer.', 'basepress' ),
			) );

			/**
			 * Footer Background
			 */
			$wp_customize->add_setting( 'basepress_footer_background_color', array(
				'default'				=> apply_filters( 'basepress_default_footer_background_color', '#ffffff' ),
				'sanitize_callback'		=> 'sanitize_hex_color',
			) );

			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'basepress_footer_background_color', array(
				'label'					=> __( 'Background color', 'basepress' ),
				'section'				=> 'basepress_footer',
				'settings'				=> 'basepress_footer_background_color',
				'priority'				=> 10,
			) ) );

			/**
			 * Footer heading color
			 */
			$wp_customize->add_setting( 'basepress_footer_heading_color', array(
				'default'				=> apply_filters( 'basepress_default_footer_heading_color', '#333333' ),
				'sanitize_callback'		=> 'sanitize_hex_color',
			) );

			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'basepress_footer_heading_color', array(
				'label'					=> __( 'Title heading color', 'basepress' ),
				'section'				=> 'basepress_footer',
				'settings'				=> 'basepress_footer_heading_color',
				'priority'				=> 20,
			) ) );

			/**
			 * Footer text color
			 */
			$wp_customize->add_setting( 'basepress_footer_text_color', array(
				'default'				=> apply_filters( 'basepress_default_footer_text_color', '#3333333' ),
				'sanitize_callback'		=> 'sanitize_hex_color',
			) );

			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'basepress_footer_text_color', array(
				'label'					=> __( 'Body text color', 'basepress' ),
				'section'				=> 'basepress_footer',
				'settings'				=> 'basepress_footer_text_color',
				'priority'				=> 30,
			) ) );

			/**
			 * Footer link color
			 */
			$wp_customize->add_setting( 'basepress_footer_link_color', array(
				'default'				=> apply_filters( 'basepress_default_footer_link_color', '#cb2027' ),
				'sanitize_callback'		=> 'sanitize_hex_color',
			) );

			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'basepress_footer_link_color', array(
				'label'					=> __( 'Link color', 'basepress' ),
				'section'				=> 'basepress_footer',
				'settings'				=> 'basepress_footer_link_color',
				'priority'				=> 40,
			) ) );

			/**
			 * Layout
			 */
			$wp_customize->add_section( 'basepress_layout' , array(
				'title'					=> __( 'Layout', 'basepress' ),
				'priority'				=> 50,
			) );

			$wp_customize->add_setting( 'basepress_layout', array(
				'default'				=> apply_filters( 'basepress_default_layout', $layout = is_rtl() ? 'left' : 'right' ),
				'sanitize_callback'		=> 'basepress_sanitize_choices',
			) );

			$wp_customize->add_control( new basepress_Custom_Radio_Image_Control( $wp_customize, 'basepress_layout', array(
				'settings'				=> 'basepress_layout',
				'section'				=> 'basepress_layout',
				'label'					=> __( 'General Layout', 'basepress' ),
				'priority'				=> 1,
				'choices'				=> array(
						'left'	=> get_template_directory_uri() . '/assets/images/customizer/controls/left.png',
						'none'	=> get_template_directory_uri() . '/assets/images/customizer/controls/none.png',
						'right'	=> get_template_directory_uri() . '/assets/images/customizer/controls/right.png',
					),
			) ) );

		}

		/**
		 * 
		 *
		 * @since 1.0.0
		 * 
		 */
		public function layout_class( $classes ) {

			$left_or_right = get_theme_mod( 'basepress_layout' );

			$classes[] = $left_or_right . '-sidebar';

			return $classes;
		}


		/**
		 * Assign basepress styles to individual theme mods.
		 *
		 * @since 1.0.0
		 * @return void
		 */
		public function set_basepress_style_theme_mods() {
			set_theme_mod( 'basepress_styles', $this->get_css() );
			//set_theme_mod( 'basepress_woocommerce_styles', $this->get_woocommerce_css() );
		}

		/**
		 * Add CSS in <head> for styles handled by the theme customizer
		 *
		 * @since 1.0.0
		 * @return void
		 */
		public function add_customizer_css() {

			$basepress_styles = get_theme_mod( 'basepress_styles' );

			if ( is_customize_preview() || ( defined( 'WP_DEBUG' ) && true === WP_DEBUG ) || ( false === $basepress_styles ) ) {

				wp_add_inline_style( 'basepress-style', $this->get_css() );
				
			} else {

				wp_add_inline_style( 'basepress-style', get_theme_mod( 'basepress_styles' ) );
				
			}
		}

		/**
		 * Get all of the basepress theme mods.
		 *
		 * @return array $basepress_theme_mods The basepress Theme Mods.
		 */
		public function get_basepress_theme_mods() {
			$basepress_theme_mods = array(
				'background_color'            => basepress_get_content_background_color(),
				'accent_color'                => get_theme_mod( 'basepress_accent_color' ),
				'footer_background_color'     => get_theme_mod( 'basepress_footer_background_color' ),
				'footer_link_color'           => get_theme_mod( 'basepress_footer_link_color' ),
				'footer_heading_color'        => get_theme_mod( 'basepress_footer_heading_color' ),
				'footer_text_color'           => get_theme_mod( 'basepress_footer_text_color' ),
				'text_color'                  => get_theme_mod( 'basepress_text_color' ),
				'heading_color'               => get_theme_mod( 'basepress_heading_color' ),
				'button_background_color'     => get_theme_mod( 'basepress_button_background_color' ),
				'button_text_color'           => get_theme_mod( 'basepress_button_text_color' ),
				'button_alt_background_color' => get_theme_mod( 'basepress_button_alt_background_color' ),
				'button_alt_text_color'       => get_theme_mod( 'basepress_button_alt_text_color' ),
			);

			return apply_filters( 'basepress_theme_mods', $basepress_theme_mods );
		}

		/**
		 * Get style
		 *
		 * @since 1.0.0
		 * @return string
		 */
		public function get_css() {

			$basepress_theme_mods = $this->get_basepress_theme_mods();
			$brighten_factor       = apply_filters( 'basepress_brighten_factor', 25 );
			$darken_factor         = apply_filters( 'basepress_darken_factor', -25 );

			$styles = '
				body, .sidebar { color: ' . $basepress_theme_mods['text_color'] . '; }
				.entry-footer, .entry-footer > span {color: '. basepress_adjust_color_brightness( $basepress_theme_mods['text_color'], 100 ) .'}
				h1, h2, h3, h4, h5 ,h6, .entry-title a, .sidebar .widget-title { color: ' . $basepress_theme_mods['heading_color'] . '; }
				a, .sidebar a, .wp-caption .wp-caption-text { color: ' . $basepress_theme_mods['accent_color'] . '; }
				a:hover, .sidebar a:hover, .entry-title a:hover { color: ' . basepress_adjust_color_brightness( $basepress_theme_mods['accent_color'],  $darken_factor ) . '; }
				.back-to-top { background: ' . $basepress_theme_mods['accent_color'] . '; }
				.site-footer { background: ' . $basepress_theme_mods['footer_background_color'] . '; }
				.site-footer, .site-footer #wp-calendar caption, .site-info { color: ' . $basepress_theme_mods['footer_text_color'] . '; }
				.site-footer h1,
				.site-footer h2,
				.site-footer h3,
				.site-footer h4,
				.site-footer h5,
				.site-footer h6,
				.site-footer .widget-title {
					color: ' . $basepress_theme_mods['footer_heading_color'] . ';
				}
				
				.footer-navigation .footer-menu li a { color: ' . $basepress_theme_mods['footer_link_color'] . '; }

			';

			return apply_filters( 'basepress_customizer_css', $styles );
		}

		/**
		 * Add CSS for custom controls
		 *
		 * This function incorporates CSS from the Kirki Customizer Framework
		 *
		 * The Kirki Customizer Framework, Copyright Aristeides Stathopoulos (@aristath),
		 * is licensed under the terms of the GNU GPL, Version 2 (or later)
		 *
		 * @link https://github.com/reduxframework/kirki/
		 * @since  1.5.0
		 */
		public function customizer_custom_control_css() {
			?>
			<style>
			.customize-control-radio-image input[type=radio] {
				display: none;
			}

			.customize-control-radio-image label:nth-of-type(2n) {
				margin-right: 0;
			}

			.customize-control-radio-image img {
				opacity: .5;
			}

			.customize-control-radio-image input[type=radio]:checked + label img,
			.customize-control-radio-image img:hover {
				opacity: 1;
			}

			</style>
			<?php
		}

	}

endif;

return new BasePress_Customizer();