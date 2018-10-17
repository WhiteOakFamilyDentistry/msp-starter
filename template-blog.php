<?php
/**
 * Template Name: Blog Template
**/
?>
<?php get_header(); ?>
<?php get_template_part('partials/template-part', 'head'); ?>
<main id="blog-page">
    <article>
        <section id="hero" class="inner inner-page">
            <header>
                <h1></h1>
                <h2></h2>
            </header>
        </section>
        <section class="container blog-post">
            <div class="col-md-8">
                <?php
                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                $args = array( 'posts_per_page' =>get_theme_mod('post_count'), 'order'=> 'DESC', 'paged' => $paged );
                $postslist = new WP_Query( $args );
                if ( $postslist->have_posts() ) :
                    while ( $postslist->have_posts() ) : $postslist->the_post();
                        ?>
                        <?php
                        $category = get_the_category(); 
                        if($category[0]){
                        }
                        ?>
                        <div class="post clearfix">
                          <?php the_post_thumbnail(('featured'), array( 'class' => 'aligncenter' )); ?>
                          <h2><a href="<?php echo get_the_permalink(); ?>"> <?php echo get_the_title(); ?></a></h2>
                          <p class="postmeta">Posted on <span class="date"><?php echo get_the_date(); ?></span> by <span class="author"> <?php echo get_the_author(); ?></a> in <span class="category"><?php the_category(', '); ?></span></p>
                          <?php excerpt('150'); ?>
                      </div>
                  <?php endwhile; ?>
                  <?php awesome_theme_pagination(); ?>
                  <?php wp_reset_postdata();
              endif;
              ?>
          </div><!--.blog-contain-->
          <?php get_sidebar('blog'); ?>
      </section><!--.container-->
  </article>
</main>
<?php get_footer(); ?>