<!DOCTYPE html>

<!--[if lt IE 7 ]> <html class="ie ie6 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7 ]>    <html class="ie ie7 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]>    <html class="ie ie8 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9 ]>    <html class="ie ie9 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 9]><!--><html class="no-js" <?php language_attributes(); ?>><!--<![endif]-->

<head>
	
	<?php global $template_dir, $post;
	$template_dir = get_template_directory_uri();
	
	$logo_height = of_get_option('js_logo_height');
	if (!$logo_height){ $logo_height = 109; }
	
	$logo_width = of_get_option('js_logo_width');
	if (!$logo_width){ $logo_width = 174; } ?>
	
	<title><?php wp_title('&mdash;', true, 'right'); ?><?php bloginfo('name'); ?></title>
	<meta charset="<?php bloginfo('charset'); ?>">
	
	<!-- Apple iOS Settings -->
	<meta name="viewport" content="initial-scale=1, width=device-width, minimum-scale=1" />
	
	<?php $header_image = get_post_meta($post->ID, '_header_image', true);
	$header_parallax = get_post_meta($post->ID, '_header_image_parallax', true);
	
	$slider_auto_cycle = (of_get_option('js_slider_auto_cycle') ? of_get_option('js_slider_auto_cycle') : 'no');
	$slider_auto_cycle_speed = (of_get_option('js_slider_auto_cycle_speed') ? of_get_option('js_slider_auto_cycle_speed') : 5);
	
	$custom_logo = of_get_option('js_logo');
	$logo_width = of_get_option('js_logo_width');
	$logo_height = of_get_option('js_logo_height');
	$footer_text_style = of_get_option('js_footer_text_style');
	
	$header_bg_color = (of_get_option('js_header_background_color') ? of_get_option('js_header_background_color') : '#603C25');
	$header_bg_image = (of_get_option('js_header_background_image') ? of_get_option('js_header_background_image') : $template_dir.'/_theme_styles/images/wood-bg.jpg');
	$header_bg_align = (of_get_option('js_header_background_image_alignment') ? of_get_option('js_header_background_image_alignment') : 'top center');
	$header_bg_repeat = (of_get_option('js_header_background_image_repeat') ? of_get_option('js_header_background_image_repeat') : 'repeat');
	$header_bg_disabled = (of_get_option('js_header_bg_disabled') ? true : false);
	$sticky_header = (of_get_option('js_sticky_header') ? of_get_option('js_sticky_header') : 'no');
	$image_zoom = (of_get_option('js_image_zoom') ? of_get_option('js_image_zoom') : 'no');
	
	$footer_bg_color = (of_get_option('js_footer_background_color') ? of_get_option('js_footer_background_color') : '#333333');
	$footer_bg_image = (of_get_option('js_footer_background_image') ? of_get_option('js_footer_background_image') : $template_dir.'/_theme_styles/images/footer.jpg');
	$footer_bg_align = (of_get_option('js_footer_background_image_alignment') ? of_get_option('js_footer_background_image_alignment') : 'top center');
	$footer_bg_repeat = (of_get_option('js_footer_background_image_repeat') ? of_get_option('js_footer_background_image_repeat') : 'repeat');
	$footer_bg_disabled = (of_get_option('js_footer_bg_disabled') ? true : false);
	
	?><script type="text/javascript"><?php
	if ($header_image):
		if ($header_parallax):
			?>var parallax = true;<?php
		else :
			?>var parallax = false;<?php
		endif;
	else :
		?>var parallax = false;<?php
	endif;
	
	if ($sticky_header != 'no'):
		?>var isSticky = true;<?php
	else :
		?>var isSticky = false;<?php
	endif; ?>
	
	var slider_auto_cycle = <?php echo (of_get_option('js_slider_auto_cycle') == 'yes' ? 'true' : 'false'); ?>;
	var slider_auto_cycle_speed = <?php echo (of_get_option('js_slider_auto_cycle_speed') ? of_get_option('js_slider_auto_cycle_speed') * 1000 : 5000); ?>;
	
	</script>
	
	<?php // Is there a custom logo or background image?
	
		wp_head();
		
		if ($custom_logo || $footer_bg_color){ echo '<style type="text/css">'; }
		if ($custom_logo){ echo '#logo { background: url(\''.$custom_logo.'\') left center no-repeat; }'; }
		
		if ($logo_width){ echo '#logo { width:'.$logo_width.'px; }'; }
		if ($logo_height){ echo 'header#top { height:'.$logo_height.'px; } h1#logo a { height:'.$logo_height.'px; }'; }
		
		if ($sticky_header == 'yes'){
			$body_padding = $logo_height - 30;
			echo 'header#top { position:fixed; width: 100%; top:'.(is_admin_bar_showing() ? '32px' : '0').'; left:0; } body { padding-top:'.$logo_height.'px; }';
			echo 'header#top.smushed { -moz-box-shadow:0 1px 15px rgba(0,0,0,0.2); -webkit-box-shadow:0 1px 15px rgba(0,0,0,0.2); box-shadow:0 1px 15px rgba(0,0,0,0.2); }'; }
		if ($image_zoom == 'yes'){
			echo '.project-block .image:hover img, .project-big .image:hover img { -webkit-transform:scale(1.1); -moz-transform:scale(1.1); transform:scale(1.1); opacity:0.8; }
			.grid-wrapper .image:hover img { -webkit-transform:scale(1.05); -moz-transform:scale(1.05); transform:scale(1.05); }';
		}
				
		if ($footer_bg_color){
			echo 'footer { background-color: '.$footer_bg_color.'; }';
		}
		
		if ($custom_logo || $footer_bg_color){ echo '</style>'; }
			
	?>
	
	<?php $boxed = of_get_option('js_body_boxed');
	
	if ($boxed == 'yes'):
	
		$body_color = (of_get_option('js_body_bg_color') ? of_get_option('js_body_bg_color') : '#fff');
		$body_image = (of_get_option('js_body_bg_image') ? of_get_option('js_body_bg_image') : '');
		$body_repeat = (of_get_option('js_body_repeat') ? of_get_option('js_body_repeat') : 'repeat');
		$body_position = (of_get_option('js_body_position') ? of_get_option('js_body_position') : 'top center');
		if ($body_color || $body_image): echo '<style type="text/css">body { background:'.($body_color ? $body_color : '').($body_image ? ' url('.$body_image.') '.$body_repeat.' '.$body_position : '').' !important; }</style>'; endif; ?>
	
	<?php endif; ?>
	
	<?php if (of_get_option('js_favicon')){ ?>
		<!-- The Favicon, change this to whatever you'd like -->
		<link rel="shortcut icon" href="<?php echo of_get_option('js_favicon'); ?>" />
	<?php } else { ?>
		<link rel="shortcut icon" href="<?php echo $template_dir; ?>/_theme_styles/images/favicon.ico" />
	<?php } ?>
	
	<?php $google_analytics = of_get_option('js_google_analytics');
	if ($google_analytics) {
		echo $google_analytics;
	} ?>
	
	<?php $custom_css = of_get_option('js_custom_css');
	if ($custom_css) {
		echo '<style type="text/css">'.$custom_css.'</style>';
	} ?>
	
</head>
<body <?php body_class(); ?>>

	<?php if ($boxed == 'yes'): echo '<div class="boxed">'; endif; ?>
	
	<?php
	$mobile_nav_toggle_class = 'toggle-shell';
	
	if ($post) {
	
		// Set up <header> classes
		$slider_choice = get_post_meta($post->ID, '_slider_choice', true);
		$top_bar_disabled = of_get_option('js_top_bar_disabled');
		$header_classes = array();
		
		if ($slider_choice){
			$slider_type = get_post_meta($slider_choice, '_slider_type', true);
			$header_classes[] = 'has-slider';
		}
		if ($top_bar_disabled){
			$header_classes[] = 'no-top-bar';
		}
		if (isset($slider_type) && $slider_type == 'one-by-one'){
			$header_classes[] = 'type-oneByOne';
		}
		if (isset($slider_type) && $slider_type == 'behind-header'){
			$header_classes[] = 'type-behind';
			$mobile_nav_toggle_class .= ' abs-slider';
		}
	}

	$header_classes = (!empty($header_classes)) ? ' class="'.implode(' ',$header_classes).'"' : '';
	
	?>
	
	<div id="mobile-nav">
		<?php  // Display Mobile Menu
		$crowdpressWalker = new CrowdPressCustomNavigation();
		wp_nav_menu(array('container' => false, 'theme_location' => 'main-menu', 'fallback_cb' => 'main_menu_message', 'walker' => $crowdpressWalker));
		?>
	</div>
	
	<header id="top">
		<div class="shell">
			<a id="logo" href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a>
			<nav>
				<?php // Display Main Menu
				wp_nav_menu(array('container' => false, 'theme_location' => 'main-menu', 'fallback_cb' => 'main_menu_message', 'walker' => $crowdpressWalker));
				?>
			</nav>
			
			<?php if ( is_user_logged_in() ) { global $edd_options; ?> 
				<div class="account-nav">
					<?php if ($edd_options['profile_page']): ?><a href="<?php echo get_permalink($edd_options['profile_page']); ?>"><?php _e('My Account','crowdpress'); ?></a><?php endif; ?>
					<?php if ($edd_options['login_page']): ?><a href="<?php echo wp_logout_url(get_permalink($edd_options['login_page'])); ?>"><?php _e('Logout','crowdpress'); ?></a><?php endif; ?>
				</div>
			<?php } else { global $edd_options; ?>
				<div class="account-nav">
					<?php if ($edd_options['login_page']): ?><a href="<?php echo get_permalink($edd_options['login_page']); ?>"><?php _e('Sign In','crowdpress'); ?></a><?php endif; ?>
				</div>
			<?php } ?>
			
			<div class="<?php echo $mobile_nav_toggle_class ?>"><a href="#" class="mobile-nav-toggle">+</a></div>
		</div>	
	</header>
	