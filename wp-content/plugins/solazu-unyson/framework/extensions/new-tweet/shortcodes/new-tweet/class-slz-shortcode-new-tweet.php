<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

class SLZ_Shortcode_New_Tweet extends SLZ_Shortcode
{
	protected function _render($atts, $content = null, $tag = '', $ajax = false)
	{

		$this->enqueue_static();
		
		$unique_id = SLZ_Com::make_id();

		$defaults = $this->get_config('default_value');

		$data = shortcode_atts( $defaults, $atts );
		$style = '';

		$css = '';

		if ( !empty( $data['block_title_color'] ) && $data['block_title_color'] != '#'  ) {

			$style ='.slz-new-tweet.new-tweet-%1$s .slz-title-shortcode{ color: %2$s }';

			$css .= sprintf( $style, esc_attr( $unique_id ), esc_attr( $data['block_title_color'] ) );

			do_action( 'slz_add_inline_style', $css );

		}

		$settings = array(
		    'oauth_access_token' 		=> str_replace(' ', '', slz_get_db_ext_settings_option('new-tweet','access_token')),
		    'oauth_access_token_secret' => str_replace(' ', '', slz_get_db_ext_settings_option('new-tweet','access_token_secret')),
		    'consumer_key' 				=> str_replace(' ', '', slz_get_db_ext_settings_option('new-tweet','consumer_key')),
		    'consumer_secret'			=> str_replace(' ', '', slz_get_db_ext_settings_option('new-tweet','consumer_key_secret')),
		    'screen_name' 				=> str_replace(' ', '', $data['screen_name']),
		    'limit_tweet'				=> $data['limit_tweet']
		);

		$tweet_data = slz_ext_new_tweet_get_tweet_data( $settings );

		return slz_render_view($this->locate_path('/views/view.php'), array( 'block' => $data, 'tweet_data' => $tweet_data, 'unique_id'	=> $unique_id, 'instance' => $this));
	}
}
