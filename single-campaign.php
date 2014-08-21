<?php

get_header();

global $template_dir,$wp_embed,$edd_options;
	
while ( have_posts() ) : the_post(); $campaign = new ATCF_Campaign( $post->ID );

	if ($campaign->contact_email()): $contact_send_results = check_contact_form($_POST,$campaign->contact_email()); endif; ?>
	
	<section id="head">
		<div class="shell" style="padding-top:20px;">
			<div class="holder">
				<article class="project project-detailed">
					<header>
						<h2><?php the_title(); ?></h2>
						<p class="author"><?php echo get_the_excerpt(); ?></p>
					</header>
					<div class="image">
						<?php if ( $campaign->video() ) : ?>
							<?php echo $wp_embed->run_shortcode( '[embed width=590]' . $campaign->video() . '[/embed]' ); ?>
						<?php else : ?>
							<?php if (has_post_thumbnail($post->ID)): the_post_thumbnail( 'campaign-full' ); endif; ?>
						<?php endif; ?>
					</div>
					<div class="social">
						<?php $post_excerpt = get_the_excerpt();
						js_social_buttons($post->ID,$post_excerpt); ?>
					</div>
				</article>
				
				<div class="progress-info new">
					<div class="progress progress-big"><em></em><span style="width:<?php echo ($campaign->percent_completed(false) > 100 ? 100 : $campaign->percent_completed(false)); ?>%"><?php echo $campaign->percent_completed(false); ?>%</span></div>
					<ul class="numbers clearfix">
						<li><strong><span class="count-percent" data-max-val="<?php echo $campaign->percent_completed(false); ?>"><?php echo $campaign->percent_completed(false); ?></span>%</strong><?php _e('funded','crowdpress'); ?></li>
						<li class="last"><strong><span class="count-amount" data-max-val="<?php echo $campaign->current_amount(false); ?>"><?php echo $campaign->current_amount(true); ?></span></strong><?php printf( __( 'PLEDGED OF %s GOAL', 'crowdpress' ), $campaign->goal() ); ?></li>
					</ul>
					
					<p class="inline-numbers">
						<span><strong class="count-pledgers" data-max-val="<?php echo $campaign->backers_count(); ?>"><?php echo $campaign->backers_count(); ?></strong> <?php echo _n( 'BACKER', 'BACKERS', $campaign->backers_count(), 'crowdpress' ); ?></span>
						
						<?php if ( ! $campaign->is_endless() ) : ?>
							<?php if ( $campaign->days_remaining() > 0 ) : ?>
								<span><strong class="count-days" data-max-val="<?php echo $campaign->days_remaining(); ?>"><?php echo $campaign->days_remaining(); ?></strong> <?php echo _n( 'Day Left', 'Days Left', $campaign->days_remaining(), 'crowdpress' ); ?></span>
							<?php elseif ($campaign->hours_remaining() > 0 ) : ?>
								<span><strong class="count-days" data-max-val="<?php echo $campaign->hours_remaining(); ?>"><?php echo $campaign->hours_remaining(); ?></strong> <?php echo _n( 'Hour Left', 'Hours Left', $campaign->hours_remaining(), 'crowdpress' ); ?></span>
							<?php endif; ?>
						<?php endif; ?>
						
					</p>
					
					<?php $end_date = date_i18n( get_option( 'date_format' ), strtotime( $campaign->end_date())) ?>
					
					<?php if ( ! $campaign->is_endless() ) : ?>
						<p class="fixed-notice">
						<?php if ( 'fixed' == $campaign->type() ) : ?>
						<?php printf( __( 'This project will only be funded if at least %1$s is pledged by %2$s.', 'crowdpress' ), $campaign->goal(), $end_date ); ?>
						<?php elseif ( 'flexible' == $campaign->type() ) : ?>
						<?php printf( __( 'All funds will be collected on %1$s.', 'crowdpress' ), $end_date ); ?>
						<?php else : ?>
						<?php printf( __( 'All pledges will be collected automatically until %1$s.', 'crowdpress' ), $end_date ); ?>
						<?php endif; ?>
						</p>
					<?php endif; ?>
				
					<?php if ( $campaign->is_active() ) : ?>
						<p class="button">
							<a href="#pledges" class="button-big"><?php _e('Support Now','crowdpress'); ?></a>
						</p>
					<?php else : ?>
						<p style="padding-top:25px;"><strong style="font-size:19px; padding-bottom:10px; display:block;"><?php _e('Project Ended','crowdpress'); ?>.</strong>
						<?php _e('This project has ended, sorry you missed it!','crowdpress'); ?></p>
					<?php endif; ?>
			
				</div>
			
				<div class="cl">&nbsp;</div>
					
			</div>
			
			<?php // Calculate Time Left
			$days_left = $campaign->days_remaining();
		
			if ($days_left > 365) { $number_left = floor($days_left / 365); $time_left = 'year'.($number_left != 1 ? 's' : ''); } else
			if ($days_left > 30) { $number_left = floor($days_left / 30); $time_left = 'month'.($number_left != 1 ? 's' : ''); } else {
				$time_left = 'day'.($days_left != 1 ? 's' : ''); $number_left = $days_left;
			} ?>
			
		
		</div>
		<div class="head-shadow"></div>
	</section>
	
	<section id="main">
		<div class="shell shell-inner-page">
			<div class="container clearfix left" style="background:none;">
				<section id="content" class="left" style="width:670px;">
					<article class="entry" style="padding:0;">
						<section>
						
							<?php global $user_ID; ?>
							
							<!-- TABS -->
							<div class="campaign-tabs">
								<a class="tab active" href="#"><?php _e('Description','crowdpress'); ?></a>
								<?php if ( '' != $campaign->updates() ) : ?><a class="tab" href="#"><?php _e('Updates','crowdpress'); ?></a><?php endif; ?>
								<a class="tab" href="#"><?php _e('Backers','crowdpress'); ?></a>
								<a class="tab" href="#"><?php _e('Comments','crowdpress'); ?></a>
								<?php if ($user_ID == $post->post_author): ?><a class="edit" href="<?php echo get_permalink($post->ID); ?>edit/"><?php _e('ویرایش کمپین','crowdpress'); ?></a><?php endif; ?>
							</div>
							<!-- END TABS -->
							
							<!-- TAB CONTENT -->
							<div class="tab-content">
						
								<div class="tab-block active">
								
									<?php
									$author = get_user_by( 'id', $post->post_author );
									if ( '' != $author->user_description || '' != $author->display_name ) : ?>
									
										<div class=" author-info new entry">
											<h3><?php _e( 'About the Author', 'crowdpress' ); ?></h3>
						
											<div style="float:left; width:100px; margin:0 20px 0 0;"><a href="<?php echo get_author_posts_url( $author->ID ); ?>"><?php echo get_avatar( $author->user_email, 100 ); ?></a></div>
											
											<div style="float:left; width:210px;">
												
												<div class="author-bio">
												
													<p style="padding:0; margin:0 0 5px;"><a href="<?php echo get_author_posts_url( $author->ID ); ?>"><strong><?php
														if ( $campaign->author() ) :
															echo esc_attr( $campaign->author() );
														else :
															echo esc_attr( $author->display_name );
														endif;
													?></strong></a>
													
													<?php if ( $campaign->location() ) : ?>
													<br /><small><?php echo $campaign->location(); ?></small>
													<?php endif; ?>
													
													<br /><small>
													<?php 
														$count = crowdpress_count_user_campaigns( $author->ID );
														printf( _nx( '%1$d کمپین تا به حال ایجاد کرده', '%1$d کمپین تا به حال ایجاد کرده', $count, '1: Number of Campaigns 2: EDD Object', 'crowdpress' ), $count ); 
													?>
													</small>
													</p>
													
													<p class="author-bio-links" style="padding:0; margin:0 0 5px;">
														<?php if ( '' != $author->user_url ) : ?>
														<small class="contact-link"><?php echo make_clickable( $author->user_url ); ?></small>
														<?php endif; ?>
												
														<?php
															$methods = _wp_get_user_contactmethods();
												
															foreach ( $methods as $key => $method ) :
																if ( '' == $author->$key )
																	continue;
														?>

														<?php endforeach; ?>
													</p>
													
													<p style="font-size:12px; line-height:18px; margin:0 0 13px; padding:0;"><?php echo $author->user_description; ?></p>
												</div>
												
												<?php if (isset($contact_send_results)){
													echo '<p style="font-weight:bold; font-size:15px; line-height:21px; margin:0 0 13px; padding:0;">'.$contact_send_results.'</p>';
												} ?>
												
												<?php if ($campaign->contact_email()): ?>
													<div id="ask-question-block">
													
														<?php global $current_user; get_currentuserinfo(); ?>
														
														<form action="" method="post">
														
															<label for="name"><?php _e('Name','crowdpress'); ?>:</label>
															<input type="text" class="ask-question-name" id="name" name="name" value="<?php echo ($current_user->display_name ? $current_user->display_name : ''); ?>" />
															
															<label for="email"><?php _e('Email','crowdpress'); ?>:</label>
															<input type="text" class="ask-question-email" id="email" name="email" value="<?php echo ($current_user->user_email ? $current_user->user_email : ''); ?>" />
															
															<label for="question"><?php _e('Question','crowdpress'); ?>:</label>
															<textarea class="ask-question-question" id="question" name="question"></textarea>
															
															<input type="submit" class="button button-mini" name="submitted" value="<?php _e( 'Ask Question', 'crowdpress' ); ?>" />
														
														</form>
														
													</div>
													<a href="#" class="ask-question-button button-mini"><?php _e( 'Ask Question', 'crowdpress' ); ?></a>
												<?php endif; ?>	
												
											</div>
											
											<div class="cl"></div>
											
										</div>
										
									<?php endif; ?>
								
									<?php the_content(); ?>
									
								</div>
								
								<?php if ( '' != $campaign->updates() ) : ?>
									<div class="tab-block" id="updates">
										<h2><?php _e( 'Updates', 'crowdpress' ); ?></h2>
										<?php echo $campaign->updates(); ?>
									</div>
								<?php endif; ?>
								
								<div class="tab-block" id="backers">
									<?php $backers = $campaign->unique_backers();?>
			
									<?php if ( empty( $backers ) ) : ?>
									<p><?php _e( 'No backers yet. Be the first!', 'crowdpress' ); ?></p>
									<?php else : ?>
			
										<ol class="backer-list">
											<?php foreach ( $backers as $payment_id ) : ?>
												<?php
													$meta       = edd_get_payment_meta( $payment_id );
													$user_info  = edd_get_payment_meta_user_info( $payment_id );
									
													if ( empty( $user_info ) )
														continue;
									
													$anon       = isset ( $meta[ 'anonymous' ] ) ? $meta[ 'anonymous' ] : 0;
												?>
									
												<li class="backer">
													<?php echo get_avatar( $anon ? '' : $user_info[ 'email' ], 40 ); ?>
				
													<div class="backer-info">
														<strong>
															<?php if ( $anon ) : ?>
																<?php _ex( 'Anonymous', 'Backer chose to hide their name', 'crowdpress' ); ?>
															<?php else : ?>
																<?php echo $user_info[ 'first_name' ]; ?> <?php echo $user_info[ 'last_name' ]; ?>
															<?php endif; ?>
														</strong><br />
														<?php echo edd_payment_amount( $payment_id ); ?>
													</div>
												</li>
											<?php endforeach; ?>
										</ol>
										
										<div class="cl"></div>
			
									<?php endif; ?>
								</div>
								
								<div class="tab-block"><?php comments_template(); ?></div>
								
							</div>
							<!-- END TAB CONTENT -->
							
						</section>
					</article>

				</section>
				<aside id="pledges" class="right">
					<div class="articles-list<?php if (isset($edd_options[ 'atcf_settings_custom_pledge']) && $edd_options[ 'atcf_settings_custom_pledge']): echo ' show-button'; endif; ?>">
					
						<?php
						
						if ( $campaign->is_active() ) :							
							echo edd_get_purchase_link( array( 
								'download_id' => $post->ID,
								'class'       => '',
								'price'       => false,
								'text'        => __( 'Contribute Now', 'crowdpress' )
							));
						else : // Inactive, just show options with no button
							?><div class="entry" style="padding:5px 20px;">
								<h3><?php _e('Project Ended','crowdpress'); ?>.</h3>
								<p><?php _e('This project has ended, sorry you missed it!','crowdpress'); ?></p>
							</div><?php
						endif;
						
						?>
						
					</div>
				</aside>
			</div>
		</div>
	</section>
	
	<?php // Campaign Page Widgets
	$widget_layout = get_post_meta($post->ID, '_campaigns_widget_layout', true);
	$widget_layout = $widget_layout ? $widget_layout[0] : 'no-widgets';

	if ($widget_layout != 'no-widgets'){ ?>

		<div id="footer-widgets">
		<div class="shell"><?php
		
			$zone_1_widget = (get_post_meta($post->ID, '_campaigns_widget_block_1',true) ? get_post_meta($post->ID, '_campaigns_widget_block_1',true) : 1);
			$zone_2_widget = (get_post_meta($post->ID, '_campaigns_widget_block_2',true) ? get_post_meta($post->ID, '_campaigns_widget_block_2',true) : 2);
			$zone_3_widget = (get_post_meta($post->ID, '_campaigns_widget_block_3',true) ? get_post_meta($post->ID, '_campaigns_widget_block_3',true) : 3);
			$zone_4_widget = (get_post_meta($post->ID, '_campaigns_widget_block_4',true) ? get_post_meta($post->ID, '_campaigns_widget_block_4',true) : 4);
			
			echo '<div id="page-widgets">';
		
			switch ($widget_layout) {
			
				case 'one' :
				
					if (is_active_sidebar($zone_1_widget)){
						
						dynamic_sidebar($zone_1_widget);
						
					}
				
				break;
				
				case 'two' :
				
					if (is_active_sidebar($zone_1_widget) || is_active_sidebar($zone_2_widget)){
						
						echo '<div class="one_half">';
							dynamic_sidebar($zone_1_widget);
						echo '</div>';
						
						echo '<div class="one_half last">';
							dynamic_sidebar($zone_2_widget);
						echo '</div>';
						
					}
				
				break;
				
				case 'three' :
				
					if (is_active_sidebar($zone_1_widget) || is_active_sidebar($zone_2_widget) || is_active_sidebar($zone_3_widget)){
						
						echo '<div class="one_third">';
							dynamic_sidebar($zone_1_widget);
						echo '</div>';
						
						echo '<div class="one_third">';
							dynamic_sidebar($zone_2_widget);
						echo '</div>';
						
						echo '<div class="one_third last">';
							dynamic_sidebar($zone_3_widget);
						echo '</div>';
						
					}
				
				break;
				
				case 'four' :
				
					if (is_active_sidebar($zone_1_widget) || is_active_sidebar($zone_2_widget) || is_active_sidebar($zone_3_widget) || is_active_sidebar($zone_4_widget)){
						
						echo '<div class="one_fourth">';
							dynamic_sidebar($zone_1_widget);
						echo '</div>';
						
						echo '<div class="one_fourth">';
							dynamic_sidebar($zone_2_widget);
						echo '</div>';
						
						echo '<div class="one_fourth">';
							dynamic_sidebar($zone_3_widget);
						echo '</div>';
						
						echo '<div class="one_fourth last">';
							dynamic_sidebar($zone_4_widget);
						echo '</div>';
						
					}
				
				break;
				
				case 'onethird_twothird' :
				
					if (is_active_sidebar($zone_1_widget) || is_active_sidebar($zone_2_widget)){
						
						echo '<div class="one_third">';
							dynamic_sidebar($zone_1_widget);
						echo '</div>';
						
						echo '<div class="two_third last">';
							dynamic_sidebar($zone_2_widget);
						echo '</div>';
						
					}
				
				break;
				
				case 'twothird_onethird' :
				
					if (is_active_sidebar($zone_1_widget) || is_active_sidebar($zone_2_widget)){
						
						echo '<div class="two_third">';
							dynamic_sidebar($zone_1_widget);
						echo '</div>';
						
						echo '<div class="one_third last">';
							dynamic_sidebar($zone_2_widget);
						echo '</div>';
						
					}
				
				break;
				
			}
			
			echo '<div class="cl"></div></div>';
				
		?></div></div><?php
	
	} ?>
	
<?php endwhile; ?>

<?php get_footer();