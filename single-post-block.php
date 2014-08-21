<?php

// Get the post format
$post_format = get_post_format($post->ID);

?><div class="single-post-block <?php echo $post_format; ?>"><?php

if (!$post_format || $post_format == 'audio'){
	if (has_post_thumbnail($post->ID)){ ?>
		<div class="one_fourth postlist-thumbnail">
		<a href="<?php the_permalink() ?>"><?php
		$featured_caption = get_the_title($post->ID);
		$featured_image = get_the_post_thumbnail($post->ID,'thumbnail', array('title'=>$featured_caption));
		echo $featured_image;
		?></a></div>
	<?php }
}
			
if (!$post_format && has_post_thumbnail($post->ID) || $post_format == 'audio' && has_post_thumbnail($post->ID)){ ?>
	<div class="three_fourth last"><?php
} else { ?>
	<div><?php 
} ?>
	
		<div class="post-content<?php if (!has_post_thumbnail($post->ID)){ ?> no-thumb<?php } ?>">
			
		<?php
			
		// Link Post Format
		switch ($post_format){
			
			case 'gallery': ?>
				
				<h3 class="entry-title"><?php the_title(); ?></h3>
				<?php if (of_get_option('js_hide_metainfo') == 0){ ?>
					<p class="post-meta"><?php _e('Posted on','crowdpress'); ?> <strong><?php the_time('F j, Y') ?></strong> <?php _e('by','crowdpress'); ?> <?php the_author_posts_link(); ?> <?php _e('in','crowdpress'); ?>
					<?php the_category(', '); ?><br /><?php comments_number('', '<a href="'.get_permalink().'#comments">'.__('1 Comment','crowdpress').'</a>', '<a href="'.get_permalink().'#comments">% '.__('Comments','crowdpress').'</a>' ); ?></a></p>
				<?php } else { ?>
					<br />
				<?php } ?>
				<div class="image-video-post"><?php the_content(); ?></div> 
			
			<?php // Quote Post Format
			break; case 'link': ?>
			
				<h3 class="entry-title"><a href="<?php echo get_the_content(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'twentyten' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
				<?php if (of_get_option('js_hide_metainfo') == 0){ ?>
					<p class="post-meta"><?php _e('Posted on','crowdpress'); ?> <strong><?php the_time('F j, Y') ?></strong> <?php _e('by','crowdpress'); ?> <?php the_author_posts_link(); ?> <?php _e('in','crowdpress'); ?>
					<?php the_category(', '); ?><br /><?php comments_number('', '<a href="'.get_permalink().'#comments">'.__('1 Comment','crowdpress').'</a>', '<a href="'.get_permalink().'#comments">% '.__('Comments','crowdpress').'</a>' ); ?></a></p>
				<?php } else { ?>
					<br />
				<?php } ?>
			
			<?php // Quote Post Format
			break; case 'quote': ?>
			
				<blockquote class="post-format-quote"><?php echo get_the_content($post->ID); ?><p style="padding-top:15px;">&mdash; <?php the_title(); ?></p></blockquote>
			
			<?php // Status Post Format
			break; case 'status': case 'aside': ?>
			
				<h3 class="entry-title"><?php echo get_the_content($post->ID); ?></h3>
			
			<?php // Image Post Format
			break; case 'image': ?>
			
				<h3 class="entry-title"><?php the_title(); ?></h3>
				<?php if (of_get_option('js_hide_metainfo') == 0){ ?>
					<p class="post-meta"><?php _e('Posted on','crowdpress'); ?> <strong><?php the_time('F j, Y') ?></strong> <?php _e('by','crowdpress'); ?> <?php the_author_posts_link(); ?> <?php _e('in','crowdpress'); ?>
					<?php the_category(', '); ?><br /><?php comments_number('', '<a href="'.get_permalink().'#comments">'.__('1 Comment','crowdpress').'</a>', '<a href="'.get_permalink().'#comments">% '.__('Comments','crowdpress').'</a>' ); ?></a></p>
				<?php } else { ?>
					<br />
				<?php } ?>
				<div class="image-video-post"><?php echo $post->format_content; ?></div>
				<br />
			
			<?php // Audio Post Format
			break; case 'audio': ?>
			
				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>  
			        <?php if(strlen( get_the_title() ) >0 ): ?><h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3><?php endif; ?>   
			        <?php if (of_get_option('js_hide_metainfo') == 0){ ?>
						<p class="post-meta"><?php _e('Posted on','crowdpress'); ?> <strong><?php the_time('F j, Y') ?></strong> <?php _e('by','crowdpress'); ?> <?php the_author_posts_link(); ?> <?php _e('in','crowdpress'); ?>
						<?php the_category(', '); ?><br /><?php comments_number('', '<a href="'.get_permalink().'#comments">'.__('1 Comment','crowdpress').'</a>', '<a href="'.get_permalink().'#comments">% '.__('Comments','crowdpress').'</a>' ); ?></a></p>
					<?php } else { ?>
						<br />
					<?php } ?>
			        <?php if ( function_exists('the_post_format_audio') ) { echo get_the_post_format_media( 'audio' ); } the_excerpt(); ?>
			    </div>
			    <a href="<?php the_permalink() ?>" class="button-small"><?php _e('Continue Reading','crowdpress'); ?></a>
				
			<?php // Video Post Format
			break; case 'video': ?>
			
				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>  
			        <?php if(strlen( get_the_title() ) >0 ): ?><h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3><?php endif; ?>   
			        <?php if (of_get_option('js_hide_metainfo') == 0){ ?>
						<p class="post-meta"><?php _e('Posted on','crowdpress'); ?> <strong><?php the_time('F j, Y') ?></strong> <?php _e('by','crowdpress'); ?> <?php the_author_posts_link(); ?> <?php _e('in','crowdpress'); ?>
						<?php the_category(', '); ?><br /><?php comments_number('', '<a href="'.get_permalink().'#comments">'.__('1 Comment','crowdpress').'</a>', '<a href="'.get_permalink().'#comments">% '.__('Comments','crowdpress').'</a>' ); ?></a></p>
					<?php } else { ?>
						<br />
					<?php } ?>
			        <?php if ( function_exists('the_post_format_video') ) { echo get_the_post_format_media( 'video' ); } the_excerpt(); ?>
			    </div>
			    <a href="<?php the_permalink() ?>" class="button-small"><?php _e('Continue Reading','crowdpress'); ?></a>
			
			
			<?php // Video Post Format
			break; case 'chat': ?>
			
				<h3 id="post-<?php the_ID(); ?>"><?php the_title(); ?></h3>
				<?php if (of_get_option('js_hide_metainfo') == 0){ ?>
					<p class="post-meta"><?php _e('Posted on','crowdpress'); ?> <strong><?php the_time('F j, Y') ?></strong> <?php _e('by','crowdpress'); ?> <?php the_author_posts_link(); ?> <?php _e('in','crowdpress'); ?>
					<?php the_category(', '); ?><br /><?php comments_number('', '<a href="'.get_permalink().'#comments">'.__('1 Comment','crowdpress').'</a>', '<a href="'.get_permalink().'#comments">% '.__('Comments','crowdpress').'</a>' ); ?></a></p>
				<?php } else { ?>
					<br />
				<?php } ?>
				<div class="chat"><?php the_content(); ?></div>
			
			<?php // Normal Post Format
			break; case '': ?>
	
				<h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
				<?php if (of_get_option('js_hide_metainfo') == 0){ ?>
					<p class="post-meta"><?php _e('Posted on','crowdpress'); ?> <strong><?php the_time('F j, Y') ?></strong> <?php _e('by','crowdpress'); ?> <?php the_author_posts_link(); ?> <?php _e('in','crowdpress'); ?>
					<?php the_category(', '); ?><br /><?php comments_number('', '<a href="'.get_permalink().'#comments">'.__('1 Comment','crowdpress').'</a>', '<a href="'.get_permalink().'#comments">% '.__('Comments','crowdpress').'</a>' ); ?></a></p>
				<?php } else { ?>
					<br />
				<?php } ?>
				<?php the_excerpt(); ?>
				<a href="<?php the_permalink() ?>" class="button-small"><?php _e('Continue Reading','crowdpress'); ?></a>
			
			<?php break;
		} ?>

		</div>	
	</div>

	<div class="cl"></div>

</div>