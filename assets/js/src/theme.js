var $ = jQuery;
var currentTitle = $(document).attr('title');

function testimonials() {
	$('#testimonials').slick({
		dots: true,
		autoplay: true,
		autoplaySpeed: 8000,
  	infinite: true,
  	speed: 500,
  	fade: true,
  	cssEase: 'linear'
	});
}

function mobileNav() {

	//====================================
	// This function controls the mobile
	// navigation.
	//====================================
	
	var $menu = $('#mobile-menu').mmenu({

		// Style the Menu to Suit the Design
		// More info: http://mmenu.frebsite.nl/

		'extensions': [
		'fullscreen',
		'fx-menu-zoom',
		'fx-listitems-slide',
		'border-full'
		],

		backbutton: {

			// Display back button
			close: true
		},

		navbars: [{

			content: [
				// Display the same hamburger nav if you'd like
				'<button class="my-icon hamburger hamburger--collapse is-active" type="button"><span class="hamburger-box"><span class="hamburger-inner"></span></span></button>'

				// Alternatively, you could use the general close button
				//'close'
			],

			// Display menu title or any HTML
			// SVG code here is useful
			title: currentTitle

		}]

	});

	// Call API to open menu from closed state
	var $icon = $('.my-icon');
	var API = $menu.data( 'mmenu' );

	$icon.on( 'click', function() {
	   API.open();
	});

	API.bind( 'open:finish', function() {
	   setTimeout(function() {
	      $icon.addClass( 'is-active' );
	   }, 100);
	});
	API.bind( 'close:finish', function() {
	   setTimeout(function() {
	      $icon.removeClass( 'is-active' );
	   }, 100);
	});

	// Call API to close menu when custom
	// close button is clicked. Delete this
	// section if using default close button.

	var $icon = $('.my-icon.is-active');
	var API = $menu.data( 'mmenu' );

	$icon.on( 'click', function() {
	   API.close();
	});

	API.bind( 'open:finish', function() {
	   setTimeout(function() {
	      $icon.addClass( 'is-active' );
	   }, 100);
	});
	API.bind( 'close:finish', function() {
	   setTimeout(function() {
	      $icon.removeClass( 'is-active' );
	   }, 100);
	});

// Exit Mobile Navigation

}


function loggedIn() {
	if ($('#wpadminbar')[0]) {
		$('#header-container').css('top', '32px');
	}
}

function scrollUp() {
	$(window).scroll(function () {
		if ($(this).scrollTop() > 100) {
			$('.scrollup').fadeIn();
		} else {
			$('.scrollup').fadeOut();
		}
	});

	$('.scrollup').click(function () {
		$('html, body').animate({
			scrollTop: 0
		}, 600);
		return false;
	});

}

$(document).ready(function() {
	testimonials();
	mobileNav();
	loggedIn();
	scrollUp();
});