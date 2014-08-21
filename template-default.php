<?php

// Sidebar Settings
$sidebar_layout = get_post_meta($post->ID, '_sidebar_layout', true);
$sidebar_layout = $sidebar_layout ? $sidebar_layout[0] : 'no-sidebar';
$sidebar_choice = get_post_meta($post->ID, '_sidebar_choice', true);

// Other Options
$other_options = get_post_meta($post->ID, '_page_options',true);

if ($sidebar_layout == 'no-sidebar'){
	$content_post_class = '';
} else if ($sidebar_layout == 'left'){
	$content_post_class = 'right';
	$sidebar_post_class = 'left';
} else if ($sidebar_layout == 'right'){
	$content_post_class = 'left';
	$sidebar_post_class = 'right';
}

// Page Widgets
$widget_layout = get_post_meta($post->ID, '_widget_layout', true);
$widget_layout = $widget_layout ? $widget_layout[0] : 'no-widgets';

if (isset($widget_layout) && $widget_layout != 'no-widgets'){
	$content_post_class .= ' has-widgets';
}

?>

<section id="main">
	<div class="shell shell-inner-page"<?php if ($widget_layout != 'no-widgets'){ ?> style="padding-bottom:0;"<?php } ?>>
		<div class="container clearfix <?php echo $content_post_class; ?>">
			<section id="content" <?php post_class($content_post_class); ?>>
				<article class="entry">
					<section>

						<?php if (isset($other_options) && is_array($other_options) && !in_array('hide_breadcrumbs',$other_options) || !isset($other_options) || !is_array($other_options)): js_breadcrumbs($post->ID); endif; ?>
						<?php if (isset($other_options) && is_array($other_options) && !in_array('hide_title',$other_options) || !isset($other_options) || !is_array($other_options)): ?><h1><?php the_title(); ?></h1><?php endif; ?>
						<?php the_content(); ?>
						
						<?php comments_template(); ?>
						
					</section>
				</article>

			</section>
			<?php if ($sidebar_layout != 'no-sidebar'){ ?>
			<aside class="<?php echo $sidebar_post_class; ?>">
				<?php dynamic_sidebar($sidebar_choice); ?>
			</aside>
			<div class="cl"></div>
			<?php } ?>
		</div>
	</div>
</section>