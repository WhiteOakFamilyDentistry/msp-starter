jQuery.noConflict();

(function ($) {

  	function scrollUp() {

    	$(window).scroll(function () {
      		if ($(this).scrollTop() > 100) {
        		$('.scrollup').fadeIn();
      		} else {
        		$('.scrollup').fadeOut();
      		}
    	});

    	$('.scrollup').click(function () {
      		$('html, body').animate(
        		{
					scrollTop: 0,
        		},
        		600
			  );
			  
		  return false;
		  
    	});
  	}

  	//--------------------
  	// Fade in Stuff
  	//--------------------

  	function animateStuff() {
		const w = $(window).width();
		
		if( w > 769 ) {
			
			$(window).scroll(function () {
			
				// add classes on page scroll to trigger animations

      			// fade in effect
      			$('.fade-out').each(function () {
        			const bottom_of_object = $(this).offset().top + $(this).outerHeight();
        			const bottom_of_window = $(window).scrollTop() + $(window).height();

        			if (bottom_of_window > bottom_of_object) {
          				$(this).addClass('fade-in');
        			}
      			});

      			// slide in effect
      			$('.slide-it').each(function () {
        			const bottom_of_object = $(this).offset().top + $(this).outerHeight();
        			const bottom_of_window = $(window).scrollTop() + $(window).height() + 550;

        			if (bottom_of_window > bottom_of_object) {
          				$(this).addClass('slide-left');
        			}
      			});

      			$('.slide-it-right').each(function () {
        			const bottom_of_object = $(this).offset().top + $(this).outerHeight();
        			const bottom_of_window = $(window).scrollTop() + $(window).height() + 550;
        
        			if (bottom_of_window > bottom_of_object) {
          				$(this).addClass('slide-right');
        			}
      			});
    
      
			});

    		// load first set of hidden items on short pages
    		$('.fade-out').each(function () {
      			const bottom_of_object = $(this).offset().top + $(this).outerHeight();
      			const bottom_of_window = $(window).scrollTop() + $(window).height();

      			if (bottom_of_window > bottom_of_object) {
        			$(this).addClass('fade-in');
      			}
    		});

  		}
    
	  }

	  function tabbedNav() {
    	$('#hiring-steps .hiring-process-content:first-of-type').addClass('show active');
    	$('#hiring-process-tabs.nav-tabs li:first-of-type a').addClass('active').attr("aria-selected", "true");
  	}
	  
	$(document).ready(function () {
    	scrollUp();
		animateStuff();
		tabbedNav();
  	});

// End jQuery function
})(jQuery);
