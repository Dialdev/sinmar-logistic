<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

class SLZ_Shortcode_Ads_Banner extends SLZ_Shortcode
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

			$style ='.slz-banner-image.banner-%1$s .slz-title-shortcode{ color: %2$s }';

			$css .= sprintf( $style, esc_attr( $unique_id ), esc_attr( $data['block_title_color'] ) );

			do_action( 'slz_add_inline_style', $css );

		}

		return slz_render_view($this->locate_path('/views/view.php'), array( 'block' => $data, 'instance' => $this, 'unique_id'	=> $unique_id ));
	}
}
