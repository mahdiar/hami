<?php



// Page Layout
$page_layout = ECF_Field::factory('imageradio', 'page_layout', __('Page Layout','crowdpress') );
$page_layout->add_options(array(
		'default'=>get_template_directory_uri().'/_theme_settings/images/page_layout_01.png',
		'homepage'=>get_template_directory_uri().'/_theme_settings/images/page_layout_02.png',
	))->help_text(__('Individual blocks can be hidden using the other options on this page.','crowdpress'));
	
$page_options = ECF_Field::factory('set', 'page_options', __('Other Options','crowdpress') );
$page_options->add_options(array('hide_breadcrumbs' => __('Hide the breadcrumbs','crowdpress'), 'hide_title' => __('Hide the page title','crowdpress')));

$featured_campaigns_style = ECF_Field::factory('select', '_featured_campaigns_style', __('Featured Campaigns Style','crowdpress') );
$featured_campaigns_style->add_options(array(
	false => __('No Featured Campaigns','crowdpress'),
	'classic' => __('Classic Flipping Slider (shows one featured campaign per category)','crowdpress'),
	'panels' => __('Featured Panels (a responsive swipable slider of campaign panels)','crowdpress'),
	'grid' => __('Campaign Grid (shows all campaigns in a big grid, sorted randomly)','crowdpress')
));

$campaign_grid_text = ECF_Field::factory('text', 'campaign_grid_text', __('Campaign Grid Text (optional)','crowdpress') );
$campaign_grid_text->help_text('Enter some text that will show up centered on top of the Campaign Grid (if in use)');

$page_image = ECF_Field::factory('image', 'header_image', __('Header Image','crowdpress') );
$page_image->set_size(2000,300);
$page_image->help_text('Upload a large image to fill the header area. The image should be at least 2000x219 pixels and will be sized to that if larger.');

$page_image_text = ECF_Field::factory('text', 'header_text', __('Header Text (optional)','crowdpress') );
$page_image_text->help_text('Enter some text that will show up centered on top of the Header Image');

$header_image_parallax = ECF_Field::factory('set', '_header_image_parallax', __('Parallax Effect','crowdpress') );
$header_image_parallax->add_options(array('header_image_parallax' => __('Activate parallax header image','crowdpress')))->help_text('Activate to make the header image scroll slower than the text (parallax effect). Keep in mind that the image needs to be at least 300px for this effect to look right.');

// Projects Title
$projects_title = ECF_Field::factory('text', 'projects_title', __('"The Latest Projects" Title','crowdpress') );
$projects_title->set_default_value('The Latest Projects');
$projects_title->help_text('Enter some text that will show up above the project list.');

// Latest Projects to Display
$projects_to_display = ECF_Field::factory('select', 'projects_count', __('Number of "Latest Projects" to display:','crowdpress'));
$projects_to_display->add_options(array(0 => 'None', 3 => 'Three',6 => 'Six',9 => 'Nine',12 => 'Twelve',15 => 'Fifteen',-1 => 'Display All Projects'));

// Project Sort Order
$projects_sortby = ECF_Field::factory('select', 'projects_sortby', __('Sort the "Latest Projects" by:','crowdpress'));
$projects_sortby->add_options(array('rand' => 'Random','date_newest' => 'Date (Newest First)','date_oldest' => 'Date (Oldest First)'));

$page_settings_panel = new ECF_Panel('page_settings_panel', __('Page Settings','crowdpress'), 'page', 'normal', 'high');
$page_settings_panel->add_fields(array($page_layout,$page_options,$featured_campaigns_style,$campaign_grid_text,$projects_title,$projects_to_display,$projects_sortby,$page_image,$page_image_text,$header_image_parallax));



// Sidebar Settings
$sidebar_layout = ECF_Field::factory('imageradio', 'sidebar_layout', __('Sidebar Layout','crowdpress') );
$sidebar_layout->add_options(array(
		'no-sidebar'=>get_template_directory_uri().'/_theme_settings/images/sidebar_none.png',
		'left'=>get_template_directory_uri().'/_theme_settings/images/sidebar_left.png',
		'right'=>get_template_directory_uri().'/_theme_settings/images/sidebar_right.png',
	));

global $wp_registered_sidebars;
$sidebar_dropdown_elements = array();
foreach($wp_registered_sidebars as $sidebar_id => $sidebar){
	$sidebar_dropdown_elements[$sidebar['id']] = $sidebar['name'];	
}

// Sidebar Choice
$sidebar_choice = ECF_Field::factory('select', 'sidebar_choice', __('Choose a sidebar:','crowdpress'));
$sidebar_choice->add_options($sidebar_dropdown_elements);
	
$sidebar_settings_panel = new ECF_Panel('sidebar_settings_panel', __('Sidebar Settings','crowdpress'), 'page', 'normal', 'high');
$sidebar_settings_panel->add_fields(array($sidebar_layout,$sidebar_choice));


// First Widget Row
$widget_layout_row_1 = ECF_Field::factory('imageradio', 'widget_layout', __('Widget Layout','crowdpress') );
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
$widget_block_1_row_1 = ECF_Field::factory('select', 'widget_block_1', __('Widget Block for ZONE 1:','crowdpress'));
$widget_block_1_row_1->add_options($sidebar_dropdown_elements);

// Widget Block 2
$widget_block_2_row_1 = ECF_Field::factory('select', 'widget_block_2', __('Widget Block for ZONE 2:','crowdpress'));
$widget_block_2_row_1->add_options($sidebar_dropdown_elements);

// Widget Block 3
$widget_block_3_row_1 = ECF_Field::factory('select', 'widget_block_3', __('Widget Block for ZONE 3:','crowdpress'));
$widget_block_3_row_1->add_options($sidebar_dropdown_elements);

// Widget Block 3
$widget_block_4_row_1 = ECF_Field::factory('select', 'widget_block_4', __('Widget Block for ZONE 4:','crowdpress'));
$widget_block_4_row_1->add_options($sidebar_dropdown_elements);

$widget_settings_panel_row_1 = new ECF_Panel('widget_settings_panel', __('Footer Widgets','crowdpress'), 'page', 'normal', 'high');
$widget_settings_panel_row_1->add_fields(array($widget_layout_row_1,$widget_block_1_row_1,$widget_block_2_row_1,$widget_block_3_row_1,$widget_block_4_row_1));

?>