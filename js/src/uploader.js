/**
 * Theme Options Scripts
 */

jQuery( document ).ready( function() {

	/* WP Media Uploader */
	var _shr_media = true;
	var _orig_send_attachment = wp.media.editor.send.attachment;

	jQuery( '.shr-image' ).click( function() {

		var button = jQuery( this ),
				textbox_id = jQuery( this ).attr( 'data-id' ),
				image_id = jQuery( this ).attr( 'data-src' ),
				_shr_media = true;

		wp.media.editor.send.attachment = function( props, attachment ) {

			if ( _shr_media && ( attachment.type === 'image' ) ) {
				if ( image_id.indexOf( "," ) !== -1 ) {
					image_id = image_id.split( "," );
					$image_ids = '';
					jQuery.each( image_id, function( key, value ) {
						if ( $image_ids )
							$image_ids = $image_ids + ',#' + value;
						else
							$image_ids = '#' + value;
					} );

					var current_element = jQuery( $image_ids );
				} else {
					var current_element = jQuery( '#' + image_id );
				}

				jQuery( '#' + textbox_id ).val( attachment.id );
                                console.log(textbox_id)
				current_element.attr( 'src', attachment.url ).show();
			} else {
				alert( 'Please select a valid image file' );
				return false;
			}
		}

		wp.media.editor.open( button );
		return false;
	} );

} );


jQuery(document).ready(function($){
	$('#upload-btn').click(function(e) {
		e.preventDefault();
		var image = wp.media({ 
			title: 'Upload Image',
			// mutiple: true if you want to upload multiple files at once
			multiple: false
		}).open()
		.on('select', function(e){
			// This will return the selected image from the Media Uploader, the result is an object
			var uploaded_image = image.state().get('selection').first();
			// We convert uploaded_image to a JSON object to make accessing it easier
			// Output to the console uploaded_image
			console.log(uploaded_image);
			var image_url = uploaded_image.toJSON().url;
			// Let's assign the url value to the input field
			$('#image_url').val(image_url);
		});
	});
});