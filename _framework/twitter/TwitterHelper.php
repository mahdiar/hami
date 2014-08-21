<?php
// Downloads and caches latest tweets from particular username
// Requires PHP 5 (it's DOM parsing for the feeds)
// usage:
// $tweets = TwitterHelper::get_tweets('cnn', 5); /* Get latest 5 tweets from cnn user */
//
// $twitter_helper = new TwitterHelper('cnn'); /* Create a new TwitterHelper object with username cnn */
// $tweets = $twitter_helper->_get_tweets(5); /* Get latest 5 tweets from cnn user */
// $avatar = $twitter_helper->get_avatar(); /* Get twitter avatar for user cnn */

class TwitterHelper {
	public $username;
	public $settings;
	public $cache_lifetime = 300; // 5 minutes
	public $main_error = "Cannot get latest tweets";

	function get_tweets($username, $limit, $disable_cache = false) {
		$self = new self($username);
		return $self->_get_tweets($limit, $disable_cache);
	}
	
	function __construct($username) {
		$this->username = $username;
		
		$this->settings = array(
		    'oauth_access_token' => of_get_option('twitter_oauth_access_token'),
		    'oauth_access_token_secret' => of_get_option('twitter_oauth_access_token_secret'),
		    'consumer_key' => of_get_option('twitter_consumer_key'),
		    'consumer_secret' => of_get_option('twitter_consumer_secret')
		);

		# TODO: retrieve basic user information
		// https://api.twitter.com/1.1/users/show.json?screen_name={$this->username}
	}
	
	function _get_data($type, $request_url, $params, $disable_cache = false) {

		if (!$disable_cache) {
			$cache_key = "twitter::" . md5($request_url . $params);
			
			$cached = get_option($cache_key, -1);
			if ($cached!==-1) {
				$expires = $cached['expires'];
				if ($expires > time()) {
					return $cached['data'];
				}
			}
		}

		$twitter = new TwitterAPIExchange($this->settings);
		$data = json_decode($twitter->setGetfield($params)->buildOauth($request_url, 'GET')->performRequest());

		if (!empty($data->errors)) {
			return $this->main_error;
		}
		
		if (isset($data->errors)) {
			$data = isset($cached['data']) ? $cached['data'] : false;
		} else {
			update_option($cache_key, array(
				'expires'=>time() + $this->cache_lifetime,
				'data'=>$data
			));
		}
		
		return $data;
	}
	
	function get_avatar($size = TwitterAvatarSize::NORMAL) {
		$avatar = '';
		$result = $this->_get_data('twitter-avatar', "https://api.twitter.com/1.1/users/profile_banner.json", '?screen_name=' . $this->username . '&size=' . $size);
		if ($result && !empty($result->sizes) && !empty($result->sizes->web)) {
			$avatar = $result->sizes->web->url;
		}
		return $avatar;
	}
	
	function _get_tweets($limit, $disable_cache = false) {
		$tweets = $this->_get_data('twitter-updates', "https://api.twitter.com/1.1/statuses/user_timeline.json", "?include_entities=true&include_rts=true&screen_name={$this->username}&count={$limit}", $disable_cache);

		if($tweets == $this->main_error) {
			return array();
		} elseif (is_array($tweets) && !empty($tweets)) {
			foreach ($tweets as &$tweet) {
				$tweet->tweet_text = $this->add_links(str_replace('&apos;', '\'', $tweet->text));
				$tweet->tweet_link = "https://twitter.com/{$this->username}/status/{$tweet->id_str}";
				$tweet->timestamp = strtotime($tweet->created_at);
				$tweet->time_distance = $this->distance_of_time_in_words($tweet->timestamp, time());

				if (isset($tweet->retweeted_status)) {
					$tweet->image = $tweet->retweeted_status->user->profile_image_url;
				} else {
					$tweet->image = $tweet->user->profile_image_url;
				}
			}
		}
		
		return $tweets;
	}
	function distance_of_time_in_words($from_time, $to_time=0, $showLessThanAMinute=false) {
		$distanceInSeconds = round(abs($to_time - $from_time));
		
		if(function_exists('lang')) {
			$lang = 'lang';
		} else {
			//Empty function if we don't have translation function
			$lang = create_function('$arg', 'return $arg; ');
		}
		
		$distanceInMinutes = round($distanceInSeconds / 60);
		if ( $distanceInMinutes <= 1 ) {
			if ( !$showLessThanAMinute ) {
				return ($distanceInMinutes == 0) ? $lang('less than a minute') : $lang('1 minute');
			} else {
				if ( $distanceInSeconds < 5 ) {
					return $lang('less than 5 seconds');
				}
				if ( $distanceInSeconds < 10 ) {
					return $lang('less than 10 seconds');
				}
				if ( $distanceInSeconds < 20 ) {
					return $lang('less than 20 seconds');
				}
				if ( $distanceInSeconds < 40 ) {
					return $lang('about half a minute');
				}
				if ( $distanceInSeconds < 60 ) {
					return $lang('less than a minute');
				}
			   
				return $lang('1 minute');
			}
		}
		if ( $distanceInMinutes < 45 ) {
			return $distanceInMinutes . ' ' . $lang('minutes');
		}
		if ( $distanceInMinutes < 90 ) {
			return $lang('about 1 hour');
		}
		if ( $distanceInMinutes < 1440 ) {
			return $lang('about') . ' ' . round(floatval($distanceInMinutes) / 60.0) . ' ' . $lang('hours');
		}
		if ( $distanceInMinutes < 2880 ) {
			return '1 ' .  $lang('day');
		}
		if ( $distanceInMinutes < 43200 ) {
			return $lang('about'). ' ' . round(floatval($distanceInMinutes) / 1440) . ' ' . $lang('days');
		}
		if ( $distanceInMinutes < 86400 ) {
			return $lang('about') .' 1 ' . $lang('month');
		}
		if ( $distanceInMinutes < 525600 ) {
			return round(floatval($distanceInMinutes) / 43200) . ' ' . $lang('months');
		}
		if ( $distanceInMinutes < 1051199 ) {
			return $lang('about') . ' 1 ' . $lang('year');
		}
	   
		return $lang('over') . ' ' . round(floatval($distanceInMinutes) / 525600) . ' ' . $lang('years');
	}
	/**
	 * Adds HTML links to tweet text
	 *
	 * Example:
	 */
	function add_links($tweet_text) {
	   $tweet_text = str_replace(array(/*':', '/', */'%'), array(/*'<wbr></wbr>:', '<wbr></wbr>/', */'<wbr></wbr>%'), $tweet_text);
	   $tweet_text = preg_replace('~(https?://([-\w\.]+)+(:\d+)?(/([\w/_\.]*(\?\S+)?)?)?)~', '<a href="$1" target="_blank">$1</a>', $tweet_text);
	   $tweet_text = preg_replace('~[\s]+@([a-zA-Z0-9_]+)~', ' <a href="http://twitter.com/$1" rel="nofollow" target="_blank">@$1</a>', $tweet_text);
	   $tweet_text = preg_replace('~[\s]+#([a-zA-Z0-9_]+)~', ' <a href="http://twitter.com/search?q=%23$1" rel="nofollow" target="_blank">#$1</a>', $tweet_text);
	   return $tweet_text;
	}
}

class TwitterAvatarSize {
	const ORIGINAL = 'original';
	const BIGGER = 'bigger';
	const NORMAL = 'normal';
	const MINI = 'mini';
}
