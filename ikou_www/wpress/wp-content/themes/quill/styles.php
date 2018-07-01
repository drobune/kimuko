<?php

//Dynamic styles
function quill_custom_styles($custom) {

	//***Front page colors
	//Services section
	$services_bg = esc_html(get_theme_mod( 'services_bg' ));
	$services_title = esc_html(get_theme_mod( 'services_title' ));
	$services_title_dec = esc_html(get_theme_mod( 'services_title_dec' ));
	$services_icon_bg = esc_html(get_theme_mod( 'services_icon_bg' ));
	$services_item_title = esc_html(get_theme_mod( 'services_item_title' ));
	$services_body_text = esc_html(get_theme_mod( 'services_body_text' ));

	if ( isset($services_bg) && ( $services_bg != '#fff' ) ) {
		$custom = ".services-area { background-color: {$services_bg}; }"."\n";
	}
	if ( isset($services_title) && ( $services_title != '#2E2E2E' ) ) {
		$custom .= ".services-area .widget-title { color: {$services_title}; }"."\n";
	}
	if ( isset($services_title_dec) && ( $services_title_dec != '#2E2E2E' ) ) {
		$custom .= ".services-area .widget-title { border-color: {$services_title_dec}; }"."\n";
	}	
	if ( isset($services_icon_bg) && ( $services_icon_bg != '#2E2E2E' ) ) {
		$custom .= ".service-icon { border-color: {$services_icon_bg}; }"."\n";
		$custom .= ".service-icon { color: {$services_icon_bg}; }"."\n";
	}
	if ( isset($services_item_title) && ( $services_item_title != '#2E2E2E' ) ) {
		$custom .= ".service-title { color: {$services_item_title}; }"."\n";
	}
	if ( isset($services_body_text) && ( $services_body_text!= '#6B6B6B' ) ) {
		$custom .= ".service-desc { color: {$services_body_text}; }"."\n";
	}

	//Employees section
	$employees_bg = esc_html(get_theme_mod( 'employees_bg' ));
	$employees_title = esc_html(get_theme_mod( 'employees_title' ));
	$employees_title_dec = esc_html(get_theme_mod( 'employees_title_dec' ));
	$employees_text = esc_html(get_theme_mod( 'employees_text' ));
	$employees_box_bg = esc_html(get_theme_mod( 'employees_box_bg' ));

	if ( isset($employees_bg) && ( $employees_bg != '#fff' ) ) {
		$custom .= ".employees-area { background-color: {$employees_bg}; }"."\n";
	}
	if ( isset($employees_title) && ( $employees_title != '#2E2E2E' ) ) {
		$custom .= ".employees-area .widget-title { color: {$employees_title}; }"."\n";
	}
	if ( isset($employees_title_dec) && ( $employees_title_dec != '#2E2E2E' ) ) {
		$custom .= ".employees-area .widget-title { border-color: {$employees_title_dec}; }"."\n";
	}
	if ( isset($employees_text) && ( $employees_text != '#fff' ) ) {
		$custom .= ".employee-name { color: {$employees_text}; }"."\n";
		$custom .= ".employee-function { color: {$employees_text}; }"."\n";
		$custom .= ".employee-social .fa { color: {$employees_text}; }"."\n";
		$custom .= ".employee .read-more { color: {$employees_text}; }"."\n";
	}
	if ( isset($employees_box_bg) && ( $employees_box_bg != '#2E2E2E' ) ) {
		$custom .= ".employee-name { background-color: {$employees_box_bg}; }"."\n";
		$custom .= ".employee-function { background-color: {$employees_box_bg}; }"."\n";
		$custom .= ".employee-social { background-color: {$employees_box_bg}; }"."\n";
		$custom .= ".employee .read-more { background-color: {$employees_box_bg}; }"."\n";
	}	

	//Testimonials section
	$testimonials_bg = esc_html(get_theme_mod( 'testimonials_bg' ));
	$testimonials_title = esc_html(get_theme_mod( 'testimonials_title' ));
	$testimonials_title_dec = esc_html(get_theme_mod( 'testimonials_title_dec' ));
	$testimonials_body_text = esc_html(get_theme_mod( 'testimonials_body_text' ));

	if ( isset($testimonials_bg) && ( $testimonials_bg != '#fff' ) ) {
		$custom .= ".testimonials-area { background-color: {$testimonials_bg}; }"."\n";
	}
	if ( isset($testimonials_title) && ( $testimonials_title != '#2E2E2E' ) ) {
		$custom .= ".testimonials-area .widget-title { color: {$testimonials_title}; }"."\n";
	}
	if ( isset($testimonials_title_dec) && ( $testimonials_title_dec != '#2E2E2E' ) ) {
		$custom .= ".testimonials-area .widget-title { border-color: {$testimonials_title_dec}; }"."\n";
	}	
	if ( isset($testimonials_body_text) && ( $testimonials_body_text!= '#6B6B6B' ) ) {
		$custom .= ".testimonial, .testimonial h4 { color: {$testimonials_body_text}; }"."\n";
	}

	//Facts section
	$facts_bg = esc_html(get_theme_mod( 'facts_bg' ));
	$facts_title = esc_html(get_theme_mod( 'facts_title' ));
	$facts_title_dec = esc_html(get_theme_mod( 'facts_title_dec' ));
	$facts_color = esc_html(get_theme_mod( 'facts_color' ));

	if ( isset($facts_bg) && ( $facts_bg != '#fff' ) ) {
		$custom .= ".facts-area { background-color: {$facts_bg}; }"."\n";
	}
	if ( isset($facts_title) && ( $facts_title != '#2E2E2E' ) ) {
		$custom .= ".facts-area .widget-title { color: {$facts_title}; }"."\n";
	}
	if ( isset($facts_title_dec) && ( $facts_title_dec != '#2E2E2E' ) ) {
		$custom .= ".facts-area .widget-title { border-color: {$facts_title_dec}; }"."\n";
	}
	if ( isset($facts_color) && ( $facts_color != '#2E2E2E' ) ) {
		$custom .= ".fact { color: {$facts_color}; }"."\n";
	}
	//Clients section
	$clients_bg = esc_html(get_theme_mod( 'clients_bg' ));
	$clients_title = esc_html(get_theme_mod( 'clients_title' ));
	$clients_title_dec = esc_html(get_theme_mod( 'clients_title_dec' ));
	$clients_slider = esc_html(get_theme_mod( 'clients_slider' ));

	if ( isset($clients_bg) && ( $clients_bg != '#fff' ) ) {
		$custom .= ".clients-area { background-color: {$clients_bg}; }"."\n";
	}
	if ( isset($clients_title) && ( $clients_title != '#444' ) ) {
		$custom .= ".clients-area .widget-title { color: {$clients_title}; }"."\n";
	}
	if ( isset($clients_title_dec) && ( $clients_title_dec != '#ff6b53' ) ) {
		$custom .= ".clients-area .widget-title:after { border-color: {$clients_title_dec}; }"."\n";
	}
	if ( isset($clients_slider) && ( $clients_slider != '#ff6b53' ) ) {
		$custom .= ".slick-prev:before, .slick-next:before { color: {$clients_slider}; }"."\n";
	}
	//Social section
	$social_bg = esc_html(get_theme_mod( 'social_bg' ));
	$social_title = esc_html(get_theme_mod( 'social_title' ));
	$social_title_dec = esc_html(get_theme_mod( 'social_title_dec' ));
	$social_icons = esc_html(get_theme_mod( 'social_icons' ));

	if ( isset($social_bg) && ( $social_bg != '#fff' ) ) {
		$custom .= ".social-area { background-color: {$social_bg}; }"."\n";
	}
	if ( isset($social_title) && ( $social_title != '#444' ) ) {
		$custom .= ".social-area .widget-title { color: {$social_title}; }"."\n";
	}
	if ( isset($social_title_dec) && ( $social_title_dec != '#2E2E2E' ) ) {
		$custom .= ".social-area .widget-title { border-color: {$social_title_dec}; }"."\n";
	}
	if ( isset($social_icons) && ( $social_icons != '#2E2E2E' ) ) {
		$custom .= ".social-area a:before { color: {$social_icons}; }"."\n";
	}
	//Projects section
	$projects_bg = esc_html(get_theme_mod( 'projects_bg' ));
	$projects_title = esc_html(get_theme_mod( 'projects_title' ));
	$projects_title_dec = esc_html(get_theme_mod( 'projects_title_dec' ));
	$projects_item_bg = esc_html(get_theme_mod( 'projects_item_bg' ));

	if ( isset($projects_bg) && ( $projects_bg != '#fff' ) ) {
		$custom .= ".cases-area { background-color: {$projects_bg}; }"."\n";
	}
	if ( isset($projects_title) && ( $projects_title != '#2E2E2E' ) ) {
		$custom .= ".cases-area .widget-title { color: {$projects_title}; }"."\n";
	}
	if ( isset($projects_title_dec) && ( $projects_title_dec != '#2E2E2E' ) ) {
		$custom .= ".cases-area .widget-title { border-color: {$projects_title_dec}; }"."\n";
	}
	if ( isset($projects_item_bg) && ( $projects_item_bg != '#2E2E2E' ) ) {
		$custom .= ".cases-area .entry-title { background-color: {$projects_item_bg}; }"."\n";
	}
    //Latest news section
    $latest_news_bg = esc_html(get_theme_mod( 'latest_news_bg' ));
    $latest_news_title = esc_html(get_theme_mod( 'latest_news_title' ));
    $latest_news_title_dec = esc_html(get_theme_mod( 'latest_news_title_dec' ));
    $latest_news_post_title = esc_html(get_theme_mod( 'latest_news_post_title' ));
    $latest_news_body_text = esc_html(get_theme_mod( 'latest_news_body_text' ));

    if ( isset($latest_news_bg) && ( $latest_news_bg != '#fff' ) ) {
        $custom .= ".latest-news-area { background-color: {$latest_news_bg}; }"."\n";
    }
    if ( isset($latest_news_title) && ( $latest_news_title != '#2E2E2E' ) ) {
        $custom .= ".latest-news-area .widget-title { color: {$latest_news_title}; }"."\n";
    }
    if ( isset($latest_news_title_dec) && ( $latest_news_title_dec != '#2E2E2E' ) ) {
        $custom .= ".latest-news-area .widget-title { border-color: {$latest_news_title_dec}; }"."\n";
    }
    if ( isset($latest_news_post_title) && ( $latest_news_post_title != '#2E2E2E' ) ) {
        $custom .= ".latest-news-area .entry-title a { color: {$latest_news_post_title}; }"."\n";
    }
    if ( isset($latest_news_body_text) && ( $latest_news_body_text != '#6B6B6B' ) ) {
        $custom .= ".blog-post { color: {$latest_news_body_text}; }"."\n";
    }
    //Subscribe section
    $subscribe_bg = esc_html(get_theme_mod( 'subscribe_bg' ));
    $subscribe_title = esc_html(get_theme_mod( 'subscribe_title' ));
    $subscribe_title_dec = esc_html(get_theme_mod( 'subscribe_title_dec' ));

    if ( isset($subscribe_bg) && ( $subscribe_bg != '#fff' ) ) {
        $custom .= ".subscribe-area { background-color: {$subscribe_bg}; }"."\n";
    }
    if ( isset($subscribe_title) && ( $subscribe_title != '#2E2E2E' ) ) {
        $custom .= ".subscribe-area .widget-title { color: {$subscribe_title}; }"."\n";
    }
    if ( isset($subscribe_title_dec) && ( $subscribe_title_dec != '#2E2E2E' ) ) {
        $custom .= ".subscribe-area .widget-title { border-color: {$subscribe_title_dec}; }"."\n";
    } 
    //Contact section
    $contact_bg = esc_html(get_theme_mod( 'contact_bg' ));
    $contact_title = esc_html(get_theme_mod( 'contact_title' ));
    $contact_title_dec = esc_html(get_theme_mod( 'contact_title_dec' ));
    $contact_info = esc_html(get_theme_mod( 'contact_info' ));

    if ( isset($contact_bg) && ( $contact_bg != '#fff' ) ) {
        $custom .= ".contact-area { background-color: {$contact_bg}; }"."\n";
    }
    if ( isset($contact_title) && ( $contact_title != '#2E2E2E' ) ) {
        $custom .= ".contact-area .widget-title { color: {$contact_title}; }"."\n";
    }
    if ( isset($contact_title_dec) && ( $contact_title_dec != '#2E2E2E' ) ) {
        $custom .= ".contact-area .widget-title { border-color: {$contact_title_dec}; }"."\n";
    } 
    if ( isset($contact_info) && ( $contact_info != '#2E2E2E' ) ) {
        $custom .= ".contact_info div { background-color: {$contact_info}; }"."\n";
    }     
    //About us section
    $about_bg = esc_html(get_theme_mod( 'about_bg' ));
    $about_title = esc_html(get_theme_mod( 'about_title' ));
    $about_title_dec = esc_html(get_theme_mod( 'about_title_dec' ));
    $about_text = esc_html(get_theme_mod( 'about_text' ));

    if ( isset($about_bg) && ( $about_bg != '#fff' ) ) {
        $custom .= ".about_text-area { background-color: {$about_bg}; }"."\n";
    }
    if ( isset($about_title) && ( $about_title != '#2E2E2E' ) ) {
        $custom .= ".about_text-area .widget-title { color: {$about_title}; }"."\n";
    }
    if ( isset($about_title_dec) && ( $about_title_dec != '#2E2E2E' ) ) {
        $custom .= ".about_text-area .widget-title { border-color: {$about_title_dec}; }"."\n";
    } 
    if ( isset($about_text) && ( $about_text != '#6B6B6B' ) ) {
        $custom .= ".about-text { color: {$about_text}; }"."\n";
    } 


	//Site title
	$site_title = esc_html(get_theme_mod( 'site_title_color' ));
	if ( isset($site_title) && ( $site_title != '#ffffff' )) {
		$custom .= ".site-title a { color: {$site_title}; }"."\n";
	}
	//Site description
	$site_desc = esc_html(get_theme_mod( 'site_desc_color' ));
	if ( isset($site_desc) && ( $site_desc != '#ffffff' )) {
		$custom .= ".site-description { color: {$site_desc}; }"."\n";
	}	
	//Entry title
	$entry_title = esc_html(get_theme_mod( 'entry_title_color' ));
	if ( isset($entry_title) && ( $entry_title != '#2E2E2E' )) {
		$custom .= ".entry-title, .entry-title a { color: {$entry_title}; }"."\n";
	}
	//Body text
	$body_text = esc_html(get_theme_mod( 'body_text_color' ));
	if ( isset($body_text) && ( $body_text != '#6B6B6B' )) {
		$custom .= "body { color: {$body_text}; }"."\n";
	}
	//Footer background
	$footer_bg = esc_html(get_theme_mod( 'footer_color' ));
	if ( isset($footer_bg) && ( $footer_bg != '#2E2E2E' )) {
		$custom .= ".footer-widget-area, .site-footer { background-color: {$footer_bg}; }"."\n";
	}		
	//Header background
	$header_bg = esc_html(get_theme_mod( 'header_color' ));
	if ( isset($header_bg) && ( $header_bg != '#2E2E2E' )) {
		$custom .= ".site-header { background-color: {$header_bg}; }"."\n";
	}

	//Fonts
	$headings_font = esc_html(get_theme_mod('headings_fonts'));	
	$body_font = esc_html(get_theme_mod('body_fonts'));	
	
	if ( $headings_font ) {
		$font_pieces = explode(":", $headings_font);
		$custom .= "h1, h2, h3, h4, h5, h6, .main-navigation, .buttons, .wpcf7-submit, .comment-respond input[type=\"submit\"], .facts-area .col-md-3, .header-buttons { font-family: {$font_pieces[0]}; }"."\n";
	}
	if ( $body_font ) {
		$font_pieces = explode(":", $body_font);
		$custom .= "body, site-title { font-family: {$font_pieces[0]}; }"."\n";
	}
	
	//Output all the styles
	wp_add_inline_style( 'quill-style', $custom );	
}
add_action( 'wp_enqueue_scripts', 'quill_custom_styles' );