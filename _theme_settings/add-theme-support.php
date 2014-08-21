<?php

/**
 * This theme supports AppThemer Crowdfunding Plugin
 */
add_theme_support( 'appthemer-crowdfunding', array(
    'campaign-edit'           => true,
    'campaign-featured-image' => true,
    'campaign-video'          => true,
    'campaign-widget'         => true,
    'campaign-category'       => true,
    'campaign-regions'        => true,
    'anonymous-backers'       => true
));

// Post Formats
add_theme_support('post-formats', array( 'aside','gallery','link','image','quote','status','video','audio','chat' ));

// Post Thumbnails
add_theme_support('post-thumbnails', array('post','page','download'));
set_post_thumbnail_size(66,66,true);

// Main Images (slider and page banners)
add_image_size('page-banner',2000,219,true);

// Lightbox images and medium thumbnails
add_image_size('lightbox-large',1000,1000,false);
add_image_size('medium',288,197,true);
add_image_size('campaign-full',1180,1180,false);
add_image_size('campaign-thumb',600,454,true);

// Navigation
add_theme_support('menus');
register_nav_menus(array( 'main-menu' => __( 'Main Menu','crowdpress' )));
register_nav_menus(array( 'footer-menu' => __( 'Footer Menu','crowdpress' )));

function crowdpress_scripts() {
	global $edd_options;
	
	$responsive_disabled = (of_get_option('js_responsive_disabled') ? of_get_option('js_responsive_disabled') : 'no');
	
	$highlight_color = of_get_option('js_highlight_color');
	if ($highlight_color){
		$highlight_color = explode('#',$highlight_color);
		$highlight_color = $highlight_color[1];
	} else {
		$highlight_color = 'eb713d';
	}
	
	$custom_font = of_get_option('js_custom_font');
	if (!$custom_font){ $custom_font = 'Roboto'; }
	
	wp_enqueue_style( 'crowdpress-style', get_stylesheet_uri() );
	wp_enqueue_style( 'crowdpress-custom_font', 'http://fonts.googleapis.com/css?family='.$custom_font.':100,200,300,400,500,600,700,800&subset=latin,latin-ext,cyrillic-ext,greek-ext,greek,vietnamese,cyrillic');
	wp_enqueue_style( 'crowdpress-custom', get_template_directory_uri() . '/_theme_styles/custom.php?color='.$highlight_color.'&amp;font='.$custom_font );
	wp_enqueue_style( 'crowdpress-magnific', get_template_directory_uri() . '/_theme_styles/magnific-popup.css');
	wp_enqueue_style( 'crowdpress-entypo', get_template_directory_uri() . '/_theme_styles/entypo.css');
	if ($responsive_disabled != 'yes'){ wp_enqueue_style( 'crowdpress-responsive', get_template_directory_uri() . '/_theme_styles/responsive.css'); }

	wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/js/modernizr.custom.js', array( 'jquery' ), '1.3', false );
	wp_enqueue_script( 'fitvids', get_template_directory_uri() . '/js/fitvids.js', array( 'jquery' ), '1.0', true );
	wp_enqueue_script( 'jquery-easing', get_template_directory_uri() . '/js/jquery.easing.1.3.js', array( 'jquery' ), '1.3', true );
	wp_enqueue_script( 'jquery-tweet', get_template_directory_uri() . '/js/jquery.tweet.js', array( 'jquery' ), '1.3', true );
	wp_enqueue_script( 'jquery-masonry', get_template_directory_uri() . '/js/jquery.masonry-with-resize-plugin.min.js', array( 'jquery' ), '1.3', true );
	wp_enqueue_script( 'jquery-bookblock', get_template_directory_uri() . '/js/jquery.bookblock.js', array( 'jquery' ), '1.3', true );
	wp_enqueue_script( 'jquery-carouFredSel', get_template_directory_uri() . '/js/jquery.carouFredSel-6.1.0-packed.js', array( 'jquery' ), '1.3', true );
	wp_enqueue_script( 'jquery-fitvids', get_template_directory_uri() . '/js/jquery.fitvids.js', array( 'jquery' ), '1.3', true );
	wp_enqueue_script( 'jquery-magnific', get_template_directory_uri() . '/js/jquery.magnific-popup.min.js', array( 'jquery' ), '1.3', true );
	wp_enqueue_script( 'crowdpress-functions', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '1.3', true );
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}
add_action( 'wp_enqueue_scripts', 'crowdpress_scripts' );

?>