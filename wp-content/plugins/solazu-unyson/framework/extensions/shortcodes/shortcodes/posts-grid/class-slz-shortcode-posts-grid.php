<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

class SLZ_Shortcode_Posts_Grid extends SLZ_Shortcode
{
	protected function _render($atts, $content = null, $tag = '', $ajax = false)
	{
		if( !$ajax ){
			$data = $this->get_data( $atts );
		} else{
			$data = $atts;
		}

		if( $data['style'] == 'style-2' ){
			$data['limit_post'] = '3';
		}elseif ( $data['style'] == 'style-3' ) {
			$data['limit_post'] = '4';
		}elseif ( $data['style'] == 'style-1' ) {
			$data['limit_post'] = '5';
		}elseif ( $data['style'] == 'style-4' ) {
			$data['limit_post'] = '2';
		}elseif ( $data['style'] == 'style-5' ) {
			$data['limit_post'] = '3';
		}elseif ( $data['style'] == 'style-6' ) {
			$data['limit_post'] = '7';
		}elseif ( $data['style'] == 'style-7' ) {
			$data['limit_post'] = '7';
		}else{
			$data['limit_post'] = '5';
		}

		$block = new SLZ_Block($data, $content);

		$this->enqueue_static();

		return slz_render_view($this->locate_path('/views/view.php'), array( 'block' => $block, 'instance' => $this ));
	}
}
