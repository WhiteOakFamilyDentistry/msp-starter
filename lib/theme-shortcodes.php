<?php


//===================================
// THEME SHORTCODES
//===================================


//-------------------------
// Add [blogurl] shortcode
//-------------------------

add_shortcode( 'blogurl', 'add_url_shortcode' );
function add_url_shortcode( $atts ) {
  return home_url() . '/';
}
add_action( 'init', 'add_url_shortcode');

//-----------------------------------
// Add [childtemplateurl] shortcode
//-----------------------------------

add_shortcode( 'childtemplateurl', 'add_childtemplateurl_shortcode' );
function add_childtemplateurl_shortcode( $atts ) {
return get_stylesheet_directory_uri() . '/';
}
add_action( 'init', 'add_childtemplateurl_shortcode');

//----------------------------------
// Add [blogurl_uploads] shortcode
//----------------------------------

add_shortcode( 'blogurl_uploads', 'add_uploads_shortcode' );
function add_uploads_shortcode( $atts ) {
return home_url() . '/' . 'wp-content' . '/' . 'uploads' . '/';
}
add_action( 'init', 'add_uploads_shortcode');

//-------------------------------
// Add [phone_number] shortcode
//-------------------------------

add_shortcode( 'phone_number', 'add_phone_number_shortcode' );
function add_phone_number_shortcode( $atts ) {
return get_field( 'phone_number', 'option' );
}
add_action( 'init', 'add_phone_number_shortcode');