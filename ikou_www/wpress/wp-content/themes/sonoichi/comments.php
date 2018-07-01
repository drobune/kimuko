<?php if ( post_password_required() ) return; ?>
	<div id="comments" class="comments-area">
<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
				printf( _nx( __('1 Comment', 'sonoichi'), __('%1$s Comments', 'sonoichi'), get_comments_number(), 'sonoichi' ),number_format_i18n( get_comments_number() ));
			?>
	<?php if ( ! comments_open() && get_comments_number() ) : ?>
			<?php _e( '(Comments are closed.)' , 'sonoichi' ); ?>
	<?php endif; ?>
		</h2>
		<ol class="commentlist">
			<?php
				wp_list_comments( array(
					'max_depth'         => -1,
					'type'       => 'comment',
					'callback'       => 'sonoichi_list_comments',
					'format'      => 'html5',
					'avatar_size'       => 56,
					'reverse_top_level' => false,
					'reverse_children'  => true
				) );
			?>
		</ol><!-- .comment-list -->
	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
		<nav class="navigation comment-navigation" role="navigation">
			<h1 class="screen-reader-text section-heading"><?php __( 'Comment navigation', 'sonoichi' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'sonoichi' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'sonoichi' ) ); ?></div>
		</nav><!-- .comment-navigation -->
	<?php endif; // Check for comment navigation ?>
<?php endif; // have_comments() ?>
	<?php comment_form( array( 'format' => 'html5' ) ); ?>
	</div><!-- #comments -->
