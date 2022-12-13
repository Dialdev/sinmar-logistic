<?php

if( ! function_exists( 'slz_ext_social_counter_network_meta' ) ) {
	
	function slz_ext_social_counter_network_meta( $service_id, $user_id, &$td_social_api, $token = array() ) {
		switch ($service_id) {
			case 'facebook':
				return array(
					'button' => esc_html__( 'Like', 'slz' ),
					'url' => "https://www.facebook.com/$user_id",
					'text' => esc_html__( 'Fans', 'slz' ),
					'api' => $td_social_api->get_social_counter($service_id, $user_id, false, $token),
				);
				break;
		
			case 'twitter':
				return array(
					'button' => esc_html__( 'Follow', 'slz' ),
					'url' => "https://twitter.com/$user_id",
					'text' => esc_html__( 'Followers', 'slz' ),
					'api' => $td_social_api->get_social_counter($service_id, $user_id),
				);
				break;
		
			case 'vimeo':
				return array(
					'button' => esc_html__( 'Like', 'slz' ),
					'url' => "http://vimeo.com/$user_id",
					'text' => esc_html__( 'Likes', 'slz' ),
					'api' => $td_social_api->get_social_counter($service_id, $user_id),
				);
				break;
		
			case 'youtube':
				return array(
					'button' => esc_html__( 'Subscribe', 'slz' ),
					'url' => (strpos('channel/', $user_id) >= 0) ? "http://www.youtube.com/$user_id" : "http://www.youtube.com/user/$user_id",
					'text' => esc_html__( 'Subscribers', 'slz' ),
					'api' => $td_social_api->get_social_counter($service_id, $user_id),
				);
				break;
		
			case 'google':
				return array(
					'button' => '+1',
					'url' => "https://plus.google.com/$user_id",
					'text' => esc_html__( 'Subscribers', 'slz' ),
					'api' => $td_social_api->get_social_counter($service_id, $user_id),
				);
				break;
		
			case 'instagram':
				return array(
					'button' => esc_html__( 'Follow', 'slz' ),
					'url' => "http://instagram.com/$user_id#",
					'text' => esc_html__( 'Followers', 'slz' ),
					'api' => $td_social_api->get_social_counter($service_id, $user_id),
				);
				break;
		
			case 'soundcloud':
				return array(
					'button' => esc_html__( 'Follow', 'slz' ),
					'url' => "https://soundcloud.com/$user_id",
					'text' => esc_html__( 'Followers', 'slz' ),
					'api' => $td_social_api->get_social_counter($service_id, $user_id),
				);
				break;
		
			case 'rss':
				return array(
					'button' => esc_html__( 'Follow', 'slz' ),
					'url' => get_bloginfo('rss2_url'),
					'text' => esc_html__( 'Followers', 'slz' ),
					'api' => $td_social_api->get_social_counter($service_id, $user_id),
				);
				break;
		}
	}
}

?>