<?php

class SLZ_Social_Sharing {

	private $post;
	public static $social_url_param;

	public function __construct( $post = null ) {
		if ( !empty ( $post ) )
			$this->post = $post;
	}

	public function render( $network, $echo = false, $format = null ){

		$out = '';
		$title = $url = $excerpt = $image = '';

		$data = $this->parse_data();

		extract( $data );

		if ( empty ( $format ) )
			$format = '<li><a href="%1$s" class="link" target="_blank">%2$s</a></li>';

		$out .= sprintf( $format, sprintf( $this->get_social_share_url( $network ), $url, $title, $excerpt, $image ), '<i class="icons fa fa-' . esc_attr( $network ) . '"></i>' );

		if ( $echo )
			echo $out;
		else
			return $out;

	}

	public function renders( $list, $echo = false, $format = null ){

		$out = '';
		$title = $url = $excerpt = $image = '';

		$data = $this->parse_data();

		extract( $data );

		if ( empty ( $format ) )
			$format = '<li><a href="%1$s" class="link" target="_blank">%2$s</a></li>';

		if( $list ) {
			foreach ($list as $network) {
				
				$out .= sprintf( $format, sprintf( $this->get_social_share_url( $network ), $url, str_replace(' ', '', $title), $excerpt, $image ), '<i class="icons fa fa-' . esc_attr( $network ) . '"></i>', 'share-'.esc_attr( $network ) );
	
			}
		}

		if ( $echo )
			echo $out;
		else
			return $out;

	}

	private function parse_data(){

		$result = array();

		if ( empty ( $this->post ) ) {

			$result['title'] = esc_attr ( get_the_title() );

			$result['url'] = esc_url ( get_permalink() );

			$result['excerpt'] = esc_attr ( get_the_excerpt() );
			
			if( function_exists('get_the_post_thumbnail_url') ) {
				
				$result['image'] = esc_url ( get_the_post_thumbnail_url() );
				
			}
			

		}
		else {

			$result['title'] = esc_attr ( $this->post->post_title );

			$result['url'] = esc_url ( get_permalink ( $this->post ) );

			$result['excerpt'] = esc_attr ( $this->post->post_excerpt );
			
			if( function_exists('get_the_post_thumbnail_url') ) {
				
				$result['image'] = esc_url ( get_the_post_thumbnail_url( $this->post ) );
			
			}

		}

		return $result;

	}

	public static function social_param () {

		return array(
			'facebook'      => esc_html__( 'Facebook', 'slz' ),
			'twitter'       => esc_html__( 'Twitter', 'slz' ),
			'google-plus'   => esc_html__( 'Google Plus', 'slz' ),
			'linkedin'		=> esc_html__( 'Linkedin', 'slz' ),
			'digg'			=> esc_html__( 'Digg', 'slz' ),
			'reddit'		=> esc_html__( 'Reddit', 'slz' ),
			'delicious'		=> esc_html__( 'Delicious', 'slz' ),
			'stumbleupon'	=> esc_html__( 'Stumbleupon', 'slz' ),
			'tumblr'		=> esc_html__( 'Tumblr', 'slz' ),
			'odnoklassniki' => esc_html__( 'Odnoklassniki', 'slz' ),
			'weibo'			=> esc_html__( 'Weibo', 'slz' ),
			'xing'			=> esc_html__( 'Xing', 'slz' ),
			'get-pocket'	=> esc_html__( 'Get Pocket', 'slz' ),
			'print'			=> esc_html__( 'Printfriendly', 'slz' ),
			'amazon'		=> esc_html__( 'Amazon', 'slz' ),
			'yahoo'			=> esc_html__( 'Yahoo Mail', 'slz' ),
			'hacker-news'	=> esc_html__( 'Hacker News', 'slz' ),
			'viadeo'		=> esc_html__( 'Viadeo', 'slz' ),
			'pinterest'		=> esc_html__( 'Pinterest', 'slz' )
		);

	}

	public function get_social_share_url( $network ) {

		if ( empty ( self::$social_url_param ) ){

			self::$social_url_param = array(
				'facebook'      => 'http://www.facebook.com/sharer/sharer.php?u=%1$s&amp;t=%2$s',
				'twitter'       => 'https://twitter.com/intent/tweet?text=%2$s&amp;url=%1$s',
				'google-plus'   => 'https://plus.google.com/share?url=%1$s',
				'linkedin'		=> 'http://www.linkedin.com/shareArticle?mini=true&amp;ro=true&amp;trk=SocialShare&amp;title=%2$s&amp;url=%1$s',
				'digg'			=> 'http://digg.com/submit?phase=2%20&amp;url=%1$s&amp;title=%2$s',
				'reddit'		=> 'http://reddit.com/submit?url=%1$s&amp;title=%2$s',
				'delicious'		=> 'https://delicious.com/save?v=5&noui&jump=close&url=%1$s&amp;title=%2$s',
				'stumbleupon'	=> 'http://www.stumbleupon.com/badge/?url=%1$s',
				'tumblr'		=> 'http://tumblr.com/share?s=&v=3&t=%2$s&u=%1$s',
				'odnoklassniki' => 'http://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1&st._surl=%1$s',
				'weibo'			=> 'http://service.weibo.com/share/share.php?url=%1$s&title=%2$s&pic=%4$s',
				'xing'			=> 'https://www.xing.com/social_plugins/share?h=1;url=%1$s',
				'get-pocket'	=> 'https://getpocket.com/save?title=%2$s&url=%1$s',
				'print'			=> 'http://www.printfriendly.com/print/?url=%1$s',
				'amazon'		=> 'http://www.amazon.com/gp/wishlist/static-add?u=%1$s&t=%2$s',
				'yahoo'			=> 'http://compose.mail.yahoo.com/?body=%1$s',
				'hacker-news'	=> 'https://news.ycombinator.com/submitlink?u=%1$s&t=%2$s',
				'viadeo'		=> 'https://www.viadeo.com/?url=%1$s&amp;title=%2$s',
				'pinterest'		=> 'http://pinterest.com/pin/create/button/?url=%1$s&media=%4$s&description=%2$s'
			);

		}

		return self::$social_url_param[ $network ];

	}

	private function get_json_values( $url ) {
		$args            = array( 'timeout' => 10 );
		$response        = wp_remote_get( $url, $args );
		$json_response   = wp_remote_retrieve_body( $response );
		return $json_response;
	}

	public function get_facebook_share_count( $url , $app_id = '' , $secret_key = '' ) {
		$facebook_count = 0;
		if( $app_id == '' || $secret_key == '' || $url == '' ) {
			return $facebook_count;
		}
		$json_string    = $this->get_json_values( 'https://graph.facebook.com/v2.7/?access_token='. $app_id .'|'. $secret_key .'&id='.$url );
		$json           = json_decode( $json_string, true );
		if( isset( $json->share->share_count ) ) {
			$facebook_count = intval( $json->share->share_count );
		}else{
			$facebook_count = 0;
		}
		return $facebook_count;
	}
	
	public function get_tweets_share_count( $url ) {
		$tweets_count = 0;
		if( !empty( $url ) || $url == '' ) {
			return  $tweets_count; 
		}
		$json_string = $this->get_json_values( 'http://opensharecount.com/count.json?url=' . $url );
		$json           = json_decode( $json_string, true );
		$tweet_count    = isset( $json['count'] ) ? intval( $json['count'] ) : 0;
		return $tweet_count;
	}
	
	public function get_googleplus_share_count( $url ){
		$curl = curl_init();
		curl_setopt( $curl, CURLOPT_URL, "https://clients6.google.com/rpc" );
		curl_setopt( $curl, CURLOPT_POST, true );
		curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $curl, CURLOPT_POSTFIELDS, '[{"method":"pos.plusones.get","id":"p","params":{"nolog":true,"id":"' . rawurldecode( $url ) . '","source":"widget","userId":"@viewer","groupId":"@self"},"jsonrpc":"2.0","key":"p","apiVersion":"v1"}]' );
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $curl, CURLOPT_HTTPHEADER, array( 'Content-type: application/json' ) );
		$curl_results = curl_exec( $curl );
		curl_close( $curl );
		unset( $curl );
		$json = json_decode( $curl_results, true );
		$plusones_count = isset( $json[0]['result']['metadata']['globalCounts']['count'] ) ? intval( $json[0]['result']['metadata']['globalCounts']['count'] ) : 0;
		return $plusones_count;
	}
	
	public function get_pinterest_share_count( $url ) {
		$json_string        = $this->get_json_values( 'http://api.pinterest.com/v1/urls/count.json?url=' . $url );
		$json_string        = preg_replace( '/^receiveCount\((.*)\)$/', "\\1", $json_string );
		$json               = json_decode( $json_string, true );
		$pinterest_count    = isset( $json['count'] ) ? intval( $json['count'] ) : 0;
		return $pinterest_count;
	}
	
	public function get_linkedin_share_count( $url ) {
		$json_string    = $this->get_json_values( "https://www.linkedin.com/countserv/count/share?url=". $url ."&format=json" );
		$json           = json_decode( $json_string, true );
		$linkedin_count = isset( $json['count'] ) ? intval( $json['count'] ) : 0;
		return $linkedin_count;
	}
	
}