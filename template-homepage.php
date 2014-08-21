<?php

// Featured Projects

$featured_campaigns_style = get_post_meta($post->ID, '_featured_campaigns_style', true);

if (isset($featured_campaigns_style) && $featured_campaigns_style):

	global $post;
	get_template_part('homepage-campaigns', $featured_campaigns_style);

endif;

// Homepage "page" content
if (get_the_content()){ ?>

<section id="main">
	<div class="shell shell-inner-page" style="padding-bottom:0;">
		<div class="container clearfix">
			<section id="content">
				<article class="entry">
					<?php the_content(); ?>
				</article>
			</section>
		</div>
	</div>
</section><?php

}

// Latest Projects
		
$projects_total = get_post_meta($post->ID, '_projects_count', true);	
$projects_sortby = get_post_meta($post->ID, '_projects_sortby', true);
$projects_title = get_post_meta($post->ID, '_projects_title', true);

if (isset($hide_featured_projects) && $hide_featured_projects && $projects_total):
	echo '<div class="colored-line"></div>';
endif;

if ($projects_total): ?>

	<section id="main">
		<div class="shell">
		
			<?php if ($projects_sortby == 'date_newest'){
				$orderby = 'date';
				$order = 'desc';
			} else if ($projects_sortby == 'date_oldest'){
				$orderby = 'date';
				$order = 'asc';
			} else {
				$orderby = 'rand';
				$order = 'desc';
			}
			
			$featured = new ATCF_Campaign_Query( array( 
				'posts_per_page' => -1,
				'orderby' => $orderby,
				'order' => $order
			));
			
			$temp_count = 0; $total_count = 0; $campaign_postcount = $featured->post_count; ?>
	
			<header class="section-head">
				<h3><?php echo ($projects_title ? $projects_title : 'The Latest Projects'); ?></h3>
				<p class="align-right"><a href="<?php echo home_url(); ?>/campaigns/" class="view"><?php _e('View all','crowdpress'); ?> <?php echo $campaign_postcount; ?> <?php _e('projects','crowdpress'); ?></a></p>
			</header>
	
			<div id="projects-masonry" class="cols clearfix">
			
				<?php while ( $featured->have_posts() ) : $featured->the_post();
								
					$campaign = new ATCF_Campaign( $post->ID ); $temp_count++; $total_count++;
					
					?><div class="project-block col<?php if ($temp_count == 3): echo ' col-last'; $temp_count = 0; endif; ?>">
						<?php get_template_part('content','campaign'); ?>
					</div><?php
					
					if ($total_count == $projects_total): break; endif;
				
				endwhile; ?>
				
			</div>
		</div>
	</section>
	
<?php endif; ?>