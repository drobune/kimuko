<?php

class Quill_Subscribe_Block extends WP_Widget {

// constructor
    function Quill_subscribe_block() {
		$widget_ops = array('classname' => 'quill_subscribe_block_widget', 'description' => __( 'Display a subscribe form integrated with MailChimp.', 'quill') );
        parent::__construct(false, $name = __('Quill FP: Subscribe', 'quill'), $widget_ops);
		$this->alt_option_name = 'quill_subscribe_block_widget';
		
		add_action( 'save_post', array($this, 'flush_widget_cache') );
		add_action( 'deleted_post', array($this, 'flush_widget_cache') );
		add_action( 'switch_theme', array($this, 'flush_widget_cache') );		
    }
	
	// widget form creation
	function form($instance) {

	// Check values
		$title     		= isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$desc 			= isset( $instance['desc'] ) ? esc_textarea( $instance['desc'] ) : '';		
		$form_action   	= isset( $instance['form_action'] ) ? esc_html( $instance['form_action'] ) : '';
		$image_uri = isset( $instance['image_uri'] ) ? esc_url( $instance['image_uri'] ) : '';				
	?>

	<p>
	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title of this section:', 'quill'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
	</p>

	<p>
	<label for="<?php echo $this->get_field_id('desc'); ?>"><?php _e('Enter a short description for this block', 'quill'); ?></label>
	<textarea class="widefat" id="<?php echo $this->get_field_id('desc'); ?>" name="<?php echo $this->get_field_name('desc'); ?>"><?php echo $desc; ?></textarea>
	</p>	

	<p>
	<label for="<?php echo $this->get_field_id('form_action'); ?>"><?php _e('Form action URL for your MailChimp list', 'quill'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('form_action'); ?>" name="<?php echo $this->get_field_name('form_action'); ?>" type="text" value="<?php echo $form_action; ?>" />
	</p>

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
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['desc'] = strip_tags($new_instance['desc']);
		$instance['form_action'] = esc_url_raw($new_instance['form_action']);
	    $instance['image_uri'] 	= esc_url_raw( $new_instance['image_uri'] );					
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['quill_subscribe_block']) )
			delete_option('quill_subscribe_block');		  
		  
		return $instance;
	}
	
	function flush_widget_cache() {
		wp_cache_delete('quill_subscribe_block', 'widget');
	}
	
	// display widget
	function widget($args, $instance) {
		$cache = array();
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( 'quill_subscribe_block', 'widget' );
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

		$title 		 = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Subscribe', 'quill' );
		$desc 		 = isset( $instance['desc'] ) ? esc_textarea($instance['desc']) : '';		
		$form_action = isset( $instance['form_action'] ) ? esc_url($instance['form_action']) : '';		
		$image_uri 	 = isset( $instance['image_uri'] ) ? esc_url($instance['image_uri']) : '';		


?>
		<section id="subscribe" class="subscribe-area">
			<div class="container">
				<?php if ( $title ) echo $before_title . '<span class="wow fadeInRight">' . $title . '</span>' . $after_title; ?>
				<?php if ($desc != '') : ?>
					<div class="section-desc">
						<?php echo $desc; ?>
					</div>
				<?php endif; ?>
				<div id="mc_embed_signup">
					<form action="<?php echo esc_url($form_action); ?>" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>

						<input type="email" value="" name="EMAIL" class="input mc-subscribe wow zoomIn" id="mce-EMAIL" placeholder="Your email adress here">

						<input type="submit" value="Submit" name="submit" id="submit" class="subscribe read-more buttons wow zoomIn" />
					</form>
				</div>
			</div>
			<?php if ($image_uri != '') : ?>
				<style type="text/css">
					.subscribe-area {
					    display: block;			    
						background: url(<?php echo $image_uri; ?>) no-repeat;
						background-position: center top;
						background-attachment: fixed;
						background-size: cover;
						z-index: -1;
					}
				</style>
			<?php endif; ?>				
		</section>

	<?php

		if ( ! $this->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'quill_subscribe_block', $cache, 'widget' );
		} else {
			ob_end_flush();
		}
	}
	
}	