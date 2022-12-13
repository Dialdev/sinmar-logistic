<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

class SLZ_Shortcode_Posts_Carousel extends SLZ_Shortcode
{
	protected function _render($atts, $content = null, $tag = '', $ajax = false)
	{
		if( !$ajax ){

            $data = $this->get_data( $atts );

        } else
            $data = $atts;


		$this->enqueue_static();

		return slz_render_view($this->locate_path('/views/view.php'), array( 'data' => $data, 'instance' => $this ));
	}
}
