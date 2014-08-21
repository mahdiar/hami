<?php
if ( !function_exists( 'optionsframework_init' ) ) {
	
	define('OPTIONS_FRAMEWORK_URL', get_template_directory() . '/_framework/admin/');
	define('OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/_framework/admin/');
	require_once (OPTIONS_FRAMEWORK_URL . 'options-framework.php');

}
?>