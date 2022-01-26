<?php

/**
 *
 * The Blogroll
 *
 */


get_header();

get_template_part('partials/template-part', 'head');

echo '<section id="blogroll-container">';

// Breadcrumbs
echo '<div class="container-xxl">';
msp_breadcrumb();
echo '</div>';

// Add for pagination
$paged = (get_query_var('paged')) ? absint(get_query_var('paged')) : 1;

// Specify Posts in the query
$args = array(
    'post_type' => 'post',
    'paged' => $paged
);
$post_query = new WP_Query($args);

// Custom Posts loop
if ($post_query->have_posts()) : while ($post_query->have_posts()) : $post_query->the_post();

    // Default thumbnail when none is set in Theme Options
    $defaultOG = get_template_directory_uri() . '/assets/images/default-thumb.jpg';
    $default = wp_normalize_path($defaultOG);

    // Default thumbnail Selected in Theme Options
    $acfThumb = get_field('default_blog_thumbnail', 'option');

    // Featured image for post
    $thumb = get_the_post_thumbnail_url($post->ID, 'thumbnail');

    echo '<section class="post-excerpt container-xxl">';

    // Thumbnail
    echo '<div class="thumb-container me-3">';

    // Thumbnail Logic
    if ($thumb) {
        echo '<img src="' .$thumb. '">';
    } elseif ($acfThumb) {
        echo wp_get_attachment_image($acfThumb, 'thumbnail');
    } elseif ($default) {
        echo '<img src="' .$default. '">';
    }

    echo '</div>'; // .thumb-container

    // Excerpt & Header
    echo '<div class="excerpt-container">';
    echo '<header>';
    echo '<h2><a href="' .get_permalink($post->ID) . '" alt="' .get_the_title(). '">' .get_the_title(). '</a></h2>';
    echo '</header>';
    msp_excerpt(20);
    echo '</div>';
    echo '</section>';
    
endwhile;

msp_theme_pagination(); // Pagination

else:

get_404_template();

endif;

echo '</section>'; // #blogroll-container

get_footer();