<?php
function ecf_add_form_enctype() {
	echo ' enctype="multipart/form-data" ';
}
add_action('post_edit_form_tag', 'ecf_add_form_enctype');

class ECF_Panel {
	/* Only pages that are children of the page with this path will have the panel */
	var $parent_page_path;
	/* Only the page with the following path will have the panel */
	var $page_path;
	/* Only posts in this category will have the panel */
	var $cat_slug;
	/* Only posts with one of these page templates will have the panel */
	var $template_names = array();
	/* Only posts in the taxonomy with this slug from this term will have the panel*/
	var $tax_term;
	var $tax_slug;
	
	var $did_save = false;
	
	// loaded post info
	var $post_type;
	var $post_id;
	var $fields = array();
	/**
	 * Constructor. Pretty close to add_meta_box signature
	 */
	function ECF_Panel($id, $title, $post_type, $context, $priority) {
		ECF_Panels_static_add_panel_id($id);
	    $this->id = $id;
	    $this->title = $title;
	    $this->post_type = $post_type;
	    $this->context = $context;
	    $this->priority = $priority;
	    
	   	add_action('admin_enqueue_scripts', array(&$this, '_attach_ecf_styling' ));
	    add_action('admin_init', array(&$this, '_attach'));
		add_action('save_post', array(&$this, 'save'));
	}
	function _attach_ecf_styling(){
		$theme_root = get_template_directory_uri();
		wp_enqueue_style(
			'ecf_styles',
			"$theme_root/_framework/custom_fields/tpls/style.css"
		);
	}
	function _attach() {
		if (isset($_GET['post']) && $_GET['post'] != 'new') {
			// editing post -- take the post type from GET
			$post_id = intval($_GET['post']);
			$this->set_post_id($post_id);
		}

		if ($this->post_type=='page' && !empty($this->parent_page_path)) {
			$this->parent_page = get_page_by_path($this->parent_page_path);
			if (!$this->parent_page) {
				// Disable the panel if the parent page is not there -- possibly
				// the post-isntall import is not done yet
				return '';
			}
			add_action('admin_footer', array(&$this, '_print_pages_js'));
		} elseif ($this->post_type=='page' && !empty($this->page_path)) {
			$this->page = get_page_by_path($this->page_path);
			if (!$this->page) {
				// Disable the panel if the parent page is not there -- possibly
				// the post-isntall import is not done yet
				return '';
			}
			add_action('admin_footer', array(&$this, '_print_pages_js'));
		} elseif ($this->post_type=='post' && !empty($this->cat_slug)) {
			$this->cat = get_category_by_slug($this->cat_slug);
			if (!$this->cat) {
				return '';
			}
			add_action('admin_footer', array(&$this, '_print_pages_js'));
		} elseif($this->post_type=='page' && !empty($this->template_names)) {
			add_action('admin_footer', array(&$this, '_print_pages_js'));
		} elseif(isset($this->level_limit)) {
			add_action('admin_footer', array(&$this, '_print_pages_js'));
		} elseif(isset($this->tax_term) && isset($this->tax_slug)) {
			$this->term = get_term_by('slug', $this->tax_term, $this->tax_slug);
			add_action('admin_footer', array(&$this, '_print_pages_js'));
		}
		
	    add_meta_box(
	    	$this->id, 
	    	$this->title, 
	    	array(&$this, 'render'), 
	    	$this->post_type, 
	    	$this->context, 
	    	$this->priority
	    );
	    
	    wp_enqueue_script('ecf', get_template_directory_uri() . '/_framework/custom_fields/tpls/ecf.js');
	    wp_enqueue_script('ecf-custom', get_template_directory_uri() . '/_theme_settings/custom-fields/ecf_custom.js');
	    
	    add_action('admin_head', array(&$this, '_hide_panel_by_default'));
	}
	function _hide_panel_by_default() {
		// hide the panel if javascript is not enabled.
	    echo '<style type="text/css">body.no-js #' . $this->id . ' { display: none; }</style>' . "\n";
	}
	function get_nonce_name() {
		return 'ecf_panel_' . $this->id . '_nonce';
	}
	function render() {
		// Print the actual content
		$html = '<table width="100%">';
	    foreach ($this->fields as $field) {
	    	$html .= $field->render_field();
	    }
	    $html .= '</table>';
	    $html .= '<input type="hidden" name="__ecf_singular_edit" value="1">';
		$html .= wp_nonce_field('ecf_panel_' . $this->id . '_nonce', $this->get_nonce_name(), /*referer?*/ false, /*echo?*/ false);
	    echo $html;
	}
	function _print_pages_js() {
	    include 'tpls/js.php';
	}
	function add_fields($fields) {
		foreach ($fields as $field) {
			if (!is_a($field, 'ECF_Field')) {
				ecf_conf_error("Trying to add non ECF object ot ECF panel field");
			}
			ECF_Panels_static_add_field_name($field->name);
			$field->current_post_type = $this->post_type;
		}
	    $this->fields =& $fields;
	}
	
	function show_on_page_children($parent_page_path) {
	    $this->parent_page_path = $parent_page_path;
	}
	
	function show_on_page($page_path) {
	    $this->page_path = $page_path;
	}
	
	function show_on_cat($cat_slug) {
	    $this->cat_slug = $cat_slug;
	}
	
	// template file name
	function show_on_template($template_path) {
		if ( is_array($template_path) ) {
			foreach ($template_path as $path) {
				$this->show_on_template($path);
			}
			return;
		}
		/*
			The following code was commented out to allow to specify a panel for the "default" template (which is an internal value and not a .php file)
			
			// Append php extension to the template if it's not there already
			if (!preg_match('~\.php~', $template_path)) {
				$template_path = $template_path . '.php';
			}
		*/
		$this->template_names[] = $template_path;
	}
	
	/* Levels start from 1 (toplevel page) */
	function show_on_level($level) {
		if ($level < 0 ) {
			ecf_conf_error('Invalid level limitation (' . $level . ')');
		}
		$this->level_limit = $level;
	}
	
	function show_on_taxonomy_term($slug, $term) {
		$this->tax_term = $term;
		$this->tax_slug = $slug;
	}
	
	function set_post_id($post_id) {
		if ( $rev_post_id = wp_is_post_revision($post_id) )
			$post_id = $rev_post_id;
		
	    $this->post_id = $post_id;
	    foreach ($this->fields as $index=>$f) {
	    	$this->fields[$index]->post_id = $post_id;
	    	$this->fields[$index]->load();
	    }
	}
	function save($post_id) {
		// Make sure that this isn't a revision
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
			return;
		}
		
		if (isset($_REQUEST[$this->get_nonce_name()]) && !wp_verify_nonce($_REQUEST[$this->get_nonce_name()], $this->get_nonce_name())) {
			return;
		}
		if (empty($_POST['__ecf_singular_edit'])) {
			return;
		}
		// For some reason WordPress(2.9) is calling post_save hook twice.
		// So, just ignore every attemp to save upon first one.
		if ($this->did_save) {
			return;
		}
		
		// Do not save panel that's not associated with needed parent page(if it's setup)
		if ($this->post_type=='page' && !empty($this->parent_page_path)) {
			$current_page = get_page($post_id);
			$needed_parent_page = get_page_by_path($this->parent_page_path);
			
			// Fail silently if the needed parent page is not existing in 
			// the current isntall at all
			if (!$needed_parent_page) {
				return;
			}
			
			// Crawl up the pages tree until the needed parent page is found or tree root is reached
			while ($needed_parent_page->ID!=$current_page->ID && $current_page->post_parent!=0) {
				$current_page = get_page($current_page->post_parent);
			}
			
			// avoid saving if we didn't found needed page parent in above loop
			if ($needed_parent_page->ID!=$current_page->ID) {
				return;
			}
		}
		
		// Do not save panel that's not associated with the current page
		if ($this->post_type=='page' && !empty($this->page_path)) {
			$current_page = get_page($post_id);
			$needed_page = get_page_by_path($this->page_path);
			
			// Fail silently if the needed parent page is not existing in 
			// the current isntall at all
			if (!$needed_page) {
				return;
			}
			
			if ($current_page->ID != $needed_page->ID) {
				return;
			}
		}
		
		if ($this->post_type=='post' && !empty($this->cat_slug)) {
			$current_post_categories = get_the_category($post_id);

			$should_save = false;
			foreach ($current_post_categories as $cat) {
				if ($cat->slug==$this->cat_slug) {
					$should_save = true;
					break;
				}
			}
			if (!$should_save) {
				return;
			}
		}
		
		if ($this->post_type=='page' && !empty($this->template_names)) {
			$chosen_template = get_post_meta($post_id, '_wp_page_template', 1);
			if ( !in_array($chosen_template, $this->template_names) ) {
				return;
			}
		}
		
		$this->set_post_id($post_id);
		
	    foreach ($this->fields as $field) {
	    	$field->set_value_from_input();
	    	$field->save();
	    }
	    
	    $this->did_save = true;
	}
}

# for PHP 4 compitability I'm not using static class members here

// keep all ECF field names and notify the end user if duplicated field name is found
function ECF_Panels_static_add_field_name($name) {
	static $names;
	if (isset($names[$name])) {
		ecf_conf_error("Trying to add ECF Field with name <code>$name</code> twice.");
	}
    $names[$name] = 1;
}
function ECF_Panels_static_add_panel_id($panel_id) {
    static $ids;
	if (isset($ids[$panel_id])) {
		ecf_conf_error("Trying to add ECF Panel with ID <code>$panel_id</code> twice.");
	}
    $ids[$panel_id] = 1;
}
?>