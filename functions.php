<?php

//===============================================
// MAIN THEME FUNCTION FILE
//===============================================


//---------------------------------
// Theme Information
//---------------------------------

$themename = "MSP Starter";
$developer_uri = "https://mattsigmonproductions.com/";
$version = '1.0';
$domain = 'msp'; // Change this to update the theme textdomain
load_theme_textdomain( $domain, get_template_directory_uri() . '/languages' );

//---------------------------------
// Include Custom Files
//---------------------------------

include 'lib/theme-widgets.php';
include 'lib/theme-shortcodes.php';
include 'lib/testimonials-post-type.php';
include 'lib/acf-options.php';



//---------------------------------
// Enqueue Styles & Scripts
//---------------------------------


function msp_theme_scripts() {
  /* Theme Styles */

  // Use filetime to force browser cache refresh
  wp_register_style('custom.min.css', get_template_directory_uri() . '/assets/css/custom.min.css', array(), filemtime(get_template_directory() . '/assets/css/custom.min.css'), false);
  wp_enqueue_style( 'custom.min.css');

  /* Theme Scripts */

  // Google Maps
  wp_register_script( 'google-map', 'https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyAB2AfrNOdVvv5KhaKMLF3WRcCEGHUEKwE', array(), '3', true );
  wp_enqueue_script('google-map');

  // Compiled Theme JS
  wp_register_script('theme', get_template_directory_uri() . '/assets/js/dist/scripts.min.js', array('jquery'), false, true);
  wp_enqueue_script('theme');
}
add_action('wp_enqueue_scripts', 'msp_theme_scripts');



//--------------------------------------
// Add Title Parameter
//--------------------------------------

if(!function_exists( 'msp_theme_title' )) {

  function msp_theme_title( $title, $sep ) {
    global $paged, $page;

    if ( is_feed() )
      return $title;

    // Add the site name.
    $title .= get_bloginfo( 'name' );

    // Add the site description for the home/front page.
    $site_description = get_bloginfo( 'description', 'display' );
    if ( $site_description && ( is_home() || is_front_page() ) )
      $title = "$title $sep $site_description";

        // Add a page number if necessary.
    if ( $paged >= 2 || $page >= 2 )
      $title = "$title $sep " . sprintf( __( 'Page %s', $domain ), max( $paged, $page ) );

    return $title;
  }
  add_filter( 'wp_title', 'msp_theme_title', 10, 2 );

}

//--------------------------------------
// Register Bootstrap 4 Desktop Navigation
//--------------------------------------

require_once('lib/bs4Navwalker.php');

//--------------------------------------
// Register Menus
//--------------------------------------

register_nav_menus(
  array(
    'mobile_menu' => 'Mobile Menu',
    'top_menu' => 'Top Menu',
    'desktop_menu' => 'Desktop Menu'
  )
);

//--------------------------------------
// Add Support for Featured Image
//--------------------------------------

add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 150, 150, true );

/* Add Cutom Image Sizes */
add_image_size( 'big-thumbnail', 300, 300, false );
add_image_size( 'full-width', 1920, 1080, false );

//--------------------------------------
// Add RSS Support
//--------------------------------------

add_theme_support( 'automatic-feed-links' );

//--------------------------------------
// Add Favicon
//--------------------------------------

function msp_add_theme_favicon() {
  echo '<link rel="shortcut icon" href="' . get_template_directory_uri() . '/assets/images/favicon.png" >';
}
add_action( 'wp_head', 'msp_add_theme_favicon' );//Custom Favicon

//--------------------------------------
// Change Default Image Attachment to None
//--------------------------------------

add_action( 'after_setup_theme', 'default_attachment_display_settings' );
function default_attachment_display_settings() {
  update_option( 'image_default_link_type', 'none' );
}

//--------------------------------------
// Add Read More Tag to Excerpt
//--------------------------------------

function msp_excerpt( $num ) {
    $limit = $num+1;
    $excerpt = explode(' ', get_the_excerpt(), $limit );
    array_pop( $excerpt );
    $excerpt = implode(" ", $excerpt ).'...<a class="moretag" href="' .get_permalink( $post->ID ) . ' ">Read More <i class="fas fa-chevron-right"></i></a>';
    echo $excerpt;
}

//--------------------------------------
// Edit Admin Footer Text
//--------------------------------------

function msp_edit_footer()
{
  add_filter( 'admin_footer_text', 'wpse_edit_text', 10 );
}

function msp_edit_text( $content ) {
  return 'Website developed by <strong><em>Matt Sigmon</em></strong>';
}
add_action( 'admin_init', 'msp_edit_footer' );

//--------------------------------------
// Add Pagination
//--------------------------------------

function awesome_theme_pagination() {
  global $postslist;
  $big = 999999999;
  echo '<div class="page_nav">';
  echo paginate_links(
    array(
      'base' => str_replace($big, '%#%', get_pagenum_link($big)),
      'format' => '%#%',
      'current' => max(1, get_query_var('paged')),
      'total' => $postslist->max_num_pages
    )
  );
  echo '</div>';
}

//--------------------------------------
// Return Slug as Parameter for Shortcodes
//--------------------------------------

if( !function_exists( 'the_slug' ) ) {
  function the_slug() {
    $post_data = get_post( $post->ID, ARRAY_A );
    $slug = $post_data['post_name'];
    return $slug;
  }
}

//--------------------------------------
// Duplicate Post Type Functions
//--------------------------------------

function awesome_duplicate_post_as_draft(){
  global $wpdb;
  if (! ( isset( $_GET['post']) || isset( $_POST['post'])  || ( isset($_REQUEST['action']) && 'rd_duplicate_post_as_draft' == $_REQUEST['action'] ) ) ) {
    wp_die('No post to duplicate has been supplied!');
  }

  /*
   * get the original post id
   */
  $post_id = (isset($_GET['post']) ? $_GET['post'] : $_POST['post']);
  /*
   * and all the original post data then
   */
  $post = get_post( $post_id );

  /*
   * if you don't want current user to be the new post author,
   * then change next couple of lines to this: $new_post_author = $post->post_author;
   */
  $current_user = wp_get_current_user();
  $new_post_author = $current_user->ID;

  /*
   * if post data exists, create the post duplicate
   */
  if (isset( $post ) && $post != null) {

    /*
     * new post data array
     */
    $args = array(
      'comment_status' => $post->comment_status,
      'ping_status'    => $post->ping_status,
      'post_author'    => $new_post_author,
      'post_content'   => $post->post_content,
      'post_excerpt'   => $post->post_excerpt,
      'post_name'      => $post->post_name,
      'post_parent'    => $post->post_parent,
      'post_password'  => $post->post_password,
      'post_status'    => 'draft',
      'post_title'     => $post->post_title,
      'post_type'      => $post->post_type,
      'to_ping'        => $post->to_ping,
      'menu_order'     => $post->menu_order
    );

    /*
     * insert the post by wp_insert_post() function
     */
    $new_post_id = wp_insert_post( $args );

    /*
     * get all current post terms ad set them to the new post draft
     */
    $taxonomies = get_object_taxonomies($post->post_type); // returns array of taxonomy names for post type, ex array("category", "post_tag");
    foreach ($taxonomies as $taxonomy) {
      $post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
      wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
    }

    /*
     * duplicate all post meta just in two SQL queries
     */
    $post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id");
    if (count($post_meta_infos)!=0) {
      $sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
      foreach ($post_meta_infos as $meta_info) {
        $meta_key = $meta_info->meta_key;
        $meta_value = addslashes($meta_info->meta_value);
        $sql_query_sel[]= "SELECT $new_post_id, '$meta_key', '$meta_value'";
      }
      $sql_query.= implode(" UNION ALL ", $sql_query_sel);
      $wpdb->query($sql_query);
    }

    /*
     * finally, redirect to the edit post screen for the new draft
     */
    wp_redirect( admin_url( 'post.php?action=edit&post=' . $new_post_id ) );
    exit;
  } else {
    wp_die('Post creation failed, could not find original post: ' . $post_id);
  }
}
add_action( 'admin_action_rd_duplicate_post_as_draft', 'awesome_duplicate_post_as_draft' );

/*
 * Add the duplicate link to action list for post_row_actions
 */
function awesome_duplicate_post_link( $actions, $post ) {
  if (current_user_can('edit_posts')) {
    $actions['duplicate'] = '<a href="admin.php?action=rd_duplicate_post_as_draft&amp;post=' . $post->ID . '" title="Duplicate this item" rel="permalink">Duplicate</a>';
  }
  return $actions;
}

add_filter( 'post_row_actions', 'awesome_duplicate_post_link', 10, 2 );
add_filter( 'page_row_actions', 'awesome_duplicate_post_link', 10, 2); /* for pages */

//--------------------------------------
// Breadcrumb Navigation
//--------------------------------------

function get_breadcrumb() {
  echo '<a href="'.home_url().'" rel="nofollow">Home</a>';
  if ( is_category() || is_single() ) {
    echo "&nbsp;&nbsp; / &nbsp;&nbsp;";
    the_category(' &bull; ');
    if ( is_single() ) {
      echo " &nbsp;&nbsp; / &nbsp;&nbsp; ";
      the_title();
    }
  } elseif ( is_page() ) {
    echo "&nbsp;&nbsp; / &nbsp;&nbsp;";
    echo the_title();
  } elseif ( is_search() ) {
    echo "&nbsp;&nbsp; / &nbsp;&nbsp;Search Results for... ";
    echo '"<em>';
    echo the_search_query();
    echo '</em>"';
  }
}

//--------------------------------------
// Load Font Libraries
//--------------------------------------

/*
 *
 * This script will load fonts from different libraries
 * More info found here: https://github.com/typekit/webfontloader
 *
 */

function load_footer_fonts() {
  echo '<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.5.18/webfont.js"></script>';
  echo "<script>WebFont.load({ google: { families: ['Roboto Slab', 'Open Sans' ]}});";
  echo '</script>';
}
add_action('wp_footer', 'load_footer_fonts');

//--------------------------------------
// Add Custom Login Styles
//--------------------------------------/

function theme_custom_login() {
  echo '<link rel="stylesheet" type="text/css" href="' . get_template_directory_uri() . '/assets/css/custom.min.css" />';
}
add_action('login_head', 'theme_custom_login');

//--------------------------------------
// Add Title & Tag Support
//--------------------------------------

add_theme_support( 'title-tag' );
get_the_tag_list();
wp_link_pages();

//--------------------------------------
// Record Timestamp for Logged In Users
//--------------------------------------

// Create new timestamp user meta key
function user_last_login( $user_login, $user ) {
    update_user_meta( $user->ID, 'timestamp', gmdate("m/d/Y h:i:sa") );
}
add_action( 'wp_login', 'user_last_login', 10, 2 );

// Add new column to user page
function add_logged_in( $logged_in ) {
    $logged_in['timestamp'] = 'Last Logged In:';
    return $logged_in;
}
add_filter( 'user_contactmethods', 'add_logged_in', 10, 1 );

// Modify the new column's data
function modify_logged_in_table( $column ) {
    $column['timestamp'] = 'Last Logged In:';
    return $column;
}
add_filter( 'manage_users_columns', 'modify_logged_in_table' );

// Modify the row itself
function modify_logged_in_table_row( $val, $column_name, $user_id ) {
    switch ($column_name) {
        case 'timestamp' :
            return get_the_author_meta( 'timestamp', $user_id );
            break;
        default:
    }
    return $val;
}
add_filter( 'manage_users_custom_column', 'modify_logged_in_table_row', 10, 3 );

//------------------------------------------------------------
// Reduce Number od Unnecessary Calls to change_link Function
//------------------------------------------------------------

remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_shortlink_wp_head');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'rest_output_link_wp_head');
remove_action('wp_head', 'wp_oembed_add_discovery_links');

//-----------------------------------
// Add SVG Upload Ability
//-----------------------------------

function custom_mtypes( $m ){
    $m['svg'] = 'image/svg+xml';
    $m['svgz'] = 'image/svg+xml';
    return $m;
}
add_filter( 'upload_mimes', 'custom_mtypes' );