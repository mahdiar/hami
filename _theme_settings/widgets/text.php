<?php

// Text Widget with Icon
// ----------------------------------------------------
class ThemeWidgetTextWidget extends ThemeWidgetBase {
	/*
	* Register widget function. Must have the same name as the class
	*/
	function ThemeWidgetTextWidget() {
		$widget_opts = array(
			'classname' => 'theme-widget-text-widget', // class of the <li> holder
			'description' => __( 'Displays a text widget.','crowdpress') );
		// Additional control options. Width specifies to what width should the widget expand when opened
		$control_ops = array(
			//'width' => 350,
		);
		// widget id, widget display title, widget options
		$this->WP_Widget('theme-widget-text-widget', __('[CROWDPRESS] Text Widget','crowdpress'), $widget_opts, $control_ops);
		$this->custom_fields = array(
			array(
				'name'=>'title',
				'type'=>'text',
				'title'=>__('Title','crowdpress'), 
				'default'=>__('Widget Title','crowdpress')
			),
			array(
				'name'=>'text',
				'type'=>'textarea',
				'title'=>__('Widget Text','crowdpress'), 
				'default'=>''
			),
			array(
				'name'=>'button_link',
				'type'=>'text',
				'title'=>__('Button Link (optional)','crowdpress'), 
				'default'=>false
			),
			array(
				'name'=>'button_text',
				'type'=>'text',
				'title'=>__('Button Text (optional)','crowdpress'), 
				'default'=>false
			),
		);
	}
	
	/*
	* Called when rendering the widget in the front-end
	*/
	function front_end($args, $instance) {
		extract($args);
		
		$title = $instance['title'];
		$text = $instance['text'];
		$button_link = $instance['button_link'];
		$button_text = $instance['button_text']; ?>
		
		<div class="text-widget">
			<?php echo $before_title . $title . $after_title; ?>
			<?php echo wpautop(do_shortcode($text)); ?>
			<?php if ($button_link && $button_text){
				echo '<a href="'.$button_link.'" class="button-small white">'.$button_text.'</a>';
			} ?>
		</div>
			
	<?php }
}

?>