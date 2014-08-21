<?php

// Recent Posts
// ----------------------------------------------------
class ThemeWidgetFacebookFeed extends ThemeWidgetBase {
	
	/*
	* Register widget function. Must have the same name as the class
	*/
	function ThemeWidgetFacebookFeed() {
		$widget_opts = array(
			'classname' => 'theme-widget-facebook-feed', // class of the <li> holder
			'description' => __( 'Displays the Facebook Feed from a user or page.','crowdpress' ) // description shown in the widget list
		);
		// Additional control options. Width specifies to what width should the widget expand when opened
		$control_ops = array(
			//'width' => 350,
		);
		// widget id, widget display title, widget options
		$this->WP_Widget('theme-widget-facebook-feed', __('[CROWDPRESS] Facebook Feed','crowdpress'), $widget_opts, $control_ops);
		$this->custom_fields = array(
			array(
				'name'=>'title',
				'type'=>'text',
				'title'=>'Title', 
				'default'=>__('Facebook Feed','crowdpress')
			),
			array(
				'name'=>'facebook_id',
				'type'=>'text',
				'title'=>'Facebook Page ID (that long number)', 
				'default'=>''
			),
			array(
				'name'=>'load',
				'type'=>'integer',
				'title'=>__('How many total items?','crowdpress'), 
				'default'=>'15'
			),
			array(
				'name'=>'show',
				'type'=>'integer',
				'title'=>__('How many visible items?','crowdpress'), 
				'default'=>'4'
			),
			array(
				'name'=>'button_text',
				'type'=>'text',
				'title'=>'Button Text (optional)', 
				'default'=>''
			),
			array(
				'name'=>'button_url',
				'type'=>'text',
				'title'=>'Button URL (optional)', 
				'default'=>''
			),
			array(
				'name'=>'new_window',
				'type'=>'set',
				'title'=>'Open button URL in a new window?', 
				'default'=>'',
				'options'=>array(true=>'Yes')
			),
			array(
				'name'=>'scrollable_list',
				'type'=>'set',
				'title'=>'Scrollable List', 
				'default'=>true,
				'options'=>array(true=>'Yes')
			)
		);
	}
	
	/*
	* Called when rendering the widget in the front-end
	*/
	function front_end($args, $instance) {
	
		extract($args);
		
		$load = intval($instance['load']);
		$title = $instance['title'];
		$facebook_id = $instance['facebook_id'];
		$button_text = $instance['button_text'];
		$button_url = $instance['button_url'];
		$new_window = $instance['new_window'];
		$scrollable_list = $instance['scrollable_list'];
		$show = $instance['show'];
		if (!$scrollable_list || $button_url || $button_text) { $load = $show; }
		$random_number = rand(100,999);
		
		?><div class="facebook-widget" rel="<?php echo intval($show); ?>"><?php
			
			echo $before_title.$title.$after_title; ?>
			
			<?php if ($button_url || $button_text || !$scrollable_list){
				
				if ($button_url || $button_text) {
			
					?><a href="<?php echo $button_url; ?>"<?php if ($new_window){ ?>target="_blank"<?php } ?> class="widget-button"><?php echo $button_text; ?></a><?php
			
				}	
					
			} else {
			
				?><span class="prev"></span>
				<span class="next"></span><?php
			
			} ?>
			
			<ul>
				<?php
				global $fb;
				$statuses = get_transient('facebook_statuses_cache');
				
				if ($fb) {
					
					if (!$statuses) {
						$statuses = $fb->api('/' . $facebook_id . '/feed', array( 'limit' => $load, 'type' => 'message' ));
						set_transient('facebook_statuses_cache', $statuses, 900);
					}
					if (!empty($statuses['data'])) {
						$temp_count = 0;
						foreach ($statuses['data'] as $s): $temp_count++;
							if ($temp_count <= $load){
							
								if ($s['type'] == 'photo'){
								
									if (isset($s['message'])){
										$message = $s['message'];
									} else {
										$message = $s['story'];
									}
									?>
									<li>
										<span class="tweet_text"><em><?php echo makeClickableLinks(js_char_shortalize($message)); ?></em><?php echo '<br /><strong><a href="'.$s['link'].'">View photo</a></strong>'; ?></span>
										<span class="tweet_time"><a href="http://facebook.com/<?php echo $s['id']; ?>">about <?php echo getRelativeTime($s['created_time'],true); ?></a></span>
									</li>
									<?php
									
								
								} else {
									
									if (isset($s['message'])){
										$message = $s['message'];
									} else {
										$message = $s['story'];
									}
							
									?>
									<li>
										<span class="tweet_text"><?php echo makeClickableLinks(js_char_shortalize($message)); ?><?php if ($s['type'] == 'link'){ echo '<br /><a href="'.$s['link'].'">Click to view link</a>'; } ?></span>
										<span class="tweet_time"><a target="_blank" href="http://facebook.com/<?php echo $s['id']; ?>">about <?php echo getRelativeTime($s['created_time'],true); ?> &mdash; View on Facebook</a></span>
									</li>
									<?php
								
								}
								
							} else {
								break;
							}
						endforeach;
					}
					
				} else {
				
					echo '<li><span class="tweet_text">You need to set your Facebook credentials in the Theme Options panel.</span></li>';
				
				}
				?>
			</ul>
		
		</div><?php
		
	}
}

?>