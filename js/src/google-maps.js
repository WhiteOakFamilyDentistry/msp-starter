var $ = jQuery;
base_url = "https://" + window.location.hostname;

function whiteoak_maps() {

	var mapDiv = document.getElementById('footer-map');
	var map = new google.maps.Map(mapDiv, {
		center: {lat: 35.6878637, lng: -78.591429},
		zoom: 14,
		scrollwheel: false,
		draggable: false
	});
	var marker = new google.maps.Marker({
	  	position: {lat: 35.6878637, lng: -78.591429},
	  	map: map,
	  	animation: google.maps.Animation.DROP,
	  	icon: base_url + '/wp-content/themes/whiteoak/images/map-logo.png',
			url:  'https://www.google.com/maps/place/White+Oak+Family+Dentistry/@35.6878637,-78.591429,17z/data=!4m12!1m6!3m5!1s0x0:0xf8c672458de5bcf!2sWhite+Oak+Family+Dentistry!8m2!3d35.6878637!4d-78.5892403!3m4!1s0x0:0xf8c672458de5bcf!8m2!3d35.6878637!4d-78.5892403'
	});

	//Content structure of info Window for the Markers


        var contentString = '<div id="info-box"><h3>White Oak Family Dentistry</h3><p>520 Timber Drive East, Suite 101</p><p><a href="tel:19199860151">919.986.0151</a></p><p><strong>Hours:</strong></p><p>Mon - Thur: 8am -5pm</p><a class="directions" href="https://www.google.com/maps/place/White+Oak+Family+Dentistry/@35.6878637,-78.591429,17z/data=!4m12!1m6!3m5!1s0x0:0xf8c672458de5bcf!2sWhite+Oak+Family+Dentistry!8m2!3d35.6878637!4d-78.5892403!3m4!1s0x0:0xf8c672458de5bcf!8m2!3d35.6878637!4d-78.5892403" target="_blank">Get Directions</a>';
            
        var infowindow = new google.maps.InfoWindow({
          content: contentString,
          maxWidth: 500
        });
        

        //add click event listener to marker which will open infoWindow          
        google.maps.event.addListener(marker, 'click', function() {
            infowindow.open(map,marker); // click on marker opens info window 
        });
}

$(document).ready(function() {
	whiteoak_maps();
});