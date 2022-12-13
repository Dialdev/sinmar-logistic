<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

class SLZ_Shortcode_Banner extends SLZ_Shortcode
{
	protected function _render($atts, $content = null, $tag = '', $ajax = false)
	{
        $view_path = $this->locate_path('/views');

		if( !$ajax ){

            $data = $this->get_data( $atts );

        } else
            $data = $atts;

		$this->enqueue_static();
		$data['content'] = '';
		if( function_exists( 'wpb_js_remove_wpautop' ) ) {
			$data['content'] = wpb_js_remove_wpautop( $content, true );
		}

		return slz_render_view($this->locate_path('/views/view.php'), compact( 'data', 'view_path' ));
	}
}
