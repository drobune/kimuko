<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Basepress
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('post-item clearfix'); ?>>

	<?php
	/**
	 * Functions hooked in to basepress_loop_post action.
	 *
	 * @hooked basepress_post_header          - 10
	 * @hooked basepress_post_meta            - 20
	 * @hooked basepress_post_content         - 30
	 * @hooked basepress_init_structured_data - 40
	 */
	do_action( 'basepress_loop_post' );

	?>	
	
</article><!-- #post-## -->
