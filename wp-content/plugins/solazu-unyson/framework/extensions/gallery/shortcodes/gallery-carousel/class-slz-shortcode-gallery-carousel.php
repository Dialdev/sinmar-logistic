<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

class SLZ_Shortcode_Gallery_Carousel extends SLZ_Shortcode
{
	protected function _render($atts, $content = null, $tag = '', $ajax = false)
	{

		$view_path = $this->locate_path('/views');

		if( !$ajax ){
			$data = $this->get_data( $atts );
		} else {
			$data = $atts;
		}
		if( $data['post_type'] == 'slz-portfolio' ){
			if( !empty($data['portfolio_limit_post']) ) {
				$data['limit_post'] = $data['portfolio_limit_post'];
			}
		}
		$this->enqueue_static();

		return slz_render_view($this->locate_path('/views/view.php'), array( 'data' => $data, 'view_path' => $view_path, 'instance' => $this ) );
	}
}
