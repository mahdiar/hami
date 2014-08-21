<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 * 
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet (lowercase and without spaces)
	$themename = wp_get_theme();
	$themename = $themename['Name'];
	
	$themename = preg_replace("/\W/", "", strtolower($themename) );
	
	$optionsframework_settings = get_option('optionsframework');
	$optionsframework_settings['id'] = $themename;
	update_option('optionsframework', $optionsframework_settings);
	
	// echo $themename;
	
}

/* 
 * This is an example of how to add custom scripts to the options panel.
 * This one shows/hides the an option when a checkbox is clicked.
 */

add_action('optionsframework_custom_scripts', 'optionsframework_custom_scripts');

function optionsframework_custom_scripts() { ?>

<?php }

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the "id" fields, make sure to use all lowercase and no spaces.
 *  
 */

function optionsframework_options() {

	// Pull all the categories into an array
	$options_categories = array();  
	$options_categories_obj = get_categories();
	$options_categories[0] = __('All','crowdpress');
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}
	
	// Pull all the pages into an array
	$options_pages = array();  
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = __('None','crowdpress');
	foreach ($options_pages_obj as $page) {
    	$options_pages[$page->ID] = $page->post_title;
	}
	
	// Pull all the pages into an array
	$options_normal_pages = array();  
	$options_normal_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_normal_pages[''] = __('None','crowdpress');
	foreach ($options_normal_pages_obj as $normal_page) {
		$template_name = get_post_meta( $normal_page->ID, '_wp_page_template', true );
		if ($template_name == 'default' || $template_name == 'page-full.php' || $template_name == 'page-leftsidebar.php'){
    		$options_normal_pages[$normal_page->ID] = $normal_page->post_title;
    	}
	}
	
	// If using image radio buttons, define a directory path
	$imagepath =  get_stylesheet_directory_uri() . '/_theme_settings/images/';
		
	$options = array();

	
	$options[] = array( "name" => __("General Styling","crowdpress"),
						"type" => "heading");
						
	$options[] = array( "name" => __("Logo Replacement","crowdpress"),
						"desc" => __("Upload your own logo. Our recommendation is to keep it at 300px x 109px or smaller.","crowdpress"),
						"id" => "js_logo",
						"type" => "upload");
	
	$options[] = array( "name" => __("Logo Width (optional)","crowdpress"),
						"desc" => __("The default width for logos is \"174\". You can change this here by entering a new width.","crowdpress"),
						"id" => "js_logo_width",
						"std" => "174",
						"type" => "text");					
	
	$options[] = array( "name" => __("Logo Height (optional)","crowdpress"),
						"desc" => __("The default height for logos is \"109\". You can change this here by entering a new height.","crowdpress"),
						"id" => "js_logo_height",
						"std" => "109",
						"type" => "text");
						
	$options[] = array( "name" => __("Custom Color","crowdpress"),
						"desc" => __("You can change the custom color. (default is #eb713d)","crowdpress"),
						"id" => "js_highlight_color",
						"std" => "#eb713d",
						"type" => "color");
						
	$option_array = array('no' => "No",'yes' => "Yes");
	
	$options[] = array( "name" => __("Sticky Header?","crowdpress"),
						"desc" => __("You can optionally choose to stick the header to the top as you scroll down.","crowdpress"),
						"id" => "js_sticky_header",
						"std" => 'no',
						"type" => "radio",
						"options" => $option_array);
	
	$options[] = array( "name" => __("Image Zoom Effect?","crowdpress"),
						"desc" => __("You can optionally turn off the \"image zoom\" effect when hovering over campaign images.","crowdpress"),
						"id" => "js_image_zoom",
						"std" => 'no',
						"type" => "radio",
						"options" => $option_array);
						
	$options[] = array( "name" => __("Disable Responsiveness?","crowdpress"),
						"desc" => __("You can optionally turn off the mobile responsiveness.","crowdpress"),
						"id" => "js_responsive_disabled",
						"std" => 'no',
						"type" => "radio",
						"options" => $option_array);
		
	$options[] = array( "name" => __("Boxed style? (fixed width)","crowdpress"),
						"desc" => __("You can optionally choose to box the site and then set a custom background color/image.","crowdpress"),
						"id" => "js_body_boxed",
						"std" => 'no',
						"type" => "radio",
						"options" => $option_array);
						
	$options[] = array( "name" => __("Body Background Color (if boxed)","crowdpress"),
						"desc" => __("You can change the custom color. (default is #ffffff)","crowdpress"),
						"id" => "js_body_bg_color",
						"std" => "#ffffff",
						"type" => "color");					
						
	$options[] = array( "name" => __("Body Background Image (if boxed)","crowdpress"),
						"desc" => __("Upload your own image that will center and repeat in the background.","crowdpress"),
						"id" => "js_body_bg_image",
						"type" => "upload");
						
	$option_array = array('repeat' => "Repeat",'no-repeat' => "No Repeat",'repeat-x' => "Repeat Horizontally",'repeat-y' => "Repeat Vertically");
		
	$options[] = array( "name" => __("Body Background Repeat (if boxed)","crowdpress"),
						"desc" => '',
						"id" => "js_body_repeat",
						"std" => 'repeat',
						"type" => "radio",
						"options" => $option_array);
						
	$option_array = array('top center' => "Top Center",'top left' => "Top Left",'top right' => "Top Right");
		
	$options[] = array( "name" => __("Body Background Position (if boxed)","crowdpress"),
						"desc" => '',
						"id" => "js_body_position",
						"std" => 'top center',
						"type" => "radio",
						"options" => $option_array);
						
	$options[] = array( "name" => __("Favicon Replacement","crowdpress"),
						"desc" => __("Upload your own favicon. Be sure it's a 16px x 16px \"ico\" or \"png\" file.","crowdpress"),
						"id" => "js_favicon",
						"type" => "upload");
						
						
						
	$options[] = array( "name" => __("Homepage Slider","crowdpress"),
						"type" => "heading");
						
	$option_array = array('no' => "No",'yes' => "Yes");
	
	$options[] = array( "name" => __("Auto-cycle the slider?","crowdpress"),
						"desc" => __("Would you like the homepage slider to cycle automatically?","crowdpress"),
						"id" => "js_slider_auto_cycle",
						"std" => 'no',
						"type" => "radio",
						"options" => $option_array);
						
	$option_array = array('3' => "3 Seconds",'4' => "4 Seconds",'5' => "5 Seconds",'6' => "6 Seconds",'7' => "7 Seconds",'8' => "8 Seconds",'9' => "9 Seconds",'10' => "10 Seconds");
	
	$options[] = array( "name" => __("Time between slides","crowdpress"),
						"desc" => __("How quickly should the slider cycle?","crowdpress"),
						"id" => "js_slider_auto_cycle_speed",
						"std" => '5',
						"type" => "radio",
						"options" => $option_array);
						
								
	
	
	$options[] = array( "name" => __("Custom Fonts","crowdpress"),
						"type" => "heading");
	
	$options[] = array( "name" => __("Choose a font from the entire Google Library:","crowdpress"),
						"desc" => '',
						"id" => "js_custom_font",
						"std" => "Roboto",
						"type" => "select",
						"options" => array(
							'' => 'Choose a font to override the above...',
							'Aclonica' => 'Aclonica',
							'Allan' => 'Allan',
							'Annie+Use+Your+Telescope' => 'Annie Use Your Telescope',
							'Anonymous+Pro' => 'Anonymous Pro',
							'Allerta+Stencil' => 'Allerta Stencil',
							'Allerta' => 'Allerta',
							'Amaranth' => 'Amaranth',
							'Anton' => 'Anton',
							'Architects+Daughter' => 'Architects Daughter',
							'Arimo' => 'Arimo',
							'Artifika' => 'Artifika',
							'Arvo' => 'Arvo',
							'Asset' => 'Asset',
							'Astloch' => 'Astloch',
							'Average+Sans' => 'Average Sans',
							'Bangers' => 'Bangers',
							'Bentham' => 'Bentham',
							'Bevan' => 'Bevan',
							'Bigshot+One' => 'Bigshot One',
							'Bowlby+One' => 'Bowlby One',
							'Bowlby+One+SC' => 'Bowlby One SC',
							'Brawler' => 'Brawler ',
							'Buda:300' => 'Buda',
							'Cabin' => 'Cabin',
							'Calligraffitti' => 'Calligraffitti',
							'Candal' => 'Candal',
							'Cantarell' => 'Cantarell',
							'Cardo' => 'Cardo',
							'Carter One' => 'Carter One',
							'Caudex' => 'Caudex',
							'Cedarville+Cursive' => 'Cedarville Cursive',
							'Cherry+Cream+Soda' => 'Cherry Cream Soda',
							'Chewy' => 'Chewy',
							'Coda' => 'Coda',
							'Coming+Soon' => 'Coming Soon',
							'Copse' => 'Copse',
							'Corben:700' => 'Corben',
							'Cousine' => 'Cousine',
							'Covered+By+Your+Grace' => 'Covered By Your Grace',
							'Crafty+Girls' => 'Crafty Girls',
							'Crimson+Text' => 'Crimson Text',
							'Crushed' => 'Crushed',
							'Cuprum' => 'Cuprum',
							'Damion' => 'Damion',
							'Dancing+Script' => 'Dancing Script',
							'Dawning+of+a+New+Day' => 'Dawning of a New Day',
							'Didact+Gothic' => 'Didact Gothic',
							'Droid+Sans' => 'Droid Sans',
							'droidarabicnaskh' => 'Droid Arabic Naskh',
							'Droid+Sans+Mono' => 'Droid Sans Mono',
							'Droid+Serif' => 'Droid Serif',
							'EB+Garamond' => 'EB Garamond',
							'Expletus+Sans' => 'Expletus Sans',
							'Fontdiner+Swanky' => 'Fontdiner Swanky',
							'Forum' => 'Forum',
							'Francois+One' => 'Francois One',
							'Geo' => 'Geo',
							'Give+You+Glory' => 'Give You Glory',
							'Goblin+One' => 'Goblin One',
							'Goudy+Bookletter+1911' => 'Goudy Bookletter 1911',
							'Gravitas+One' => 'Gravitas One',
							'Gruppo' => 'Gruppo',
							'Hammersmith+One' => 'Hammersmith One',
							'Holtwood+One+SC' => 'Holtwood One SC',
							'Homemade+Apple' => 'Homemade Apple',
							'Inconsolata' => 'Inconsolata',
							'Indie+Flower' => 'Indie Flower',
							'IM+Fell+DW+Pica' => 'IM Fell DW Pica',
							'IM+Fell+DW+Pica+SC' => 'IM Fell DW Pica SC',
							'IM+Fell+Double+Pica' => 'IM Fell Double Pica',
							'IM+Fell+Double+Pica+SC' => 'IM Fell Double Pica SC',
							'IM+Fell+English' => 'IM Fell English',
							'IM+Fell+English+SC' => 'IM Fell English SC',
							'IM+Fell+French+Canon' => 'IM Fell French Canon',
							'IM+Fell+French+Canon+SC' => 'IM Fell French Canon SC',
							'IM+Fell+Great+Primer' => 'IM Fell Great Primer',
							'IM+Fell+Great+Primer+SC' => 'IM Fell Great Primer SC',
							'Irish+Grover' => 'Irish Grover',
							'Irish+Growler' => 'Irish Growler',
							'Istok+Web' => 'Istok Web',
							'Josefin+Sans' => 'Josefin Sans Regular 400',
							'Josefin+Slab' => 'Josefin Slab Regular 400',
							'Judson' => 'Judson',
							'Jura' => ' Jura Regular',
							'Jura:500' => ' Jura 500',
							'Jura:600' => ' Jura 600',
							'Just+Another+Hand' => 'Just Another Hand',
							'Just+Me+Again+Down+Here' => 'Just Me Again Down Here',
							'Kameron' => 'Kameron',
							'Kenia' => 'Kenia',
							'Kranky' => 'Kranky',
							'Kreon' => 'Kreon',
							'Kristi' => 'Kristi',
							'La+Belle+Aurore' => 'La Belle Aurore',
							'Lato:100' => 'Lato 100',
							'Lato:100italic' => 'Lato 100 (plus italic)',
							'Lato:300' => 'Lato Light 300',
							'Lato' => 'Lato',
							'Lato:bold' => 'Lato Bold 700',
							'Lato:900' => 'Lato 900',
							'League+Script' => 'League Script',
							'Lekton' => ' Lekton ',
							'Limelight' => ' Limelight ',
							'Lobster' => 'Lobster',
							'Lobster Two' => 'Lobster Two',
							'Lora' => 'Lora',
							'Love+Ya+Like+A+Sister' => 'Love Ya Like A Sister',
							'Loved+by+the+King' => 'Loved by the King',
							'Luckiest+Guy' => 'Luckiest Guy',
							'Maiden+Orange' => 'Maiden Orange',
							'Mako' => 'Mako',
							'Maven+Pro' => ' Maven Pro',
							'Maven+Pro:500' => ' Maven Pro 500',
							'Maven+Pro:700' => ' Maven Pro 700',
							'Maven+Pro:900' => ' Maven Pro 900',
							'Meddon' => 'Meddon',
							'MedievalSharp' => 'MedievalSharp',
							'Megrim' => 'Megrim',
							'Merriweather' => 'Merriweather',
							'Metrophobic' => 'Metrophobic',
							'Michroma' => 'Michroma',
							'Miltonian Tattoo' => 'Miltonian Tattoo',
							'Miltonian' => 'Miltonian',
							'Modern Antiqua' => 'Modern Antiqua',
							'Monofett' => 'Monofett',
							'Molengo' => 'Molengo',
							'Mountains of Christmas' => 'Mountains of Christmas',
							'Muli:300' => 'Muli Light',
							'Muli' => 'Muli Regular',
							'Neucha' => 'Neucha',
							'Neuton' => 'Neuton',
							'News+Cycle' => 'News Cycle',
							'Nixie+One' => 'Nixie One',
							'Nobile' => 'Nobile',
							'Nova+Cut' => 'Nova Cut',
							'Nova+Flat' => 'Nova Flat',
							'Nova+Mono' => 'Nova Mono',
							'Nova+Oval' => 'Nova Oval',
							'Nova+Round' => 'Nova Round',
							'Nova+Script' => 'Nova Script',
							'Nova+Slim' => 'Nova Slim',
							'Nova+Square' => 'Nova Square',
							'Nunito:light' => ' Nunito Light',
							'Nunito' => ' Nunito Regular',
							'OFL+Sorts+Mill+Goudy+TT' => 'OFL Sorts Mill Goudy TT',
							'Old+Standard+TT' => 'Old Standard TT',
							'Open+Sans' => 'Open Sans',
							'Orbitron' => 'Orbitron',
							'Oswald' => 'Oswald',
							'Over+the+Rainbow' => 'Over the Rainbow',
							'Reenie+Beanie' => 'Reenie Beanie',
							'Pacifico' => 'Pacifico',
							'Patrick+Hand' => 'Patrick Hand',
							'Paytone+One' => 'Paytone One',
							'Permanent+Marker' => 'Permanent Marker',
							'Philosopher' => 'Philosopher',
							'Play' => 'Play',
							'Playfair+Display' => ' Playfair Display ',
							'Podkova' => ' Podkova ',
							'PT+Sans' => 'PT Sans',
							'PT+Sans+Narrow' => 'PT Sans Narrow',
							'PT+Sans+Narrow:regular,bold' => 'PT Sans Narrow (plus bold)',
							'PT+Serif' => 'PT Serif',
							'PT+Serif Caption' => 'PT Serif Caption',
							'Puritan' => 'Puritan',
							'Quattrocento' => 'Quattrocento',
							'Quattrocento+Sans' => 'Quattrocento Sans',
							'Radley' => 'Radley',
							'Raleway:100' => 'Raleway',
							'Redressed' => 'Redressed',
							'Roboto' => 'Roboto',
							'Rock+Salt' => 'Rock Salt',
							'Rokkitt' => 'Rokkitt',
							'Ruslan+Display' => 'Ruslan Display',
							'Sanchez' => 'Sanchez',
							'Schoolbell' => 'Schoolbell',
							'Shadows+Into+Light' => 'Shadows Into Light',
							'Shanti' => 'Shanti',
							'Sigmar+One' => 'Sigmar One',
							'Six+Caps' => 'Six Caps',
							'Slackey' => 'Slackey',
							'Smythe' => 'Smythe',
							'Sniglet:800' => 'Sniglet',
							'Special+Elite' => 'Special Elite',
							'Stardos+Stencil' => 'Stardos Stencil',
							'Strait' => 'Strait',
							'Sue+Ellen+Francisco' => 'Sue Ellen Francisco',
							'Sunshiney' => 'Sunshiney',
							'Swanky+and+Moo+Moo' => 'Swanky and Moo Moo',
							'Syncopate' => 'Syncopate',
							'Tangerine' => 'Tangerine',
							'Tenor+Sans' => ' Tenor Sans ',
							'Terminal+Dosis+Light' => 'Terminal Dosis Light',
							'The+Girl+Next+Door' => 'The Girl Next Door',
							'Tinos' => 'Tinos',
							'Ubuntu' => 'Ubuntu',
							'Ultra' => 'Ultra',
							'Unkempt' => 'Unkempt',
							'UnifrakturCook:bold' => 'UnifrakturCook',
							'UnifrakturMaguntia' => 'UnifrakturMaguntia',
							'Varela' => 'Varela',
							'Varela Round' => 'Varela Round',
							'Vibur' => 'Vibur',
							'Vollkorn' => 'Vollkorn',
							'VT323' => 'VT323',
							'Waiting+for+the+Sunrise' => 'Waiting for the Sunrise',
							'Wallpoet' => 'Wallpoet',
							'Walter+Turncoat' => 'Walter Turncoat',
							'Wire+One' => 'Wire One',
							'Yanone+Kaffeesatz' => 'Yanone Kaffeesatz',
							'Yanone+Kaffeesatz:300' => 'Yanone Kaffeesatz:300',
							'Yanone+Kaffeesatz:400' => 'Yanone Kaffeesatz:400',
							'Yanone+Kaffeesatz:700' => 'Yanone Kaffeesatz:700',
							'Yeseva+One' => 'Yeseva One',
							'Zeyada' => 'Zeyada')
						);	
	
	$options[] = array( "name" => __("Font preview (save to refresh the preview):","crowdpress"),
						"id" => "js_font_preview",
						"type" => "custom_font_preview");
			
	$options[] = array( "name" => __("Comment Disabling","crowdpress"),
						"type" => "heading");
			
	$option_array = array('yes' => "Yes",'no' => "No");
		
	$options[] = array( "name" => __("Disable comments on pages?","crowdpress"),
						"desc" => __("Select 'yes' if you want to hide the commenting for all pages.","crowdpress"),
						"id" => "js_disable_page_comments",
						"std" => true,
						"type" => "radio",
						"options" => $option_array);
		
	$options[] = array( "name" => __("Disable comments on posts?","crowdpress"),
						"desc" => __("Select 'yes' if you want to hide the commenting for all posts.","crowdpress"),
						"id" => "js_disable_post_comments",
						"std" => false,
						"type" => "radio",
						"options" => $option_array);
		
	$options[] = array( "name" => __("Disable comments on campaigns?","crowdpress"),
						"desc" => __("Select 'yes' if you want to hide the commenting for all campaigns.","crowdpress"),
						"id" => "js_disable_campaign_comments",
						"std" => true,
						"type" => "radio",
						"options" => $option_array);


	
	$options[] = array( "name" => __("Social Settings","crowdpress"),
						"type" => "heading");
						
	$options[] = array( "name" => __("Hide the \"Facebook Like\" on Campaigns?","crowdpress"),
						"desc" => '',
						"id" => "js_hide_facebook_like",
						"std" => false,
						"type" => "checkbox",
						"label" => 'Yes');
						
	$options[] = array( "name" => __("Hide the \"Twitter Tweet\" on Campaigns?","crowdpress"),
						"desc" => '',
						"id" => "js_hide_twitter_tweet",
						"std" => false,
						"type" => "checkbox",
						"label" => 'Yes');
						
	$options[] = array( "name" => __("Hide \"Google Plus\" on Campaigns?","crowdpress"),
						"desc" => '',
						"id" => "js_hide_google_plus",
						"std" => false,
						"type" => "checkbox",
						"label" => 'Yes');
						
	$options[] = array( "name" => __("Hide \"Pinterest\" on Campaigns?","crowdpress"),
						"desc" => '',
						"id" => "js_hide_pinterest",
						"std" => false,
						"type" => "checkbox",
						"label" => 'Yes');
						
	$options[] = array( "name" => __("Facebook","crowdpress"),
						"desc" => __("Paste your Facebook profile or page URL here.","crowdpress"),
						"id" => "js_social_icon_facebook",
						"std" => "",
						"type" => "text");
						
	$options[] = array( "name" => __("Twitter","crowdpress"),
						"desc" => __("Paste your Twitter profile URL here.","crowdpress"),
						"id" => "js_social_icon_twitter",
						"std" => "",
						"type" => "text");
						
	$options[] = array( "name" => __("LinkedIn","crowdpress"),
						"desc" => __("Paste your LinkedIn profile URL here.","crowdpress"),
						"id" => "js_social_icon_linkedin",
						"std" => "",
						"type" => "text");
						
	$options[] = array( "name" => __("Youtube","crowdpress"),
						"desc" => __("Paste your Youtube profile URL here.","crowdpress"),
						"id" => "js_social_icon_youtube",
						"std" => "",
						"type" => "text");
						
	$options[] = array( "name" => __("Vimeo","crowdpress"),
						"desc" => __("Paste your Vimeo profile URL here.","crowdpress"),
						"id" => "js_social_icon_vimeo",
						"std" => "",
						"type" => "text");
						
	$options[] = array( "name" => __("RSS Feed","crowdpress"),
						"desc" => __("Paste your RSS Feed URL here.","crowdpress"),
						"id" => "js_social_icon_rss",
						"std" => "",
						"type" => "text");
						
						
	$options[] = array( "name" => __("Facebook Settings","crowdpress"),
						"type" => "heading");

	$info = <<<HTML
<p><strong>All of the Facebook functionality in this theme requires a Facebook application for communication with 3rd party sites. Here are the steps for creating and setting up a Facebook application:</strong></p>
<ol>
<li>Go to <a href="https://developers.facebook.com/apps/?action=create" target="_blank">https://developers.facebook.com/apps/?action=create</a> and log in, if necessary.</li>
<li>Supply the necessary required fields, and solve the CAPTCHA.</li>
<li>Submit the form</li>
<li>On the next screen scroll down to "Your access token" section and click the "Create my access token" button.</li>
<li>Copy the App ID and App Secret Secret to the fields below.</li>
</ol>
HTML;

	$options[] = array( "name" => __( "Instructions", "crowdpress" ),
						"desc" => $info,
						"type" => "info" );
												
	$options[] = array( "name" => "Facebook App ID",
						"type" => "text",
						"id"   => "facebook_app_id",
						"std"  => "" );

	$options[] = array( "name" => "Facebook App Secret",
						"type" => "text",
						"id"   => "facebook_app_secret",
						"std"  => "" );

	$options[] = array( "name" => __("Twitter Settings","gymboom"),
						"type" => "heading");

	$info = <<<HTML
<p><strong>Twitter API requires a Twitter application for communication with 3rd party sites. Here are the steps for creating and setting up a Twitter application:</strong></p>
<ol>
	<li>Go to <a href="https://dev.twitter.com/apps/new" target="_blank">https://dev.twitter.com/apps/new</a> and log in, if necessary</li>
	<li>Supply the necessary required fields, accept the TOS, and solve the CAPTCHA. Callback URL field may be left empty</li>
	<li>Submit the form</li>
	<li>On the next screen scroll down to "Your access token" section and click the "Create my access token" button</li>
	<li>Copy the following fields: Access token, Access token secret, Consumer key, Consumer secret to the fields below</li>
</ol>
HTML;

	$options[] = array( "name" => __( "Instructions", "gymboom" ),
						"desc" => __( $info, "gymboom" ),
						"type" => "info" );
												
	$options[] = array( "name" => "Twitter Oauth Access Token",
						"type" => "text",
						"id"   => "twitter_oauth_access_token",
						"std"  => "" );

	$options[] = array( "name" => "Twitter Oauth Access Token Secret",
						"type" => "text",
						"id"   => "twitter_oauth_access_token_secret",
						"std"  => "" );

	$options[] = array( "name" => "Twitter Consumer Key",
						"type" => "text",
						"id"   => "twitter_consumer_key",
						"std"  => "" );

	$options[] = array( "name" => "Twitter Consumer Secret",
						"type" => "text",
						"id"   => "twitter_consumer_secret",
						"std"  => "" );		

								
						
	$options[] = array( "name" => __("Footer","crowdpress"),
						"type" => "heading");
						
	$options[] = array( "name" => __("Default Footer Widget Setting","crowdpress"),
						"desc" => '',
						"id" => "js_footer_widgets",
						"std" => false,
						"type" => "select",
						"options" => array(
							false => 'No widgets',
							1 => 'Single Column',
							2 => 'Two Columns',
							3 => 'Three Columns',
							4 => 'Four Columns')
						);
						
	$options[] = array( "name" => __("Footer Background Color","crowdpress"),
						"desc" => __("You can change the custom background color. (default is #333333)","crowdpress"),
						"id" => "js_footer_background_color",
						"std" => "#333333",
						"type" => "color");
						
	$options[] = array( "name" => __("Footer Logo Replacement","crowdpress"),
						"desc" => __("Upload your own logo. Make the image exactly 143px x 32px or smaller.","crowdpress"),
						"id" => "js_footer_logo",
						"type" => "upload");
						
	$options[] = array( "name" => __("Left Text","crowdpress"),
						"desc" => __("You can use [year] to display the year.","crowdpress"),
						"id" => "js_bottom_left_text",
						"std" => "Copyright &copy;2005-[year] Scheetz Designs. Put whatever you want in this spot!",
						"type" => "textarea");
	
	$option_array = array('social' => "Social Icons",'text' => "Text");
		
	$options[] = array( "name" => __("Right Content Type","crowdpress"),
						"desc" => __("Choose the type of content you want to display on the right side of the footer.","crowdpress"),
						"id" => "js_bottom_right_content_type",
						"std" => "social",
						"type" => "radio",
						"options" => $option_array);
						
	$options[] = array( "name" => __("Right Text (if selected above)","crowdpress"),
						"desc" => __("You can use &lt;span&gt; tags to colorize &amp; bold specific text.","crowdpress"),
						"id" => "js_bottom_right_text",
						"std" => "Custom Text. Feel free to add anything here.",
						"type" => "textarea");
						
	$options[] = array( "name" => __("Disable the Footer Bar?","crowdpress"),
						"desc" => '',
						"id" => "js_bottom_bar_disabled",
						"std" => false,
						"type" => "checkbox",
						"label" => 'Yes');
						
						
									
	$options[] = array( "name" => __("Breadcrumbs","crowdpress"),
						"type" => "heading");
						
	$options[] = array( "name" => __("Disable the Breadcrumbs on Pages?","crowdpress"),
						"desc" => '',
						"id" => "js_disable_breadcrumbs_pages",
						"std" => false,
						"type" => "checkbox",
						"label" => 'Yes');
	
	$options[] = array( "name" => __("Disable the Breadcrumbs on Posts?","crowdpress"),
						"desc" => '',
						"id" => "js_disable_breadcrumbs_posts",
						"std" => false,
						"type" => "checkbox",
						"label" => 'Yes');
	
	$options[] = array( "name" => __("Disable the Breadcrumbs on Search Results?","crowdpress"),
						"desc" => '',
						"id" => "js_disable_breadcrumbs_search",
						"std" => false,
						"type" => "checkbox",
						"label" => 'Yes');
										
											
	
	$options[] = array( "name" => __("Other Options","crowdpress"),
						"type" => "heading");
	
	$options[] = array( "name" => __("404 Page Content","crowdpress"),
						"desc" => __("This is what will show up on the 404 page. HTML Allowed.","crowdpress"),
						"id" => "js_404_content",
						"std" => "<p>".__("Sorry, the page cannot be found.","crowdpress")."</p>",
						"type" => "textarea");
						
	$options[] = array( "name" => __("Google Analytics Code","crowdpress"),
						"desc" => __("Enter your code, this shows up right above the </head> tag.","crowdpress"),
						"id" => "js_google_analytics",
						"std" => "",
						"type" => "textarea");
						
	$options[] = array( "name" => __("Custom CSS Code","crowdpress"),
						"desc" => __("Enter your own styles to overwrite whatever you need to.","crowdpress"),
						"id" => "js_custom_css",
						"std" => "",
						"type" => "textarea");
	
	
		
	
			
	return $options;
}