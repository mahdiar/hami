<?php
/*
Plugin Name: mygallery
Plugin URI: http://wphardcore.com
Description: A simple user interface for Gallery shortcode
Version: 0.1
Author: Gary Cao
Author URI: http://garyc40.com
*/

if ( ! defined( 'ABSPATH' ) )
	die( "Can't load this file directly" );

class MyGallery
{
	function __construct() {
		add_action( 'admin_init', array( $this, 'action_admin_init' ) );
	}
	
	function action_admin_init() {
		// only hook up these filters if we're in the admin panel, and the current user has permission
		// to edit posts and pages
		if ( current_user_can( 'edit_posts' ) && current_user_can( 'edit_pages' ) ) {
			add_filter( 'mce_buttons_3', array( $this, 'filter_mce_button' ) );
			add_filter( 'mce_external_plugins', array( $this, 'filter_mce_plugin' ) );
		}
	}
	
	function filter_mce_button( $buttons ) {
		array_push( $buttons, '', 'mygallery_button' );
		return $buttons;
	}
	
	function filter_mce_plugin( $plugins ) {
		// this plugin file will work the magic of our button
		$plugins['mygallery'] = get_template_directory_uri() . '/_theme_settings/shortcodes/test-shortcode/mygallery_plugin.js';
		return $plugins;
	}
}

$mygallery = new MyGallery();