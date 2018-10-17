<?php

////////////////////////////////////////////////////////////////////
//msp CUSTOM OPTIONS FILE
////////////////////////////////////////////////////////////////////


add_action( 'admin_bar_menu', 'customize_admin_bar', 50 );
function customize_admin_bar()
{
  global $wp_admin_bar;
  $wp_admin_bar->add_menu( array(
    'id' => 'dd_custom-menu',
    'title' => '<span class="ab-icon"></span><span class="ab-label">'.__( 'Theme Options', 'msp' ).'</span>',
    'href' => false
    ) );

  $wp_admin_bar->add_menu( array(
    'id' => 'msp_options',
    'parent' => 'dd_custom-menu',
    'title' => 'Site Options',
    'href' => admin_url('customize.php'),
    ) );
}

//SANITIZE OUR VARIOUS OPTIONS

function msp_sanitize_choices( $input, $setting ) {
  global $wp_customize;

  $control = $wp_customize->get_control( $setting->id );

  if ( array_key_exists( $input, $control->choices ) ) {
    return $input;
  } else {
    return $setting->default;
  }
}

function awesome_sanitize_nohtml( $nohtml ) {
  return wp_filter_nohtml_kses( $nohtml );
}


function msp_options( $wp_customize ) {

//////////////////////////////////////////////////////////
/////////////// SET UP PANELS & SECTIONS /////////////////
//////////////////////////////////////////////////////////


//MAIN SITE OPTIONS PANEL (ALL OPTIONS ARE PLACED UNDER THIS MAIN PANEL)

  $wp_customize->add_panel('site_options', array(
    'title' => 'Customize Site Options',
    'priority' => 20,
    'description' => 'Adjust the main container sizes'
    ) );

//SOCIAL MEDIA SECTION
  $wp_customize->add_section('social_media', array(
    'panel' => 'site_options',
    'title' => 'Social Media Links',
    'priority' => 20
    ) );

//CLIENT INFORMATION
  $wp_customize->add_section('client_info', array(
    'panel' => 'site_options',
    'title' => 'Client Info',
    'priority' => 30
    ) );

//BLOG OPTIONS SECTION

  $wp_customize->add_section('blog_options', array(
    'panel' => 'site_options',
    'title' => 'Blog Options',
    'priority' => 40
    ) );


//////////////////////////////////////////////////////////
/////////////////// INTIALIZE OPTIONS ////////////////////
//////////////////////////////////////////////////////////


//SOCIAL MEDIA LINKS

   $wp_customize->add_setting('facebook_link', array(
     'type' => 'theme_mod',
     'sanitize_callback' => 'esc_url_raw',
     'capability' => 'edit_theme_options'
   ) );

   $wp_customize->add_control('facebook_link', array(
     'label' => __( 'Facebook', 'msp' ),
     'section' => 'social_media',
     'type' => 'text'
   ) );

   $wp_customize->add_setting('twitter_link', array(
     'type' => 'theme_mod',
     'sanitize_callback' => 'esc_url_raw',
     'capability' => 'edit_theme_options'
   ) );
   $wp_customize->add_control('twitter_link', array(
     'label' => __( 'Twitter', 'msp' ),
     'section' => 'social_media',
     'type' => 'text'
   ) );

   $wp_customize->add_setting('yelp_link', array(
     'type' => 'theme_mod',
     'sanitize_callback' => 'esc_url_raw',
     'capability' => 'edit_theme_options'
   ) );
   $wp_customize->add_control('yelp_link', array(
     'label' => __( 'Yelp', 'msp' ),
     'section' => 'social_media',
     'type' => 'text'
   ) );

   $wp_customize->add_setting('google_plus_link', array(
     'type' => 'theme_mod',
     'sanitize_callback' => 'esc_url_raw',
     'capability' => 'edit_theme_options'
   ) );
   $wp_customize->add_control('google_plus_link', array(
     'label' => __( 'Google +', 'msp' ),
     'section' => 'social_media',
     'type' => 'text'
   ) );

   $wp_customize->add_setting('instagram_link', array(
     'type' => 'theme_mod',
     'sanitize_callback' => 'esc_url_raw',
     'capability' => 'edit_theme_options'
   ) );
   $wp_customize->add_control('instagram_link', array(
     'label' => __( 'Instagram', 'msp' ),
     'section' => 'social_media',
     'type' => 'text'
   ) );

   $wp_customize->add_setting('you_tube_link', array(
     'type' => 'theme_mod',
     'sanitize_callback' => 'esc_url_raw',
     'capability' => 'edit_theme_options'
   ) );
   $wp_customize->add_control('you_tube_link', array(
     'label' => __( 'YouTube', 'msp' ),
     'section' => 'social_media',
     'type' => 'text'
   ) );

//CLIENT INFORMATION

   $wp_customize->add_setting('location_street', array(
     'type' => 'theme_mod',
     'sanitize_callback' => 'awesome_sanitize_nohtml',
     'capability' => 'edit_theme_options'
   ) );

   $wp_customize->add_control('location_street', array(
     'label' => __( 'Street Address', 'msp' ),
     'section' => 'client_info',
     'type' => 'text'
   ) );

   $wp_customize->add_setting('location_city', array(
     'type' => 'theme_mod',
     'sanitize_callback' => 'awesome_sanitize_nohtml',
     'capability' => 'edit_theme_options'
   ) );

   $wp_customize->add_control('location_city', array(
     'label' => __( 'City', 'msp' ),
     'section' => 'client_info',
     'type' => 'text'
   ) );

   $wp_customize->add_setting('location_state', array(
     'type' => 'theme_mod',
     'sanitize_callback' => 'awesome_sanitize_nohtml',
     'capability' => 'edit_theme_options'
   ) );

   $wp_customize->add_control('location_state', array(
     'label' => __( 'State', 'msp' ),
     'section' => 'client_info',
     'type' => 'text'
   ) );

   $wp_customize->add_setting('location_zip', array(
     'type' => 'theme_mod',
     'sanitize_callback' => 'awesome_sanitize_nohtml',
     'capability' => 'edit_theme_options'
   ) );

   $wp_customize->add_control('location_zip', array(
     'label' => __( 'Zip', 'msp' ),
     'section' => 'client_info',
     'type' => 'text'
   ) );

   $wp_customize->add_setting('location_phone', array(
     'type' => 'theme_mod',
     'sanitize_callback' => 'awesome_sanitize_nohtml',
     'capability' => 'edit_theme_options'
   ) );

   $wp_customize->add_control('location_phone', array(
     'label' => __( 'Phone Number', 'msp' ),
     'section' => 'client_info',
     'type' => 'text'
   ) );

   $wp_customize->add_setting('hours', array(
     'type' => 'theme_mod',
     'sanitize_callback' => 'awesome_sanitize_nohtml',
     'capability' => 'edit_theme_options'
   ) );

   $wp_customize->add_control('hours', array(
     'label' => __( 'Weekday Hours', 'msp' ),
     'section' => 'client_info',
     'type' => 'text'
   ) );

   $wp_customize->add_setting('weekend_hours', array(
     'type' => 'theme_mod',
     'sanitize_callback' => 'awesome_sanitize_nohtml',
     'capability' => 'edit_theme_options'
   ) );

   $wp_customize->add_control('weekend_hours', array(
     'label' => __( 'Weekend Hours', 'msp' ),
     'section' => 'client_info',
     'type' => 'text'
   ) );

   $wp_customize->add_setting('directions', array(
     'type' => 'theme_mod',
     'sanitize_callback' => 'esc_url_raw',
     'capability' => 'edit_theme_options'
   ) );

   $wp_customize->add_control('directions', array(
     'label' => __( 'Directions Link', 'msp' ),
     'section' => 'client_info',
     'type' => 'text'
   ) );

//BLOG ARTICLE OPTIONS

//POST COUNT

  $wp_customize->add_setting('post_count', array(
    'default' => '-1',
    'sanitize_callback' => 'msp_sanitize_choices',
    'capability' => 'edit_theme_options'
    ) );

  $wp_customize->add_control('post_count', array(
    'label' => 'Post Count',
    'priority' => 40,
    'section' => 'blog_options',
    'type' => 'select',
    'choices' => array(
      '-1' => 'All Posts',
      '1' => '1',
      '2' => '2',
      '3' => '3',
      '4' => '4',
      '5' => '5',
      '6' => '6',
      '7' => '7',
      '8' => '8',
      '9' => '9',
      '10' => '10'
      )
    ) );

//REMOVE ALL UNNECESSARY SECTIONS

  $wp_customize->remove_section( 'title_tagline' );
  $wp_customize->remove_section( 'static_front_page' );
  $wp_customize->remove_section( 'custom_css' );

}
add_action( 'customize_register' , 'msp_options' );


?>