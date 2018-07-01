<?php

class Quill_Services extends WP_Widget {

// constructor
    function quill_services() {
		$widget_ops = array('classname' => 'quill_services_widget', 'description' => __( 'Show what services you are able to provide.', 'quill') );
        parent::__construct(false, $name = __('Quill FP: Services', 'quill'), $widget_ops);
		$this->alt_option_name = 'quill_services_widget';
		
		add_action( 'save_post', array($this, 'flush_widget_cache') );
		add_action( 'deleted_post', array($this, 'flush_widget_cache') );
		add_action( 'switch_theme', array($this, 'flush_widget_cache') );		
    }
	
	// widget form creation
	function form($instance) {

	// Check values
		$title     	= isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$desc 		= isset( $instance['desc'] ) ? esc_textarea( $instance['desc'] ) : '';		
		$image_uri 	= isset( $instance['image_uri'] ) ? esc_url_raw( $instance['image_uri'] ) : '';
		$number    	= isset( $instance['number'] ) ? intval( $instance['number'] ) : -1;
		$category  	= isset( $instance['category '] ) ? esc_attr( $instance['category '] ) : '';
		$see_all   	= isset( $instance['see_all'] ) ? esc_url_raw( $instance['see_all'] ) : '';				
	?>

	<p><?php _e('In order to display this widget, you must first add some services from the dashboard. Add as many as you want and the theme will automatically display them all.', 'quill'); ?></p>
	<p>
	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'quill'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
	</p>
	<p>
	<label for="<?php echo $this->get_field_id('desc'); ?>"><?php _e('Enter a short description for this block', 'quill'); ?></label>
	<textarea class="widefat" id="<?php echo $this->get_field_id('desc'); ?>" name="<?php echo $this->get_field_name('desc'); ?>"><?php echo $desc; ?></textarea>
	</p>

    <?php
        if ( $image_uri != '' ) :
           echo '<p><img class="custom_media_image" src="' . $image_uri . '" style="max-width:100px;" /></p>';
        endif;
    ?>
    <p><label for="<?php echo $this->get_field_id('image_uri'); ?>"><?php _e('Upload an image for the background if you want. [DEPRECATED - use row styles instead]', 'quill'); ?></label></p> 
    <p><input type="button" class="button button-primary custom_media_button" id="custom_media_button" name="<?php echo $this->get_field_name('image_uri'); ?>" value="Upload Image" style="margin-top:5px;" /></p>
	<p><input class="widefat custom_media_url" id="<?php echo $this->get_field_id( 'image_uri' ); ?>" name="<?php echo $this->get_field_name( 'image_uri' ); ?>" type="text" value="<?php echo $image_uri; ?>" size="3" /></p>	

	<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of services to show (-1 shows all of them):', 'quill' ); ?></label>
	<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
    <p><label for="<?php echo $this->get_field_id('see_all'); ?>"><?php _e('Enter the URL for your services page. Useful if you want to show here just a few services, then send your visitors to a different page.', 'quill'); ?></label>
	<input class="widefat custom_media_url" id="<?php echo $this->get_field_id( 'see_all' ); ?>" name="<?php echo $this->get_field_name( 'see_all' ); ?>" type="text" value="<?php echo $see_all; ?>" size="3" /></p>	
	<p><label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e( 'Enter the slug for your category or leave empty to show all services.', 'quill' ); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'category' ); ?>" name="<?php echo $this->get_field_name( 'category' ); ?>" type="text" value="<?php echo $category; ?>" size="3" /></p>

	
	<?php
	}

	// update widget
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['desc'] = strip_tags($new_instance['desc']);		
		$instance['number'] = strip_tags($new_instance['number']);
	    $instance['image_uri'] = esc_url_raw( $new_instance['image_uri'] );
		$instance['see_all'] = esc_url_raw( $new_instance['see_all'] );	
		$instance['category'] = strip_tags($new_instance['category']);		
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['quill_services']) )
			delete_option('quill_services');		  
		  
		return $instance;
	}
	
	function flush_widget_cache() {
		wp_cache_delete('quill_services', 'widget');
	}
	
	// display widget
	function widget($args, $instance) {
		$cache = array();
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( 'quill_services', 'widget' );
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

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';

		/** This filter is documented in wp-includes/default-widgets.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$desc = isset( $instance['desc'] ) ? esc_textarea($instance['desc']) : '';		
		$image_uri = isset( $instance['image_uri'] ) ? esc_url($instance['image_uri']) : '';		
		$see_all = isset( $instance['see_all'] ) ? esc_url($instance['see_all']) : '';
		$number = ( ! empty( $instance['number'] ) ) ? intval( $instance['number'] ) : -1;
		if ( ! $number )
			$number = -1;				
		$category = isset( $instance['category'] ) ? esc_attr($instance['category']) : '';

		/**
		 * Filter the arguments for the Recent Posts widget.
		 *
		 * @since 3.4.0
		 *
		 * @see WP_Query::get_posts()
		 *
		 * @param array $args An array of arguments used to retrieve the recent posts.
		 */
		$r = new WP_Query( apply_filters( 'widget_posts_args', array(
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'post_type' 		  => 'services',
			'posts_per_page'	  => $number,
			'category_name'		  => $category		
		) ) );

		if ($r->have_posts()) :
?>
		<section id="services" class="services-area">
			<div class="container">
				<?php if ( $title ) echo $before_title . '<span class="wow fadeInRight">' . $title . '</span>' . $after_title; ?>
				<?php if ($desc != '') : ?>
					<div class="section-desc">
						<?php echo $desc; ?>
					</div>
				<?php endif; ?>	
				<div class="services-container">			
				<?php while ( $r->have_posts() ) : $r->the_post(); ?>
					<?php $icon = get_post_meta( get_the_ID(), 'wpcf-service-icon', true ); ?>
					<div class="service col-md-4 col-sm-6 col-xs-6 wow rotateInUpLeft">
					<?php if ($icon) : ?>
						<span class="service-icon"><?php echo '<i class="fa ' . esc_html($icon) . '"></i>'; ?></span>
					<?php endif; ?>
						<h4 class="service-title"><?php the_title(); ?></h4>
						<div class="service-desc"><?php the_excerpt(); ?></div>
						<?php $service_link = get_post_meta( get_the_ID(), 'wpcf-service-link', true ); ?>
						<?php if ($service_link) : ?>
							<a class="read-more buttons" href="<?php echo esc_url($service_link); ?>"><?php echo __('Read More', 'quill'); ?></a>
						<?php else : ?>
							<a class="read-more buttons" href="<?php the_permalink(); ?>"><?php echo __('Read More', 'quill'); ?></a>
						<?php endif; ?>
					</div>
				<?php endwhile; ?>
				</div>
			</div>
			<?php if ($see_all != '') : ?>
				<a href="<?php echo esc_url($see_all); ?>" class="read-more buttons"><?php echo __('See all our services', 'quill'); ?></a>
			<?php endif; ?>			
		<?php if ($image_uri != '') : ?>
			<style type="text/css">
				.services-area {
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
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();

		endif;

		if ( ! $this->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'quill_services', $cache, 'widget' );
		} else {
			ob_end_flush();
		}
	}
	
}