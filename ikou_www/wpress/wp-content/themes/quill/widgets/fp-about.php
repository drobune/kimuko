<?php

class Quill_About extends WP_Widget {

// constructor
    function quill_about() {
		$widget_ops = array('classname' => 'quill_about_widget', 'description' => __( 'Add some info about your firm', 'quill') );
        parent::__construct(false, $name = __('Quill FP: About us', 'quill'), $widget_ops);
		$this->alt_option_name = 'quill_about_widget';
		
		add_action( 'save_post', array($this, 'flush_widget_cache') );
		add_action( 'deleted_post', array($this, 'flush_widget_cache') );
		add_action( 'switch_theme', array($this, 'flush_widget_cache') );		
    }
	
	// widget form creation
	function form($instance) {

	// Check values
		$title      	= isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$image_uri  	= isset( $instance['image_uri'] ) ? esc_url_raw( $instance['image_uri'] ) : '';
		$about_text  	= isset( $instance['about_text'] ) ? esc_textarea( $instance['about_text'] ) : '';	
		$action_title   = isset( $instance['action_title'] ) ? esc_html( $instance['action_title'] ) : '';
		$action_link 	= isset( $instance['action_link'] ) ? esc_url_raw( $instance['action_link'] ) : '';
		$action_anchor   = isset( $instance['action_anchor'] ) ? esc_html( $instance['action_anchor'] ) : '';		


	?>

	<p>
	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'quill'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
	</p>
	
	<p>
	<label for="<?php echo $this->get_field_id('about_text'); ?>"><?php _e('Add a bit of info about your firm.', 'quill'); ?></label>
	<textarea class="widefat" id="<?php echo $this->get_field_id('about_text'); ?>" name="<?php echo $this->get_field_name('about_text'); ?>"><?php echo $about_text; ?></textarea>
	</p>

    <?php
        if ( $image_uri != '' ) :
           echo '<p><img class="custom_media_image" src="' . $image_uri . '" style="max-width:100px;" /></p>';
        endif;
    ?>
 	<p><label for="<?php echo $this->get_field_id('image_uri'); ?>"><?php _e('Upload an image to show up next to your quote.', 'quill'); ?></label></p>   
    <p><input type="button" class="button button-primary custom_media_button" id="custom_media_button" name="<?php echo $this->get_field_name('image_uri'); ?>" value="Upload Image" style="margin-top:5px;" /></p>
	<p><input class="widefat custom_media_url" id="<?php echo $this->get_field_id( 'image_uri' ); ?>" name="<?php echo $this->get_field_name( 'image_uri' ); ?>" type="text" value="<?php echo $image_uri; ?>" size="3" /></p>	

	<p>
	<label for="<?php echo $this->get_field_id('action_title'); ?>"><?php _e('Call to action title', 'quill'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('action_title'); ?>" name="<?php echo $this->get_field_name('action_title'); ?>" type="text" value="<?php echo $action_title; ?>" />
	</p>

	<p>
	<label for="<?php echo $this->get_field_id('action_link'); ?>"><?php _e('Call to action button link', 'quill'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('action_link'); ?>" name="<?php echo $this->get_field_name('action_link'); ?>" type="text" value="<?php echo $action_link; ?>" />
	</p>

	<p>
	<label for="<?php echo $this->get_field_id('action_anchor'); ?>"><?php _e('Call to action title', 'quill'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('action_anchor'); ?>" name="<?php echo $this->get_field_name('action_anchor'); ?>" type="text" value="<?php echo $action_anchor; ?>" />
	</p>	
	
	<?php
	}

	// update widget
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['about_text'] = strip_tags($new_instance['about_text']);
	    $instance['image_uri'] = esc_url_raw( $new_instance['image_uri'] );	
		$instance['action_title'] = strip_tags($new_instance['action_title']);
		$instance['action_link'] = esc_url_raw( $new_instance['action_link'] );
		$instance['action_anchor'] = strip_tags($new_instance['action_anchor']);    		
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['quill_about']) )
			delete_option('quill_about');		  
		  
		return $instance;
	}
	
	function flush_widget_cache() {
		wp_cache_delete('quill_about', 'widget');
	}
	
	// display widget
	function widget($args, $instance) {
		$cache = array();
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( 'quill_about', 'widget' );
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

		$title 			= ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'About us', 'quill' );
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$image_uri = isset( $instance['image_uri'] ) ? esc_url($instance['image_uri']) : '';	
		$about_text = isset( $instance['about_text'] ) ? esc_textarea($instance['about_text']) : '';
		$action_title = isset( $instance['action_title'] ) ? esc_html($instance['action_title']) : '';
		$action_link= isset( $instance['action_link'] ) ? esc_url($instance['action_link']) : '';
		$action_anchor = isset( $instance['action_anchor'] ) ? esc_html($instance['action_anchor']) : '';

?>
		<section id="about_text" class="about_text-area">
			<div class="container">			
				<?php if ( $title ) echo $before_title . '<span class="wow fadeInRight">' . $title . '</span>' . $after_title; ?>
				<?php if ($image_uri !='') : ?>
					<div class="about-photo wow fadeInLeft col-md-6 col-sm-12 col-xs-12">
						<img src="<?php echo esc_url($image_uri); ?>" />
					</div>
					<div class="col-md-6 col-sm-12 col-xs-12">
				<?php else : ?>
					<div class="col-md-12">
				<?php endif; ?>
					<div class="about-text wow fadeInRight"><?php echo $about_text; ?></div>
					<h3 class="action-title"><?php echo esc_html($action_title); ?></h3>
					<a class="read-more buttons wow pulse" href="<?php echo esc_url($action_link); ?>"><?php echo esc_html($action_anchor); ?></a>
				</div>	
			</div>		
		</section>		
	<?php

		if ( ! $this->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'quill_about', $cache, 'widget' );
		} else {
			ob_end_flush();
		}
	}
	
}