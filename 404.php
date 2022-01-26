<?php

/**
 *
 * 404 Page
 * Controls the display of the 404 page
 *
 */

get_header();
get_template_part('partials/template-part', 'head'); ?>

<main>
    <article id="not-found">
        <section id="hero" class="inner inner-page">
            <header>
                <h1>Error</h1>
                <h2>Page Not Found</h2>
            </header>
        </section>
        <section id="inner-content" class="not-found">
            <div class="container-xxl centered">
                <h3></h3>
                <a href="<?php echo esc_url(home_url('/')); ?>"><i class="fa fa-home" aria-hidden="true"></i> Back to
                    Home</a>
            </div>
        </section>
    </article>
</main>
<?php get_footer(); ?>