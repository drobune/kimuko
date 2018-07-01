<?php
/**
 * Template part for displaying content single.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package  basepress
 */

?>

<div class="single_post clearfix">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php

	do_action( 'basepress_single_post_top' );

	/**
	 * Functions hooked into basepress_single_post add_action
	 *
	 * @hooked basepress_post_header          - 10
	 * @hooked basepress_post_header_meta     - 20
	 * @hooked basepress_post_content         - 35
	 * @hooked basepress_init_structured_data - 40
	 */
	do_action( 'basepress_single_post' );

	/**
	 * Functions hooked in to basepress_single_post_bottom action
	 *
	 * @hooked basepress_post_tags         - 10
	 * @hooked basepress_post_nav          - 20
	 * @hooked basepress_display_comments  - 30
	 */
	do_action( 'basepress_single_post_bottom' );

	?>

	</article><!-- #post-## -->

</div>
