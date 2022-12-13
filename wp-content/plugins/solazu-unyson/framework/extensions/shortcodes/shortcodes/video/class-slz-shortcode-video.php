<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

class SLZ_Shortcode_Video extends SLZ_Shortcode
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
		return slz_render_view($this->locate_path('/views/view.php'), array( 'data' => $data, 'view_path' => $view_path, 'instance' => $this ));
	}

	public function iframe_render( $video_url ) {
        $format = '<iframe src="%1$s" allowfullscreen="allowfullscreen" class="video-embed"></iframe>';
        return sprintf($format, esc_url( $video_url ) );
    }

    public function get_video_thumb_general( $video_type, $video_id ) {
		$protocol = is_ssl() ? 'https' : 'http';
		$thumb = '';
		if( $video_id && $video_type ) {
			switch ( $video_type ) {
				case 'youtube':
					if( $video_id ) {
						$img_url = $protocol . '://img.youtube.com/vi/' . $video_id;
						if ( ! $this->is_404( $img_url . '/maxresdefault.jpg')) {
							$thumb = $img_url . '/maxresdefault.jpg';
						} else {
							$thumb = $img_url . '/hqdefault.jpg';
						}
					}
					break;
				case 'vimeo':
					if( $video_id ) {
						$video_api = @file_get_contents('http://vimeo.com/api/v2/video/' . $video_id . '.php');
						if (! empty( $video_api ) ) {
							$video_data = @unserialize( $video_api );
							if (! empty( $video_data[0]['thumbnail_large'] ) ) {
								$thumb = $video_data[0]['thumbnail_large'];
							}
						}
					}
					break;
			}
		}
		return $thumb;
	}
	public function is_404( $url ) {
		$headers = get_headers( $url );
		if (strpos( $headers[0],'404' ) !== false) {
			return true;
		} else {
			return false;
		}
	}
}
