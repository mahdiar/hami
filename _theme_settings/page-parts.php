<?php

// Event Countdown
function page_part_countdown($post_id,$include_hr = false, $bottom = false){
	
	$countdown_type = get_post_meta($post_id, '_countdown_type',true);

	if (isset($countdown_type) && $countdown_type):
	
		?>
		<div id="countdown"<?php if ($bottom): echo ' style="margin-bottom:-40px;"'; endif; ?>>
		
			<?php // Event Countdown Settings
			$featured_event = (get_post_meta($post_id, '_countdown_type',true) ? get_post_meta($post_id, '_countdown_type',true) : false);
			$countdown_order = (get_post_meta($post_id, '_countdown_order',true) ? get_post_meta($post_id, '_countdown_order',true) : false);
			$countdown_pretext = (get_post_meta($post_id, '_countdown_pretext',true) && get_post_meta($post_id, '_countdown_pretext',true) ? get_post_meta($post_id, '_countdown_pretext',true) : false);
			
			if ($featured_event && $featured_event != 'next'):
			
				$event = featured_event($featured_event);
				
				if (!empty($event)) { ?>
				
					<a href="#" id="countdown_link" onclick="jQuery.aecDialog({'id':<?php echo $event['id']; ?>,'start':'<?php echo $event['start']; ?>','end':'<?php echo $event['end']; ?>'}); return false;">
						<div class="shell">
						
							<?php $event_countdown = ($countdown_pretext == 'DEFAULT' ? __('Featured Event in','crowdpress').' ' : ($countdown_pretext ? $countdown_pretext.' ' : '')).'<span>'.date('F j, Y G i Z',strtotime($event['start'])).'</span>';
							$event_title = stripslashes($event['title']); ?>
							
							<?php if ($countdown_order == 'flipped'){ ?>
								<h4><?php echo $event_title ?></h4>
								<h2 class="countdown"><?php echo $event_countdown ?></h2>
							<?php } else { ?>
								<h4 class="countdown"><?php echo $event_countdown ?></h4>
								<h2><?php echo $event_title ?></h2>
							<?php } ?>
							<span class="arrow"></span>
					
						</div>
					</a>
				
				<?php } ?>
						
			<?php elseif ($featured_event == 'next') :
				
				$event = get_upcoming_events(); 
				
				if (!empty($event)) { ?>
				
					<a href="#" id="countdown_link" onclick="jQuery.aecDialog({'id':<?php echo $event->id; ?>,'start':'<?php echo $event->start; ?>','end':'<?php echo $event->end; ?>'}); return false;">
						<div class="shell">
						
							<?php $event_countdown = ($countdown_pretext == 'DEFAULT' ? __('Next Event in','crowdpress').' ' : ($countdown_pretext ? $countdown_pretext.' ' : '')).'<span>'.date('F j, Y G i Z',strtotime($event->start)).'</span>';
							$event_title = stripslashes($event->title); ?>
							
							<?php if ($countdown_order == 'flipped'){ ?>
								<h4><?php echo $event_title ?></h4>
								<h2 class="countdown"><?php echo $event_countdown ?></h2>
							<?php } else { ?>
								<h4 class="countdown"><?php echo $event_countdown ?></h4>
								<h2><?php echo $event_title ?></h2>
							<?php } ?>
							<span class="arrow"></span>
							
						</div>
					</a>
				
				<?php } ?>
			
			<?php endif; ?>
		
		</div>
		<?php

	endif;

}

// Page Content
function page_part_page($post_id,$include_hr = false, $bottom = false){

	global $sidebar_layout, $sidebar_choice;
	$content = get_the_content($post_id);
	if ($content):
		
		if ($sidebar_layout == 'no-sidebar'){
			$content_post_class = '';
		} else if ($sidebar_layout == 'left'){
			$content_post_class = 'right';
			$sidebar_post_class = 'left';
		} else if ($sidebar_layout == 'right'){
			$content_post_class = 'left';
			$sidebar_post_class = 'right';
		}
		?>
		
		<div class="shell">
		
			<?php
			
			if ($include_hr){ echo '<hr class="doubleline" />'; }
			$other_options = get_post_meta($post_id, '_page_options',true); ?>
		
			<article id="content" <?php post_class($content_post_class); ?>>
				<?php if (!in_array('hide_breadcrumbs',$other_options)): js_breadcrumbs($post_id); endif; ?>
				<?php if (!in_array('hide_title',$other_options)): ?><h1><?php the_title(); ?></h1><?php endif; ?>
				
				<?php the_content(); ?>
				<?php comments_template(); ?>
			</article>
			
			<?php if ($sidebar_layout != 'no-sidebar'){ ?>
				<section id="sidebar" class="<?php echo $sidebar_post_class; ?>">
					<?php dynamic_sidebar($sidebar_choice); ?>				
				</section>
				<div class="cl"></div>
			<?php } ?>
		
		</div>
		<?php
	
	endif;

}

// Page Widgets
function page_part_widgets($post_id,$include_hr = false, $bottom = false){

	global $widget_layout;

	if ($widget_layout != 'no-widgets'){ ?>
	
		<div class="shell"><?php
				
			if ($include_hr){ echo '<hr class="doubleline" />'; }
		
			$zone_1_widget = (get_post_meta($post_id, '_widget_block_1',true) ? get_post_meta($post_id, '_widget_block_1',true) : 1);
			$zone_2_widget = (get_post_meta($post_id, '_widget_block_2',true) ? get_post_meta($post_id, '_widget_block_2',true) : 2);
			$zone_3_widget = (get_post_meta($post_id, '_widget_block_3',true) ? get_post_meta($post_id, '_widget_block_3',true) : 3);
		
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
			
			echo '</div>';
			
		?></div><?php
		
	}
	
}

?>