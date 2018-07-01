<?php
/**
 * Quill functions and definitions
 *
 * @package Quill
 */


if ( ! function_exists( 'quill_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function quill_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Quill, use a find and replace
	 * to change 'quill' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'quill', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Set the content width based on the theme's design and stylesheet.
	global $content_width;
	if ( ! isset( $content_width ) ) {
		$content_width = 640; /* pixels */
	}

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	add_image_size('employee-thumb', 350, 230, true);
	add_image_size('quill-image', 750);

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'quill' ),
	) );
	
	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link'
	) );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'quill_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // quill_setup
add_action( 'after_setup_theme', 'quill_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function quill_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'quill' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer A', 'quill' ),
		'id'            => 'sidebar-3',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );	
	register_sidebar( array(
		'name'          => __( 'Footer B', 'quill' ),
		'id'            => 'sidebar-4',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );	
	register_sidebar( array(
		'name'          => __( 'Footer C', 'quill' ),
		'id'            => 'sidebar-5',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );	

	//Register the front page widgets
	if ( function_exists('siteorigin_panels_activate') ) {
		register_widget( 'Quill_Services' );
		register_widget( 'Quill_Facts' );
		register_widget( 'Quill_Contact' );
		register_widget( 'Quill_Employees' );
		register_widget( 'Quill_Testimonials' );
		register_widget( 'Quill_Fp_Social_Profile' );
		register_widget( 'Quill_Cases' );
		register_widget( 'Quill_About' );
		register_widget( 'Quill_Latest_News' );
		register_widget( 'Quill_Subscribe_Block' );
	}
	//Register the sidebar widgets
	register_widget( 'Quill_Recent_Comments' );
	register_widget( 'Quill_Recent_Posts' );
	register_widget( 'Quill_Social_Profile' );
	register_widget( 'Quill_Video_Widget' );
}
add_action( 'widgets_init', 'quill_widgets_init' );

if ( function_exists('siteorigin_panels_activate') ) {
	require get_template_directory() . "/widgets/fp-services.php";
	require get_template_directory() . "/widgets/fp-facts.php";
	require get_template_directory() . "/widgets/fp-contact.php";
	require get_template_directory() . "/widgets/fp-employees.php";
	require get_template_directory() . "/widgets/fp-testimonials.php";
	require get_template_directory() . "/widgets/fp-social.php";
	require get_template_directory() . "/widgets/fp-cases.php";
	require get_template_directory() . "/widgets/fp-about.php";
	require get_template_directory() . "/widgets/fp-latest-news.php";
	require get_template_directory() . "/widgets/fp-subscribe.php";
}
/**
 * Load the sidebar widgets.
 */
require get_template_directory() . "/widgets/recent-comments.php";
require get_template_directory() . "/widgets/recent-posts.php";
require get_template_directory() . "/widgets/social-profile.php";
require get_template_directory() . "/widgets/video-widget.php";

/**
 * Enqueue scripts and styles.
 */
function quill_scripts() {

	//Load the fonts
	$headings_font = esc_html(get_theme_mod('headings_fonts'));
	$body_font = esc_html(get_theme_mod('body_fonts'));
	if( $headings_font ) {
		wp_enqueue_style( 'quill-headings-fonts', '//fonts.googleapis.com/css?family='. $headings_font );	
	} else {
		wp_enqueue_style( 'quill-heading-fonts', '//fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700');
	}	
	if( $body_font ) {
		wp_enqueue_style( 'quill-body-fonts', '//fonts.googleapis.com/css?family='. $body_font );	
	} else {
		wp_enqueue_style( 'quill-body-fonts', '//fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,800,700');
	}	

	wp_enqueue_style( 'quill-bootstrap', get_template_directory_uri() . '/bootstrap/css/bootstrap.min.css', array(), true );

	wp_enqueue_style( 'quill-style', get_stylesheet_uri() );

	wp_enqueue_style( 'quill-font-awesome', get_template_directory_uri() . '/fonts/font-awesome.min.css' );

	wp_enqueue_script( 'quill-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'quill-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	wp_enqueue_script( 'quill-scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), true );

	wp_enqueue_script( 'quill-waypoints', get_template_directory_uri() . '/js/waypoints.min.js', array('jquery'), true );

	wp_enqueue_script( 'quill-waypoints-sticky', get_template_directory_uri() . '/js/waypoints-sticky.min.js', array('jquery'), true );	

	wp_enqueue_script( 'quill-fitvids', get_template_directory_uri() . '/js/jquery.fitvids.js', array('jquery'), true );
		
	wp_enqueue_script( 'quill-wow', get_template_directory_uri() . '/js/wow.min.js', array('jquery'), true );	

	wp_enqueue_style( 'quill-animate', get_template_directory_uri() . '/css/animate.min.css' );


	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
		
	wp_enqueue_script( 'quill-flex-script', get_template_directory_uri() .  '/js/jquery.flexslider-min.js', array( 'jquery' ), true );
			
	wp_enqueue_script( 'quill-slider-init', get_template_directory_uri() .  '/js/slider-init.js', array(), true );	

}
add_action( 'wp_enqueue_scripts', 'quill_scripts' );

/**
 * Enqueues the necessary script for image uploading in widgets
 */
add_action('admin_enqueue_scripts', 'quill_image_upload');
function quill_image_upload($post) {
    if( 'post.php' != $post )
        return;	
    wp_enqueue_script('quill-image-upload', get_template_directory_uri() . '/js/image-uploader.js', array('jquery'), true );
	if ( did_action( 'wp_enqueue_media' ) )
		return;    
    wp_enqueue_media();    
}

/**
 * Load html5shiv
 */
function quill_html5shiv() {
    echo '<!--[if lt IE 9]>' . "\n";
    echo '<script src="' . esc_url( get_template_directory_uri() . '/js/html5shiv.js' ) . '"></script>' . "\n";
    echo '<![endif]-->' . "\n";
}
add_action( 'wp_head', 'quill_html5shiv' ); 

/**
 * Page title banner
 */
function quill_page_title() {
	echo '<div class="title-banner">';
	echo 	'<div class="container">';
	if ( is_singular() ) :
		echo '<h1 class="entry-title">';
	else :
		echo '<h1 class="page-title">';
	endif;	
			if ( is_singular() ) :
				the_title();
			elseif ( is_category() ) :
				single_cat_title();
			elseif ( is_tag() ) :
				single_tag_title();
			elseif ( is_post_type_archive() ) :
				post_type_archive_title();	
			elseif ( is_author() ) :
				printf( __( 'Author: %s', 'quill' ), '<span class="vcard">' . get_the_author() . '</span>' );
			elseif ( is_day() ) :
				printf( __( 'Day: %s', 'quill' ), '<span>' . get_the_date() . '</span>' );
			elseif ( is_month() ) :
				printf( __( 'Month: %s', 'quill' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'quill' ) ) . '</span>' );
			elseif ( is_year() ) :
				printf( __( 'Year: %s', 'quill' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'quill' ) ) . '</span>' );
			elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
				_e( 'Asides', 'quill' );
			elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) :
				_e( 'Galleries', 'quill' );
			elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
				_e( 'Images', 'quill' );
			elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
				_e( 'Videos', 'quill' );
			elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
				_e( 'Quotes', 'quill' );
			elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
				_e( 'Links', 'quill' );
			elseif ( is_tax( 'post_format', 'post-format-status' ) ) :
				_e( 'Statuses', 'quill' );
			elseif ( is_tax( 'post_format', 'post-format-audio' ) ) :
				_e( 'Audios', 'quill' );
			elseif ( is_tax( 'post_format', 'post-format-chat' ) ) :
				_e( 'Chats', 'quill' );
			else :
				_e( 'Archives', 'quill' );

			endif;
	echo 		'</h1>';	
	echo 	'</div>';
	echo '</div>';   
}

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load the slider
 */
require get_template_directory() . '/inc/slider.php';

/**
 * Styles
 */
require get_template_directory() . '/styles.php';

/**
 * Page builder styles
 */
require get_template_directory() . '/inc/rows.php';

/**
 *TGM Plugin activation.
 */
require_once dirname( __FILE__ ) . '/plugins/class-tgm-plugin-activation.php';
 
add_action( 'tgmpa_register', 'quill_recommend_plugin' );
function quill_recommend_plugin() {
 
    $plugins = array(
        array(
            'name'               => 'Page Builder by SiteOrigin',
            'slug'               => 'siteorigin-panels',
            'required'           => false,
        ),
        array(
            'name'               => 'Types - Custom Fields and Custom Post Types Management',
            'slug'               => 'types',
            'required'           => false,
        ),          
    );
 
    tgmpa( $plugins);
 
}