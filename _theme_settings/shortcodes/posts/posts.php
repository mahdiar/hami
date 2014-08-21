<?php



// ----------------------------------------------------------------------------------------------------
// Shortcode Button/Form

class Custom_Shortcodes_Posts
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
		array_push( $buttons, '|', 'js_posts_button' );
		return $buttons;
	}
	
	function filter_mce_plugin( $plugins ) {
		// this plugin file will work the magic of our button
		$plugins['js_posts'] = get_template_directory_uri() . '/_theme_settings/shortcodes/posts/script.js';
		return $plugins;
	}
}

$posts = new Custom_Shortcodes_Posts();



// ----------------------------------------------------------------------------------------------------
// Shortcode Display

function js_display_posts( $atts, $content=null ) {
	extract( shortcode_atts( array(
		'category' => '',
		'count' => 5
	), $atts ) );
			
	global $post;
	
	$args = array( 'post_type' => 'post', 'numberposts' => $count, 'category' => $category);
	$posts = get_posts($args);
	if ($posts) {
	
		ob_start();
		
		foreach ( $posts as $post ) {
		
			?><div class="single-post">
						
				<?php if (has_post_thumbnail($post->ID)){ ?>
					<div class="one_fourth postlist-thumbnail">
					<a href="<?php the_permalink() ?>"><?php
					$featured_caption = get_the_title($post->ID);
					$featured_image = get_the_post_thumbnail($post->ID,'thumbnail', array('title'=>$featured_caption));
					echo $featured_image;
					?></a></div>
				<?php } ?>
							
				<?php if (has_post_thumbnail($post->ID)){ ?>
					<div class="three_fourth last"><?php
				} ?>	
					
					<div class="post-content<?php if (!has_post_thumbnail($post->ID)){ ?> no-thumb<?php } ?>">
						<h4 id="post-<?php echo $post->ID; ?>"><a href="<?php echo get_permalink($post->ID) ?>"><?php echo $post->post_title; ?></a></h4>
						
						<?php if (of_get_option('js_hide_metainfo') == 0){
							$author_id = $post->post_author; ?>
							<p class="post-meta"><?php _e('Posted on','crowdpress'); ?> <strong><?php the_time('F j, Y') ?></strong> <?php _e('by','crowdpress'); ?> <?php echo '<a href="'.home_url().'/author/'.get_the_author_meta( 'user_nicename' , $author_id ).'/">'; the_author_meta( 'display_name' , $author_id ); echo '</a>'; ?> <?php _e('in','crowdpress'); ?>
							<?php the_category(', '); ?><br /><?php comments_number('', '<a href="'.get_permalink().'#comments">'.__('1 Comment','crowdpress').'</a>', '<a href="'.get_permalink().'#comments">% '.__('Comments','crowdpress').'</a>' ); ?></a></p>
						<?php } else { ?>
							<br />
						<?php } ?>

						<p><?php echo get_the_excerpt(); ?></p>

						<a href="<?php echo get_permalink($post->ID) ?>" class="more"><?php _e('Continue Reading','crowdpress'); ?></a>
					</div>
						
				<?php if (has_post_thumbnail($post->ID)){ ?>
					</div><?php
				} ?>
				
				<div class="cl"></div>
			
			</div><?php

		}
		
		return ob_get_clean();
		
	}
	
	wp_reset_query();
	
}
add_shortcode( 'display-posts', 'js_display_posts' );

?>