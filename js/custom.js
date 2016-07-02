(function () {
	'use strict';

	var teslaThemes = {
		init: function () {
			this.smallToggles();
			this.fixedElements();
		},
		
		smallToggles: function () {
			var nav = jQuery('header nav'),
				navToggle = jQuery('.menu-toggle'),
				searchForm = jQuery('.global-search-form'),
				searchFormToggle = jQuery('.search-box-toggle'),
				cart = jQuery('.shopping-cart'),
				cartToggle = jQuery('.shopping-cart-toggle'),
				paymentType = jQuery('#payment-type'),
				creditCard = jQuery('#credit-card-payment');

			function hamburgerToggle() {
				jQuery('.top-menu').toggleClass('top-animate');
				jQuery('.mid-menu').toggleClass('mid-animate');
				jQuery('.bottom-menu').toggleClass('bottom-animate');
			}

			// Menu Toggle
			navToggle.on('click', function () {
				hamburgerToggle();
				nav.toggleClass('open');
				jQuery(this).toggleClass('menu-opened');
				nav.hasClass('open') ? nav.velocity('slideDown', {duration: 280}) : nav.velocity('slideUp', {duration: 200});
				return false;
			});

			jQuery(document).on('click', function () {
				if (nav.hasClass('open')) {
					hamburgerToggle();
				}

				nav.removeClass('open');
				navToggle.removeClass('menu-opened');
				nav.hasClass('open') ? nav.velocity('slideDown', {duration: 280}) : nav.velocity('slideUp', {duration: 200});
			});

			nav.on('click', function (e) {
				e.stopPropagation();
			});


			// Enroll to course
			jQuery('.section-courses').on('click', '.single-course .enroll-btn', function (e) {
				e.preventDefault();
				cart.addClass('open');
				return false;
			});

			// Save course
			jQuery('.section-courses').on('click', '.single-course .save-btn', function () {
				var obj = jQuery(this),
					popup = obj.find('.popup');

				obj.toggleClass('saved');
				if (obj.hasClass('saved')) {
					popup.addClass('visible');

					setTimeout(function () {
						popup.addClass('slow').removeClass('visible');
					}, 1500);

					popup.removeClass('slow');
				}
			});
		},
		
		fixedElements: function () {
				var footer = jQuery('footer'),
					header = jQuery('header'),
					fh = footer.height();
	
				jQuery(window).on('scroll', function () {
					var st = jQuery(this).scrollTop();
					// Fixed Footer
					if (footer.hasClass('fixed')) {
						if (jQuery(window).width() > 767) {
							var dh = jQuery(document).height(),
								wh = jQuery(window).height(),
								cb = jQuery('.content-wrapper')[0].getBoundingClientRect();
	
							if (wh - cb.bottom <= fh) {
								footer.css({
									'opacity': Math.ceil(((wh - cb.bottom) / fh) * 100) / 100
								});
							}
						}
					}
	
					// Fixed Header
					(st > header.outerHeight(true)) ? header.addClass('not-visible') : header.removeClass('not-visible');
	
					(st > header.outerHeight(true) + 70) ? header.addClass('fixed') : header.removeClass('fixed');
				});
	
				if (footer.hasClass('fixed')) {
					if (jQuery(window).width() > 767) {
						jQuery('.content-wrapper').css({
							'margin-bottom': fh
						});
					} else {
						jQuery('.content-wrapper').css({
							'margin-bottom': 0
						});
					}
	
					jQuery(window).on('resize', function () {
						fh = footer.height();
						
						if (jQuery(window).width() > 767) {
							jQuery('.content-wrapper').css({
								'margin-bottom': fh
							});
						} else {
							jQuery('.content-wrapper').css({
								'margin-bottom': 0
							});
						}
					});
				}
			},

	};

	jQuery(document).ready(function(){
		teslaThemes.init();

		setTimeout(function () {
			jQuery('body').addClass('dom-ready');
		}, 200);
	});
}());


// registr / Login Modal
$('#registerModal').on('show.bs.modal', function (event) {})
$('#loginModal').on('show.bs.modal', function (event) {})
$('#QueueModal').on('show.bs.modal', function (event) {})
	  
	  
	  
	  
	  
	  
	  