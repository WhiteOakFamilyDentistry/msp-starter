var $ = jQuery;
var current_title = $(document).attr('title');

function testimonials(){
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

function mobileNav(){
	var $menu = $('#mobile-menu').mmenu({
		"extensions": [
		"pagedim-black",
		"fx-menu-zoom",
		"fx-listitems-slide",
		"border-full"
		],
		backbutton: {
			close: true
		},
		navbar: {
			title: current_title
		}
	});
}

function loggedIn() {
	if ($('#wpadminbar')[0])
		$('#header-container').css('top', '32px')
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
		$("html, body").animate({
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