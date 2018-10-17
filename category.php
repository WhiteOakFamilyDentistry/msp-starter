<?php get_header(); ?>
<?php get_template_part('partials/template-part', 'head'); ?>
<main>
    <article id="category-page">
        <section id="hero" class="inner inner-page">
            <header>
                <h1>Category: <?php single_cat_title( '', true ); ?></h1>
            </header>
        </section>
        <section class="container blog-post">
            <?php if ( have_posts() ) : ?>
                <div class="col-md-8">
                    <?php while ( have_posts() ) : the_post(); ?>
                        <div class="post clearfix">
                          <?php the_post_thumbnail(('featured'), array( 'class' => 'aligncenter' )); ?>
                          <h2><a href="<?php echo get_the_permalink(); ?>"> <?php echo get_the_title(); ?></a></h2>
                          <p class="postmeta">Posted on <span class="date"><?php echo get_the_date(); ?></span> by <span class="author"> <?php echo get_the_author(); ?></a> in <span class="category"><?php the_category(', '); ?></span></p>
                          <?php excerpt('150'); ?>
                      </div>
                  <?php endwhile; 
                  else: ?>
                    <p>Sorry, no posts matched your criteria.</p>
                <?php endif; ?>
            </div>
            <?php get_sidebar( 'blog' ); ?>
        </section><!--.container-->
    </article>
</main>
<?php get_footer(); ?>