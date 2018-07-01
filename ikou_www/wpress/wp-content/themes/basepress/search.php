<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package  basepress
 */

get_header();

?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			
			<?php
			if ( have_posts() ) :

			?>
			<header class="page-header">

				<h1 class="page-title"><?php printf( esc_attr__( 'Search Results for: %s', 'basepress' ), '<em>' . get_search_query() . '</em>' ); ?></h1>

			</header><!-- .page-header -->

			<?php 

				get_template_part( 'loop' );
				
			else :

				get_template_part( 'template-parts/content', 'none' );

			endif; ?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
do_action( 'basepress_sidebar' );

get_footer();
