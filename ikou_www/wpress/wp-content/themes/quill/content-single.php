<?php
/**
 * @package Quill
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if ( (has_post_thumbnail()) && ( get_theme_mod( 'quill_post_img' )) ) : ?>
		<div class="single-thumb">
			<?php the_post_thumbnail('quill-image'); ?>
		</div>	
	<?php endif; ?>

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'quill' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php quill_posted_on(); ?>
		<?php
			/* translators: used between list items, there is a space after the comma */
			$category_list = get_the_category_list( __( ', ', 'quill' ) );

			/* translators: used between list items, there is a space after the comma */
			$tag_list = get_the_tag_list( '', __( ', ', 'quill' ) );

			if ( ! quill_categorized_blog() ) {
				// This blog only has 1 category so we just need to worry about tags in the meta text
				if ( '' != $tag_list ) {
					$meta_text = '<i class="fa fa-tag"></i> %2$s' . '<i class="fa fa-link"></i>' . __( '<a href="%3$s" rel="bookmark"> permalink</a>.', 'quill' );
				} else {
					$meta_text = '<span><i class="fa fa-link"></i>' . __( '<a href="%3$s" rel="bookmark"> permalink</a>', 'quill' ) . '</span>';
				}

			} else {
				// But this blog has loads of categories so we should probably display them here
				if ( '' != $tag_list ) {
					$meta_text = '<span><i class="fa fa-folder"></i> %1$s</span>' . '<span><i class="fa fa-tag"></i> %2$s</span>' . '<span><i class="fa fa-link"></i>' . __( '<a href="%3$s" rel="bookmark"> permalink</a>', 'quill' ) . '</span>';
				} else {
					$meta_text = '<span><i class="fa fa-folder"></i> %1$s</span>' . '<span><i class="fa fa-link"></i>' . __( '<a href="%3$s" rel="bookmark"> permalink</a>', 'quill' ) . '</span>';
				}

			} // end check for categories on this blog

			printf(
				$meta_text,
				$category_list,
				$tag_list,
				get_permalink()
			);
		?>

		<?php edit_post_link( __( 'Edit', 'quill' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
