<?php

/**
* Header Partial
*
* This file controls the Main Header display
*
* @package  Partials
*
*/

// Include Mobile Navigation Partial
get_template_part('partials/template-part', 'mobilenav-mmenu');

?>
<div id="site-content">

    <header id="header-container" role="banner">
        <div id="header-container-content" class="container d-flex align-center justify-content-between">
            <div id="logo" class="d-none d-lg-block">
                <a href="<?php echo esc_url(home_url('/')); ?>">

                    <?php

                    if (function_exists('get_field')) {

                        //--------------------------
                        // Site Logo
                        //--------------------------

                        $logo = get_field('site_logo', 'option');

                        // Helper function to process SVGs
                        msp_acf_svg_helper($logo);
                    }

                    ?>

                </a>
            </div>
            <!--#logo-->

            <?php get_template_part('partials/template-part', 'desktop-nav'); // Desktop Navigation?>
        </div>
    </header>
    <!--#header-container-->