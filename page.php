<?php get_header(); ?>
<?php get_template_part('partials/template-part', 'head'); ?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<main>
	<article>
		<section>
			<?php the_content(); ?>
		</section>
	</article>
</main>
<?php endwhile; else: ?>
  <?php get_404_template(); ?>
<?php endif; ?>
<!-- END WORDPRESS LOOP -->
<?php get_footer(); ?>