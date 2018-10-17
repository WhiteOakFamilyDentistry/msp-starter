<?php
function create_post_type_review()
{
    register_taxonomy( 'group', 'review',
        array(
            'labels' => array(
                'name'          => 'Groups',
                'singular_name' => 'Group',
                'search_items'  => 'Search Groups',
                'edit_item'     => 'Edit Group',
                'update_item'   => 'Update Group',
                'add_new_item'  => 'Add New Group',
                'parent_item'   => 'Parent Group',
                'menu_name' => 'Groups'
            ),
            'query_var' => true,
            'hierarchical' => true,
            'show_admin_column' => true,
            'rewrite' => array('slug' => 'group', 'hierarchical' => true)
        )
    );
    register_post_type('review', // REGISTER CUSTOM POST TYPE
        array(
        'labels' => array(
            'name' => __('Reviews', 'whiteoak'),
            'singular_name' => __('Review', 'whiteoak'),
            'add_new' => __('Add New', 'whiteoak'),
            'add_new_item' => __('Add New Review', 'whiteoak'),
            'edit' => __('Edit', 'whiteoak'),
            'edit_item' => __('Edit Review', 'whiteoak'),
            'new_item' => __('New Review', 'whiteoak'),
            'view' => __('View Review', 'whiteoak'),
            'view_item' => __('View Review', 'whiteoak'),
            'search_items' => __('Search Review', 'whiteoak'),
            'not_found' => __('No Review found', 'whiteoak'),
            'not_found_in_trash' => __('No Review found in Trash', 'whiteoak')
        ),
        'menu_icon' => 'dashicons-testimonial',
        'exclude_from_search' => false,
        'public' => true,
        'query_var' => true,
        'hierarchical' => true,
        'has_archive' => true,
        'rewrite' => array( 'slug' => 'review', 'with_front' => true, 'hierarchical' => true),
        'supports' => array( 'title' ), // ADD PAGE-ATTRIBUTES TO ENABLE MENU_ORDER WHICH ALLOWS BACKE-END SORTING
        'can_export' => true,
        'taxonomies' => array('group')
    ));
}
add_action('init', 'create_post_type_review'); // ADD OUR "review" CUSTOM POST TYPE


////////////////////////////////////////////////////////////////////
// REMOVE UNECESSARY YOAST META BOXES AND FIELDS FROM REVIEWS
////////////////////////////////////////////////////////////////////

// PEACE OUT WORKSHOP
function remove_yoast_metabox_review(){
    remove_meta_box('wpseo_meta', 'review', 'normal');
}
add_action( 'add_meta_boxes', 'remove_yoast_metabox_review',11 );


?>