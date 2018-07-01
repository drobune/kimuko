<?php

class Quill_Cases extends WP_Widget {

// constructor
    function quill_cases() {
		$widget_ops = array('classname' => 'quill_cases_widget', 'description' => __( 'Show your most interesting cases.', 'quill') );
        parent::__construct(false, $name = __('Quill FP: Cases', 'quill'), $widget_ops);
		$this->alt_option_name = 'quill_cases_widget';
		
		add_action( 'save_post', array($this, 'flush_widget_cache') );
		add_action( 'deleted_post', array($this, 'flush_widget_cache') );
		add_action( 'switch_theme', array($this, 'flush_widget_cache') );		
    }
	
	// widget form creation
	function form($instance) {

	// Check values
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$desc 		= isset( $instance['desc'] ) ? esc_textarea( $instance['desc'] ) : '';			
		$image_uri = isset( $instance['image_uri'] ) ? esc_url_raw( $instance['image_uri'] ) : '';		
	?>

	<p><?php _e('In order to display this widget, you must first add some cases from the dashboard.', 'quill'); ?></p>
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
	
	<?php
	}

	// update widget
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['desc'] = strip_tags($new_instance['desc']);		
	    $instance['image_uri'] = esc_url_raw( $new_instance['image_uri'] );			
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['quill_cases']) )
			delete_option('quill_cases');		  
		  
		return $instance;
	}
	
	function flush_widget_cache() {
		wp_cache_delete('quill_cases', 'widget');
	}
	
	// display widget
	function widget($args, $instance) {
		$cache = array();
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( 'quill_cases', 'widget' );
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

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Our cases', 'quill' );

		/** This filter is documented in wp-includes/default-widgets.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$desc = isset( $instance['desc'] ) ? esc_textarea($instance['desc']) : '';		
		$image_uri = isset( $instance['image_uri'] ) ? esc_url($instance['image_uri']) : '';		

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
			'post_type' 		  => 'cases',
			'posts_per_page'	  => 4
		) ) );

		if ($r->have_posts()) :
?>
		<section id="cases" class="cases-area">
			<div class="container">
				<?php if ( $title ) echo $before_title . '<span class="wow fadeInRight">' . $title . '</span>' . $after_title; ?>
				<?php if ($desc != '') : ?>
					<div class="section-desc">
						<?php echo $desc; ?>
					</div>
				<?php endif; ?>				
				<?php while ( $r->have_posts() ) : $r->the_post(); ?>
					<div class="project col-md-6 col-sm-6 col-xs-12 wow pulse">
						<?php the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
					</div>
				<?php endwhile; ?>
			</div>
		<?php if ($image_uri != '') : ?>
			<style type="text/css">
				.cases-area {
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
			wp_cache_set( 'quill_cases', $cache, 'widget' );
		} else {
			ob_end_flush();
		}
	}
	
}