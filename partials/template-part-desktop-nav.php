<?php

/**
* Desktop Navigation Partial
*
* This file controls the Desktop Navigation
*
* @package  Partials
*
*/

if (has_nav_menu('desktop_menu')) : ?>

<nav id="desktop-navigation" class="d-none d-lg-block navbar navbar-expand-lg desktop-nav" role="navigation">

    <?php

        //-------------------------------
        // Register Desktop Navigation
        //-------------------------------

            wp_nav_menu(
                array(
                'theme_location'    => 'desktop_menu',
                'depth'             => 2,
                'menu_class'        => 'navbar-nav',
                'fallback_cb'       => '__return_false',
                'walker'            => new bootstrap_5_wp_nav_menu_walker()
                )
            );

        ?>
</nav>

<?php endif; ?>