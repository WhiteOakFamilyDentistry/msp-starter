<?php

/**
* Mobile Navigation Partial
*
* This file controls the Mobile Navigation
*
* @package  Partials
*
*/

if (has_nav_menu('mobile_menu')) : ?>

<section id="mobile-navigation" class="d-md-none">

    <!-- Mobile Navbar -->
    <div id="mobile-navbar" class="d-flex justify-content-between">

        <!-- Mobile Logo -->

        <div id="mobile-logo">
            <a href="<?php echo esc_url(home_url('/')); ?>">
                <?php

                if (function_exists('get_field')) {

                    //--------------------------
                    // Site Logo
                    //--------------------------

                    $logo = get_field('site_logo', 'option');

                    // Helper function to process SVGs
                    mem_acf_svg_helper($logo);
                }

                ?>
            </a>
        </div>
        <!-- End Mobile Logo -->

        <!-- Hamburger Button -->
        <button id="mobile-toggler" type="button" role="button" aria-controls="navigation"
            aria-label="Mobile Navigation">
            <span class="sr-only">Open Menu</span>
            <a class="mburger mburger--collapse" aria-label="Open Mobile Menu">
                <b></b>
                <b></b>
                <b></b>
            </a>
        </button>
        <!-- End Hamburger Button -->

    </div><!-- #mobile-navbar -->

    <nav id="mobile-menu">

        <?php

      //--------------------------
      // Mobile Navigation
      //--------------------------

      wp_nav_menu(
          array(
            'theme_location'    => 'mobile_menu',
            'depth'             => 3
        )
      );

  ?>

    </nav>
</section><!-- #mobile-navigation -->
<?php endif; ?>