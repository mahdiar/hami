<?php
if (function_exists('register_sidebar')) {

	register_sidebar(array(
		'name' => __('Default Sidebar','crowdpress'),
		'id'   => 'default-sidebar',
		'description'   => __('The default sidebar for pages.','crowdpress'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>'
	));
		
	register_sidebar(array(
		'name' => __('Bottom Widget Block 1','crowdpress'),
		'id'   => 'bottom-footer-1',
		'description'   => __('This widget area should be used in the footer.','crowdpress'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>'
	));
	
	register_sidebar(array(
		'name' => __('Bottom Widget Block 2','crowdpress'),
		'id'   => 'bottom-footer-2',
		'description'   => __('This widget area should be used in the footer.','crowdpress'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>'
	));
	
	register_sidebar(array(
		'name' => __('Bottom Widget Block 3','crowdpress'),
		'id'   => 'bottom-footer-3',
		'description'   => __('This widget area should be used in the footer.','crowdpress'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>'
	));
	
	register_sidebar(array(
		'name' => __('Bottom Widget Block 4','crowdpress'),
		'id'   => 'bottom-footer-4',
		'description'   => __('This widget area should be used in the footer.','crowdpress'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>'
	));
	
	register_sidebar(array(
		'name' => __('Footer Widgets - Column 1','crowdpress'),
		'id'   => 'footer-1',
		'description'   => __('This widget area should be used in the footer.','crowdpress'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>'
	));
	
	register_sidebar(array(
		'name' => __('Footer Widgets - Column 2','crowdpress'),
		'id'   => 'footer-2',
		'description'   => __('This widget area should be used in the footer.','crowdpress'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>'
	));
	
	register_sidebar(array(
		'name' => __('Footer Widgets - Column 3','crowdpress'),
		'id'   => 'footer-3',
		'description'   => __('This widget area should be used in the footer.','crowdpress'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>'
	));
	
	register_sidebar(array(
		'name' => __('Footer Widgets - Column 4','crowdpress'),
		'id'   => 'footer-4',
		'description'   => __('This widget area should be used in the footer.','crowdpress'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>'
	));
	
	register_sidebar(array(
		'name' => __('Post Sidebar','crowdpress'),
		'id'   => 'post-sidebar',
		'description'   => __('These widgets will show up on posts only.','crowdpress'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>'
	));
	
}
?>