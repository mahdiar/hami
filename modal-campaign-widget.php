<div id="campaign-widget-modal" class="mfp-hide">
	
	<h2 class="modal-title"><?php _e( 'Embed this campaign on your site...', 'crowdpress' ); ?></h2>

	<div class="campaign-widget-preview-widget">
		<iframe src="<?php echo atcf_create_permalink( 'widget', get_permalink() ); ?>" width="300" height="446" frameborder="0" scrolling="no" /></iframe>
	</div>

	<div class="campaign-widget-preview-use">
		<p><?php _e( 'Help raise awareness by sharing this widget. Simply paste the following HTML code most places on the web.', 'crowdpress' ); ?></p>

		<p style="margin:0 0 5px;"><strong><?php _e( 'Embed Code', 'crowdpress' ); ?></strong></p>

		<pre>&lt;iframe src="<?php echo atcf_create_permalink( 'widget', get_permalink() ); ?>" width="300" height="446" frameborder="0" scrolling="no" /&gt;&lt;/iframe&gt;</pre>
	</div>
	
	<div class="cl"></div>
	
</div>