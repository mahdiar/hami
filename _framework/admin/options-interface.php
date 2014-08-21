<?php

/**
 * Generates the options fields that are used in the form.
 */

function optionsframework_fields() {

	global $allowedposttags;
	$optionsframework_settings = get_option('optionsframework');

	// Gets the unique option id
	if (isset($optionsframework_settings['id'])) {
		$option_name = $optionsframework_settings['id'];
	}
	else {
		$option_name = 'optionsframework';
	};

	$settings = get_option($option_name);
    $options = optionsframework_options();
        
    $counter = 0;
	$menu = '';
	$output = '';
	
	foreach ($options as $value) {
	   
		$counter++;
		$val = '';
		$select_value = '';
		$checked = '';
		
		// Wrap all options
		if ( ($value['type'] != "heading") && ($value['type'] != "info") ) {

			// Keep all ids lowercase with no spaces
			$value['id'] = preg_replace('/\W/', '', strtolower($value['id']) );

			$id = 'section-' . $value['id'];

			$class = 'section ';
			if ( isset( $value['type'] ) ) {
				$class .= ' section-' . $value['type'];
			}
			if ( isset( $value['class'] ) ) {
				$class .= ' ' . $value['class'];
			}

			if (!isset($value['hidden_flag']) || isset($value['hidden_flag']) && !$value['hidden_flag']){
				$output .= '<div id="' . esc_attr( $id ) .'" class="' . esc_attr( $class ) . '">'."\n";
				$output .= '<h3 class="heading">' . esc_html( $value['name'] ) . '</h3>' . "\n";
				$output .= '<div class="option">' . "\n" . '<div class="controls">' . "\n";
			}
		 }
		
		// Set default value to $val
		if ( isset( $value['std']) ) {
			$val = $value['std'];
		}
		
		// If the option is already saved, ovveride $val
		if ( ($value['type'] != 'heading') && ($value['type'] != 'info')) {
			if ( isset($settings[($value['id'])]) ) {
					$val = $settings[($value['id'])];
					// Striping slashes of non-array options
					if (!is_array($val)) {
						$val = stripslashes($val);
					}
			}
		}
		                                
		switch ( $value['type'] ) {
		
		// Basic text input
		case 'text':
			if(isset($value['hidden_flag']) && $value['hidden_flag']){ $type = 'hidden'; } else { $type = 'text'; }
			$output .= '<input id="' . esc_attr( $value['id'] ) . '" class="of-input" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" type="'.$type.'" value="' . esc_attr( $val ) . '" />';
		break;
		
		// Custom Font Preview
		case 'custom_font_preview':
			
			$custom_font = of_get_option('js_custom_font');
			if (!$custom_font){ $custom_font = 'Droid+Serif'; }
			$custom_font = str_replace('+',' ',$custom_font);
			if (strstr($custom_font,':')){ $custom_font = explode(':',$custom_font); $custom_font = $custom_font[0]; }
			if ($custom_font != 'sans-serif'){ $google_custom_font = "'".$custom_font."'"; }
			
			$output .= '<div style="font-family:'.$google_custom_font.'; font-size: 21px; color: #888; padding: 20px 0 0; line-height: 31px; width: 525px;">';
				$output .= 'You have chosen the &ldquo;'.str_replace('+',' ',$custom_font).'&rdquo; font style. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';
			$output .= '</div>';
			
		break;
		
		// Textarea
		case 'textarea':
			$cols = '8';
			$ta_value = '';
			
			if(isset($value['options'])){
				$ta_options = $value['options'];
				if(isset($ta_options['cols'])){
					$cols = $ta_options['cols'];
				} else { $cols = '8'; }
			}
			
			$val = stripslashes( $val );
			
			$output .= '<textarea id="' . esc_attr( $value['id'] ) . '" class="of-input" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" cols="'. esc_attr( $cols ) . '" rows="8">' . esc_textarea( $val ) . '</textarea>';
		break;
		
		// Select Box
		case ($value['type'] == 'select'):
			$output .= '<select class="of-input" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" id="' . esc_attr( $value['id'] ) . '">';
			
			foreach ($value['options'] as $key => $option ) {
				$selected = '';
				 if( $val != '' ) {
					 if ( $val == $key) { $selected = ' selected="selected"';} 
			     }
				 $output .= '<option'. $selected .' value="' . esc_attr( $key ) . '">' . esc_html( $option ) . '</option>';
			 } 
			 $output .= '</select>';
		break;

		
		// Radio Box
		case "radio":
			$name = $option_name .'['. $value['id'] .']';
			foreach ($value['options'] as $key => $option) {
				$id = $option_name . '-' . $value['id'] .'-'. $key;
				$output .= '<input class="of-input of-radio" type="radio" name="' . esc_attr( $name ) . '" id="' . esc_attr( $id ) . '" value="'. esc_attr( $key ) . '" '. checked( $val, $key, false) .' /><label for="' . esc_attr( $id ) . '">' . esc_html( $option ) . '</label><br />';
			}
		break;
		
		// Image Selectors
		case "images":
			$name = $option_name .'['. $value['id'] .']';
			foreach ( $value['options'] as $key => $option ) {
				$selected = '';
				$checked = '';
				if ( $val != '' ) {
					if ( $val == $key ) {
						$selected = ' of-radio-img-selected';
						$checked = ' checked="checked"';
					}
				}
				$output .= '<input type="radio" id="' . esc_attr( $value['id'] .'_'. $key) . '" class="of-radio-img-radio" value="' . esc_attr( $key ) . '" name="' . esc_attr( $name ) . '" '. $checked .' />';
				$output .= '<div class="of-radio-img-label">' . esc_html( $key ) . '</div>';
				$output .= '<img src="' . esc_url( $option ) . '" alt="' . $option .'" class="of-radio-img-img' . $selected .'" onclick="document.getElementById(\''. esc_attr($value['id'] .'_'. $key) .'\').checked=true;" />';
			}
		break;
		
		// Checkbox
		case "checkbox":
			$output .= '<input id="' . esc_attr( $value['id'] ) . '" class="checkbox of-input" type="checkbox" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" '. checked( $val, 1, false) .' /><label for="' . esc_attr( $value['id'] ) . '">' . esc_html( $value['label'] ) . '</label>';
		break;
		
		// Multicheck
		case "multicheck":
			foreach ($value['options'] as $key => $option) {
				$checked = '';
				$label = $option;
				$option = preg_replace('/\W/', '', strtolower($key));

				$id = $option_name . '-' . $value['id'] . '-'. $option;
				$name = $option_name . '[' . $value['id'] . '][' . $option .']';

			    if ( isset($val[$option]) ) {
					$checked = checked($val[$option], 1, false);
				}

				$output .= '<input id="' . esc_attr( $id ) . '" class="checkbox of-input" type="checkbox" name="' . esc_attr( $name ) . '" ' . $checked . ' /><label for="' . esc_attr( $id ) . '">' . esc_html( $label ) . '</label><br />';
			}
		break;
		
		// Multicheck
		case "multicheckHomepageBlocks":
			$output .= '<div class="homepageBlockBuilder">';
			$output .= '<div class="homepage-block header no-sorting">Header</div>';
				foreach ($value['options'] as $key => $option) {
					
					$checked = '';
					$label = $option;
					$option = preg_replace('/\W/', '', strtolower($key));
	
					$id = $option_name . '-' . $value['id'] . '-'. $option;
					$name = $option_name . '[' . $value['id'] . '][' . $option .']';
	
				    if ( isset($val[$option]) ) {
						$checked = checked($val[$option], 1, false);
					}
					
					if ($key == 'widget_block'){
						$page_title = of_get_option('js_homepage_page_display');
						$page_title = get_the_title($page_title);
						$title = 'Hide &ldquo;'.$page_title.'&rdquo; Page';
						if (!$page_title) { $title = $label; }
					} else {
						$title = $label;
					}
					
					$output .= '<div id="' . esc_attr( $id ) . '" class="homepage-block ' . esc_attr( $id ) .' no-sorting">';
					$output .= '<input id="' . esc_attr( $id ) . '" class="checkbox of-input" type="checkbox" name="' . esc_attr( $name ) . '" ' . $checked . ' /><label for="' . esc_attr( $id ) . '">' . esc_html( $title ) . '</label><br />';
					$output .= '</div>';

				}
			$output .= '<div class="homepage-block footer no-sorting">Footer Widgets</div>';
			$output .= '</div>';
		break;
		
		// Color picker
		case "color":
			$output .= '<div id="' . esc_attr( $value['id'] . '_picker' ) . '" class="colorSelector"><div style="' . esc_attr( 'background-color:' . $val ) . '"></div></div>';
			$output .= '<input class="of-color" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" id="' . esc_attr( $value['id'] ) . '" type="text" value="' . esc_attr( $val ) . '" />';
		break; 
		
		// Uploader
		case "upload":
			$output .= optionsframework_medialibrary_uploader( $value['id'], $val, null ); // New AJAX Uploader using Media Library	
		break;
		
		// Typography
		case 'typography':	
		
			$typography_stored = $val;
			
			// Font Size
			$output .= '<select class="of-typography of-typography-size" name="' . esc_attr( $option_name . '[' . $value['id'] . '][size]' ) . '" id="' . esc_attr( $value['id'] . '_size' ) . '">';
			for ($i = 9; $i < 71; $i++) { 
				$size = $i . 'px';
				$output .= '<option value="' . esc_attr( $size ) . '" ' . selected( $typography_stored['size'], $size, false ) . '>' . esc_html( $size ) . '</option>';
			}
			$output .= '</select>';
		
			// Font Face
			/* $output .= '<select class="of-typography of-typography-face" name="' . esc_attr( $option_name . '[' . $value['id'] . '][face]' ) . '" id="' . esc_attr( $value['id'] . '_face' ) . '">';
			
			$faces = of_recognized_font_faces();
			foreach ( $faces as $key => $face ) {
				$output .= '<option value="' . esc_attr( $key ) . '" ' . selected( $typography_stored['face'], $key, false ) . '>' . esc_html( $face ) . '</option>';
			}			
			
			$output .= '</select>';	*/

			// Font Weight
			$output .= '<select class="of-typography of-typography-style" name="'.$option_name.'['.$value['id'].'][style]" id="'. $value['id'].'_style">';

			/* Font Style */
			$styles = of_recognized_font_styles();
			foreach ( $styles as $key => $style ) {
				$output .= '<option value="' . esc_attr( $key ) . '" ' . selected( $typography_stored['style'], $key, false ) . '>'. $style .'</option>';
			}
			$output .= '</select>';

			// Font Color		
			$output .= '<div id="' . esc_attr( $value['id'] ) . '_color_picker" class="colorSelector"><div style="' . esc_attr( 'background-color:' . $typography_stored['color'] ) . '"></div></div>';
			$output .= '<input class="of-color of-typography of-typography-color" name="' . esc_attr( $option_name . '[' . $value['id'] . '][color]' ) . '" id="' . esc_attr( $value['id'] . '_color' ) . '" type="text" value="' . esc_attr( $typography_stored['color'] ) . '" />';

		break;
		
		// Background
		case 'background':
			
			$background = $val;
			
			// Background Color		
			$output .= '<div id="' . esc_attr( $value['id'] ) . '_color_picker" class="colorSelector"><div style="' . esc_attr( 'background-color:' . $background['color'] ) . '"></div></div>';
			$output .= '<input class="of-color of-background of-background-color" name="' . esc_attr( $option_name . '[' . $value['id'] . '][color]' ) . '" id="' . esc_attr( $value['id'] . '_color' ) . '" type="text" value="' . esc_attr( $background['color'] ) . '" />';
			
			// Background Image - New AJAX Uploader using Media Library
			if (!isset($background['image'])) {
				$background['image'] = '';
			}
			
			$output .= optionsframework_medialibrary_uploader( $value['id'], $background['image'], null, '',0,'image');
			$class = 'of-background-properties';
			if ( '' == $background['image'] ) {
				$class .= ' hide';
			}
			$output .= '<div class="' . esc_attr( $class ) . '">';
			
			// Background Repeat
			$output .= '<select class="of-background of-background-repeat" name="' . esc_attr( $option_name . '[' . $value['id'] . '][repeat]'  ) . '" id="' . esc_attr( $value['id'] . '_repeat' ) . '">';
			$repeats = of_recognized_background_repeat();
			
			foreach ($repeats as $key => $repeat) {
				$output .= '<option value="' . esc_attr( $key ) . '" ' . selected( $background['repeat'], $key, false ) . '>'. esc_html( $repeat ) . '</option>';
			}
			$output .= '</select>';
			
			// Background Position
			$output .= '<select class="of-background of-background-position" name="' . esc_attr( $option_name . '[' . $value['id'] . '][position]' ) . '" id="' . esc_attr( $value['id'] . '_position' ) . '">';
			$positions = of_recognized_background_position();
			
			foreach ($positions as $key=>$position) {
				$output .= '<option value="' . esc_attr( $key ) . '" ' . selected( $background['position'], $key, false ) . '>'. esc_html( $position ) . '</option>';
			}
			$output .= '</select>';
			
			// Background Attachment
			$output .= '<select class="of-background of-background-attachment" name="' . esc_attr( $option_name . '[' . $value['id'] . '][attachment]' ) . '" id="' . esc_attr( $value['id'] . '_attachment' ) . '">';
			$attachments = of_recognized_background_attachment();
			
			foreach ($attachments as $key => $attachment) {
				$output .= '<option value="' . esc_attr( $key ) . '" ' . selected( $background['attachment'], $key, false ) . '>' . esc_html( $attachment ) . '</option>';
			}
			$output .= '</select>';
			$output .= '</div>';
		
		break;  
		
		// Info
		case "info":
			$class = 'section';
			if ( isset( $value['type'] ) ) {
				$class .= ' section-' . $value['type'];
			}
			if ( isset( $value['class'] ) ) {
				$class .= ' ' . $value['class'];
			}

			$output .= '<div class="' . esc_attr( $class ) . '">' . "\n";
			if ( isset($value['name']) ) {
				$output .= '<h3 class="heading">' . esc_html( $value['name'] ) . '</h3>' . "\n";
			}
			if ( $value['desc'] ) {
				$output .= wpautop( wp_kses( $value['desc'], $allowedposttags) ) . "\n";
			}
			$output .= '<div class="clear"></div></div>' . "\n";
		break;                       
		
		// Heading for Navigation
		case "heading":
			if($counter >= 2){
			   $output .= '</div>'."\n";
			}
			$jquery_click_hook = preg_replace('/\W/', '', strtolower($value['name']) );
			$jquery_click_hook = "of-option-" . $jquery_click_hook;
			$menu .= '<li><a id="'.  esc_attr( $jquery_click_hook ) . '-tab" title="' . esc_attr( $value['name'] ) . '" href="' . esc_attr( '#'.  $jquery_click_hook ) . '">' . esc_html( $value['name'] ) . '</a></li>';
			$output .= '<div class="group" id="' . esc_attr( $jquery_click_hook ) . '"><h2>' . esc_html( $value['name'] ) . '</h2>' . "\n";
			break;
		}

		if (!isset($value['hidden_flag']) || isset($value['hidden_flag']) && !$value['hidden_flag']){

			if ( ( $value['type'] != "heading" ) && ( $value['type'] != "info" ) ) {
				if ( $value['type'] != "checkbox" ) {
					$output .= '<br/>';
				}
				$explain_value = '';
				if ( isset( $value['desc'] ) ) {
					$explain_value = $value['desc'];
				}
				$output .= '</div><div class="explain">' . wp_kses( $explain_value, $allowedposttags) . '</div>'."\n";
				$output .= '<div class="clear"></div></div></div>'."\n";
			}
	
		}
		
	}
    $output .= '</div>';
    return array($output,$menu);
}