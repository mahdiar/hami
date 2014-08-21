<?php get_header(); ?>

<div class="colored-line"></div>

<section id="main">
	<div class="shell shell-inner-page">
		<div class="container clearfix left">
			<section id="content" <?php post_class('left'); ?>>
				<article class="entry">
					<section>
					
						<?php js_breadcrumbs($post->ID); ?>
						<h1 class="bitter"><?php _e('Search Results','crowdpress'); ?></h1>
			
						<?php if ( have_posts() ) : ?>
						
							<?php while (have_posts()) : the_post(); ?>
									
								<?php get_template_part('single-post-block'); ?>
					
							<?php endwhile; ?>
							
						<?php endif; ?>
						
						<?php js_get_pagination(); wp_reset_query(); ?>
							
					</section>
				</article>

			</section>
			<aside class="<?php echo $sidebar_post_class; ?>">
				<?php get_sidebar(); ?>
			</aside>
			<div class="cl"></div>
			
		</div>
	</div>
</section>
	
<?php get_footer(); ?>