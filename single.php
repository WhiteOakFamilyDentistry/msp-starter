<?php

/**
 *
 * Single Post Template
 * Contols the single post view.
 *
 */

get_header();
get_template_part('partials/template-part', 'head');

echo '<article class="single-post-article">';
echo '<section class="container-xxl single-post">';

// WordPress Loop
if (have_posts()) : while (have_posts()) : the_post();

    // Post content
    echo '<section class="post-content">';
    the_content();
    echo '</section>';

endwhile;
else :
    get_404_template();
endif; // End WordPress Loop

echo '</section>';
echo '</article>';

get_footer();