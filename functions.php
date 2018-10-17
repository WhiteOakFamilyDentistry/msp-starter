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
load_theme_textdomain( 'msp', get_template_directory_uri() . '/languages' );

//---------------------------------
// Include Custom Files
//---------------------------------

include 'lib/theme-widgets.php';
include 'lib/custom-author.php';
include 'lib/theme-shortcodes.php';
include 'lib/testimonials-post-type.php';
include 'lib/customizer.php';

//---------------------------------
// Enqueue Styles & Scripts
//---------------------------------

function add_theme_theme_stylesheets()
{
  // Use filetime to force browser cache refresh
  wp_register_style('custom.min.css', get_template_directory_uri() . '/css/custom.min.css', array(), filemtime(get_template_directory() . '/css/custom.min.css'), false);
  wp_enqueue_style( 'custom.min.css');
}
add_action('wp_enqueue_scripts', 'add_theme_theme_stylesheets');

function load_my_theme_scripts() {
  // Google Maps
  wp_register_script( 'google-map', 'https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyAB2AfrNOdVvv5KhaKMLF3WRcCEGHUEKwE', array(), '3', true );
  wp_enqueue_script('google-map');

  // Compiled Theme JS
  wp_register_script('theme', get_template_directory_uri() . '/js/dist/scripts.min.js', array('jquery'), false, true);
  wp_enqueue_script('theme');
}
add_action('wp_enqueue_scripts', 'load_my_theme_scripts');

//--------------------------------------
// Add Title Parameter
//--------------------------------------

if(!function_exists('awesome_wp_title')) {

  function awesome_wp_title( $title, $sep ) {
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
      $title = "$title $sep " . sprintf( __( 'Page %s', 'msp' ), max( $paged, $page ) );

    return $title;
  }
  add_filter( 'wp_title', 'awesome_wp_title', 10, 2 );

}

//--------------------------------------
// Register custom Navigation
//--------------------------------------

require_once('lib/wp_bootstrap_navwalker.php');

////////////////////////////////////////////////////////////////////
// REGISTER MENUS
////////////////////////////////////////////////////////////////////

register_nav_menus(
  array(
    'mobile_menu' => 'Mobile Menu',
    'top_menu' => 'Top Menu',
    'desktop_menu' => 'Desktop Menu'
    )
  );

////////////////////////////////////////////////////////////////////
// ADD SUPPORT FOR A FEATURED IMAGE AND THE SIZE
////////////////////////////////////////////////////////////////////

add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size(150,150, true);


////////////////////////////////////////////////////////////////////
// ADDS RSS FEED LINKS TO FOR POSTS AND COMMENTS
////////////////////////////////////////////////////////////////////

add_theme_support( 'automatic-feed-links' );

////////////////////////////////////////////////////////////////////
//ADD FAVICON
////////////////////////////////////////////////////////////////////

function add_theme_favicon() {
  echo '<link rel="shortcut icon" href="' . get_template_directory_uri() . '/images/favicon.png" >';
}
add_action('wp_head', 'add_theme_favicon');//Custom Favicon


////////////////////////////////////////////////////////////////////
//CHANGE DEFAULT IMAGE ATTACHMENT TO NONE
////////////////////////////////////////////////////////////////////

add_action( 'after_setup_theme', 'default_attachment_display_settings' );
function default_attachment_display_settings() {
  update_option( 'image_default_link_type', 'none' );
}


////////////////////////////////////////////////////////////////////
// REPLACES THE EXCERPT "MORE" TEXT BY A LINK
////////////////////////////////////////////////////////////////////


function excerpt($num) {
    $limit = $num+1;
    $excerpt = explode(' ', get_the_excerpt(), $limit);
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt).'...<a class="moretag" href="' .get_permalink($post->ID) . ' ">Read More <i class="fa fa-chevron-right" aria-hidden="true"></i></a>';
    echo $excerpt;
}


////////////////////////////////////////////////////////////////////
// EDIT ADMIN FOOTER TEXT
////////////////////////////////////////////////////////////////////

function awesome_edit_footer()
{
  add_filter( 'admin_footer_text', 'wpse_edit_text', 10 );
}

function wpse_edit_text($content) {
  return 'Website developed by <strong><em><a href="https://mattsigmonproductions.comcom/" target="_blank">Matt Sigmon Productions</a></em></strong>';
}
add_action( 'admin_init', 'awesome_edit_footer' );

////////////////////////////////////////////////////////////////////
//ADD PAGINATED NAVIGATION
////////////////////////////////////////////////////////////////////

function awesome_theme_pagination() {
  global $postslist;

  $total_pages = $postslist->max_num_pages;

  if ($total_pages > 1){

    $current_page = max(1, get_query_var('paged'));

    echo '<div class="page_nav">';

    echo paginate_links(array(
      'base' => get_pagenum_link(1) . '%_%',
      'format' => '/page/%#%',
      'current' => $current_page,
      'total' => $total_pages,
      'prev_text' => 'Prev',
      'next_text' => 'Next'
      ));

    echo '</div>';
  }
}

////////////////////////////////////////////////////////////////////
// RETURN THE SLUG AS A PARAMETER FOR SHORTCODES
////////////////////////////////////////////////////////////////////

if(!function_exists('the_slug')) {
  function the_slug() {
    $post_data = get_post($post->ID, ARRAY_A);
    $slug = $post_data['post_name'];
    return $slug;
  }
}

////////////////////////////////////////////////////////////////////
// DUPLICATE POST FUNCTION
////////////////////////////////////////////////////////////////////

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


////////////////////////////////////////////////////////////////////
// BREADCRUMB NAVIGATION FUNCTION
////////////////////////////////////////////////////////////////////

function get_breadcrumb() {
    echo '<a href="'.home_url().'" rel="nofollow">Home</a>';
    if (is_category() || is_single()) {
        echo "&nbsp;&nbsp; / &nbsp;&nbsp;";
        the_category(' &bull; ');
            if (is_single()) {
                echo " &nbsp;&nbsp; / &nbsp;&nbsp; ";
                the_title();
            }
    } elseif (is_page()) {
        echo "&nbsp;&nbsp; / &nbsp;&nbsp;";
        echo the_title();
    } elseif (is_search()) {
        echo "&nbsp;&nbsp; / &nbsp;&nbsp;Search Results for... ";
        echo '"<em>';
        echo the_search_query();
        echo '</em>"';
    }
}

////////////////////////////////////////////////////////////////////
// LOAD GOOGLE FONTS
////////////////////////////////////////////////////////////////////

function load_footer_fonts() {
  echo '<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.5.18/webfont.js"></script>';
  echo "<script>WebFont.load({ google: { families: ['Montserrat', 'Open Sans:400,700' ]}});";
  echo '</script>';
}
add_action('wp_footer', 'load_footer_fonts');

////////////////////////////////////////////////////////////////////
// ADD CUSTOM LOGIN PAGE STYLES
////////////////////////////////////////////////////////////////////

function theme_custom_login() {
  echo '<link rel="stylesheet" type="text/css" href="' . get_template_directory_uri() . '/css/custom.min.css" />';
}
add_action('login_head', 'theme_custom_login');

////////////////////////////////////////////////////////////////////
// ADD TITLE & TAG SUPPORT
////////////////////////////////////////////////////////////////////

add_theme_support( 'title-tag' );
get_the_tag_list();
wp_link_pages();


//////////////////////////////////////////////////////////
////////// RECORD TIMESTAMP FUNCTION & DISPLAY //////////
////////////////////////////////////////////////////////

// CREATE NEW TIMESTAMP USER META KEY
function user_last_login( $user_login, $user ) {
    update_user_meta( $user->ID, 'timestamp', gmdate("m/d/Y h:i:sa") );
}
add_action( 'wp_login', 'user_last_login', 10, 2 );

// ADD NEW COLUMN TO USER PAGE
function add_logged_in( $logged_in ) {
    $logged_in['timestamp'] = 'Last Logged In:';
    return $logged_in;
}
add_filter( 'user_contactmethods', 'add_logged_in', 10, 1 );

// MODIFY THE NEW COLUMN'S DATA
function modify_logged_in_table( $column ) {
    $column['timestamp'] = 'Last Logged In:';
    return $column;
}
add_filter( 'manage_users_columns', 'modify_logged_in_table' );

// MODIFY THE ROW ITSELF
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





?>