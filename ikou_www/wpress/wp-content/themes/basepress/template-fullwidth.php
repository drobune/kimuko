<?php
/**
 * Template Name: Full Width Page
 *
 * Description: A custom page template for displaying a fullwidth page with no sidebar.
 *
 * @package  basepress
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<div class="page-content">

				<?php
				while ( have_posts() ) : the_post();

					do_action( 'basepress_page_before' );

					get_template_part( 'template-parts/content', 'page' );

					/**
					 * Functions hooked in to basepress_page_after action
					 *
					 * @hooked basepress_display_comments - 10
					 */
					do_action( 'basepress_page_after' );

				endwhile; // End of the loop.
				?>

			</div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php

get_footer();