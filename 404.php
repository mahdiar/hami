<?php get_header(); ?>

<div class="colored-line"></div>
	
<section id="main">
	<div class="shell shell-inner-page">
		<div class="container clearfix full">
			<section id="content" <?php post_class('full'); ?>>
				<article class="entry">
					<section>
					
						<h1><?php _e('Page Not Found','crowdpress'); ?></h1>
								
						<?php echo (of_get_option('js_404_content') ? of_get_option('js_404_content') : '<p>'.__('Sorry, this page cannot be found.','crowdpress').'</p>'); ?>
					</section>
				</article>
			</section>
		</div>
	</div>
</section>		

<?php get_footer(); ?>