<?php get_header(); ?>

	<section id="main">
		<div class="shell shell-inner-page">
			<div class="container clearfix ">
				
				<?php while ( have_posts() ) : the_post(); $campaign = new ATCF_Campaign( $post->ID ); ?>
			
				<section id="content" >
					<article class="entry">
						<section>
							<h1><?php the_title() ;?></h1>
							<h3><?php _e( 'Edit', 'crowdpress' ); ?></h3>
							
							<?php echo atcf_shortcode_submit( array( 
								'editing'    => is_preview() ? false : true, 
								'previewing' => is_preview() ? true : false  
							) ); ?>
						</section>
					</article>
				</section>
				
				<?php endwhile; ?>
	
				<div class="cl"></div>
				
			</div>
		</div>
	</section>

<?php get_footer(); ?>
