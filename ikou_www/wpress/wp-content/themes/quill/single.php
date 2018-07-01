<?php
/**
 * The template for displaying all single posts.
 *
 * @package Quill
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

		<?php if ( get_post_type() == 'post' ): ?>
			<?php get_template_part( 'content', 'single' ); ?>
		<?php elseif ( get_post_type() == 'services' ): ?>
			<?php get_template_part( '/templates/content', 'services' ); ?>
		<?php elseif ( get_post_type() == 'employees' ): ?>
			<?php get_template_part( '/templates/content', 'employees' ); ?>
		<?php elseif ( get_post_type() == 'cases' ): ?>
			<?php get_template_part( '/templates/content', 'cases' ); ?>							
		<?php endif; ?>	

			<?php quill_post_nav(); ?>

			<?php
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || '0' != get_comments_number() ) :
					comments_template();
				endif;
			?>

		<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>