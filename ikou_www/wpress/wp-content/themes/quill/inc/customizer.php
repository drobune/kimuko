<?php
/**
 * Quill Theme Customizer
 *
 * @package Quill
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function quill_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	$wp_customize->remove_control( 'display_header_text' );


  //Add a class for titles
    class Quill_Info extends WP_Customize_Control {
        public $type = 'info';
        public $label = '';
        public function render_content() {
        ?>
      <h3 style="text-decoration: underline; color: #DA4141; text-transform: uppercase;"><?php echo esc_html( $this->label ); ?></h3>
        <?php
        }
    }

	//___General___//
    $wp_customize->add_section(
        'quill_general',
        array(
            'title' => __('General', 'quill'),
            'priority' => 9,
        )
    );
	//Logo Upload
	$wp_customize->add_setting(
		'site_logo',
		array(
			'default-image' => '',
      'sanitize_callback' => 'esc_url_raw',
		)
	);
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'site_logo',
            array(
               'label'          => __( 'Upload your logo', 'quill' ),
			         'type' 			=> 'image',
               'section'        => 'quill_general',
               'settings'       => 'site_logo',
               'priority' => 9,
            )
        )
    );
	//Favicon Upload
	$wp_customize->add_setting(
		'site_favicon',
		array(
			'default-image' => '',
      'sanitize_callback' => 'esc_url_raw',
		)
	);
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'site_favicon',
            array(
               'label'          => __( 'Upload your favicon', 'quill' ),
			   'type' 			=> 'image',
               'section'        => 'quill_general',
               'settings'       => 'site_favicon',
               'priority' => 10,
            )
        )
    );
    //Apple touch icon 144
    $wp_customize->add_setting(
        'apple_touch_144',
        array(
            'default-image' => '',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'apple_touch_144',
            array(
               'label'          => __( 'Upload your Apple Touch Icon (144x144 pixels)', 'quill' ),
               'type'           => 'image',
               'section'        => 'quill_general',
               'settings'       => 'apple_touch_144',
               'priority'       => 11,
            )
        )
    );
    //Apple touch icon 114
    $wp_customize->add_setting(
        'apple_touch_114',
        array(
            'default-image' => '',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'apple_touch_114',
            array(
               'label'          => __( 'Upload your Apple Touch Icon (114x114 pixels)', 'quill' ),
               'type'           => 'image',
               'section'        => 'quill_general',
               'settings'       => 'apple_touch_114',
               'priority'       => 12,
            )
        )
    );
    //Apple touch icon 72
    $wp_customize->add_setting(
        'apple_touch_72',
        array(
            'default-image' => '',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'apple_touch_72',
            array(
               'label'          => __( 'Upload your Apple Touch Icon (72x72 pixels)', 'quill' ),
               'type'           => 'image',
               'section'        => 'quill_general',
               'settings'       => 'apple_touch_72',
               'priority'       => 13,
            )
        )
    );
    //Apple touch icon 57
    $wp_customize->add_setting(
        'apple_touch_57',
        array(
            'default-image' => '',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'apple_touch_57',
            array(
               'label'          => __( 'Upload your Apple Touch Icon (57x57 pixels)', 'quill' ),
               'type'           => 'image',
               'section'        => 'quill_general',
               'settings'       => 'apple_touch_57',
               'priority'       => 14,
            )
        )
    );
  //Full content posts
  $wp_customize->add_setting(
    'quill_full_content',
    array(
      'sanitize_callback' => 'quill_sanitize_checkbox',
      'default' => 0,     
    )   
  );
  $wp_customize->add_control(
    'quill_full_content',
    array(
      'type' => 'checkbox',
      'label' => __('Check this box to display the full content of the posts on the home page.', 'quill'),
      'section' => 'quill_general',
      'priority' => 16,     
    )
  );  
    //___Slider___//
    $wp_customize->add_section(
        'quill_slider',
        array(
            'title' => __('Slider', 'quill'),
            'priority' => 10,
        )
    );
    //Display
    $wp_customize->add_setting(
        'slider_display',
        array(
            'sanitize_callback' => 'quill_sanitize_checkbox',
        )       
    );
    $wp_customize->add_control(
        'slider_display',
        array(
            'type' => 'checkbox',
            'label' => __('Check this box to display the slider.', 'quill'),
            'section' => 'quill_slider',
            'priority'       => 10,
        )
    );
    //Image 1
    $wp_customize->add_setting(
        'slider_image_1',
        array(
            'default-image' => '',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'slider_image_1',
            array(
               'label'          => __( 'Upload your first image for the slider', 'quill' ),
               'type'           => 'image',
               'section'        => 'quill_slider',
               'settings'       => 'slider_image_1',
               'priority'       => 11,
            )
        )
    );
    //Image 2
    $wp_customize->add_setting(
        'slider_image_2',
        array(
            'default-image' => '',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'slider_image_2',
            array(
               'label'          => __( 'Upload your second image for the slider', 'quill' ),
               'type'           => 'image',
               'section'        => 'quill_slider',
               'settings'       => 'slider_image_2',
               'priority'       => 12,
            )
        )
    );
    //Image 3
    $wp_customize->add_setting(
        'slider_image_3',
        array(
            'default-image' => '',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'slider_image_3',
            array(
               'label'          => __( 'Upload your third image for the slider', 'quill' ),
               'type'           => 'image',
               'section'        => 'quill_slider',
               'settings'       => 'slider_image_3',
               'priority'       => 13,
            )
        )
    );        
    //Image 4
    $wp_customize->add_setting(
        'slider_image_4',
        array(
            'default-image' => '',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'slider_image_4',
            array(
               'label'          => __( 'Upload your fourth image for the slider', 'quill' ),
               'type'           => 'image',
               'section'        => 'quill_slider',
               'settings'       => 'slider_image_4',
               'priority'       => 14,
            )
        )
    );
    //Image 5
    $wp_customize->add_setting(
        'slider_image_5',
        array(
            'default-image' => '',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'slider_image_5',
            array(
               'label'          => __( 'Upload your fifth image for the slider', 'quill' ),
               'type'           => 'image',
               'section'        => 'quill_slider',
               'settings'       => 'slider_image_5',
               'priority'       => 15,
            )
        )
    );

   //Header button 1
	$wp_customize->add_setting(
	    'header_btn_text_1',
	    array(
	        'default' => '',
	        'sanitize_callback' => 'quill_sanitize_text',
	    )
	);
	$wp_customize->add_control(
	    'header_btn_text_1',
	    array(
	        'label' => __( 'First call to action button anchor', 'quill' ),
	        'section' => 'quill_slider',
	        'type' => 'text',
	        'priority' => 16
	    )
	);
   //Header button link 1
	$wp_customize->add_setting(
	    'header_btn_link_1',
	    array(
	        'default' => '',
	        'sanitize_callback' => 'esc_url_raw',
	    )
	);
	$wp_customize->add_control(
	    'header_btn_link_1',
	    array(
	        'label' => __( 'First call to action button link', 'quill' ),
	        'section' => 'quill_slider',
	        'type' => 'text',
	        'priority' => 17
	    )
	); 
   //Header button 2
	$wp_customize->add_setting(
	    'header_btn_text_2',
	    array(
	        'default' => '',
	        'sanitize_callback' => 'quill_sanitize_text',
	    )
	);
	$wp_customize->add_control(
	    'header_btn_text_2',
	    array(
	        'label' => __( 'Second call to action button anchor', 'quill' ),
	        'section' => 'quill_slider',
	        'type' => 'text',
	        'priority' => 18
	    )
	);
   //Header button link 2
	$wp_customize->add_setting(
	    'header_btn_link_2',
	    array(
	        'default' => '',
	        'sanitize_callback' => 'esc_url_raw',
	    )
	);
	$wp_customize->add_control(
	    'header_btn_link_2',
	    array(
	        'label' => __( 'Second call to action button link', 'quill' ),
	        'section' => 'quill_slider',
	        'type' => 'text',
	        'priority' => 19
	    )
	);
    //___Single posts___//
    $wp_customize->add_section(
        'quill_singles',
        array(
            'title' => __('Single posts/pages', 'quill'),
            'priority' => 14,
        )
    );
    //Single posts
    $wp_customize->add_setting(
        'quill_post_img',
        array(
            'sanitize_callback' => 'quill_sanitize_checkbox',
        )       
    );
    $wp_customize->add_control(
        'quill_post_img',
        array(
            'type' => 'checkbox',
            'label' => __('Check this box to show featured images on single posts', 'quill'),
            'section' => 'quill_singles',
        )
    );
    //Pages
    $wp_customize->add_setting(
        'quill_page_img',
        array(
            'sanitize_callback' => 'quill_sanitize_checkbox',
        )
    );
    $wp_customize->add_control(
        'quill_page_img',
        array(
            'type' => 'checkbox',
            'label' => __('Check this box to show featured images on pages', 'quill'),
            'section' => 'quill_singles',
        )
    );
  //___FRONT PAGE COLORS___//
    $wp_customize->add_section(
        'quill_fp_colors',
        array(
            'title' => __('Front Page Colors', 'quill'),
            'priority' => 21,
            'description' => __('Here you can change the colors for each type of front page section.', 'quill'),
        )
    );  
  //***Services section
    $wp_customize->add_setting('quill_options[info]', array(
            'type' => 'info_control',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'esc_attr',
        )
    );
    $wp_customize->add_control( new quill_Info( $wp_customize, 'services_section', array(
        'label' => __('Services section', 'quill'),
        'section' => 'quill_fp_colors',
        'settings' => 'quill_options[info]',
        'priority' => 10
        ) )
    );
    //Background
  $wp_customize->add_setting(
    'services_bg',
    array(
      'default'     => '#fff',
      'sanitize_callback' => 'sanitize_hex_color',
      'transport'     => 'postMessage'
    )
  );
  $wp_customize->add_control(
    new WP_Customize_Color_Control(
      $wp_customize,
      'services_bg',
      array(
        'label' => __('Services section background color', 'quill'),
        'section' => 'quill_fp_colors',
        'settings' => 'services_bg',
        'priority' => 11
      )
    )
  );
    //Title
  $wp_customize->add_setting(
    'services_title',
    array(
      'default'     => '#2E2E2E',
      'sanitize_callback' => 'sanitize_hex_color',
      'transport'     => 'postMessage'
    )
  );
  $wp_customize->add_control(
    new WP_Customize_Color_Control(
      $wp_customize,
      'services_title',
      array(
        'label' => __('Services section main title color', 'quill'),
        'section' => 'quill_fp_colors',
        'settings' => 'services_title',
        'priority' => 12
      )
    )
  );
    //Title decoration
  $wp_customize->add_setting(
    'services_title_dec',
    array(
      'default'     => '#2E2E2E',
      'sanitize_callback' => 'sanitize_hex_color',
      'transport'     => 'postMessage'
    )
  );
  $wp_customize->add_control(
    new WP_Customize_Color_Control(
      $wp_customize,
      'services_title_dec',
      array(
        'label' => __('Services section main title border', 'quill'),
        'section' => 'quill_fp_colors',
        'settings' => 'services_title_dec',
        'priority' => 13
      )
    )
  );
  //Icons
  $wp_customize->add_setting(
    'services_icon_bg',
    array(
      'default'     => '#2E2E2E',
      'sanitize_callback' => 'sanitize_hex_color',
      'transport'     => 'postMessage'
    )
  );
  $wp_customize->add_control(
    new WP_Customize_Color_Control(
      $wp_customize,
      'services_icon_bg',
      array(
        'label' => __('Services section icons', 'quill'),
        'section' => 'quill_fp_colors',
        'settings' => 'services_icon_bg',
        'priority' => 15
      )
    )
  );
    //Item title
  $wp_customize->add_setting(
    'services_item_title',
    array(
      'default'     => '#2E2E2E',
      'sanitize_callback' => 'sanitize_hex_color',
      'transport'     => 'postMessage'
    )
  );
  $wp_customize->add_control(
    new WP_Customize_Color_Control(
      $wp_customize,
      'services_item_title',
      array(
        'label' => __('Services section item titles', 'quill'),
        'section' => 'quill_fp_colors',
        'settings' => 'services_item_title',
        'priority' => 16
      )
    )
  );
    //Body
  $wp_customize->add_setting(
    'services_body_text',
    array(
      'default'     => '#6B6B6B',
      'sanitize_callback' => 'sanitize_hex_color',
      'transport'     => 'postMessage'
    )
  );
  $wp_customize->add_control(
    new WP_Customize_Color_Control(
      $wp_customize,
      'services_body_text',
      array(
        'label' => __('Services section body', 'quill'),
        'section' => 'quill_fp_colors',
        'settings' => 'services_body_text',
        'priority' => 17
      )
    )
  );
    //***Employees section
    $wp_customize->add_setting('quill_options[info]', array(
            'type' => 'info_control',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'esc_attr',
        )
    );
    $wp_customize->add_control( new quill_Info( $wp_customize, 'employees_section', array(
        'label' => __('Employees section', 'quill'),
        'section' => 'quill_fp_colors',
        'settings' => 'quill_options[info]',
        'priority' => 18
        ) )
    );
    //Background
    $wp_customize->add_setting(
        'employees_bg',
        array(
            'default'           => '#fff',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'     => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'employees_bg',
            array(
                'label' => __('Employees section background color', 'quill'),
                'section' => 'quill_fp_colors',
                'settings' => 'employees_bg',
                'priority' => 19
            )
        )
    );
    //Title
    $wp_customize->add_setting(
        'employees_title',
        array(
            'default'           => '#2E2E2E',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'     => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'employees_title',
            array(
                'label' => __('Employees section main title color', 'quill'),
                'section' => 'quill_fp_colors',
                'settings' => 'employees_title',
                'priority' => 20
            )
        )
    );
    //Title decoration
    $wp_customize->add_setting(
        'employees_title_dec',
        array(
            'default'           => '#2E2E2E',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'     => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'employees_title_dec',
            array(
                'label' => __('Employees section main title border', 'quill'),
                'section' => 'quill_fp_colors',
                'settings' => 'employees_title_dec',
                'priority' => 21
            )
        )
    );
    //Employee name
    $wp_customize->add_setting(
        'employees_text',
        array(
            'default'           => '#fff',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'     => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'employees_text',
            array(
                'label' => __('Employees text', 'quill'),
                'section' => 'quill_fp_colors',
                'settings' => 'employees_text',
                'priority' => 22
            )
        )
    );
    //Employee bg
    $wp_customize->add_setting(
        'employees_box_bg',
        array(
            'default'           => '#2E2E2E',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'     => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'employees_box_bg',
            array(
                'label' => __('Employees box background', 'quill'),
                'section' => 'quill_fp_colors',
                'settings' => 'employees_box_bg',
                'priority' => 23
            )
        )
    );    
    //***Testimonials section
    $wp_customize->add_setting('quill_options[info]', array(
            'type' => 'info_control',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'esc_attr',
        )
    );
    $wp_customize->add_control( new quill_Info( $wp_customize, 'testimonials_section', array(
        'label' => __('Testimonials section', 'quill'),
        'section' => 'quill_fp_colors',
        'settings' => 'quill_options[info]',
        'priority' => 25
        ) )
    );
    //Background
    $wp_customize->add_setting(
        'testimonials_bg',
        array(
            'default'           => '#fff',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'     => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'testimonials_bg',
            array(
                'label' => __('Testimonials section background color', 'quill'),
                'section' => 'quill_fp_colors',
                'settings' => 'testimonials_bg',
                'priority' => 26
            )
        )
    );
    //Title
    $wp_customize->add_setting(
        'testimonials_title',
        array(
            'default'           => '#2E2E2E',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'     => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'testimonials_title',
            array(
                'label' => __('Testimonials section main title color', 'quill'),
                'section' => 'quill_fp_colors',
                'settings' => 'testimonials_title',
                'priority' => 27
            )
        )
    );
    //Title decoration
    $wp_customize->add_setting(
        'testimonials_title_dec',
        array(
            'default'           => '#2E2E2E',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'     => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'testimonials_title_dec',
            array(
                'label' => __('Testimonials section main title border', 'quill'),
                'section' => 'quill_fp_colors',
                'settings' => 'testimonials_title_dec',
                'priority' => 28
            )
        )
    );    
    //Testimonial item text
    $wp_customize->add_setting(
        'testimonials_body_text',
        array(
            'default'           => '#6B6B6B',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'     => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'testimonials_body_text',
            array(
                'label' => __('Testimonials text', 'quill'),
                'section' => 'quill_fp_colors',
                'settings' => 'testimonials_body_text',
                'priority' => 29
            )
        )
    );
    //***Facts section
    $wp_customize->add_setting('quill_options[info]', array(
            'type' => 'info_control',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'esc_attr',
        )
    );
    $wp_customize->add_control( new quill_Info( $wp_customize, 'facts_section', array(
        'label' => __('Facts section', 'quill'),
        'section' => 'quill_fp_colors',
        'settings' => 'quill_options[info]',
        'priority' => 39
        ) )
    );
    //Background
    $wp_customize->add_setting(
        'facts_bg',
        array(
            'default'           => '#fff',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'     => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'facts_bg',
            array(
                'label' => __('Facts section background color', 'quill'),
                'section' => 'quill_fp_colors',
                'settings' => 'facts_bg',
                'priority' => 40
            )
        )
    );
    //Title
    $wp_customize->add_setting(
        'facts_title',
        array(
            'default'           => '#2E2E2E',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'     => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'facts_title',
            array(
                'label' => __('Facts section main title color', 'quill'),
                'section' => 'quill_fp_colors',
                'settings' => 'facts_title',
                'priority' => 41
            )
        )
    );
    //Title decoration
    $wp_customize->add_setting(
        'facts_title_dec',
        array(
            'default'           => '#2E2E2E',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'     => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'facts_title_dec',
            array(
                'label' => __('Facts section main title border', 'quill'),
                'section' => 'quill_fp_colors',
                'settings' => 'facts_title_dec',
                'priority' => 42
            )
        )
    );
    //Facts
    $wp_customize->add_setting(
        'facts_color',
        array(
            'default'           => '#2E2E2E',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'     => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'facts_color',
            array(
                'label' => __('Facts color', 'quill'),
                'section' => 'quill_fp_colors',
                'settings' => 'facts_color',
                'priority' => 43
            )
        )
    );
    //***Social section
    $wp_customize->add_setting('quill_options[info]', array(
            'type' => 'info_control',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'esc_attr',
        )
    );
    $wp_customize->add_control( new quill_Info( $wp_customize, 'social_section', array(
        'label' => __('Social section', 'quill'),
        'section' => 'quill_fp_colors',
        'settings' => 'quill_options[info]',
        'priority' => 44
        ) )
    );
    //Background
    $wp_customize->add_setting(
        'social_bg',
        array(
            'default'           => '#fff',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'     => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'social_bg',
            array(
                'label' => __('Social section background color', 'quill'),
                'section' => 'quill_fp_colors',
                'settings' => 'social_bg',
                'priority' => 45
            )
        )
    );
    //Title
    $wp_customize->add_setting(
        'social_title',
        array(
            'default'           => '#2E2E2E',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'     => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'social_title',
            array(
                'label' => __('Social section main title color', 'quill'),
                'section' => 'quill_fp_colors',
                'settings' => 'social_title',
                'priority' => 46
            )
        )
    );
    //Title decoration
    $wp_customize->add_setting(
        'social_title_dec',
        array(
            'default'           => '#2E2E2E',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'     => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'social_title_dec',
            array(
                'label' => __('Social section main title border', 'quill'),
                'section' => 'quill_fp_colors',
                'settings' => 'social_title_dec',
                'priority' => 47
            )
        )
    );
    //Social icons
    $wp_customize->add_setting(
        'social_icons',
        array(
            'default'           => '#2E2E2E',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'     => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'social_icons',
            array(
                'label' => __('Social section - social icons (Updates after you press Save&amp;Publish)', 'quill'),
                'section' => 'quill_fp_colors',
                'settings' => 'social_icons',
                'priority' => 48
            )
        )
    );
    //***Projects section
    $wp_customize->add_setting('quill_options[info]', array(
            'type' => 'info_control',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'esc_attr',
        )
    );
    $wp_customize->add_control( new quill_Info( $wp_customize, 'projects_section', array(
        'label' => __('Cases section', 'quill'),
        'section' => 'quill_fp_colors',
        'settings' => 'quill_options[info]',
        'priority' => 61
        ) )
    );
    //Background
    $wp_customize->add_setting(
        'projects_bg',
        array(
            'default'           => '#fff',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'     => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'projects_bg',
            array(
                'label' => __('Cases section background color', 'quill'),
                'section' => 'quill_fp_colors',
                'settings' => 'projects_bg',
                'priority' => 62
            )
        )
    );
    //Title
    $wp_customize->add_setting(
        'projects_title',
        array(
            'default'           => '#2E2E2E',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'     => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'projects_title',
            array(
                'label' => __('Cases section main title color', 'quill'),
                'section' => 'quill_fp_colors',
                'settings' => 'projects_title',
                'priority' => 63
            )
        )
    );
    //Title decoration
    $wp_customize->add_setting(
        'projects_title_dec',
        array(
            'default'           => '#2E2E2E',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'     => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'projects_title_dec',
            array(
                'label' => __('Cases section main title border', 'quill'),
                'section' => 'quill_fp_colors',
                'settings' => 'projects_title_dec',
                'priority' => 64
            )
        )
    );
    //Project background
    $wp_customize->add_setting(
        'projects_item_bg',
        array(
            'default'           => '#2E2E2E',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'     => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'projects_item_bg',
            array(
                'label' => __('Cases section - item background', 'quill'),
                'section' => 'quill_fp_colors',
                'settings' => 'projects_item_bg',
                'priority' => 65
            )
        )
    );
    //***Latest news section
    $wp_customize->add_setting('quill_options[info]', array(
            'type' => 'info_control',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'esc_attr',
        )
    );
    $wp_customize->add_control( new quill_Info( $wp_customize, 'latest_news_section', array(
        'label' => __('Latest news section', 'quill'),
        'section' => 'quill_fp_colors',
        'settings' => 'quill_options[info]',
        'priority' => 67
        ) )
    );
    //Background
    $wp_customize->add_setting(
        'latest_news_bg',
        array(
            'default'           => '#fff',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'latest_news_bg',
            array(
                'label' => __('Latest news section background color', 'quill'),
                'section' => 'quill_fp_colors',
                'settings' => 'latest_news_bg',
                'priority' => 68
            )
        )
    );
    //Title
    $wp_customize->add_setting(
        'latest_news_title',
        array(
            'default'           => '#444',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'latest_news_title',
            array(
                'label' => __('Latest news section main title color', 'quill'),
                'section' => 'quill_fp_colors',
                'settings' => 'latest_news_title',
                'priority' => 69
            )
        )
    );
    //Title decoration
    $wp_customize->add_setting(
        'latest_news_title_dec',
        array(
            'default'           => '#2E2E2E',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'latest_news_title_dec',
            array(
                'label' => __('Latest news section main title border)', 'quill'),
                'section' => 'quill_fp_colors',
                'settings' => 'latest_news_title_dec',
                'priority' => 70
            )
        )
    );
    //Post title
    $wp_customize->add_setting(
        'latest_news_post_title',
        array(
            'default'           => '#2E2E2E',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'latest_news_post_title',
            array(
                'label' => __('Post titles', 'quill'),
                'section' => 'quill_fp_colors',
                'settings' => 'latest_news_post_title',
                'priority' => 71
            )
        )
    );
    //Latest news text
    $wp_customize->add_setting(
        'latest_news_body_text',
        array(
            'default'           => '#6B6B6B',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'latest_news_body_text',
            array(
                'label' => __('Text color', 'quill'),
                'section' => 'quill_fp_colors',
                'settings' => 'latest_news_body_text',
                'priority' => 72
            )
        )
    );

    //***Subscribe
    $wp_customize->add_setting('quill_options[info]', array(
            'type' => 'info_control',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'esc_attr',
        )
    );
    $wp_customize->add_control( new quill_Info( $wp_customize, 'subscribe_section', array(
        'label' => __('Subscribe section', 'quill'),
        'section' => 'quill_fp_colors',
        'settings' => 'quill_options[info]',
        'priority' => 73
        ) )
    );
    //Background
    $wp_customize->add_setting(
        'subscribe_bg',
        array(
            'default'           => '#fff',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'subscribe_bg',
            array(
                'label' => __('Subscribe section background color', 'quill'),
                'section' => 'quill_fp_colors',
                'settings' => 'subscribe_bg',
                'priority' => 74
            )
        )
    );
    //Title
    $wp_customize->add_setting(
        'subscribe_title',
        array(
            'default'           => '#2E2E2E',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'subscribe_title',
            array(
                'label' => __('Subscribe section main title color', 'quill'),
                'section' => 'quill_fp_colors',
                'settings' => 'subscribe_title',
                'priority' => 75
            )
        )
    );
    //Title decoration
    $wp_customize->add_setting(
        'subscribe_title_dec',
        array(
            'default'           => '#2E2E2E',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'subscribe_title_dec',
            array(
                'label' => __('Subscribe section main title border)', 'quill'),
                'section' => 'quill_fp_colors',
                'settings' => 'subscribe_title_dec',
                'priority' => 76
            )
        )
    );
    //***Contact
    $wp_customize->add_setting('quill_options[info]', array(
            'type' => 'info_control',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'esc_attr',
        )
    );
    $wp_customize->add_control( new quill_Info( $wp_customize, 'contact_section', array(
        'label' => __('Contact section', 'quill'),
        'section' => 'quill_fp_colors',
        'settings' => 'quill_options[info]',
        'priority' => 77
        ) )
    );
    //Background
    $wp_customize->add_setting(
        'contact_bg',
        array(
            'default'           => '#fff',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'contact_bg',
            array(
                'label' => __('Contact section background color', 'quill'),
                'section' => 'quill_fp_colors',
                'settings' => 'contact_bg',
                'priority' => 78
            )
        )
    );
    //Title
    $wp_customize->add_setting(
        'contact_title',
        array(
            'default'           => '#2E2E2E',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'contact_title',
            array(
                'label' => __('Contact section main title color', 'quill'),
                'section' => 'quill_fp_colors',
                'settings' => 'contact_title',
                'priority' => 79
            )
        )
    );
    //Title decoration
    $wp_customize->add_setting(
        'contact_title_dec',
        array(
            'default'           => '#2E2E2E',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'contact_title_dec',
            array(
                'label' => __('Contact section main title border)', 'quill'),
                'section' => 'quill_fp_colors',
                'settings' => 'contact_title_dec',
                'priority' => 80
            )
        )
    );
    //Contact info
    $wp_customize->add_setting(
        'contact_info',
        array(
            'default'           => '#2E2E2E',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'contact_info',
            array(
                'label' => __('Contact section - address, email, phone)', 'quill'),
                'section' => 'quill_fp_colors',
                'settings' => 'contact_info',
                'priority' => 81
            )
        )
    );
    //***About
    $wp_customize->add_setting('quill_options[info]', array(
            'type' => 'info_control',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'esc_attr',
        )
    );
    $wp_customize->add_control( new quill_Info( $wp_customize, 'about_section', array(
        'label' => __('About us section', 'quill'),
        'section' => 'quill_fp_colors',
        'settings' => 'quill_options[info]',
        'priority' => 82
        ) )
    );
    //Background
    $wp_customize->add_setting(
        'about_bg',
        array(
            'default'           => '#fff',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'about_bg',
            array(
                'label' => __('About us section background color', 'quill'),
                'section' => 'quill_fp_colors',
                'settings' => 'about_bg',
                'priority' => 83
            )
        )
    );
    //Title
    $wp_customize->add_setting(
        'about_title',
        array(
            'default'           => '#2E2E2E',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'about_title',
            array(
                'label' => __('About us section main title color', 'quill'),
                'section' => 'quill_fp_colors',
                'settings' => 'about_title',
                'priority' => 84
            )
        )
    );
    //Title decoration
    $wp_customize->add_setting(
        'about_title_dec',
        array(
            'default'           => '#2E2E2E',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'about_title_dec',
            array(
                'label' => __('About us section main title border)', 'quill'),
                'section' => 'quill_fp_colors',
                'settings' => 'about_title_dec',
                'priority' => 85
            )
        )
    );
    //About us text
    $wp_customize->add_setting(
        'about_text',
        array(
            'default'           => '#6B6B6B',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'about_text',
            array(
                'label' => __('About us section - text)', 'quill'),
                'section' => 'quill_fp_colors',
                'settings' => 'about_text',
                'priority' => 86
            )
        )
    );
    //___Fonts___//
    $wp_customize->add_section(
        'quill_typography',
        array(
            'title' => __('Fonts', 'quill' ),
            'priority' => 15,
        )
    );
    $font_choices = 
        array(
            'Source Sans Pro:400,700,400italic,700italic' => 'Source Sans Pro',     
            'Droid Sans:400,700' => 'Droid Sans',
            'Lato:400,700,400italic,700italic' => 'Lato',
            'Arvo:400,700,400italic,700italic' => 'Arvo',
            'Lora:400,700,400italic,700italic' => 'Lora',
            'PT Sans:400,700,400italic,700italic' => 'PT Sans',
            'PT+Sans+Narrow:400,700' => 'PT Sans Narrow',
            'Arimo:400,700,400italic,700italic' => 'Arimo',
            'Ubuntu:400,700,400italic,700italic' => 'Ubuntu',
            'Bitter:400,700,400italic' => 'Bitter',
            'Droid Serif:400,700,400italic,700italic' => 'Droid Serif',
            'Open+Sans:400italic,700italic,400,700' => 'Open Sans',
            'Roboto:400,400italic,700,700italic' => 'Roboto',
            'Oswald:400,700' => 'Oswald',
            'Open Sans Condensed:700,300italic,300' => 'Open Sans Condensed',
            'Roboto Condensed:400italic,700italic,400,700' => 'Roboto Condensed',
            'Raleway:400,700' => 'Raleway',
            'Roboto Slab:400,700' => 'Roboto Slab',
            'Yanone Kaffeesatz:400,700' => 'Yanone Kaffeesatz',
            'Rokkitt:400' => 'Rokkitt',
        );
    
    $wp_customize->add_setting(
        'headings_fonts',
        array(
            'sanitize_callback' => 'quill_sanitize_fonts',
        )
    );
    
    $wp_customize->add_control(
        'headings_fonts',
        array(
            'type' => 'select',
            'label' => __('Select your desired font for the headings.', 'quill'),
            'section' => 'quill_typography',
            'choices' => $font_choices
        )
    );
    
    $wp_customize->add_setting(
        'body_fonts',
        array(
            'sanitize_callback' => 'quill_sanitize_fonts',
        )
    );
    
    $wp_customize->add_control(
        'body_fonts',
        array(
            'type' => 'select',
            'label' => __('Select your desired font for the body.', 'quill'),
            'section' => 'quill_typography',
            'choices' => $font_choices
        )
    );
    //___Colors___//

    $wp_customize->get_section( 'colors' )->description = __('Not all of the color settings found in this section apply to the front page.', 'quill');
    
    //Header background
    $wp_customize->add_setting(
        'header_color',
        array(
            'default'           => '#2E2E2E',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'header_color',
            array(
                'label' => __('Header background', 'quill'),
                'section' => 'colors',
                'settings' => 'header_color',
                'priority' => 11
            )
        )
    );             
    //Site title
    $wp_customize->add_setting(
        'site_title_color',
        array(
            'default'           => '#ffffff',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'site_title_color',
            array(
                'label' => __('Site title', 'quill'),
                'section' => 'colors',
                'settings' => 'site_title_color',
                'priority' => 13
            )
        )
    );
    //Site description
    $wp_customize->add_setting(
        'site_desc_color',
        array(
            'default'           => '#ffffff',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'site_desc_color',
            array(
                'label' => __('Site description', 'quill'),
                'section' => 'colors',
                'settings' => 'site_desc_color',
                'priority' => 14
            )
        )
    );
    //Entry title
    $wp_customize->add_setting(
        'entry_title_color',
        array(
            'default'           => '#2E2E2E',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'entry_title_color',
            array(
                'label' => __('Entry title', 'quill'),
                'section' => 'colors',
                'settings' => 'entry_title_color',
                'priority' => 15
            )
        )
    );  
    //Body
    $wp_customize->add_setting(
        'body_text_color',
        array(
            'default'           => '#6B6B6B',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'body_text_color',
            array(
                'label' => __('Text', 'quill'),
                'section' => 'colors',
                'settings' => 'body_text_color',
                'priority' => 16
            )
        )
    );
    //Footer
    $wp_customize->add_setting(
        'footer_color',
        array(
            'default'           => '#2E2E2E',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'footer_color',
            array(
                'label' => __('Footer background', 'quill'),
                'section' => 'colors',
                'settings' => 'footer_color',
                'priority' => 17
            )
        )
    );            
}
add_action( 'customize_register', 'quill_customize_register' );

/**
 * Sanitization
 */
//Checkboxes
function quill_sanitize_checkbox( $input ) {
	if ( $input == 1 ) {
		return 1;
	} else {
		return '';
	}
}
//Text
function quill_sanitize_text( $input ) {
    return wp_kses_post( force_balance_tags( $input ) );
}
//Fonts
function quill_sanitize_fonts( $input ) {
    $valid = array(
            'Source Sans Pro:400,700,400italic,700italic' => 'Source Sans Pro',     
            'Droid Sans:400,700' => 'Droid Sans',
            'Lato:400,700,400italic,700italic' => 'Lato',
            'Arvo:400,700,400italic,700italic' => 'Arvo',
            'Lora:400,700,400italic,700italic' => 'Lora',
            'PT Sans:400,700,400italic,700italic' => 'PT Sans',
            'PT+Sans+Narrow:400,700' => 'PT Sans Narrow',
            'Arimo:400,700,400italic,700italic' => 'Arimo',
            'Ubuntu:400,700,400italic,700italic' => 'Ubuntu',
            'Bitter:400,700,400italic' => 'Bitter',
            'Droid Serif:400,700,400italic,700italic' => 'Droid Serif',
            'Open+Sans:400italic,700italic,400,700' => 'Open Sans',
            'Roboto:400,400italic,700,700italic' => 'Roboto',
            'Oswald:400,700' => 'Oswald',
            'Open Sans Condensed:700,300italic,300' => 'Open Sans Condensed',
            'Roboto Condensed:400italic,700italic,400,700' => 'Roboto Condensed',
            'Raleway:400,700' => 'Raleway',
            'Roboto Slab:400,700' => 'Roboto Slab',
            'Yanone Kaffeesatz:400,700' => 'Yanone Kaffeesatz',
            'Rokkitt:400' => 'Rokkitt',
    );
 
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}
/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function quill_customize_preview_js() {
	wp_enqueue_script( 'quill_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '', true );
}
add_action( 'customize_preview_init', 'quill_customize_preview_js' );
