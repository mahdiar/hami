<?php

include('page-children.php');
include('recent-posts.php');
include('recent-tweets.php');
include('facebook-feed.php');
include('text.php');

/* Register the widgets */
function load_widgets() {
	register_widget('ThemeWidgetRecentPosts');
	register_widget('ThemeWidgetRecentTweets');
	register_widget('ThemeWidgetFacebookFeed');
	register_widget('ThemeWidgetPageChildren');
	register_widget('ThemeWidgetTextWidget');
}
add_action('widgets_init', 'load_widgets');

?>