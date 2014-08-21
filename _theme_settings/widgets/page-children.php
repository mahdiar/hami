<?php

// Page Children
class ThemeWidgetPageChildren extends ThemeWidgetBase {
	function ThemeWidgetPageChildren() {
		$widget_opts = array(
			'classname' => 'theme-widget widget-subnav',
			'description' => __( 'Displays the direct children of the current page ancestor. This widget is displayed only on pages.','crowdpress'));
		$control_ops = array();
		$this->WP_Widget('theme-widget-top-level-page-children', __('[CROWDPRESS] List Child Pages','crowdpress'), $widget_opts, $control_ops);
	}
	function front_end($args, $instance) {
		extract($args);
		global $wp_query, $post;
		
		if (!is_page()) {
			return;
		}
		
		$anc = get_page_ancestor(get_the_id());
		$children = get_pages('sort_column=menu_order&order=ASC&parent=' . $anc->ID . '&child_of=' . $anc->ID);
		if (!$children) {
			return;
		}
		
		echo $before_title . $anc->post_title . $after_title; ?>
		
		<div class="side-nav">
			<ul class="bit">
				<?php foreach ($children as $child): ?>
					<li <?php echo (is_page($child->ID) ? 'class="current_page_item"' : ''); ?>><a href="<?php echo get_permalink($child->ID); ?>"><span><?php echo apply_filters('the_title', $child->post_title); ?></span></a></li>
				<?php endforeach; ?>
			</ul>
		</div>
		<?php
	}
}

?>