<?php

get_header(); global $template_dir;
	
if (have_posts()) : while(have_posts()) : the_post();

	$header_image = get_post_meta($post->ID, '_header_image', true);
	$header_text = get_post_meta($post->ID, '_header_text', true);
	$header_parallax = get_post_meta($post->ID, '_header_image_parallax', true);
	
	if ($header_image):
	
		?><script><?php if ($header_parallax): ?>var parallax = true;<?php else : ?>var parallax = false;<?php endif; ?></script>

		<section id="banner" style="background-image:url('<?php echo home_url().'/wp-content/uploads/'.$header_image; ?>'); <?php if ($header_parallax){ ?>background-position:center -50px;<?php } ?>">
			<?php if ($header_text): ?>
			<div class="shell">
				<h2><?php echo $header_text; ?></h2>
			</div>
			<?php endif; ?>
		</section><?php
	
	else:
	
		echo '<div class="colored-line"></div>';
		
	endif;
	
	// Page Layout
	$page_layout = get_post_meta($post->ID, '_page_layout', true);
	$page_layout = $page_layout ? $page_layout[0] : 'default';
	$page_content = get_the_content($post->ID);
	
	// Sidebar Settings
	$sidebar_layout = get_post_meta($post->ID, '_sidebar_layout', true);
	$sidebar_layout = $sidebar_layout ? $sidebar_layout[0] : 'no-sidebar';
	$sidebar_choice = get_post_meta($post->ID, '_sidebar_choice', true);
	
	// Page Widgets
	$widget_layout = get_post_meta($post->ID, '_widget_layout', true);
	$widget_layout = $widget_layout ? $widget_layout[0] : 'no-widgets';
	
	get_template_part( 'template', $page_layout ); wp_reset_query();
	
	?>
	
	</div>
	
	<?php
	if ($widget_layout != 'no-widgets'){
		
	$boxed = of_get_option('js_body_boxed');
	if ($boxed == 'yes'): echo '<div class="boxed">'; endif;
	?>

	<div class="footer-widgets">
	<div class="shell"><?php
	
		$zone_1_widget = (get_post_meta($post->ID, '_widget_block_1',true) ? get_post_meta($post->ID, '_widget_block_1',true) : 1);
		$zone_2_widget = (get_post_meta($post->ID, '_widget_block_2',true) ? get_post_meta($post->ID, '_widget_block_2',true) : 2);
		$zone_3_widget = (get_post_meta($post->ID, '_widget_block_3',true) ? get_post_meta($post->ID, '_widget_block_3',true) : 3);
		$zone_4_widget = (get_post_meta($post->ID, '_widget_block_4',true) ? get_post_meta($post->ID, '_widget_block_4',true) : 4);
		
		echo '<div id="page-widgets">';
	
		switch ($widget_layout) {
		
			case 'one' :
			
				if (is_active_sidebar($zone_1_widget)){
					
					dynamic_sidebar($zone_1_widget);
					
				}
			
			break;
			
			case 'two' :
			
				if (is_active_sidebar($zone_1_widget) || is_active_sidebar($zone_2_widget)){
					
					echo '<div class="one_half">';
						dynamic_sidebar($zone_1_widget);
					echo '</div>';
					
					echo '<div class="one_half last">';
						dynamic_sidebar($zone_2_widget);
					echo '</div>';
					
				}
			
			break;
			
			case 'three' :
			
				if (is_active_sidebar($zone_1_widget) || is_active_sidebar($zone_2_widget) || is_active_sidebar($zone_3_widget)){
					
					echo '<div class="one_third">';
						dynamic_sidebar($zone_1_widget);
					echo '</div>';
					
					echo '<div class="one_third">';
						dynamic_sidebar($zone_2_widget);
					echo '</div>';
					
					echo '<div class="one_third last">';
						dynamic_sidebar($zone_3_widget);
					echo '</div>';
					
				}
			
			break;
			
			case 'four' :
			
				if (is_active_sidebar($zone_1_widget) || is_active_sidebar($zone_2_widget) || is_active_sidebar($zone_3_widget) || is_active_sidebar($zone_4_widget)){
					
					echo '<div class="one_fourth">';
						dynamic_sidebar($zone_1_widget);
					echo '</div>';
					
					echo '<div class="one_fourth">';
						dynamic_sidebar($zone_2_widget);
					echo '</div>';
					
					echo '<div class="one_fourth">';
						dynamic_sidebar($zone_3_widget);
					echo '</div>';
					
					echo '<div class="one_fourth last">';
						dynamic_sidebar($zone_4_widget);
					echo '</div>';
					
				}
			
			break;
			
			case 'onethird_twothird' :
			
				if (is_active_sidebar($zone_1_widget) || is_active_sidebar($zone_2_widget)){
					
					echo '<div class="one_third">';
						dynamic_sidebar($zone_1_widget);
					echo '</div>';
					
					echo '<div class="two_third last">';
						dynamic_sidebar($zone_2_widget);
					echo '</div>';
					
				}
			
			break;
			
			case 'twothird_onethird' :
			
				if (is_active_sidebar($zone_1_widget) || is_active_sidebar($zone_2_widget)){
					
					echo '<div class="two_third">';
						dynamic_sidebar($zone_1_widget);
					echo '</div>';
					
					echo '<div class="one_third last">';
						dynamic_sidebar($zone_2_widget);
					echo '</div>';
					
				}
			
			break;
			
		}
		
		echo '<div class="cl"></div></div>';
			
	?></div></div><?php
	
	if ($boxed): echo '</div>'; endif;
	
	}

endwhile; endif; ?>

<?php get_footer(); ?>