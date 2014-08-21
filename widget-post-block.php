<?php

// Get the post format
$post_format = get_post_format($post->ID);

?><div class="item<?php echo ($post_format ? " ".$post_format : ''); ?>"<?php if (!has_post_thumbnail($post->ID) || $hide_thumbnails){ ?> style="padding-left:0; width:100%;"<?php } ?>>
	<?php if (has_post_thumbnail($post->ID) && !$hide_thumbnails){ ?>
		<a href="<?php the_permalink() ?>"><?php
		$featured_caption = get_the_title($post->ID);
		$featured_image = get_the_post_thumbnail($post->ID);
		echo $featured_image;
		?></a>
	<?php } ?>
	
	<?php switch ($post_format){
		
		case 'audio':
		case 'video':
		case 'image':
		case 'chat':
		case 'gallery':
		case '':
		
		?><h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
		<?php if (of_get_option('js_hide_metainfo') == 0){ ?>
			<h6><?php _e('Posted on','crowdpress'); ?> <strong><?php the_time('F j, Y') ?></strong> <?php _e('by','crowdpress'); ?> <?php the_author_posts_link(); ?> <?php _e('in','crowdpress'); ?>
			<?php the_category(', '); ?><br /><?php comments_number('', '<a href="'.get_permalink().'#comments">'.__('1 Comment','crowdpress').'</a>', '<a href="'.get_permalink().'#comments">% '.__('Comments','crowdpress').'</a>' ); ?></a></h6>
		<?php }
		
		break;
		
	} ?>
	
	<?php switch ($post_format){

		case 'audio':
	
			if ( function_exists('the_post_format_audio') ) { echo get_the_post_format_media( 'audio' ); } ?>
			<?php the_excerpt(); ?>
			
		<?php break;
		
		case 'video':
		
			if ( function_exists('the_post_format_video') ) { echo get_the_post_format_media( 'video' ); } ?>
			<?php the_excerpt(); ?>
	
		<?php break;
		
		case 'image':
		
			?><div class="image-video-post"><?php echo $post->format_content; ?></div>
			<?php the_excerpt(); ?>
		
		<?php break;
		
		case 'quote':
		
			?><p>&ldquo;<?php echo get_the_content($post->ID); ?>&rdquo;</p><p style="padding-top:5px; padding-bottom:10px; color:#888;">&mdash; <?php the_title(); ?></p>
		
		<?php break;
		
		case 'gallery':
		
			the_excerpt();
		
		break;
		
		case 'link':
		
		?><h5><a href="<?php echo get_the_content(); ?>"><?php the_title(); ?></a></h5>
		<?php if (of_get_option('js_hide_metainfo') == 0){ ?>
			<h6><?php _e('Posted on','crowdpress'); ?> <strong><?php the_time('F j, Y') ?></strong> <?php _e('by','crowdpress'); ?> <?php the_author_posts_link(); ?> <?php _e('in','crowdpress'); ?>
			<?php the_category(', '); ?><br /><?php comments_number('', '<a href="'.get_permalink().'#comments">'.__('1 Comment','crowdpress').'</a>', '<a href="'.get_permalink().'#comments">% '.__('Comments','crowdpress').'</a>' ); ?></a></h6>
		<?php }
		
		break;
		
		case 'aside':
		case 'chat':
		case 'status':
			
			the_content();
		
		break;
		
		case '':
		case 'gallery':
		
			the_excerpt();
			
		break;
		
	} ?>
	
	<?php switch ($post_format){
		
		case 'status':
		case 'aside':
		case 'quote':
		
		if (of_get_option('js_hide_metainfo') == 0){ ?>
			<h6><?php _e('Posted on','crowdpress'); ?> <strong><?php the_time('F j, Y') ?></strong> <?php _e('by','crowdpress'); ?> <?php the_author_posts_link(); ?> <?php _e('in','crowdpress'); ?>
			<?php the_category(', '); ?><br /><?php comments_number('', '<a href="'.get_permalink().'#comments">'.__('1 Comment','crowdpress').'</a>', '<a href="'.get_permalink().'#comments">% '.__('Comments','crowdpress').'</a>' ); ?></a></h6>
		<?php }
		
		break;
		
	}

?></div>