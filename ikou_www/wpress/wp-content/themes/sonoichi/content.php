<article id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
	<div class="entry-info">
		<header class="entry-header">			
<?php if ( is_singular()) : ?>
			<h1 class="entry-title"><?php the_title(); ?></h1>
<?php else : ?>
			<h1 class="entry-title">
				<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h1>
<?php endif; // is_singular() ?>
		</header><!-- .entry-header -->
<?php if( !is_page() )  : ?>
		<footer class="entry-meta">
			<?php sonoichi_entry_meta(); ?>
			<?php edit_post_link( __( '(Edit)', 'sonoichi' ), '<span class="edit-link">', '</span>' ); ?>
		</footer><!-- .entry-meta -->
<?php elseif( is_page() && is_user_logged_in() ) : ?>
		<footer class="entry-meta">
			<?php edit_post_link( __( '(Edit)', 'sonoichi' ), '<span class="edit-link">', '</span>' ); ?>
		</footer><!-- .entry-meta -->
<?php endif; ?>
	</div>
<?php if ( comments_open() ) : ?>
	<div class="comments-link">
		<?php comments_popup_link( '<span class="leave-reply">' . __( 'Leave a comment', 'sonoichi' ) . '</span>', __( '1 Comment', 'sonoichi' ), __( '% Comments', 'sonoichi' ) ); ?>
	</div><!-- .comments-link -->
<?php endif; // comments_open() ?>
<?php if ( is_search() ) : // Only display Excerpts for Search ?>
	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
<?php else : ?>
	<div class="entry-content">
		<?php the_content( __( '<span class="mod-readMore">Read more</span>', 'sonoichi' ) ); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'sonoichi' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
	</div><!-- .entry-content -->
<?php endif; ?>
</article><!-- #post -->
