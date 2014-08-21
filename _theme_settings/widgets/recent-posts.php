<?php

// Recent Posts
// ----------------------------------------------------
class ThemeWidgetRecentPosts extends ThemeWidgetBase {
	
	/*
	* Register widget function. Must have the same name as the class
	*/
	function ThemeWidgetRecentPosts() {
		$widget_opts = array(
			'classname' => 'theme-widget-recent-posts', // class of the <li> holder
			'description' => __( 'Displays recent posts in a custom style.','crowdpress' ) // description shown in the widget list
		);
		// Additional control options. Width specifies to what width should the widget expand when opened
		$control_ops = array(
			//'width' => 350,
		);
		// widget id, widget display title, widget options
		$this->WP_Widget('theme-widget-recent-posts', __('[CROWDPRESS] Recent Posts','crowdpress'), $widget_opts, $control_ops);
		$this->custom_fields = array(
			array(
				'name'=>'title',
				'type'=>'text',
				'title'=>'Title', 
				'default'=>__('Recent Posts','crowdpress')
			),
			array(
				'name'=>'categories',
				'type'=>'multiCategories',
				'title'=>__('Select Categories','crowdpress'),
				'default'=>''
			),
			array(
				'name'=>'load',
				'type'=>'integer',
				'title'=>__('How many total items?','crowdpress'), 
				'default'=>'10'
			),
			array(
				'name'=>'show',
				'type'=>'integer',
				'title'=>__('How many visible items?','crowdpress'), 
				'default'=>'3'
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
				'name'=>'hide_thumbs',
				'type'=>'set',
				'title'=>'Hide thumbnails?', 
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
		
		$limit = intval($instance['load']);
		$title = $instance['title'];
		$categories = $instance['categories'];
		if ($categories) { $categories = implode(",",$categories); }
		
		$button_text = $instance['button_text'];
		$button_url = $instance['button_url'];
		$hide_thumbnails = $instance['hide_thumbs'];
		$hide_thumbnails = $hide_thumbnails[0];
		$new_window = $instance['new_window'];
		$scrollable_list = $instance['scrollable_list'];
		$show = $instance['show'];
		if ($scrollable_list || $button_url || $button_text) { $load = $show; }
		
		$current_sidebar = $args['id'];
		if ($current_sidebar == 'homepage-horizontal-blocks') { $is_horizontal = true; } else { $is_horizontal = false; }
		
		query_posts(array('posts_per_page'=>$limit, 'cat'=>$categories));
		if ( have_posts() ) : ?>
		
			<div class="recent" rel="<?php echo intval($show); ?>">
				<?php echo $before_title.$title.$after_title; ?>

				<?php if ($button_url || $button_text || !$scrollable_list){
				
					if ($button_url || $button_text) {
				
						?><a href="<?php echo $button_url; ?>"<?php if ($new_window){ ?>target="_blank"<?php } ?> class="widget-button"><?php echo $button_text; ?></a><?php
				
					}	
						
				} else {
				
					?><span class="prev"></span>
					<span class="next"></span><?php
				
				} ?>

				<ul>
				
				<?php $temp_counter = 0;
				while ( have_posts() ) : the_post(); global $post; $temp_counter++; ?>
				
					<li>
						<?php include(locate_template('widget-post-block.php')); ?>
					</li>
					
				<?php endwhile
				?></ul></div><?php
						
		endif; wp_reset_query();
		
	}
}

?>