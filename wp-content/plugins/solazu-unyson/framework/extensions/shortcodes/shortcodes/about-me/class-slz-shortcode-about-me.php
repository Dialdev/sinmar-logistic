<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

class SLZ_Shortcode_About_Me extends SLZ_Shortcode
{
	protected function _render($atts, $content = null, $tag = '', $ajax = false)
	{
		$unique_id = SLZ_Com::make_id();
		
		$view_path = $this->locate_path('/views');

		$defaults = $this->get_config('default_value');

		$data = shortcode_atts( $defaults, $atts );

		$style = '';

		$css = '';

		if ( !empty( $data['block_title_color'] ) && $data['block_title_color'] != '#'  ) {

			$style ='.sc_about_me.block-%1$s .slz-title-shortcode{ color: %2$s }';

			$css .= sprintf( $style, esc_attr( $unique_id ), esc_attr( $data['block_title_color'] ) );

			do_action( 'slz_add_inline_style', $css );

		}

		$this->enqueue_static();

		return slz_render_view($this->locate_path('/views/view.php'), array( 'data' => $data, 'block_id' => $unique_id, 'view_path' => $view_path, 'instance' => $this ));
	}
}
