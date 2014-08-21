<?php
// Parse errors will be thrown in PHP 4
if (version_compare(PHP_VERSION, '5.0.0', '>=')) {
	/* uncomment the line below to always include twitter settings */
	//define('ENABLE_TWITTER_CONFIG', 1);

	include_once('TwitterAPIExchange.php');
	include_once('TwitterHelper.php');
} else {
	class TwitterHelper {
		function get_tweets() {
			trigger_error("Please upgrade to PHP 5 in order to use twitter widget", E_USER_ERROR);
		}
	}
}
