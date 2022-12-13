<?php

if( ! function_exists( 'slz_ext_instagram_get_instagram_data' ) ) {

	function slz_ext_instagram_get_instagram_data($instagram_id)
	{
		$exp = 3600;
		$cache_data = get_option('slz_instagram_cache_data');

		if ($cache_data != false )
		{
			$cache_time = $cache_data['settings']['cache_time'];
			$cache_instagram_id = $cache_data['settings']['instagram_id'];
			$time = time() - $cache_time;
			if($time < $exp && $instagram_id == $cache_instagram_id)
			{
				return $cache_data['instagram_data'];
			}
			else
			{
				$instagram_data = slz_ext_instagram_get_instagram_data_api($instagram_id);
				if (!is_null($instagram_data))
				{
					update_option('slz_instagram_cache_data', $instagram_data);
					return $instagram_data['instagram_data'];
				}
				else
				{
					return false;
				}
			}
		}
		else
		{
			$instagram_data = slz_ext_instagram_get_instagram_data_api($instagram_id);
			if (!is_null($instagram_data))
				{
					add_option('slz_instagram_cache_data', $instagram_data);
				return $instagram_data['instagram_data'];
				}
				else
				{
					return false;
				}

		}
	}
}

if( ! function_exists( 'slz_ext_instagram_get_instagram_data_api' ) ) {

	function slz_ext_instagram_get_instagram_data_api($instagram_id)
	{
		$url = "http://instagram.com/$instagram_id/?__a=1"; // url api
		$response = wp_remote_get( esc_url_raw( $url ) );
		$data = json_decode( wp_remote_retrieve_body( $response ), true );
		// is nul or fail respone?
		if( empty( $data ) )
		{
			return false;
		}
		$media = $data['user']['media']['nodes'];
		$settings = array(	'instagram_id' => $instagram_id,
							'cache_time'   => time()  );
		$data_to_cache = array('instagram_data' => $media, 'settings' => $settings );
		return $data_to_cache;
	}
}
?>