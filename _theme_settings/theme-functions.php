<?php

// ------------------------------------------------------------
// Add Thumbnails to Page/Post management screen

if ( !function_exists('AddThumbColumn') && function_exists('add_theme_support') ) {

    function AddThumbColumn($cols) {
        $cols['thumbnail'] = __('Featured Image','crowdpress');
        return $cols;
    }
    function AddThumbValue($column_name, $post_id) {
        if ( 'thumbnail' == $column_name ) {
        
        	if (has_post_thumbnail( $post_id )) :
				$image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'gallery-small' );
				if (is_array($image_url)) { $image_url = $image_url[0]; }
			endif;
        
            if ( isset($image_url) && $image_url ) {
                echo '<img style="border-radius:3px; margin:5px 0;" src="'.$image_url.'" width="100" />';
            } else {
                echo __('None','crowdpress');
            }
            
        }
    }
    
    // for posts
    add_filter( 'manage_posts_columns', 'AddThumbColumn' );
    add_action( 'manage_posts_custom_column', 'AddThumbValue', 10, 2 );
    
    // for pages
    add_filter( 'manage_pages_columns', 'AddThumbColumn' );
    add_action( 'manage_pages_custom_column', 'AddThumbValue', 10, 2 );
    
}

function check_contact_form($_my_post,$emailTo){
	if(isset($_my_post['submitted'])) {
	
		if(trim($_my_post['name']) === '') {
			$error = __('Please enter your name.','crowdpress');
			$hasError = true;
		} else {
			$name = trim($_my_post['name']);
		}
	
		if(trim($_my_post['email']) === '')  {
			$error = __('Please enter your email address.','crowdpress');
			$hasError = true;
		} else if (!preg_match("/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", trim($_my_post['email']))) {
			$error = __('You entered an invalid email address.','crowdpress');
			$hasError = true;
		} else {
			$email = trim($_my_post['email']);
		}
	
		if(trim($_my_post['question']) === '') {
			$error = __('Please enter your question.','crowdpress');
			$hasError = true;
		} else {
			if(function_exists('stripslashes')) {
				$comments = stripslashes(trim($_my_post['question']));
			} else {
				$comments = trim($_my_post['question']);
			}
		}
	
		if(!isset($hasError)) {
			$subject =  __('Campaign question from ','crowdpress').$name;
			$body = __("Name","crowdpress").": ".$name." \n\n".__("Email","crowdpress").": ".$email." \n\n".__("Question","crowdpress").": ".$comments;
			$headers = 'From: '.$name.' <'.$email.'>' . "\r\n" . 'Reply-To: ' . $email;
			wp_mail($emailTo, $subject, $body, $headers);
			return __('Your message has been sent!','crowdpress');
		} else {
			return $error;
		}
	
	}
}

function crowdpress_is_crowdfunding() {
	if ( class_exists( 'Easy_Digital_Downloads' ) && class_exists( 'ATCF_Campaign' ) )
		return true;

	return false;
}

function crowdpress_features_notice() {
	?>
	<div class="updated">
		<p><?php printf( 
				__( '<strong>Notice:</strong> CrowdPress will not work properly without the <strong><a href="%s">AppThemer Crowdfunding Plugin</a></strong> installed. <a href="%s" class="alignright">Hide this message.</a>', 'crowdpress' ), 
				wp_nonce_url( network_admin_url( 'update.php?action=install-plugin&plugin=appthemer-crowdfunding' ), 'install-plugin_appthemer-crowdfunding' ), 
				wp_nonce_url( add_query_arg( array( 'action' => 'crowdpress-hide-plugin-notice' ), admin_url( 'index.php' ) ), 'crowdpress-hide-plugin-notice' ) 
		); ?></p>
	</div>
<?php
}
if ( ( !crowdpress_is_crowdfunding() ) && is_admin() && ! get_user_meta( get_current_user_id(), 'crowdpress-hide-plugin-notice', true ) )
	add_action( 'admin_notices', 'crowdpress_features_notice' );

function crowdpress_hide_plugin_notice() {
	check_admin_referer( 'crowdpress-hide-plugin-notice' );

	$user_id = get_current_user_id();

	add_user_meta( $user_id, 'crowdpress-hide-plugin-notice', 1 );
}
if ( is_admin() )
	add_action( 'admin_action_crowdpress-hide-plugin-notice', 'crowdpress_hide_plugin_notice' );
	


// ------------------------------------------------------------
// Quick Word Truncation

function trunc($string, $your_desired_width) {
  $parts = preg_split('/([\s\n\r]+)/', $string, null, PREG_SPLIT_DELIM_CAPTURE);
  $parts_count = count($parts);

  $length = 0;
  $last_part = 0;
  for (; $last_part < $parts_count; ++$last_part) {
    $length += strlen($parts[$last_part]);
    if ($length > $your_desired_width) { break; }
  }

  return implode(array_slice($parts, 0, $last_part)).'...';
}



// ------------------------------------------------------------
// Pagination

function js_get_pagination($args = null) {
	global $wp_query;
	
	$total_pages = $wp_query->max_num_pages;
	$big = 999999999; // need an unlikely integer
	
	if ($total_pages > 1){
	
		echo '<div id="pagination">';
			echo paginate_links( array(
				'base' => @add_query_arg('paged','%#%'),
				'format' => '?paged=%#%',
				'current' => max( 1, get_query_var('paged') ),
				'total' => $wp_query->max_num_pages,
				'type' => 'list',
				'prev_text' => '&laquo;',
				'next_text' => '&raquo;',
			));
		echo '</div>';
	
	}
	
}



// ------------------------------------------------------------
// Top/Bottom Bar Content

function display_top_right_content(){
	$top_right_content_type = (of_get_option('js_top_right_content_type') ? of_get_option('js_top_right_content_type') : 'search');
	switch($top_right_content_type){
	
		case 'search' :
			echo '<form action="'.site_url().'" method="get" id="search-form">';
			echo '<input name="s" type="text" class="field" placeholder="Search..." />';
			echo '<input type="submit" class="submit" value="GO" />';
			echo '</form>';
			break;
			
		case 'social' :
			js_social_icons();
			break;
			
		case 'text' :
			echo '<ul class="right">';
			echo '<li>'.(of_get_option('js_top_right_text') ? of_get_option('js_top_right_text') : '').'</li>';
			echo '</ul>';
			break;
			
	}
}

function display_top_left_content(){
	echo '<ul>';
	echo '<li>'.(of_get_option('js_top_left_text') ? of_get_option('js_top_left_text') : '').'</li>';
	echo '</ul>';	
}

function display_bottom_right_content(){
	$top_right_content_type = (of_get_option('js_bottom_right_content_type') ? of_get_option('js_bottom_right_content_type') : 'social');
	switch($top_right_content_type){
	
		case 'social' :
			js_social_icons();
			break;
			
		case 'text' :
			echo '<p>'.(of_get_option('js_bottom_right_text') ? str_replace('[year]',date('Y'),of_get_option('js_bottom_right_text')) : '').'</p>';
			break;
			
	}
}

function display_bottom_left_content(){
	echo '<p>'.(of_get_option('js_bottom_left_text') ? nl2br(str_replace('[year]',date('Y'),of_get_option('js_bottom_left_text'))) : '').'</p>';
}



// ------------------------------------------------------------
// Social Icons

function js_social_icons(){
	
	if (of_get_option('js_social_icon_facebook') || of_get_option('js_social_icon_twitter') || of_get_option('js_social_icon_linkedin') || of_get_option('js_social_icon_vimeo') || of_get_option('js_social_icon_youtube') || of_get_option('js_social_icon_rss')):
		echo '<ul class="socials right">';
			echo (of_get_option('js_social_icon_facebook') ? '<li class="facebook"><a href="'.of_get_option('js_social_icon_facebook').'">Facebook</a></li>' : '');
			echo (of_get_option('js_social_icon_twitter') ? '<li class="twitter"><a href="'.of_get_option('js_social_icon_twitter').'">Twitter</a></li>' : '');
			echo (of_get_option('js_social_icon_linkedin') ? '<li class="linkedin"><a href="'.of_get_option('js_social_icon_linkedin').'">LinkedIn</a></li>' : '');
			echo (of_get_option('js_social_icon_vimeo') ? '<li class="vimeo"><a href="'.of_get_option('js_social_icon_vimeo').'">Vimeo</a></li>' : '');
			echo (of_get_option('js_social_icon_youtube') ? '<li class="youtube"><a href="'.of_get_option('js_social_icon_youtube').'">YouTube</a></li>' : '');
			echo (of_get_option('js_social_icon_rss') ? '<li class="rss"><a href="'.of_get_option('js_social_icon_rss').'">Feed</a></li>' : '');
		echo '</ul>';
	endif;

}

function crowdpress_count_user_campaigns( $userid ) {
	global $wpdb;

	$where = get_posts_by_author_sql( 'download', true, $userid);

	$count = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->posts $where" );

	return apply_filters( 'crowdpress_get_usernumposts', $count, $userid );
}


function js_social_buttons($post_id,$post_excerpt){

	global $post;

	$hide_facebook = of_get_option('js_hide_facebook_like');
	$hide_twitter = of_get_option('js_hide_twitter_tweet');
	$hide_google = of_get_option('js_hide_google_plus');
	$hide_pinterest = of_get_option('js_hide_pinterest');

	if (!$hide_google || !$hide_twitter || !$hide_facebook || !$hide_pinterest) {
		
		?><div class="entry-share">
	
			<span class="title"><?php _e( 'Share', 'crowdpress' ); ?>:</span>
			<?php $message = apply_filters( 'crowdpress_share_message', sprintf( __( 'Check out %s on %s! %s', 'crowdpress' ), $post->post_title, get_bloginfo( 'name' ), get_permalink() ) ); ?>
	
			<?php if (!$hide_twitter){ ?>
				<a href="<?php echo esc_url( sprintf( 'http://twitter.com/home?status=%s', urlencode( $message ) ) ); ?>" target="_blank" class="share-twitter"><i class="icon-twitter"></i></a>
			<?php } ?>
			
			<?php if (!$hide_google){ ?>
				<a href="https://plus.google.com/share?url=<?php the_permalink(); ?>" target="_blank" class="share-google"><i class="icon-gplus"></i></a>
			<?php } ?>	
			
			<?php if (!$hide_facebook){ ?>
				<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'campaign-thumb' ); ?>
				<a href="http://www.facebook.com/sharer.php?s=100
					&p[url]=<?php echo urlencode( get_permalink() ); ?>
					&p[images][0]=<?php echo urlencode( $image[0]); ?>
					&p[title]=<?php echo urlencode( $post->post_title ); ?>
					&p[summary]=<?php echo urlencode( $post->post_excerpt ); ?>" target="_blank" class="share-facebook"><i class="icon-facebook"></i></a>
			<?php } ?>
			
			<?php if (!$hide_pinterest){ ?>
				<a href="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>" target="_blank" class="share-pinterest"><i class="icon-pinterest"></i></a>
			<?php } ?>
			
			<a href="<?php the_permalink(); ?>" target="_blank" class="share-link"><i class="icon-link"></i></a>
			
			<a href="#campaign-widget-modal" class="share-widget modal-popup"><i class="icon-code"></i><span class="text">Embed</span></a>
	
			<div id="share-widget" class="modal">
				<?php get_template_part( 'modal', 'campaign-widget' ); ?>
			</div>
			
			<div class="clearboth"></div>
			
		</div><?php
	
	}

}



// ------------------------------------------------------------
// Breadcrumb Display

function js_breadcrumbs($post_id = ''){

	if (is_page()){ $hide_breadcrumbs = of_get_option('js_disable_breadcrumbs_pages');
	} else if (is_search()){ $hide_breadcrumbs = of_get_option('js_disable_breadcrumbs_search');
	} else if (is_single()){ $hide_breadcrumbs = of_get_option('js_disable_breadcrumbs_posts');
	} else { $hide_breadcrumbs = of_get_option('js_disable_breadcrumbs_posts'); }
	
	if ($hide_breadcrumbs != 1){

		$breadcrumbs = '<p id="breadcrumbs"><a href="'.home_url().'">Home</a>';


		if (is_home()){
		
			$breadcrumbs .= '&nbsp;&nbsp;&rsaquo;&nbsp;&nbsp;'.get_the_title( get_option('page_for_posts', true) );
		
		} else if (is_page()){
		
			$ancestors = get_post_ancestors($post_id);
			$ancestors = array_reverse($ancestors);
			if (!empty($ancestors)){
				foreach($ancestors as $page_id){
					$breadcrumbs .= '&nbsp;&nbsp;&rsaquo;&nbsp;&nbsp;<a href="'.get_permalink($page_id).'">'.get_the_title($page_id).'</a>';
				}
			}
		
		} else if (is_search()){
		
			$breadcrumbs .= '&nbsp;&nbsp;&rsaquo;&nbsp;&nbsp;'.__('Search Results','crowdpress');
		
		} else if (is_single()){
			
			$categories = get_the_category();
			$cat_name = $categories[0]->cat_name;
			$cat_link = get_category_link($categories[0]->cat_ID);
	
			$breadcrumbs .= '&nbsp;&nbsp;&rsaquo;&nbsp;&nbsp;<a href="'.$cat_link.'">'.$cat_name.'</a>';
			
		}
		
		if (!is_tax() && !is_archive() && !is_home()){
		
			$original_title = get_the_title($post_id);
			$shortened_title = substr(get_the_title($post_id), 0, 75);
			
			$orig_length = strlen($original_title);
			$new_length = strlen($shortened_title);
			
			$dots = ''; if ($new_length < $orig_length) { $dots = '...'; }
			
			$breadcrumbs .= '&nbsp;&nbsp;&rsaquo;&nbsp;&nbsp;'.$shortened_title.$dots.'</p>';
			
		} else if (is_tax() || is_archive()){ $breadcrumbs .= '&nbsp;&nbsp;&rsaquo;&nbsp;&nbsp;'.single_cat_title('',false).'</p>'; }
		
		echo $breadcrumbs;
		
	}
	
}



// ------------------------------------------------------------
// Misc Functions

function add_admin_menu_separator($position) {
	global $menu;
	$index = 0;
	if ($menu) {
		foreach($menu as $offset => $section) {
			if (substr($section[2],0,9)=='separator')
				$index++;
			if ($offset>=$position) {
				$menu[$position] = array('','read',"separator{$index}",'','wp-menu-separator');
				break;
			}
		}
	}
}

function main_menu_message(){ echo '<span style="top:0; display:block; position:relative; text-align:right; font-size:15px; color:#000;">Please <a style="color:#ed7134;" href="'.home_url().'/wp-admin/nav-menus.php">create and set a menu</a> for the main navigation.</span>'; }
function footer_menu_message(){ echo '<span style="top:0; display:block; position:relative; text-align:left; font-size:15px; color:#fff;">Please <a style="color:#ed7134;" href="'.home_url().'/wp-admin/nav-menus.php">create and set a menu</a> for the main navigation.</span>'; }

// Fix <p>'s and <br>'s from showing up around shortcodes.
add_filter('the_content', 'js_empty_paragraph_fix');
function js_empty_paragraph_fix($content)
{   
    $array = array ( '<p>[' => '[', ']</p>' => ']', ']<br />' => ']' );
    $content = strtr($content, $array);
    return $content;
}

function custom_excerpt($text) {
	$text = str_replace('[...]', '...', $text);
	return $text;
}
add_filter('get_the_excerpt', 'custom_excerpt');

function js_char_shortalize($text, $length = 180, $append = '...') {
	$new_text = substr($text, 0, $length);
	if (strlen($text) > $length) {
		$new_text .= '...';
	}
	return $new_text;
}

function getRelativeTime($date,$hide_date = false) {

	$date = strtotime($date);
	$diff = time() - $date;
		
	if ($diff<60)
		return "<b>".$diff . " second" . plural($diff) . " ago</b>";
	$diff = round($diff/60);
	if ($diff<60)
		return "<b>".$diff . " minute" . plural($diff) . " ago</b>";
	$diff = round($diff/60);
	if ($diff<24)
		return "<b>".$diff . " hour" . plural($diff) . " ago</b>";
	$diff = round($diff/24);
	if ($diff<7){
		$display = "<b>".$diff . " day" . plural($diff) . " ago</b>";
		if (!$hide_date){ $display .= " on <b>".date('F j, Y', $date)."</b> at <b>".date('g:ia', $date)."</b>"; }
		return $display;
	}
	$diff = round($diff/7);
	if ($diff<4){
		$display = "<b>".$diff . " week" . plural($diff) . " ago</b>";
		if (!$hide_date){ $display .= " on <b>".date('F j, Y', $date)."</b> at <b>".date('g:ia', $date)."</b>"; }
		return $display;
	}

	return "at <b>" .date('g:i'). " on " . date("F j, Y", $date)."</b>";
	
}

function makeClickableLinks($text) {

	$text = preg_replace(
	    '/(^|[^"])(((f|ht){1}tp:\/\/)[-a-zA-Z0-9@:%_\+.~#?&\/\/=]+)/i',
	    '\\1<a href="\\2" target="_blank">\\2</a>', 
	    $text
	);
	
	return $text;
	
}

function plural($num) {
	if ($num != 1)
		return "s";
}

class CrowdPressCustomNavigation extends Walker_Nav_Menu {
	
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul>\n";
	}
	
	function end_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "$indent</ul>\n";
	}

}

function get_page_ancestor($page_id) {
    $page_obj = get_page($page_id);
    while($page_obj->post_parent!=0) {
        $page_obj = get_page($page_obj->post_parent);
    }
    return get_page($page_obj->ID);
}

/*function crowdpress_campaign_contribute_custom_price() {
	global $edd_options;
?>
	<h2><?php echo apply_filters( 'crowdpress_pledge_custom_title', __( 'Enter your pledge amount', 'crowdpress' ) ); ?></h2>

	<p class="crowdpress_custom_price_wrap">
	<?php if ( ! isset( $edd_options['currency_position'] ) || $edd_options['currency_position'] == 'before' ) : ?>
		<span class="currency left">
			<?php echo edd_currency_filter( '' ); ?>
		</span>

		<input type="text" name="crowdpress_custom_price" id="crowdpress_custom_price" class="left" value="" />
	<?php else : ?>
		<input type="text" name="crowdpress_custom_price" id="crowdpress_custom_price" class="right" value="" />
		<span class="currency right">
			<?php echo edd_currency_filter( '' ); ?>
		</span>
	<?php endif; ?>
	</p>
<?php
}
add_action( 'edd_purchase_link_top', 'crowdpress_campaign_contribute_custom_price', 5 );*/

/**
 * Custom pledge level fix.
 *
 * If there is a custom price, figure out the difference
 * between that, and the price level they have chosen. Store
 * the differene in the cart item meta, so it can be added to
 * the total in the future.
 *
 * @since crowdpress 1.3
 *
 * @param array $cart_item The current cart item to be added.
 * @return array $cart_item The modified cart item.
 */
function crowdpress_edd_add_to_cart_item( $cart_item ) {
	if ( isset ( $_POST[ 'post_data' ] ) ) {
		$post_data = array();
		parse_str( $_POST[ 'post_data' ], $post_data );

		$custom_price = $post_data[ 'crowdpress_custom_price' ];
	} else {
		$custom_price = $_POST[ 'crowdpress_custom_price' ];
	}

	$custom_price = edd_sanitize_amount( $custom_price );
	
	$price        = edd_get_cart_item_price( $cart_item[ 'id' ], $cart_item[ 'options' ] );

	if ( $custom_price > $price ) {
		$cart_item[ 'options' ][ 'atcf_extra_price' ] = $custom_price - $price;
	
		return $cart_item;
	}

	return $cart_item;
}
//add_filter( 'edd_add_to_cart_item', 'crowdpress_edd_add_to_cart_item' );
//add_filter( 'edd_ajax_pre_cart_item_template', 'crowdpress_edd_add_to_cart_item' );

/**
 * Calculate the cart item total based on the existence of
 * an additional pledge amount.
 *
 * @since crowdpress 1.3
 *
 * @param int $price The current price.
 * @param int $item_id The ID of the cart item.
 * @param array $options Item meta for the current cart item.
 * @return int $price The updated price.
 */
function crowdpress_edd_cart_item_price( $price, $item_id, $options = array() ) {
	if ( isset ( $options[ 'atcf_extra_price' ] ) ) {
		$price = $price + $options[ 'atcf_extra_price' ];
	}

	return $price;
}
//add_filter( 'edd_cart_item_price', 'crowdpress_edd_cart_item_price', 10, 3 );

/**
 * Toggle custom pledge on/off
 *
 * @since crowdpress 1.4
 * 
 * @param $settings
 * @return $settings
 */
function crowdpress_crowdfunding_settings( $settings ) {
	$settings[ 'atcf_settings_custom_pledge' ] = array(
		'id'      => 'atcf_settings_custom_pledge',
		'name'    => __( 'Custom Pledging', 'crowdpress' ),
		'desc'    => __( 'Allow arbitrary amounts to be pledged.', 'crowdpress' ),
		'type'    => 'checkbox',
		'std'     => 1
	);

	return $settings;
}
add_filter( 'edd_settings_general', 'crowdpress_crowdfunding_settings', 100 );

function crowdpress_disable_custom_pledging() {
	global $edd_options;

	if ( isset ( $edd_options[ 'atcf_settings_custom_pledge' ] ) )
		return;

	remove_action( 'edd_purchase_link_top', 'crowdpress_campaign_contribute_custom_price', 5 );
	remove_filter( 'edd_add_to_cart_item', 'crowdpress_edd_add_to_cart_item' );
	remove_filter( 'edd_ajax_pre_cart_item_template', 'crowdpress_edd_add_to_cart_item' );
	remove_filter( 'edd_cart_item_price', 'crowdpress_edd_cart_item_price', 10, 3 );
	remove_action( 'init', 'crowdpress_reverse_purchase_button_location', 12 );
}
add_action( 'init', 'crowdpress_disable_custom_pledging' );

function crowdpress_login_form_args( $redirect ) {

	global $edd_options;
	$profile_page = $edd_options['profile_page'];
	
	$redirect = array( 'redirect' => add_query_arg( array( 'login' => 'success', 'logout' => false ), get_permalink($profile_page) ) );

	return $redirect;
}
add_filter( 'atcf_shortcode_login_form_args', 'crowdpress_login_form_args' );