<?php
/**
 * BasePress hooks
 *
 * @author   ThemeCountry
 * @package  basepress
 */

/**
 * General
 *
 * @see  basepress_header_widget_region()
 * @see  basepress_get_sidebar()
 */
add_action( 'basepress_before_content',		'basepress_header_widget_region',		10 );
//add_action( 'basepress_sidebar',			'basepress_get_sidebar',				10 );

/**
 * Header
 * 
 * @see basepress_skip_links
 * @see basepress_site_branding
 * @see basepress_primary_navigation
 * @see basepress_header_image
 */
add_action( 'basepress_header',				'basepress_skip_links',					 0 );
add_action( 'basepress_header',				'basepress_site_branding',				10 );
add_action( 'basepress_header',				'basepress_primary_navigation',			20 );
add_action( 'basepress_after_header',		'basepress_header_image',				10 );


/**
 * Header Menu
 * 
 * @see basepress_category_navigation
 */

add_action( 'basepress_category_menu',		'basepress_category_navigation',		0 );

/**
 * Footer
 *
 * @see  basepress_footer_widgets()
 * @see  basepress_credit()
 * @see  basepress_footer_nav()
 * @see  basepress_footer_back_top()
 */
add_action( 'basepress_footer',				'basepress_footer_widgets',				10 );
add_action( 'basepress_footer',				'basepress_credit_wrapper',				20 );
add_action( 'basepress_footer',				'basepress_footer_nav',					30 );
add_action( 'basepress_footer',				'basepress_credit',						40 );
add_action( 'basepress_footer',				'basepress_credit_wrapper_close',		50 );
add_action( 'basepress_after_footer',		'basepress_footer_back_top',			10 );
/**
 * Homepage - Hooks
 */
add_action( 'basepress_homepage',			'basepress_homepage_content',			10);

/**
 * Posts - Hooks
 *
 * @see basepress_post_content()
 * @see basepress_post_header()
 * @see basepress_paging_nav()
 * @see basepress_entry_meta_footer()
 * @see basepress_post_thumbnail()
 * @see basepress_init_structured_data()
 * @see basepress_post_header_meta()
 * @see basepress_post_nav()
 * @see basepress_post_tags()
 * @see basepress_display_comments()
 */
add_action( 'basepress_loop_post',				'basepress_post_header_wrapper',			5 );
add_action( 'basepress_loop_post',				'basepress_post_header',					10 );
add_action( 'basepress_loop_post',				'basepress_post_header_wrapper_close',		20 );
add_action( 'basepress_loop_post',				'basepress_post_content',					30 );
add_action( 'basepress_loop_post',				'basepress_init_structured_data',			40 );
add_action( 'basepress_loop_after',				'basepress_paging_nav',						10 );
add_action( 'basepress_post_content_before',	'basepress_post_thumbnail',					10 );
add_action( 'basepress_post_content_after',		'basepress_entry_meta_footer',				10 );

add_action( 'basepress_single_post',			'basepress_post_header_wrapper',			5 );
add_action( 'basepress_single_post',			'basepress_post_header',					10 );
add_action( 'basepress_single_post',			'basepress_post_header_meta',				20 );
add_action( 'basepress_single_post',			'basepress_post_header_wrapper_close',		25 );
add_action( 'basepress_single_post',			'basepress_post_content_wrapper',			30 );
add_action( 'basepress_single_post',			'basepress_post_single_content',			35 );
add_action( 'basepress_single_post',			'basepress_post_content_wrapper_close',		40 );
add_action( 'basepress_single_post',			'basepress_init_structured_data',			50 );
add_action( 'basepress_single_post_bottom',		'basepress_post_tags',						10 );
add_action( 'basepress_single_post_bottom',		'basepress_post_nav',						20 );
add_action( 'basepress_single_post_bottom',		'basepress_display_comments',				40 );

/**
 * Page - Hooks
 *
 * @see  basepress_page_header()
 * @see  basepress_page_content
 * @see  basepress_init_structured_data()
 * @see  basepress_display_comments()
 */

add_action( 'basepress_page',				'basepress_page_header',		  		10 );
add_action( 'basepress_page',				'basepress_page_content',				20 );
add_action( 'basepress_page',				'basepress_init_structured_data',		30 );
add_action( 'basepress_page_after',			'basepress_display_comments',			10 );