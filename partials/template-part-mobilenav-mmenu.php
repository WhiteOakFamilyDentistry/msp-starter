<?php if ( has_nav_menu( 'mobile_menu' ) ) : ?>
  <div class="hidden-sm hidden-md hidden-lg mobile-navigation">
    <div class="container">
      <div class="col-xs-2 slideout-contain">
        <a class="slideout-show" href="#mobile-menu">
          <span></span>
          <span></span>
          <span></span>
        </a>
      </div><!-- .col-xs-2 -->
      <div class="col-xs-10 mobile-logo">
        <h3>Mobile Logo Here.</h3>
      </div><!-- .col-xs-10 -->
    </div><!-- .container -->
    <nav id="mobile-menu">
      <?php
        wp_nav_menu( array(
          'theme_location'    => 'mobile_menu',
          'depth'             => 3,
          'menu_class'        => 'mmenu mmenu-horizontal'
          //'walker'            => new Walker_Nav_Menu())

          )
        );
      ?>
  </nav>
</div><!-- .mobile-navigation -->
<?php endif; ?>