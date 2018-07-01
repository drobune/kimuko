<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
	<div class="mod-pageContent-secondary">
		<div class="mod-pageContent-secondary-inner">
	<?php 
		if(is_page()): 
			global $post;
			if ( get_post_ancestors($post->ID)) :
	?>
			<aside class="widget mod-navLocal">
				<ul>
					<li class="page_item current_page_ancestor parent"><a href="<?php echo get_permalink(array_pop(get_post_ancestors($post->ID))); ?>"><?php echo get_the_title(array_pop(get_post_ancestors($post->ID))); ?></a>
				<ul>
				<?php wp_list_pages( array( 'depth' => 0,'child_of'    => array_pop(get_post_ancestors($post->ID)), 'title_li' => '' ) ); ?>
						</ul>
					</li>
				</ul>
			</aside>
		<?php elseif (get_pages('child_of=' . $post->ID)) : ?>
			<aside class="widget mod-navLocal">
				<ul>
					<li class="page_item current_page_ancestor current_page_origin parent"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				<ul>
				<?php wp_list_pages( array( 'depth' => 0,'child_of'    => $post->ID, 'title_li' => '' ) ); ?>
						</ul>
					</li>
				</ul>
			</aside>
		<?php endif; ?>
	<?php endif; ?>
			<?php dynamic_sidebar( 'sidebar-1' ); ?>
		</div><!--/mod-pageContent-secondary-inner-->
	</div><!--/mod-pageContent-secondary-->
<?php endif; ?>
