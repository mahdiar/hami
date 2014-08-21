<section id="head" >
	<div class="shell">
	
		<div class="pagination">
			<a href="#" class="swiper-next"></a>
			<a href="#" class="swiper-prev"></a>
	    </div>
	
		<div class="swiper-container">
		
		<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/_theme_styles/idangerous.swiper.css">
		
			 <div class="swiper-wrapper"><?php
		    
		    	$featured = new ATCF_Campaign_Query( array( 
					'posts_per_page' => -1,
					'meta_query'     => array(
						array(
							'key'     => '_campaign_featured',
							'value'   => 1,
							'compare' => '=',
							'type'    => 'numeric'
						)
					)
				));
				
				$category_postcount = $featured->post_count;
				
				if ($category_postcount):
			
					while ( $featured->have_posts() ) : $featured->the_post();
					
						echo '<div class="swiper-slide">';
						$campaign = new ATCF_Campaign( $post->ID );
						get_template_part( 'content', 'campaign' );
						echo '</div>';
						
					endwhile;
					
				endif;
				
				wp_reset_query();
		    
		    ?></div>
		</div>
		<script src="<?php echo get_template_directory_uri(); ?>/js/idangerous.swiper-2.1.min.js"></script>
		</div>
		
	</div>
</section>