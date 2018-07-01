<?php
/**
 * @package Quill
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<?php $position 	= get_post_meta( get_the_ID(), 'wpcf-position', true ); ?>
	<?php $studies 		= get_post_meta( get_the_ID(), 'wpcf-studies', true ); ?>
	<?php $speciality 	= get_post_meta( get_the_ID(), 'wpcf-speciality', true ); ?>
	<?php $admission 	= get_post_meta( get_the_ID(), 'wpcf-admission', true ); ?>
	<?php $affiliation 	= get_post_meta( get_the_ID(), 'wpcf-affiliation', true ); ?>


	<div class="employee-bio col-md-6 wow fadeInLeft">
		<?php if ($position != '') : ?>
			<h4><?php echo __('Position', 'quill'); ?></h4>
			<span><?php echo esc_html($position); ?></span>
		<?php endif; ?>		
		<?php if ($studies != '') : ?>
			<h4><?php echo __('Studies', 'quill'); ?></h4>
			<span class="employee-studies"><?php echo esc_html($studies); ?></span>
		<?php endif; ?>
		<?php if ($speciality != '') : ?>
			<h4><?php echo __('Specialities', 'quill'); ?></h4>
			<span class="employee-speciality"><?php echo esc_html($speciality); ?></span>
		<?php endif; ?>
		<?php if ($admission != '') : ?>
			<h4><?php echo __('Bar admission', 'quill'); ?></h4>
			<span class="employee-admission"><?php echo absint($admission); ?></span>
		<?php endif; ?>
		<?php if ($affiliation != '') : ?>
			<h4><?php echo __('Affiliations', 'quill'); ?></h4>
			<span class="employee-affiliation"><?php echo esc_html($affiliation); ?></span>
		<?php endif; ?>							
	</div>
	<div class="entry-content col-md-6 wow fadeInRight">
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="employee-thumb">
				<?php the_post_thumbnail(); ?>
			</div>
		<?php endif; ?>			
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'quill' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

</article><!-- #post-## -->
