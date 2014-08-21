<?php

global $post;
$campaign_grid_text = get_post_meta($post->ID, '_campaign_grid_text', true);    

$featured = new ATCF_Campaign_Query( array( 
	'posts_per_page' => 50,
));

$category_postcount = $featured->post_count;

if ($category_postcount):

	echo '<div id="campaign-grid"><div class="grid-wrapper">';
	$thumbs = 0;

	do {
	
		while ( $featured->have_posts() ) : $featured->the_post();
		
			?><div class="image">
				<a href="<?php the_permalink(); ?>">
				<?php if (has_post_thumbnail($post->ID)):
					the_post_thumbnail( 'campaign-thumb' );
					$thumbs++;
				endif; ?>
				</a>
			</div><?php
			
		endwhile;

	} while ($thumbs < 30);
	
	echo '</div>';
	if ($campaign_grid_text){
		echo '<h1>'.$campaign_grid_text.'</h1>';
	}
	echo '</div>';
	
endif;

wp_reset_query();