/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );
	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title, .site-description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '.site-title, .site-description' ).css( {
					'clip': 'auto',
					'color': to,
					'position': 'relative'
				} );
			}
		} );
	} );
	//--FRONT PAGE COLORS
	//Services section
	wp.customize('services_bg',function( value ) {
		value.bind( function( newval ) {
			$('.services-area').css('background-color', newval );
		} );
	});
	wp.customize('services_title',function( value ) {
		value.bind( function( newval ) {
			$('.services-area .widget-title').css('color', newval );
		} );
	});
	wp.customize('services_title_dec',function( value ) {
		value.bind( function( newval ) {
			$('.services-area .widget-title').css('border-color', newval );
		} );
	});	
	wp.customize('services_icon_bg',function( value ) {
		value.bind( function( newval ) {
			$('.service-icon').css('border-color', newval );
			$('.service-icon').css('color', newval );
		} );
	});	
	wp.customize('services_item_title',function( value ) {
		value.bind( function( newval ) {
			$('.service-title').css('color', newval );
		} );
	});
	wp.customize('services_body_text',function( value ) {
		value.bind( function( newval ) {
			$('.service-desc').css('color', newval );
		} );
	});
	//Employees section
	wp.customize('employees_bg',function( value ) {
		value.bind( function( newval ) {
			$('.employees-area').css('background-color', newval );
		} );
	});
	wp.customize('employees_title',function( value ) {
		value.bind( function( newval ) {
			$('.employees-area .widget-title').css('color', newval );
		} );
	});
	wp.customize('employees_title_dec',function( value ) {
		value.bind( function( newval ) {
			$('.employees-area .widget-title').css('border-color', newval );
		} );
	});	
	wp.customize('employees_text',function( value ) {
		value.bind( function( newval ) {
			$('.employee-name, .employee-position, .employee-social .fa, .employee .read-more').css('color', newval );
		} );
	});
	wp.customize('employees_box_bg',function( value ) {
		value.bind( function( newval ) {
			$('.employee-name, .employee-position, .employee-social, .employee .read-more').css('background-color', newval );
		} );
	});
	//Testimonials section
	wp.customize('testimonials_bg',function( value ) {
		value.bind( function( newval ) {
			$('.testimonials-area').css('background-color', newval );
		} );
	});
	wp.customize('testimonials_title',function( value ) {
		value.bind( function( newval ) {
			$('.testimonials-area .widget-title').css('color', newval );
		} );
	});
	wp.customize('testimonials_title_dec',function( value ) {
		value.bind( function( newval ) {
			$('.testimonials-area .widget-title').css('border-color', newval );
		} );
	});
	wp.customize('testimonials_body_text',function( value ) {
		value.bind( function( newval ) {
			$('.testimonial, .testimonial h4').css('color', newval );
		} );
	});
	//Facts section
	wp.customize('facts_bg',function( value ) {
		value.bind( function( newval ) {
			$('.facts-area').css('background-color', newval );
		} );
	});
	wp.customize('facts_title',function( value ) {
		value.bind( function( newval ) {
			$('.facts-area .widget-title').css('color', newval );
		} );
	});
	wp.customize('facts_title_dec',function( value ) {
		value.bind( function( newval ) {
			$('.facts-area .widget-title').css('border-color', newval );
		} );
	});	
	wp.customize('facts_color',function( value ) {
		value.bind( function( newval ) {
			$('.fact').css('background-color', newval );
			$('.fact-name').css('border-color', newval );
			$('.fact-name').css('color', newval );
		} );
	});
	//Social section
	wp.customize('social_bg',function( value ) {
		value.bind( function( newval ) {
			$('.social-area').css('background-color', newval );
		} );
	});
	wp.customize('social_title',function( value ) {
		value.bind( function( newval ) {
			$('.social-area .widget-title').css('color', newval );
		} );
	});
	wp.customize('social_title_dec',function( value ) {
		value.bind( function( newval ) {
			$('.social-area .widget-title').css('border-color', newval );
		} );
	});	
	//Projects section
	wp.customize('projects_bg',function( value ) {
		value.bind( function( newval ) {
			$('.cases-area').css('background-color', newval );
		} );
	});
	wp.customize('projects_title',function( value ) {
		value.bind( function( newval ) {
			$('.cases-area .widget-title').css('color', newval );
		} );
	});
	wp.customize('projects_title_dec',function( value ) {
		value.bind( function( newval ) {
			$('.cases-area .widget-title').css('border-color', newval );
		} );
	});	
	wp.customize('projects_item_bg',function( value ) {
		value.bind( function( newval ) {
			$('.cases-area .entry-title').css('background-color', newval );
		} );
	});
	//Latest news section
	wp.customize('latest_news_bg',function( value ) {
		value.bind( function( newval ) {
			$('.latest-news-area').css('background-color', newval );
		} );
	});
	wp.customize('latest_news_title',function( value ) {
		value.bind( function( newval ) {
			$('.latest-news-area .widget-title').css('color', newval );
		} );
	});
	wp.customize('latest_news_title_dec',function( value ) {
		value.bind( function( newval ) {
			$('.latest-news-area .widget-title').css('border-color', newval );
		} );
	});	
	wp.customize('latest_news_post_title',function( value ) {
		value.bind( function( newval ) {
			$('.latest-news-area .entry-title a').css('color', newval );
		} );
	});
	wp.customize('latest_news_body_text',function( value ) {
		value.bind( function( newval ) {
			$('.blog-post').css('color', newval );
		} );
	});
    //Subscribe
    wp.customize('subscribe_bg',function( value ) {
        value.bind( function( newval ) {
            $('.subscribe-area').css('background-color', newval );
        } );
    });
    wp.customize('subscribe_title',function( value ) {
        value.bind( function( newval ) {
            $('.subscribe-area .widget-title').css('color', newval );
        } );
    });
    wp.customize('subscribe_title_dec',function( value ) {
        value.bind( function( newval ) {
            $('.subscribe-area .widget-title').css('border-color', newval );
        } );
    });
    //Contact
    wp.customize('contact_bg',function( value ) {
        value.bind( function( newval ) {
            $('.contact-area').css('background-color', newval );
        } );
    });
    wp.customize('contact_title',function( value ) {
        value.bind( function( newval ) {
            $('.contact-area .widget-title').css('color', newval );
        } );
    });
    wp.customize('contact_title_dec',function( value ) {
        value.bind( function( newval ) {
            $('.contact-area .widget-title').css('border-color', newval );
        } );
    });
    wp.customize('contact_info',function( value ) {
        value.bind( function( newval ) {
            $('.contact-info div').css('background-color', newval );
        } );
    });
    //About us
    wp.customize('about_bg',function( value ) {
        value.bind( function( newval ) {
            $('.about_text-area').css('background-color', newval );
        } );
    });
    wp.customize('about_title',function( value ) {
        value.bind( function( newval ) {
            $('.about_text-area .widget-title').css('color', newval );
        } );
    });
    wp.customize('about_title_dec',function( value ) {
        value.bind( function( newval ) {
            $('.about_text-area .widget-title').css('border-color', newval );
        } );
    });
    wp.customize('about_text',function( value ) {
        value.bind( function( newval ) {
            $('.about-text').css('color', newval );
        } );
    });
	// Site header
	wp.customize('header_color',function( value ) {
		value.bind( function( newval ) {
			$('.site-header').css('background-color', newval );
		} );
	});	
	// Site title
	wp.customize('site_title_color',function( value ) {
		value.bind( function( newval ) {
			$('.site-title a').css('color', newval );
		} );
	});
	// Site description
	wp.customize('site_desc_color',function( value ) {
		value.bind( function( newval ) {
			$('.site-description').css('color', newval );
		} );
	});
	// Entry title
	wp.customize('entry_title_color',function( value ) {
		value.bind( function( newval ) {
			$('.hentry .entry-title, .hentry .entry-title a').css('color', newval );
		} );
	});
	// Body text color
	wp.customize('body_text_color',function( value ) {
		value.bind( function( newval ) {
			$('body').css('color', newval );
		} );
	});
	// Footer background
	wp.customize('footer_color',function( value ) {
		value.bind( function( newval ) {
			$('.footer-widget-area, .site-footer').css('background-color', newval );
		} );
	});

} )( jQuery );
