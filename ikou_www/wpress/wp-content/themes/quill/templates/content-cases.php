<?php
/**
 * @package Quill
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php $client_name 	= get_post_meta( get_the_ID(), 'wpcf-client-name', true ); ?>
	<?php $outcome 		= get_post_meta( get_the_ID(), 'wpcf-outcome', true ); ?>
	<?php $team 		= get_post_meta( get_the_ID(), 'wpcf-team', true ); ?>


	<div class="case-info col-md-6 wow fadeInLeft">
		<?php if ($client_name != '') : ?>
			<h4><?php echo __('Client', 'quill'); ?></h4>
			<span><?php echo esc_html($client_name); ?></span>
		<?php endif; ?>		
		<?php if ($outcome != '') : ?>
			<h4><?php echo __('Outcome', 'quill'); ?></h4>
			<span class="case-outcome"><?php echo esc_html($outcome); ?></span>
		<?php endif; ?>
		<?php if ($team != '') : ?>
			<h4><?php echo __('Team involved', 'quill'); ?></h4>
			<span class="case-team"><?php echo esc_html($team); ?></span>
		<?php endif; ?>						
	</div>


	<div class="entry-content wow fadeInRight col-md-6">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'quill' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

</article><!-- #post-## -->
