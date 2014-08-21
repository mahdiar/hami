<?php
/*
* Base Theme Widget Class. Extend this class when adding new widgets instead of WP_Widget.
* Handles updating, displaying the form in wp-admin and $before_widget/$after_widget
*/
class ThemeWidgetBase extends WP_Widget {
	// Should $before_widget and $after_widget be printed
	var $print_wrappers = true;
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		foreach ($this->custom_fields as $field) {
			if ($field['type'] == 'integer') {
				$instance[$field['name']] = intval($new_instance[$field['name']]);
			} else {
				$instance[$field['name']] = $new_instance[$field['name']];
			}
		}
		
		return $instance;
	}
 
	function form($instance) {
		$defaults = array();

		if( method_exists( $this, 'get_description' ) ) {
			echo wpautop( $this->get_description() );
		}
		
		if (!empty($this->custom_fields)){
			foreach ($this->custom_fields as $field) {
				$defaults[$field['name']] = $field['default'];
			}
			$instance = wp_parse_args( (array) $instance, $defaults);
			foreach ($this->custom_fields as $field) :
				call_user_func_array('widget_field_'.$field['type'], array($this, $instance, $field['name'], $field['title'], $field));
			endforeach;
		} else {
			echo '<p>There are no available options for this widget</p>';
		}
	}
	
	function widget($args, $instance) {
        extract($args);
        if ($this->print_wrappers) {
        	echo $before_widget;
        }
        $this->front_end($args, $instance);
        if ($this->print_wrappers) {
        	echo $after_widget;
        }
    }
    
    /*abstract*/ function front_end($args, $instance) {
    	
    }
}

/*
* Field rendering functions. Called in the admin when showing the widget form.
*/
function widget_field_text($obj, $instance, $fieldname, $fieldtitle) {
	$value = $instance[$fieldname];
	?>
	<p>
		<label for="<?php echo $obj->get_field_id($fieldname); ?>"><?php echo $fieldtitle; ?>:</label>
		<input class="widefat" id="<?php echo $obj->get_field_id($fieldname); ?>" name="<?php echo $obj->get_field_name($fieldname); ?>" type="text" value="<?php echo esc_attr($value); ?>" />
	</p>
	<?php
}
function widget_field_integer($obj, $instance, $fieldname, $fieldtitle) {
	$value = intval($instance[$fieldname]);
	?>
	<p>
		<label for="<?php echo $obj->get_field_id($fieldname); ?>"><?php echo $fieldtitle; ?>:</label>
		<input class="widefat" id="<?php echo $obj->get_field_id($fieldname); ?>" name="<?php echo $obj->get_field_name($fieldname); ?>" type="text" value="<?php echo esc_attr($value); ?>" />
	</p>
	<?php
}

function widget_field_textarea($obj, $instance, $fieldname, $fieldtitle) {
	$value = $instance[$fieldname];
	?>
	<p>
		<label for="<?php echo $obj->get_field_id($fieldname); ?>"><?php echo $fieldtitle; ?>:</label>
		<textarea class="widefat" id="<?php echo $obj->get_field_id($fieldname); ?>" name="<?php echo $obj->get_field_name($fieldname); ?>" style="height: 150px;" type="text"><?php echo esc_attr($value); ?></textarea>
	</p>
	<?php
}

function widget_field_desc($obj, $instance, $fieldname, $fieldtitle) {
	?><p><small style="display:block; line-height:14px; font-size:11px; color:#666; padding:0 2px;"><?php echo $fieldtitle; ?></small></p><?php
}

function widget_field_select($obj, $instance, $fieldname, $fieldtitle, $field_array) {
	$value = $instance[$fieldname];
	?>
	<p>
		<label for="<?php echo $obj->get_field_id($fieldname); ?>"><?php echo $fieldtitle; ?>:</label><br />
		<select name="<?php echo $obj->get_field_name($fieldname); ?>" id="<?php echo $obj->get_field_id($fieldname); ?>" style="width: 100%;">
			<?php foreach ($field_array['options'] as $val => $name) : ?>
				<option value="<?php echo $val; ?>" <?php echo ($val == esc_attr($value)) ? 'selected="selected"' : ''; ?>><?php echo $name; ?></option>
			<?php endforeach; ?>
		</select>
	</p>
	<?php
}
function widget_field_customCategories($obj, $instance, $fieldname, $fieldtitle, $field_array){
	$value = $instance[$fieldname];
	$options = $field_array['options'];
	$categories = get_categories(array('type' => $options['post_type'],'taxonomy' => $options['taxonomy']));
	
	if (!empty($categories)){ ?>
	<p>
		<label for="<?php echo $obj->get_field_id($fieldname); ?>"><?php echo $fieldtitle; ?>:</label><br />
		<select multiple size="5" name="<?php echo $obj->get_field_name($fieldname); ?>[]" id="<?php echo $obj->get_field_id($fieldname); ?>" style="height:98px; width: 100%;">
			<?php foreach ($categories as $category) : ?>
				<option value="<?php echo $category->cat_ID; ?>" <?php if (!empty($value) && in_array($category->cat_ID,$value)) { echo 'selected="selected"'; } ?>><?php echo $category->name; ?></option>
			<?php endforeach; ?>
		</select>
	</p>
	<?php }
}
function widget_field_multiCategories($obj, $instance, $fieldname, $fieldtitle, $field_array) {
	$value = $instance[$fieldname];
	$categories = get_categories('hide_empty=0');
	?>
	<p>
		<label for="<?php echo $obj->get_field_id($fieldname); ?>"><?php echo $fieldtitle; ?>:</label><br />
		<select multiple size="5" name="<?php echo $obj->get_field_name($fieldname); ?>[]" id="<?php echo $obj->get_field_id($fieldname); ?>" style="height:98px; width: 100%;">
			<?php foreach ($categories as $category) : ?>
				<option value="<?php echo $category->cat_ID; ?>" <?php if (!empty($value) && in_array($category->cat_ID,$value)) { echo 'selected="selected"'; } ?>><?php echo $category->name; ?></option>
			<?php endforeach; ?>
		</select>
	</p>
	<?php
}
function widget_field_customPosts($obj, $instance, $fieldname, $fieldtitle, $field_array){
	$value = $instance[$fieldname];
	$options = $field_array['options'];
	$posts = get_posts(array('post_type' => $options['post_type'], 'numberposts' => -1));
	?>
	<p>
		<label for="<?php echo $obj->get_field_id($fieldname); ?>"><?php echo $fieldtitle; ?>:</label><br />
		<select name="<?php echo $obj->get_field_name($fieldname); ?>[]" id="<?php echo $obj->get_field_id($fieldname); ?>" style="width: 100%;">
			<option value="0">None</option>
			<?php foreach ($posts as $post) : ?>
				<option value="<?php echo $post->ID; ?>" <?php if (!empty($value) && in_array($post->ID,$value)) { echo 'selected="selected"'; } ?>><?php echo get_the_title($post->ID); ?></option>
			<?php endforeach; ?>
		</select>
	</p>
	<?php
}
function widget_field_set($obj, $instance, $fieldname, $fieldtitle, $field_array) {
	$value = $instance[$fieldname];
	if (!$value) {
		$value = array();
	}
	?>
	<p>
		<label for="<?php echo $obj->get_field_id($fieldname); ?>"><?php echo $fieldtitle; ?>:</label><br />
		<?php foreach ($field_array['options'] as $val => $name) : ?>
			<span style="padding-top:3px; display:block;"><input type="checkbox" name="<?php echo $obj->get_field_name($fieldname); ?>[]" value="<?php echo $val; ?>" <?php echo (!(in_array($val, $value) === FALSE)) ? 'checked="checked"' : ''; ?>>&nbsp;<?php echo $name; ?></span>
		<?php endforeach; ?>
	</p>
	<?php
}

// Event Categories Function
function widget_field_eventCategories($obj, $instance, $fieldname, $fieldtitle, $field_array) {
	$value = $instance[$fieldname];
	$categories = get_categories(array('hide_empty'=>0,'taxonomy'=>'events'));
	?>
	<p>
		<label for="<?php echo $obj->get_field_id($fieldname); ?>"><?php echo $fieldtitle; ?>:</label><br />
		<select multiple size="5" name="<?php echo $obj->get_field_name($fieldname); ?>[]" id="<?php echo $obj->get_field_id($fieldname); ?>" style="height:98px; width: 100%;">
			<?php foreach ($categories as $category) : ?>
				<option value="<?php echo $category->cat_ID; ?>" <?php if (!empty($value) && in_array($category->cat_ID,$value)) { echo 'selected="selected"'; } ?>><?php echo $category->name; ?></option>
			<?php endforeach; ?>
		</select>
	</p>
	<?php
}
?>