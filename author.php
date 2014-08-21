<?php

global $wp_query;
$author = $wp_query->get_queried_object();

get_header(); ?>

<section id="main">
	<div class="shell shell-inner-page">
		<div class="container clearfix">
			<section id="content">
				<article class="entry">
					<section>

						<div class="title title-two pattern-<?php echo rand(1,4); ?>">
							<div class="container">
								<h1><?php echo $author->display_name; ?></h1>
							</div>
							<!-- / container -->
						</div>
						<div id="content">
							<div class="container">
								<?php if ( '' != $author->user_description ) : ?>
								<div class="single-author-bio">
					
									<div class="author-bio big">
										<?php echo wpautop( $author->user_description ); ?>
									</div>
									
									<ul class="author-bio-links">
										<?php if ( '' != $author->user_url ) : ?>
										<li class="contact-link"><i class="icon-link"></i> <?php echo make_clickable( $author->user_url ); ?></li>
										<?php endif; ?>
					
										<?php
											$methods = _wp_get_user_contactmethods();
					
											foreach ( $methods as $key => $method ) :
												if ( '' == $author->$key )
													continue;
										?>
											<li class="contact-<?php echo $key; ?>"><i class="icon-<?php echo $key; ?>"></i> <?php echo make_clickable( $author->$key ); ?></li>
										<?php endforeach; ?>
									</ul>
					
								</div>
								<?php endif; ?>
							</div>
							<!-- / container -->
						</div>
					</section>
				</article>
								
				<?php
				
				$author_campaigns = new ATCF_Campaign_Query( array( 
					'posts_per_page' => -1,
					'author' => $author->ID
				));
				
				$temp_count = 0; $total_count = 0; $campaign_postcount = $author_campaigns->post_count; ?>
		
				<header class="section-head">
					<h3><?php echo $author->display_name; ?>'s <?php echo $campaign_postcount; ?> <?php _e('Campaigns','crowdpress'); ?></h3>
				</header>
		
				<div id="projects-masonry" class="cols clearfix">
				
					<?php while ( $author_campaigns->have_posts() ) : $author_campaigns->the_post();
									
						$campaign = new ATCF_Campaign( $post->ID ); $temp_count++; $total_count++;
						
						?><div class="project-block col<?php if ($temp_count == 3): echo ' col-last'; $temp_count = 0; endif; ?>">
							<?php get_template_part('content','campaign'); ?>
						</div><?php
						
						if ($total_count == $campaign_postcount): break; endif;
					
					endwhile; ?>
					
				</div>		
							
			</section>
		</div>
	</div>
</section>

<?php get_footer(); ?>