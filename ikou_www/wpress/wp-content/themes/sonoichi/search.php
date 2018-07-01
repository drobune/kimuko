<?php get_header(); ?>
	<div class="mod-pageContent">
		<div class="mod-pageContent-inner">
			<div class="mod-pageContent-wrapper">   
				<div class="mod-pageContent-primary">
					<div class="mod-pageContent-primary-inner">
						<div id="content" role="main">
							<header class="page-header">
								<h1 class="page-title"><?php printf( __( 'Search Results for:<span>%s</span>', 'sonoichi' ), get_search_query() ); ?></h1>
							</header>
<?php if ( have_posts() ) : ?>
	<?php /* The loop */ ?>
	<?php while ( have_posts() ) : the_post(); ?>
							<?php get_template_part( 'content', get_post_format() ); ?>
	<?php endwhile; ?>

							<?php sonoichi_page_nav(); ?>
							<?php if ( comments_open() && is_singular())  comments_template(); ?>

<?php else : ?>
							<article id="post-0" class="post no-results not-found">
								<div class="entry-info">
									<header class="entry-header">
										<h1 class="entry-title"><?php _e( 'Nothing Found', 'sonoichi' ); ?></h1>
									</header>
								</div>

								<div class="entry-content">
									<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'sonoichi' ); ?></p>
								</div><!-- .entry-content -->

								<aside class="widget_search">
									<?php get_search_form( true, 'html5' ); ?>
								</aside>
							</article>
<?php endif; ?>
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
