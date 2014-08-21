<section id="head" >
	<div class="shell">
		<div class="pull-col">
			<div class="col col2">
				<ul class="slider" id="bb-bookblock">
				
					<?php
					
					$categories = get_terms( 'download_category', array( 'hide_empty' => 1 ) );
					
					foreach ( $categories as $category ) :
					
						$featured = new ATCF_Campaign_Query( array( 
							'posts_per_page' => -1,
							'meta_query'     => array(
								array(
									'key'     => '_campaign_featured',
									'value'   => 1,
									'compare' => '=',
									'type'    => 'numeric'
								)
							),
							'download_category' => $category->slug
						));
						
						$category_postcount = $featured->post_count;
						
						if ($category_postcount):
					
							while ( $featured->have_posts() ) : $featured->the_post();
							
								$campaign = new ATCF_Campaign( $post->ID );
							
								?><li class="bb-item" data-label="<?php echo $category->slug; ?>">
									<div class="holder">
									<header class="section-head">
										<h3><?php _e('Featured Project in','crowdpress'); ?> <?php echo $category->name; ?></h3>
										<p class="align-right"><a href="<?php echo get_term_link($category); ?>" class="view"><?php _e('View all','crowdpress'); ?> <?php echo $category_postcount.' '.$category->name; ?> <?php _e('projects','crowdpress'); ?></a></p>	
									</header>
		
									<article class="project project-big">
										<div class="image">
											<a href="<?php the_permalink(); ?>">
											<?php if (has_post_thumbnail($post->ID)):
												the_post_thumbnail( 'campaign-thumb' );
											else: ?>
												<img src="<?php echo $template_dir; ?>/_theme_styles/images/gray-project.jpg" alt="" />
											<?php endif; ?>
											</a>
											<?php if ($campaign->percent_completed(false) >= 100) { ?><div class="ribbon success"><?php _e('Successful','crowdpress'); ?></div><?php } else if (get_post_meta($post->ID,'_campaign_featured')) { ?><div class="ribbon featured"><?php _e('Staff Pick','crowdpress'); ?></div><?php } ?>
										</div>
										<div class="text">
											<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
											<p class="author"><?php _e('by','crowdpress'); ?> <?php the_author(); ?></p>
		
											<p><?php echo trunc(get_the_excerpt(),200); ?></p>
											<div class="progress progress-small"><span style="width:<?php echo ($campaign->percent_completed(false) > 100 ? 100 : $campaign->percent_completed(false)); ?>%"><?php echo $campaign->percent_completed(false); ?>%</span></div>
											
											<ul class="numbers">
												<li><strong><?php echo $campaign->percent_completed(false); ?>%</strong><?php _e('funded','crowdpress'); ?></li>
												<li><strong><?php echo $campaign->current_amount(); ?></strong><?php _e('pledged','crowdpress'); ?></li>
												<li><strong><?php echo $campaign->days_remaining(); ?> <?php echo _n( 'day', 'days', $campaign->days_remaining(), 'crowdpress' ); ?></strong><?php _e('to go','crowdpress'); ?></li>
											</ul>
										</div>
									</article>
									</div>
								</li><?php
								
								break;
							
							endwhile;
							
						endif;
					
					endforeach; ?>
					
				</ul>
			</div>
		</div>
		<div class="col col3 bookblock-nav">
			<nav>
				<ul>
				
					<?php $temp_count = 0; $categories = get_terms( 'download_category', array( 'hide_empty' => 1 ));
					foreach ( $categories as $category ) :
					
						$featured = new ATCF_Campaign_Query( array( 
							'posts_per_page' => -1,
							'meta_query'     => array(
								array(
									'key'     => '_campaign_featured',
									'value'   => 1,
									'compare' => '=',
									'type'    => 'numeric'
								)
							),
							'download_category' => $category->slug
						));
						
						$category_postcount = $featured->post_count;
						
						if ($category_postcount):
					
							while ( $featured->have_posts() ) : $featured->the_post();
							
								$temp_count++;
							
								?><li<?php if ($temp_count == 1): ?> class="bb-current"<?php endif; ?>><a href="#" data-label="<?php echo $category->slug; ?>"><?php echo $category->name; ?></a></li><?php
								
								
								break;
							
							endwhile;
							
						endif;
					
					endforeach; wp_reset_query(); ?>
					
				</ul>
			</nav>
		</div>
		<div class="cl">&nbsp;</div>
	</div>
</section>