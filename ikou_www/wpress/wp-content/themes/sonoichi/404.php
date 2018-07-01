<?php get_header(); ?>
	<div class="mod-pageContent">
		<div class="mod-pageContent-inner">
			<div class="mod-pageContent-wrapper">    
				<div class="mod-pageContent-primary">
					<div class="mod-pageContent-primary-inner">
						<div id="content" role="main">
							<article id="post-0" class="post no-results not-found">
								<div class="entry-info">
									<header class="entry-header">
										<h1 class="entry-title"><?php _e( '404 Not Found', 'sonoichi' ); ?></h1>
									</header>
								</div>
								<div class="entry-content">
									<p><?php _e( 'This is somewhat embarrassing, isn&rsquo;t it?<br>
										It looks like nothing was found at this location. Maybe try a search?', 'sonoichi' ); ?></p>
								</div><!-- .entry-content -->
								<aside class="widget_search">
									<?php get_search_form( true, 'html5' ); ?>
								</aside>
							</article>
						</div><!-- #content -->          
					</div>
				</div>
				<!--/mod-pageContent-primary-->
				<?php get_sidebar(); ?>
			</div>
		</div>
	</div>
	<!--/mod-pageContent-->
	<?php get_footer(); ?>
