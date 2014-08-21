<?php

if ( ! isset( $content_width ) ) $content_width = 940;

// Option tree for theme settings
require('option-tree.php');

// Widget Framework
require('widget_framework.php');

// Enhanced Custom Fields Framework
require('custom_fields/cf_framework.php');

// Twitter
include_once('twitter/versions-proxy.php');

# Include FB
include_once('facebook/facebook.php');

global $fb;

if (of_get_option('facebook_app_id') && of_get_option('facebook_app_secret')){
	$fb = new Facebook(array(
		'appId' => of_get_option('facebook_app_id'),
		'secret' => of_get_option('facebook_app_secret')
	));
	$fb->getAccessToken();
} else {
	$fb = false;
}



# Include Twitter
include_once('twitter/versions-proxy.php');

function my_myme_types($mime_types){
    $mime_types['ico'] = 'image/vnd.microsoft.icon'; //Adding ico extension for favicon
    return $mime_types;
}
add_filter('upload_mimes', 'my_myme_types', 1, 1);

// Timezone Settings
if ( !function_exists('getTimezoneByOffset') ) {
	function getTimezoneByOffset($offset){
	
	 	$offset *= 3600; // convert hour offset to seconds
        $abbrarray = timezone_abbreviations_list();
        foreach ($abbrarray as $abbr){
			foreach ($abbr as $city){
               	if ($city['offset'] == $offset){
                  	return $city['timezone_id'];
                }
         	}
        }

        return false;
	
	}

	$timezone_setting = get_option('timezone_string');
	$offset_setting = get_option('gmt_offset');
	if (!$timezone_setting) { $timezone_setting = getTimezoneByOffset($offset_setting); }
	
	date_default_timezone_set($timezone_setting);

}
// END Timezone Settings

// Add allowed <script> tag for Google Analytics code
add_action('init', 'my_html_tags_code', 10);
function my_html_tags_code() {
  	global $allowedposttags;
  	$allowedposttags = array(
  		'script' => array(),
  		'b' => array(),
  		'i' => array(),
  		'p' => array(),
  		'h1' => array(),
  		'h2' => array(),
  		'h3' => array(),
  		'h4' => array(),
  		'h5' => array(),
  		'h6' => array(),
  		'nav' => array(),
      	'ul' => array(),
      	'ol' => array(),
      	'li' => array(),
      	'strong' => array(),
      	'em' => array(),
      	'pre' => array(),
      	'code' => array(),
      	'a' => array(
      		'href' => array(),
      		'title' => array(),
      		'target' => array()),
      	'span' => array(
      		'style' => array()),
      	'small' => array(),
      	'img'=>array(
      		'src' => array(),
      		'width' => array(),
      		'height' => array()),
    );
}

// Add RSS links to <head> section
add_theme_support( 'automatic-feed-links' );

// Load jQuery
if ( !function_exists('core_mods') ) {
	function core_mods() {
		if ( !is_admin() ) {
			wp_enqueue_script('jquery');
		}
	}
	add_action('init','core_mods');
}

// Clean up the <head>
function removeHeadLinks() {
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wlwmanifest_link');
}
add_action('init', 'removeHeadLinks');

require_once('wp-updates-theme.php');
new WPUpdatesThemeUpdater_496( 'http://wp-updates.com/api/2/theme', basename(get_template_directory()));
?>