<?php
/**
 * Template Name: Inner Page
**/
?>
<?php get_header(); ?>
<?php get_template_part('partials/template-part', 'head'); ?>
<main id="inner-page">
	<article>
		<section id="hero" class="<?php the_field('hero_image') ;?>">
			<header>
				<h1><?php the_field('h1_tag') ;?></h1>
				<?php if( get_field( "h2_tag" ) ): ?>
					<h2><?php the_field('h2_tag') ;?></h2>
				<?php endif; ?>
			</header>
		</section>
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<section id="main-content">
				<article class="container">
					<h2 class="breadcrumb"><?php get_breadcrumb(); ?></h2>
					<div id="side-stuff" class="col-md-4 col-md-push-8">
						<?php if( get_field( "sidebar_image" ) ): ?>
							<img src="<?php the_field('sidebar_image'); ?>" class="aligncenter border"/>
						<?php endif; ?>
						<?php if ( is_active_sidebar( 'inner-sidebar' ) ) : ?>
							<div id="inner-sidebar" class="primary-sidebar widget-area" role="complementary">
								<?php dynamic_sidebar( 'inner-sidebar' ); ?>
							</div><!-- #inner-sidebar -->
						<?php endif; ?>
						<?php wp_reset_query(); ?>
					</div>
					<div id="inner-content" class="col-md-8 col-md-pull-4">
						<?php the_content(); ?>
					<?php endwhile; ?>
					<?php else: ?>
						<?php get_404_template(); ?>
					<?php endif; ?>
				</div>
			</article><!-- .container -->
		</section>
	</article>
</main>
<?php get_footer(); ?>