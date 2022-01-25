<?php

/**
* Homepage Template
*
* This file controls the display of the
* site's homepage.
*
* @package Templates
*
*/

get_header();
get_template_part('partials/template-part', 'head');

// Basic WordPress Loop.  Nothing to see here.
if (have_posts()) : while (have_posts()) : the_post(); ?>

<main id="homepage">

    <?php the_content(); ?>

</main>

<?php

endwhile; endif; // End Loop

get_footer(); // Grab Footer

?>