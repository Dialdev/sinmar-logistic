<?php

function slz_ext_new_tweet_get_display_elements($data, $show_media)
{
	$src_text = $data['text'];
						
	//URL
	$urls = $data['entities']['urls'];
	foreach ($urls as $url) {
		$url_in_text = $url['url'];
		$display_url_src = $url['display_url'];
		$display_url = '<a href="'.esc_url($url_in_text).'" class="link" target="_blank" title="http://'.$display_url_src.'">'.esc_html($display_url_src).'</a>';
		$src_text = str_replace($url_in_text, $display_url, $src_text);
	}

	$display_image = '';
	//Media
	if(isset($data['entities']['media']))
	{
		$medias = $data['entities']['media'];
		foreach ($medias as $media) {
			$media_url = $media['url'];
			$display_url = $media['media_url_https'];
			$src_text = str_replace($media_url, '', $src_text);
			if ($show_media)
			{
				$display_image .= '<img src="'.esc_url($display_url).'" alt="" class="img-responsive">';
			}
		}
	}

	//Hashtag
	$hashtags = $data['entities']['hashtags'];
	foreach ($hashtags as $hashtag) {
		$tag = '#'.$hashtag['text'];
		$hasurl = 'https://twitter.com/hashtag/'.$hashtag['text'].'?src=hash';
		$display_tag = '<a href="'.esc_url( $hasurl ).'" class="link" target="_blank">
			'.$tag.'
		</a>';
		
		$src_text = str_replace($tag, $display_tag, $src_text);
	}

	//Mention
	$user_mentions = $data['entities']['user_mentions'];
	foreach ($user_mentions as $user) {
		$user_screen_name = $user['screen_name'];
		$user_screen_name_in_text = '@'.$user_screen_name;

		$mentionurl = 'https://twitter.com/'.esc_attr($user_screen_name);
		$mention = '<a href="'.esc_url( $mentionurl ).'" class="link">'.$user_screen_name_in_text.'</a>';
		$src_text = str_replace($user_screen_name_in_text, $mention, $src_text);
	}

	$date_create = $data['created_at'];

	$date = new DateTime( $date_create );
	$time = date_timestamp_get($date);
	
	$time = time() - $time;
	
	$time = ($time<1)? 1 : $time;
		
	$time = slz_human_time($time);
	
	$result = array('text' => $src_text, 'media' => $display_image, 'time_ago' => $time);

	return $result;
}

function slz_ext_new_tweet_get_tweet_data_api($settings)
{
	$cache_data = get_option('slz_new_tweet_cache_data');	

	$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
	$getfield = '?screen_name='.$settings['screen_name'].'&count='.$settings['limit_tweet'].'';
	$requestMethod = 'GET';

	$twitter = new SLZ_Twitter_New_Tweet_API ($settings);
	$request = $twitter->setGetfield($getfield)
				 ->buildOauth($url, $requestMethod)
				 ->performRequest();
	$result = json_decode($request, true);

	$settings['cache_time'] = time();

	$data_to_cache = array('settings' => $settings, 'tweet_data' => $result );

	return $data_to_cache;
}

function slz_ext_new_tweet_get_tweet_data($settings)
{
	$exp = 3600;
	$cache_data = get_option('slz_new_tweet_cache_data');

	if ($cache_data != false )
	{
		$cache_time = array_pop($cache_data['settings']);
		$time = time() - $cache_time;
		if($time < $exp && array_diff_assoc($settings, $cache_data['settings']) == '')
		{
			return $cache_data['tweet_data'];
		}
		else
		{
			$tweet_data = slz_ext_new_tweet_get_tweet_data_api($settings);
			update_option('slz_new_tweet_cache_data', $tweet_data);
			return $tweet_data['tweet_data'];
		}
	}
	else
	{
		$tweet_data = slz_ext_new_tweet_get_tweet_data_api($settings);
		add_option('slz_new_tweet_cache_data', $tweet_data);
		return $tweet_data['tweet_data'];
	}
}

?>