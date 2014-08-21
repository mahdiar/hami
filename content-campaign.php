<?php

global $post;

$campaign = new ATCF_Campaign( $post );
$author = get_user_by( 'id', $post->post_author );

$age = date( 'U' ) - get_post_time( 'U', true, $post );
?>

<article class="project">
	<div class="image">
		<a href="<?php the_permalink(); ?>">
		<?php if (has_post_thumbnail($post->ID)):
			the_post_thumbnail( 'campaign-thumb' );
		else: ?>
			<img src="<?php echo $template_dir; ?>/_theme_styles/images/gray-project.jpg" alt="" />
		<?php endif; ?>
		</a>
		<?php if ($campaign->percent_completed(false) >= 100) { ?><div class="ribbon success"><?php _e('Successful','crowdpress'); ?></div><?php } else if (get_post_meta($post->ID,'_campaign_featured')) { ?><div class="ribbon featured"><?php _e('Staff Pick','crowdpress'); ?></div><?php } ?>
	</div>
	<div class="text">
		<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
		<p class="author"><?php _e('by','crowdpress'); ?> <a href="<?php echo get_author_posts_url( $author->ID ); ?>"><?php
			if ( $campaign->author() ) :
				echo esc_attr( $campaign->author() );
			else :
				echo esc_attr( $author->display_name );
			endif;
		?></a></p>
		<p class="excerpt"><?php echo trunc(get_the_excerpt(),100); ?></p>
		<ul class="numbers">
			<li><strong><?php echo $campaign->percent_completed(false); ?>%</strong><?php _e('funded','crowdpress'); ?></li>
			<li><strong><?php echo $campaign->current_amount(); ?></strong><?php _e('pledged','crowdpress'); ?></li>
			<?php if ( ! $campaign->is_endless() ) : ?>
				<li>
					<?php if ( $campaign->days_remaining() > 0 ) : ?>
						<strong><?php echo $campaign->days_remaining(); ?></strong>
						<?php echo _n( 'Day Left', 'Days Left', $campaign->days_remaining(), 'crowdpress' ); ?>
					<?php else : ?>
						<strong><?php echo $campaign->hours_remaining(); ?></strong>
						<?php echo _n( 'Hour Left', 'Hours Left', $campaign->hours_remaining(), 'crowdpress' ); ?>
					<?php endif; ?>
				</li>
			<?php endif; ?>
		</ul>
	</div>
	<div class="progress progress-small"><span style="width:<?php echo ($campaign->percent_completed(false) > 100 ? 100 : $campaign->percent_completed(false)); ?>%"><?php echo $campaign->percent_completed(false); ?>%</span></div>
</article>