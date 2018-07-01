<?php
/**
 * Slider template
 *
 * @package Quill
 */

//Load the script for the slider
function quill_slider_scripts() {
	if ( is_front_page() && get_theme_mod('slider_display') ) {
			
		wp_enqueue_script( 'quill-superslides', get_template_directory_uri() . '/js/jquery.superslides.min.js', array(), true );

		wp_enqueue_script( 'quill-slides-init', get_template_directory_uri() . '/js/slides-init.js', array('jquery'), true );
					
	}		
}
add_action( 'wp_enqueue_scripts', 'quill_slider_scripts' );

//Slider template
function quill_slider_template() { ?>
	<div class="overlay"></div>
	<div id="slides">
	    <div class="slides-container">
		    <?php 
			    if ( get_theme_mod('slider_image_1') ) {
					echo '<img src="' . esc_url(get_theme_mod('slider_image_1')) . '">';
				}
			    if ( get_theme_mod('slider_image_2') ) {
					echo '<img src="' . esc_url(get_theme_mod('slider_image_2')) . '">';
				}			
			    if ( get_theme_mod('slider_image_3') ) {
					echo '<img src="' . esc_url(get_theme_mod('slider_image_3')) . '">';
				}
			    if ( get_theme_mod('slider_image_4') ) {
					echo '<img src="' . esc_url(get_theme_mod('slider_image_4')) . '">';
				}
			    if ( get_theme_mod('slider_image_5') ) {
					echo '<img src="' . esc_url(get_theme_mod('slider_image_5')) . '">';
				}				
			?>	
	    </div>

	    <div class="header-buttons">
	    	<?php 
		    	if ( get_theme_mod('header_btn_link_1') ) {
			    	echo '<a class="header-button wow zoomInUp" href="' . esc_url(get_theme_mod('header_btn_link_1')) . '">' . esc_html(get_theme_mod('header_btn_text_1')) . '</a>';
				}
		    	if ( get_theme_mod('header_btn_link_2') ) {
			    	echo '<a class="header-button wow zoomInUp" href="' . esc_url(get_theme_mod('header_btn_link_2')) . '">' . esc_html(get_theme_mod('header_btn_text_2')) . '</a>';
				}
			?>
		</div>
	</div>
	<?php	
}