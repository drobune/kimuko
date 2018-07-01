<?php
/**
 * @package Quill
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('wow fadeInUp'); ?>>

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="entry-thumb">
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" >
				<?php the_post_thumbnail('quill-image'); ?>
			</a>			
		</div>	
	<?php endif; ?>

	<header class="entry-header">
		<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>

		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<?php quill_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->	

	<div class="entry-summary">
		<?php if ( (get_theme_mod('quill_full_content') == 1) && is_home() ) : ?>
			<?php the_content(); ?>
		<?php else : ?>
			<?php the_excerpt(); ?>
		<?php endif; ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'quill' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
			<?php
				/* translators: used between list items, there is a space after the comma */
				$categories_list = get_the_category_list( __( ', ', 'quill' ) );
				if ( $categories_list && quill_categorized_blog() ) :
			?>
			<span class="cat-links">
				<i class="fa fa-folder"></i><?php printf( __( ' %1$s', 'quill' ), $categories_list ); ?>
			</span>
			<?php endif; // End if categories ?>

		<?php endif; // End if 'post' == get_post_type() ?>

		<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
		<span class="comments-link"><i class="fa fa-comment"></i><?php comments_popup_link( __( ' Leave a comment', 'quill' ), __( '1 Comment', 'quill' ), __( '% Comments', 'quill' ) ); ?></span>
		<?php endif; ?>

		<?php edit_post_link( __( 'Edit', 'quill' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->