<?php

/**
 *
 * Search Page
 * Controls the display of the search page.
 */

get_header();
get_template_part('partials/template-part', 'head');
if (have_posts()) : while (have_posts()) : the_post();
    echo '<section id="search-page" class="container-xxl p5">';
    the_content();
    echo '</section>';
    endwhile; else:
        get_404_template();
    endif;
get_footer();