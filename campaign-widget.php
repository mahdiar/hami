<?php
/**
 * Widget
 */

global $post;
?><!DOCTYPE html>
<html lang="en" <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width" />
	
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<?php wp_head(); ?>
	
	<style type="text/css">
		html { margin-top:0 !important; }
		#wpadminbar,#customizer { display:none !important; }
	</style>
	
</head>
<body <?php body_class( 'campaign-widget' ); ?>>

	<div id="projects">
		<section>
			<?php
				while ( have_posts() ) : the_post();
					get_template_part( 'content-campaign', 'widget' );
				endwhile;
			?>
		</section>
	</div>

	<?php wp_footer(); ?>
</body>
</html>