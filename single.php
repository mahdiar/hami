<?php get_header();

if (have_posts()) : while (have_posts()) : the_post(); ?>

	<div class="colored-line"></div>
	
	<?php
	
	$featured_caption = get_the_title(get_post_thumbnail_id(get_the_ID()));
	$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'page-banner' );
	if ($featured_image[0]){ ?>
		<section id="banner" style="background-image:url(<?php echo $featured_image[0]; ?>); background-position:center center;"></section><?php
	}
	
	?>
	
	<section id="main">
	<div class="shell shell-inner-page">
		<div class="container clearfix left">
			<section id="content" <?php post_class('left'); ?>>
				<article class="entry">
					<section>
					
					<?php js_breadcrumbs($post->ID); ?>
					<h1><?php the_title(); ?></h1>
					
					<?php
					
					// Get the post format
					$post_format = get_post_format($post->ID);
					
					if ($post_format == 'video'){
					
						if ( function_exists('the_post_format_video') ) { echo get_the_post_format_media( 'video' ); } else { the_content(); }

					} else if ($post_format == 'audio'){
					
						if ( function_exists('the_post_format_audio') ) { echo get_the_post_format_media( 'audio' ); }
					
					} else {
			
						the_content();
					
					} ?>
					
					<?php wp_link_pages(); ?>
					
					<?php the_tags('<small><strong>Tags:</strong> ', ', ', '</small>'); ?>
					
					<?php comments_template(); ?>
					
					</section>
				</article>

			</section>

<?php endwhile; ?>
								
			<aside class="right">
				<?php get_sidebar(); ?>
			</aside>
			<div class="cl"></div>

		</div>
	</div>
</section>

<?php endif; ?>

<?php get_footer(); ?>