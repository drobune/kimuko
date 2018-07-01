jQuery.fn.exists = function(callback) {
	var args = [].slice.call(arguments, 1);
	if (this.length) {
		callback.call(this, args);
	}
	return this;
};

(function($) {

	var base = {
		initAll: function() {
			this.mainmenu();
			this.mobileMenu();
			this.scrollTop();
		},
		mainmenu: function() {
			$menu = $('.main-navigation > ul li.menu-item-has-children > a');

			$('.main-navigation ul.sub-menu').hide();
			var time;
			var delay = 100;
			
			$('.main-navigation li').hover(
				function() {
					var $this = $(this);

					time = setTimeout(function(){ 
						$this.children('ul.sub-menu').slideDown(600); 
					}, delay);
				},

				function() {
					$(this).children('ul.sub-menu').hide();
					clearTimeout(time);
				}
			);

		},

		mobileMenu: function() {
			
			var $primary_menu = $('#primary-navigation');
			var $secondary_menu = $('#category-navigation');
			var $first_menu = '';
			var $second_menu = '';

			$('.sub-menu, .widget_nav_menu .children').parent().append('<span class="arrow-menu"><i class="fa fa-angle-down"></i></span>');

			if ($primary_menu.length == 0 && $secondary_menu.length == 0) {
				return;
			} else {
				if ($primary_menu.length) {
					$first_menu = $primary_menu;
					if($secondary_menu.length) {
						$second_menu = $secondary_menu;
					}
				} else {
					$first_menu = $secondary_menu;
				}
			}

			var menu_wrapper = $first_menu
			.clone().attr('class', 'mobile-menu')
			.wrap('<div id="mobile-menu-wrapper" class="mobile-menu-wrapper mobile-only"></div>').parent().hide()
			.appendTo('body');

			// Add items from the other menu
			if ($second_menu.length) {
				$second_menu.clone().appendTo('#mobile-menu-wrapper');
			}
			
			$('.menu-toggle').click(function(e) {
				e.preventDefault();
				e.stopPropagation();
				$('#mobile-menu-wrapper').show(); // only required once
				$('body').toggleClass('mobile-menu-active');
			});

			$('#page').click(function() {
				if ($('body').hasClass('mobile-menu-active')) {
					$('body').removeClass('mobile-menu-active');
				}
			});

			if($('#wpadminbar').length) {
				$('#mobile-menu-wrapper').addClass('wpadminbar-active');
			}

			$('.arrow-menu').on('click', function(e) {
				e.preventDefault();
				e.stopPropagation();
				var subMenuOpen = $(this).hasClass('sub-menu-open');
				
				if ( subMenuOpen ) {
					$(this).removeClass('sub-menu-open');
					$(this).find('i').removeClass('fa-angle-up').addClass('fa-angle-down');
					$(this).prev('ul.sub-menu, ul.children').slideUp();
				} else {
					$(this).prev('ul.sub-menu, ul.children').slideDown();
					$(this).addClass('sub-menu-open');
					$(this).find('i').removeClass('fa-angle-down').addClass('fa-angle-up');
				}

			});
		
		},

		scrollTop : function() {
			$(".back-to-top").click(function () {
				$('html, body').animate({scrollTop : 0},800);
				return false;
			});

			$(document).scroll ( function() {
				
				var topPositionScrollBar = $(document).scrollTop();
				if ( topPositionScrollBar < "150" ) {
					
					$(".back-to-top").fadeOut();
				
				} else {

					$(".back-to-top").fadeIn();

				}

			});
		},

		skipLinkFocusFix: function() {
			var is_webkit = navigator.userAgent.toLowerCase().indexOf( 'webkit' ) > -1,
			is_opera	= navigator.userAgent.toLowerCase().indexOf( 'opera' )  > -1,
			is_ie		= navigator.userAgent.toLowerCase().indexOf( 'msie' )   > -1;

			if ( ( is_webkit || is_opera || is_ie ) && document.getElementById && window.addEventListener ) {
				window.addEventListener( 'hashchange', function() {
					var element = document.getElementById( location.hash.substring( 1 ) );

					if ( element ) {
						if ( ! /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) )
							element.tabIndex = -1;

						element.focus();
					}
				}, false );
			}
		}
	};

	$(document).ready(function() {
		base.initAll();
	});	

})(jQuery);