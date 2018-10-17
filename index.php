<?php get_header(); ?>
<?php get_template_part('partials/template-part', 'head'); ?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<?php the_content(); ?>
<?php endwhile; ?>
<?php else: ?>
	<?php get_404_template(); ?>
<?php endif; ?>
<?php get_footer(); ?>