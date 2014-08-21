<?php $show_comments = true;
$disable_page_comments = (of_get_option('js_disable_page_comments') == 'yes' ? true : false);
$disable_post_comments = (of_get_option('js_disable_post_comments') == 'yes' ? true : false);
$disable_campaign_comments = (of_get_option('js_disable_campaign_comments') == 'yes' ? true : false);

if (is_single() && $disable_post_comments && 'post' == get_post_type() || is_page() && $disable_page_comments || $disable_campaign_comments && 'download' == get_post_type()) {
	$show_comments = false;
}

// If $show_comments
if ($show_comments){ ?>

	<div id="comments-block">
		<div class="post light">
			
				<?php if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
					die (__('Please do not load this page directly. Thanks!','crowdpress'));
				
				if ( post_password_required() ) { ?>
					<?php _e('This post is password protected. Enter the password to view comments.','crowdpress'); ?>
				<?php
					return;
				}
				
				if ( have_comments() ) : ?>
					
					<h2 id="comments" class="dotted-line-title"><span><?php comments_number(__('No Responses','crowdpress'), __('One Response','crowdpress'), '% '.__('Responses','crowdpress'));?></span></h2>
				
					<div class="navigation">
						<div class="next-posts"><?php previous_comments_link() ?></div>
						<div class="prev-posts"><?php next_comments_link() ?></div>
					</div>
				
					<ol class="commentlist">
						<?php wp_list_comments(); ?>
					</ol>
				
					<div class="navigation">
						<div class="next-posts"><?php previous_comments_link() ?></div>
						<div class="prev-posts"><?php next_comments_link() ?></div>
					</div>
					
				 <?php else : // this is displayed if there are no comments so far ?>
				
					<?php if ( comments_open() ) : ?>
						<!-- If comments are open, but there are no comments. -->
				
					 <?php else : // comments are closed ?>
						<p class="closed-comments"><?php _e('Comments are closed.','crowdpress'); ?></p>
				
					<?php endif; ?>
					
				<?php endif; ?>
				
				<?php if ( comments_open() ) :
						
					$comment_field = '<div class="textarea_wrap"><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></div>';
					
					comment_form(array('title_reply'=>'<h2 id="comments" class="dotted-line-title"><span>'.__('Comments','crowdpress').'</span></h2>','comment_notes_after' => '','comment_field'=>$comment_field));
					
				endif; ?>
			
		</div>
	</div>

<?php } // End if $show_comments ?>