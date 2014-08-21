<?php

// First Widget Row
$widget_layout_row_1 = ECF_Field::factory('imageradio', 'campaigns_widget_layout', __('Widget Layout','crowdpress') );
$widget_layout_row_1->add_options(array(
		'no-widgets'=>get_template_directory_uri().'/_theme_settings/images/widget_columns_none.png',
		'one'=>get_template_directory_uri().'/_theme_settings/images/widget_columns_one.png',
		'two'=>get_template_directory_uri().'/_theme_settings/images/widget_columns_two.png',
		'three'=>get_template_directory_uri().'/_theme_settings/images/widget_columns_three.png',
		'four'=>get_template_directory_uri().'/_theme_settings/images/widget_columns_four.png',
		'onethird_twothird'=>get_template_directory_uri().'/_theme_settings/images/widget_columns_onethird_twothird.png',
		'twothird_onethird'=>get_template_directory_uri().'/_theme_settings/images/widget_columns_twothird_onethird.png',
	));
	
// Widget Block 1
$widget_block_1_row_1 = ECF_Field::factory('select', 'campaigns_widget_block_1', __('Widget Block for ZONE 1:','crowdpress'));
$widget_block_1_row_1->add_options($sidebar_dropdown_elements);

// Widget Block 2
$widget_block_2_row_1 = ECF_Field::factory('select', 'campaigns_widget_block_2', __('Widget Block for ZONE 2:','crowdpress'));
$widget_block_2_row_1->add_options($sidebar_dropdown_elements);

// Widget Block 3
$widget_block_3_row_1 = ECF_Field::factory('select', 'campaigns_widget_block_3', __('Widget Block for ZONE 3:','crowdpress'));
$widget_block_3_row_1->add_options($sidebar_dropdown_elements);

// Widget Block 3
$widget_block_4_row_1 = ECF_Field::factory('select', 'campaigns_widget_block_4', __('Widget Block for ZONE 4:','crowdpress'));
$widget_block_4_row_1->add_options($sidebar_dropdown_elements);

$widget_settings_panel_row_1 = new ECF_Panel('campaigns_widget_settings_panel', __('Footer Widgets','crowdpress'), 'download', 'normal', 'high');
$widget_settings_panel_row_1->add_fields(array($widget_layout_row_1,$widget_block_1_row_1,$widget_block_2_row_1,$widget_block_3_row_1,$widget_block_4_row_1));

?>