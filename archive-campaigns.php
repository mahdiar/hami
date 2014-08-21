<?php get_header(); ?>

<div class="colored-line"></div>

<section id="main">
	<div class="shell">
	
		<header class="section-head">
			<h3><?php _e('Discover Projects','crowdpress'); ?>: <strong><?php single_cat_title(); ?></strong></h3>
			<div class="align-right"><?php get_search_form(); ?></div>
		</header>

		<div id="projects-masonry" class="cols clearfix">
		
			<?php $temp_count = 0; $total_count = 0; while ( have_posts() ) : the_post();
							
				$campaign = new ATCF_Campaign( $post->ID ); $temp_count++; $total_count++;
				
				?><div class="project-block col<?php if ($temp_count == 3): echo ' col-last'; $temp_count = 0; endif; ?>">
					<?php get_template_part('content','campaign'); ?>
				</div><?php
			
			endwhile; ?>
			
		</div>
		
		<?php js_get_pagination(); wp_reset_query(); ?>

	</div>
</section>

<?php get_footer(); ?>