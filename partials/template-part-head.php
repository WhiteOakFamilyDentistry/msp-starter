<section id="mobile-slideout" class="hidden-lg hidden-md">
    <?php get_template_part('partials/template-part', 'mobilenav-mmenu'); ?>
</section>
<section id="header-container">
    <div class="container">
        <div class="col-md-3">
            <div id="logo">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo get_theme_mod('main_logo'); ?>" alt="<?php bloginfo('name'); ?>" /></a>
            </div><!--#logo-->
        </div>
        <div class="col-md-9">
            <div id="header-widget">
                <?php get_template_part('partials/template-part', 'desktop-nav'); ?>
            </div><!-- #header-widget -->
        </div><!--.col-md-9-->
    </div><!--.container-->
</section><!--#header-container-->