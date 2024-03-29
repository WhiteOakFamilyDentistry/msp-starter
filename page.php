<?php

/**
 *
 * Standard Page with a container
 * (max-width: 1320px)
 *
 */

get_header();
get_template_part('partials/template-part', 'head');
if (have_posts()) : while (have_posts()) : the_post(); {
    echo '<main class="msp-content-container">';
    echo '<article>';
    echo '<section class="msp-content container-xxl p-5">';
    msp_breadcrumb();
    the_content();
    echo '</section>';
    echo '<article>';
    echo '</main>';
}
endwhile; else:
get_404_template();
endif;
// End WordPress Loop
get_footer();