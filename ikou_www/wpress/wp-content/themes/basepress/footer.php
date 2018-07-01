<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package  basepress
 */
?>
			<?php do_action( 'basepress_after_content' ); ?>		
		</div><!-- . container -->
	</div><!-- #content -->

	<?php do_action( 'basepress_before_footer' ); ?>

	<footer id="colophon" class="site-footer" role="contentinfo">

			<?php
			/**
			 * Functions hooked in to storefront_footer action
			 *
			 * @hooked basepress_footer_widgets			 - 10
			 * @hooked basepress_footer_nav              - 30
			 * @hooked basepress_credit 				 - 40
			 * 
			 */
			do_action( 'basepress_footer' ); ?>

	</footer><!-- #colophon -->
	
	<?php 
		/**
		 * Functions hooked in to basepress_after_footer action
		 *
		 * @hooked basepress_footer_back_top 	- 10
		 * 
		 */
		do_action( 'basepress_after_footer' ); ?>
</div><!-- #page -->
	
<?php wp_footer(); ?>

</body>
</html>
