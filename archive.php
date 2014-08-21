<?php get_header(); ?>

<div class="colored-line"></div>

<section id="main">
	<div class="shell shell-inner-page">
		<div class="container clearfix left">
			<section id="content" <?php post_class('left'); ?>>
				<article class="entry">
					<section>
					
						<?php js_breadcrumbs($post->ID); ?>
						
						<h1><?php $post = $posts[0];
							if (is_home()):
								echo get_the_title( get_option('page_for_posts', true) );
							elseif (is_category()):
								single_cat_title();
							elseif(is_tag()) :
								_e('Tagged','crowdpress'); ?>: &ldquo;<?php single_tag_title(); ?>&rdquo;<?php
							elseif (is_day()) :
								_e('Archive for','crowdpress'); echo ' '; the_time('F jS, Y');
							elseif (is_month()) :
								_e('Archive for','crowdpress'); echo ' '; the_time('F, Y');
							elseif (is_year()) :
								_e('Archive for','crowdpress'); echo ' '; the_time('Y');
							elseif (is_author()) :
								_e('Author Archive','crowdpress');
							else :
								_e('Archives','crowdpress');
							endif; ?>
						</h1>
						
						<br />
						
						<?php if ( have_posts() ) : ?>
						
							<?php while (have_posts()) : the_post(); ?>
									
								<?php get_template_part('single-post-block'); ?>
					
							<?php endwhile; ?>
							
						<?php endif; ?>
						
						<?php js_get_pagination(); wp_reset_query(); ?>
							
					</section>
				</article>

			</section>
			<aside class="right">
				<?php get_sidebar(); ?>
			</aside>
			<div class="cl"></div>
			
		</div>
	</div>
</section>
	
<?php get_footer(); ?>