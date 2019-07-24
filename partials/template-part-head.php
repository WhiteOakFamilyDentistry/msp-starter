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

<header id="header-container" class="d-flex justify-content-between" role="banner">

    <div id="logo" class="d-none d-lg-block">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>">

        <?php

        //=============================
        // THEME LOGO
        //=============================


        // Logo Vars
        $logo = get_field( 'svg_logo_upload', 'option' ); // SVG Logo
        $tlogo = get_field( 'traditional_logo_desktop', 'option' ); // Old School Logo

        if( $logo ) {

          /**
          * If SVG logo is present use file_get_contents
          * to return SVG code inline
          */


          $svg = file_get_contents( $logo );
          echo $svg;


        } else { /* Otherwise use traditional logo file type */ ?>

          <img src="<?php esc_attr_e( $tlogo['url'] ); ?>" alt="<?php esc_attr_e( $tlogo['title'] ); ?>" />

        <?php } ?>

        <p>Boogers</p>

      </a>
    </div><!--#logo-->

    <?php get_template_part('partials/template-part', 'desktop-nav'); // Desktop Navigation ?>


</header><!--#header-container-->