<?php global $template_dir; ?>

	<?php
	
	$footer_widgets = of_get_option('js_footer_widgets');

	if ($footer_widgets): ?>
	
		<div class="footer-widgets">
		<div class="shell"><?php
		
			echo '<div id="page-widgets">';
	
			switch ($footer_widgets) {
			
				case 1 :
				
					if (is_active_sidebar('footer-1')){
						
						dynamic_sidebar('footer-1');
						
					}
				
				break;
				
				case 2 :
				
					if (is_active_sidebar('footer-1') || is_active_sidebar('footer-2')){
						
						echo '<div class="one_half">';
							dynamic_sidebar('footer-1');
						echo '</div>';
						
						echo '<div class="one_half last">';
							dynamic_sidebar('footer-2');
						echo '</div>';
						
					}
				
				break;
				
				case 3 :
				
					if (is_active_sidebar('footer-1') || is_active_sidebar('footer-2') || is_active_sidebar('footer-3')){
						
						echo '<div class="one_third">';
							dynamic_sidebar('footer-1');
						echo '</div>';
						
						echo '<div class="one_third">';
							dynamic_sidebar('footer-2');
						echo '</div>';
						
						echo '<div class="one_third last">';
							dynamic_sidebar('footer-3');
						echo '</div>';
						
					}
				
				break;
				
				case 4 :
				
					if (is_active_sidebar('footer-1') || is_active_sidebar('footer-2') || is_active_sidebar('footer-3') || is_active_sidebar('footer-4')){
						
						echo '<div class="one_fourth">';
							dynamic_sidebar('footer-1');
						echo '</div>';
						
						echo '<div class="one_fourth">';
							dynamic_sidebar('footer-2');
						echo '</div>';
						
						echo '<div class="one_fourth">';
							dynamic_sidebar('footer-3');
						echo '</div>';
						
						echo '<div class="one_fourth last">';
							dynamic_sidebar('footer-4');
						echo '</div>';
						
					}
				
				break;
				
			}
			
			echo '<div class="cl"></div></div>';
	
		?></div></div>
	
	<?php endif; ?>
	
	
	<?php $boxed = of_get_option('js_body_boxed'); if ($boxed == 'yes'): echo '<div class="boxed">'; endif; ?>
	
	<footer>
	
		<div class="footer-navigation">
			<div class="shell">
				<nav>
					<?php // Display Main Menu
					$crowdpressWalker = new CrowdPressCustomNavigation();
					wp_nav_menu(array('container' => false, 'theme_location' => 'footer-menu', 'fallback_cb' => 'footer_menu_message', 'walker' => $crowdpressWalker));
					?>
				</nav>
				<?php $footer_logo = of_get_option('js_footer_logo'); ?>
				<a href="<?php site_url(); ?>" <?php echo ($footer_logo ? 'style="background:url('.$footer_logo.') no-repeat center center;" ' : ''); ?>class="footer-logo">crowdpress</a>
			</div>
		</div>
		
		<?php
				
		$footer_text_left = of_get_option('js_bottom_left_text');
		$footer_text_right = of_get_option('js_bottom_right_text');
		$footer_right_content_type = of_get_option('js_bottom_right_content_type');
		$footer_bottom_bar_disabled = of_get_option('js_bottom_bar_disabled');
		
		$social_link_facebook = of_get_option('js_social_icon_facebook');
		$social_link_twitter = of_get_option('js_social_icon_twitter');
		$social_link_linkedin = of_get_option('js_social_icon_linkedin');
		$social_link_vimeo = of_get_option('js_social_icon_vimeo');
		$social_link_youtube = of_get_option('js_social_icon_youtube');
		$social_link_rss = of_get_option('js_social_icon_rss');
		
		if (!$footer_bottom_bar_disabled) :
		
			?>
			
			<div class="copyright">
				<div class="shell">
					
					<p><?php echo ($footer_text_left ? str_replace('[year]',date('Y'),$footer_text_left) : ''); ?></p>
					
					<?php if ($footer_right_content_type == 'social'){ ?>
						<div class="socials">
							<?php echo ($social_link_facebook ? '<a href="'.$social_link_facebook.'" class="facebook-ico">Facebook</a>' : ''); ?>
							<?php echo ($social_link_twitter ? '<a href="'.$social_link_twitter.'" class="twitter-ico">Twitter</a>' : ''); ?>
							<?php echo ($social_link_linkedin ? '<a href="'.$social_link_linkedin.'" class="in-ico">LinkedIn</a>' : ''); ?>
							<?php echo ($social_link_vimeo ? '<a href="'.$social_link_vimeo.'" class="v-ico">Vimeo</a>' : ''); ?>
							<?php echo ($social_link_youtube ? '<a href="'.$social_link_youtube.'" class="you-tube-ico">Youtube</a>' : ''); ?>
							<?php echo ($social_link_rss ? '<a href="'.$social_link_rss.'" class="rss-ico">Feed</a>' : ''); ?>
						</div>
					<?php } else { ?>
						<div class="socials">
							<p><?php echo ($footer_text_right ? str_replace('[year]',date('Y'),$footer_text_right) : ''); ?></p>
						</div>
					<?php } ?>
				</div>
			</div>
		
		<?php endif; ?>
		
	</footer>
	
	<?php if ($boxed == 'yes'): echo '</div></div>'; endif; ?>
	
	<?php wp_footer(); ?>
	
</body>
</html>