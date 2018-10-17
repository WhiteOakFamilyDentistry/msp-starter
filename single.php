<?php get_header(); ?>
<?php get_template_part('partials/template-part', 'head'); ?>
<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );?>
<article id="category-page">
    <section id="hero" class="inner-page <?php the_field('header_class') ;?>" style="background: url('<?php echo $thumb['0'];?>') 50% 50%; background-size: cover;">
        <header>
            <h1><?php the_title(); ?></h1>
        </header>
    </section>
    <section class="container single-blog">
        <div class="row">
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <header>
                <h2><?php the_field('sub_heading') ;?></h2>
                <h3 class="postmeta">Posted on <span class="date"><?php the_date(); ?></span> by <span class="author"><?php the_author(); ?> </a> in <span class="category"><?php the_category(', '); ?></span></h3>
            </header>
            <div class="article">
                <div>
                    <?php the_content(); ?>
                </div>
            </div>
        </div>
        <!--BEGIN .author-bio-->
        <div class="row author-bio">
            <div class="col-md-3">
                <?php echo get_avatar( get_the_author_meta('user_email'), $size = 'full'); ?>
            </div>
            <div class="col-md-9">
                <div class="author-info">
                   <h3 class="author-title">Written by <?php the_author_link(); ?></h3>
                   <p class="author-description"><?php the_author_meta('description'); ?></p>
               </div>
           </div>
           <!--END .author-bio-->
        </div>
        <?php endwhile; ?>
        <?php else: ?>
            <?php get_404_template(); ?>
        <?php endif; ?>
    </section><!--.container-->
</article>
<?php get_footer(); ?>