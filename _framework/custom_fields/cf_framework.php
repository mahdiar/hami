<?php
// Pages
function page_array(){
	$pages = array();  
	$pages_obj = get_pages(array('sort_column' => 'post_parent,menu_order'));
	$pages[''] = __('Select a page...','crowdpress');
	foreach ($pages_obj as $page) {
		$pages[$page->ID] = $page->post_title;
	}
	return $pages;
}

// Posts (includes posts, galleries, videos, audio, and events)
function post_array($type = 'post'){

	$type_name = explode('-',$type);
	$type_name = $type_name[0];
	
	if ($type_name == 'audio'){
		$a_text = 'an';
	} else {
		$a_text = 'a';
	}
	
	if ($type_name == 'video' || $type_name == 'audio' || $type_name == 'gallery'){
		$post_text = ' post';
	} else if ($type_name == 'custom'){
		$post_text = ' slider';
	} else {
		$post_text = '';
	}

	$posts = array();  
	$posts_obj = get_posts(array('numberposts' => -1, 'post_type' => $type,'orderby' => 'name', 'order' => 'asc'));
	if ($type_name == 'slide'){ $posts[''] = 'No slider'; } else { $posts[''] = __('Select','crowdpress').' '.$a_text.' '.$type_name.$post_text.'...'; }
	
	foreach ($posts_obj as $post) {
		$posts[$post->ID] = $post->post_title;
	}
	return $posts;
}

function ecf_conf_error($message) {
    exit("<strong>Enhanced Custom Fields configuration error: </strong>$message");
}
include_once(dirname(__FILE__) . '/panel.php');
include_once(dirname(__FILE__) . '/fields.php');

/*
Updates an image url (as supplied by efc_fieldimage) to a full image url.
Sidenote: Why arent values stored as full urls and stored in default wp uploads-style categorization?
*/
function ecf_get_image_url($url) {
	$upload_url_path = get_option('upload_url_path');
	if (!$upload_url_path) {
		$upload_url_path = home_url() . '/wp-content/uploads/';
	}
	return $upload_url_path . $url;
}
?>