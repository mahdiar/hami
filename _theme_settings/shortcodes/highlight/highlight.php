<?php



// ----------------------------------------------------------------------------------------------------
// Shortcode Button/Form

class Custom_Shortcodes_Highlight
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
		array_push( $buttons, '', 'js_highlight_button' );
		return $buttons;
	}
	
	function filter_mce_plugin( $plugins ) {
		// this plugin file will work the magic of our button
		$plugins['js_highlight'] = get_template_directory_uri() . '/_theme_settings/shortcodes/highlight/script.js';
		return $plugins;
	}
}

$highlight = new Custom_Shortcodes_Highlight();



// ----------------------------------------------------------------------------------------------------
// Shortcode Display

function js_highlight( $atts, $content = null ) {
   return '<span class="highlight">' . do_shortcode($content) . '</span>';
}
add_shortcode('highlight', 'js_highlight');


?>