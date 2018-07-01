<?php

class Quill_Contact extends WP_Widget {

// constructor
    function quill_contact() {
		$widget_ops = array('classname' => 'quill_contact_widget', 'description' => __( 'Display the contact methods for your firm', 'quill') );
        parent::__construct(false, $name = __('Quill FP: Contact', 'quill'), $widget_ops);
		$this->alt_option_name = 'quill_contact_widget';
		
		add_action( 'save_post', array($this, 'flush_widget_cache') );
		add_action( 'deleted_post', array($this, 'flush_widget_cache') );
		add_action( 'switch_theme', array($this, 'flush_widget_cache') );		
    }
	
	// widget form creation
	function form($instance) {

	// Check values
		$title     	= isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$desc 		= isset( $instance['desc'] ) ? esc_textarea( $instance['desc'] ) : '';			
		$form   	= isset( $instance['form'] ) ? absint( $instance['form'] ) : '';
		$address  	= isset( $instance['address'] ) ? esc_html( $instance['address'] ) : '';
		$phone   	= isset( $instance['phone'] ) ? esc_html( $instance['phone'] ) : '';
		$email    	= isset( $instance['email'] ) ? esc_html( $instance['email'] ) : '';	
		$image_uri 	= isset( $instance['image_uri'] ) ? esc_url( $instance['image_uri'] ) : '';		
	?>

	<p>
	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'quill'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
	</p>

	<p>
	<label for="<?php echo $this->get_field_id('desc'); ?>"><?php _e('Enter a short description for this block', 'quill'); ?></label>
	<textarea class="widefat" id="<?php echo $this->get_field_id('desc'); ?>" name="<?php echo $this->get_field_name('desc'); ?>"><?php echo $desc; ?></textarea>
	</p>	

	<!-- Contact form id -->
	<p>
	<label for="<?php echo $this->get_field_id('form'); ?>"><?php _e('ID for your contact form', 'quill'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('form'); ?>" name="<?php echo $this->get_field_name('form'); ?>" type="text" value="<?php echo $form; ?>" />
	</p>

	<p><label for="<?php echo $this->get_field_id( 'address' ); ?>"><?php _e( 'Enter your address', 'quill' ); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'address' ); ?>" name="<?php echo $this->get_field_name( 'address' ); ?>" type="text" value="<?php echo $address; ?>" size="3" /></p>

	<p><label for="<?php echo $this->get_field_id( 'phone' ); ?>"><?php _e( 'Enter your phone number', 'quill' ); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'phone' ); ?>" name="<?php echo $this->get_field_name( 'phone' ); ?>" type="text" value="<?php echo $phone; ?>" size="3" /></p>

	<p><label for="<?php echo $this->get_field_id( 'email' ); ?>"><?php _e( 'Enter your email address', 'quill' ); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'email' ); ?>" name="<?php echo $this->get_field_name( 'email' ); ?>" type="text" value="<?php echo $email; ?>" size="3" /></p>						

    <?php
        if ( $image_uri != '' ) :
           echo '<p><img class="custom_media_image" src="' . $image_uri . '" style="max-width:100px;" /></p>';
        endif;
    ?>
    <p><label for="<?php echo $this->get_field_id('image_uri'); ?>"><?php _e('Upload an image for the background if you want. [DEPRECATED - use row styles instead]', 'quill'); ?></label></p> 
    <p><input type="button" class="button button-primary custom_media_button" id="custom_media_button" name="<?php echo $this->get_field_name('image_uri'); ?>" value="Upload Image" style="margin-top:5px;" /></p>
	<p><input class="widefat custom_media_url" id="<?php echo $this->get_field_id( 'image_uri' ); ?>" name="<?php echo $this->get_field_name( 'image_uri' ); ?>" type="text" value="<?php echo $image_uri; ?>" size="3" /></p>	
	
	<?php
	}

	// update widget
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] 		= strip_tags($new_instance['title']);
		$instance['desc'] 		= strip_tags($new_instance['desc']);		
		$instance['form'] 		= intval($new_instance['form']);
		$instance['address'] 	= strip_tags($new_instance['address']);
		$instance['phone'] 		= strip_tags($new_instance['phone']);
		$instance['email'] 		= sanitize_email($new_instance['email']);
	    $instance['image_uri'] 	= esc_url_raw( $new_instance['image_uri'] );			
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['quill_contact']) )
			delete_option('quill_contact');		  
		  
		return $instance;
	}
	
	function flush_widget_cache() {
		wp_cache_delete('quill_contact', 'widget');
	}
	
	// display widget
	function widget($args, $instance) {
		$cache = array();
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( 'quill_contact', 'widget' );
		}

		if ( ! is_array( $cache ) ) {
			$cache = array();
		}

		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

		ob_start();
		extract($args);

		$title 			= ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Get in touch', 'quill' );
		$title 			= apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$desc 			= isset( $instance['desc'] ) ? esc_textarea($instance['desc']) : '';		
		$form   		= isset( $instance['form'] ) ? absint( $instance['form'] ) : '';
		$address   		= isset( $instance['address'] ) ? esc_html( $instance['address'] ) : '';
		$phone   		= isset( $instance['phone'] ) ? esc_html( $instance['phone'] ) : '';
		$email   		= isset( $instance['email'] ) ? esc_html( $instance['email'] ) : '';		
		$image_uri 		= isset( $instance['image_uri'] ) ? esc_url($instance['image_uri']) : '';		

?>
		<section id="contact" class="contact-area">
			<div class="container">
				<?php if ( $title ) echo $before_title . '<span class="wow fadeInRight">' . $title . '</span>' . $after_title; ?>
				<?php if ($desc != '') : ?>
					<div class="section-desc">
						<?php echo $desc; ?>
					</div>
				<?php endif; ?>				
				<?php if ( ($address   !='') || ($phone  !='') || ($email   !='') ) : ?>
					<div class="contact-info">
					<?php
						if( ($address) ) {
							echo '<div class="contact-address wow fadeIn">';
							echo '<span><i class="fa fa-home"></i>' . __('Address: ', 'quill') . '</span>' . $address;
							echo '</div>';
						}
						if( ($phone) ) {
							echo '<div class="contact-phone wow fadeIn">';
							echo '<span><i class="fa fa-phone"></i>' . __('Phone: ', 'quill') . '</span>' . $phone;
							echo '</div>';
						}
						if( ($email) ) {
							echo '<div class="contact-email wow fadeIn">';
							echo '<span><i class="fa fa-envelope"></i>' . __('Email: ', 'quill') . '</span>' . '<a href="mailto:' . $email . '">' . $email . '</a>';
							echo '</div>';
						}
						?>
					</div>
				<?php endif; ?>		
				<?php if ($form !='') : ?>
					<?php echo do_shortcode('[contact-form-7 id="' . absint($form) . '"]'); ?>
				<?php endif; ?>																				
			</div>
			<?php if ($image_uri != '') : ?>
				<style type="text/css">
					.contact-area {
					    display: block;			    
						background: url(<?php echo $image_uri; ?>) no-repeat;
						background-position: center top;
						background-attachment: fixed;
						background-size: cover;
						z-index: 0;
						position: relative;
					}
					.contact-area:after {
					    content: '';		    
					    width: 100%;
					    height: 100%;
					    position: absolute;
					    background-color: #333;
					    opacity: 0.7;
					    top: 0;
					    left: 0;
					    z-index: -1;
					}					
				</style>
			<?php endif; ?>									
		</section>				
	<?php

		if ( ! $this->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'quill_contact', $cache, 'widget' );
		} else {
			ob_end_flush();
		}
	}
	
}