<?php



// Load the CSS for the custom shortcode forms
function js_shortcode_admin_head() {
	
	$template_dir = get_template_directory_uri(); ?>
	<link rel="stylesheet" type="text/css" href="<?php echo $template_dir; ?>/_theme_settings/shortcodes/admin-styles.css"><?php
	
	// Get all post categories
	$post_categories = get_categories(array('type' => 'post'));

	?><script type="text/javascript">
		var postCategories = {
		
			<?php foreach ($post_categories as $category){
				?>"<?php echo $category->term_id; ?>" : '<?php echo addslashes($category->name); ?>',<?php
			} ?>
		
		};
 	</script><?php

}

add_action('admin_head', 'js_shortcode_admin_head');


// Load the Shortcodes
include('shortcodes/columns/columns.php');
include('shortcodes/highlight/highlight.php');
include('shortcodes/cta/cta.php');
include('shortcodes/custom-buttons/custom-buttons.php');
include('shortcodes/posts/posts.php');

?>