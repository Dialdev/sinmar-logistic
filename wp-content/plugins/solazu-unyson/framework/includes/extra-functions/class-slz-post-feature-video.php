<?php
class SLZ_Post_Feature_Video {
	function init(){
		require_once(ABSPATH . 'wp-admin/includes/media.php');
		require_once(ABSPATH . 'wp-admin/includes/file.php');
		require_once(ABSPATH . 'wp-admin/includes/image.php');
		add_action( 'action_solazbiz_save_fearture_video', array( &$this, 'action_save_feature_video') );
		add_action( 'save_post', array( &$this, 'action_save_post_data' ) );
	}

	/*
	 * Get video thumb from post id and video id
	 */
	function get_video_thumb( $post_id, $status, $video_id ){
		$protocol = is_ssl() ? 'https' : 'http';
		$meta = true;
		$thumb = '';
		if( $meta ) {

			switch ( $status ) {
				case '\"youtube\"':
					if( $video_id ) {
						$img_url = $protocol . '://img.youtube.com/vi/' . $video_id;
						if ( ! $this->is_404_imgurl( $img_url . '/maxresdefault.jpg')) {
							$thumb = $img_url . '/maxresdefault.jpg';
						} else {
							$thumb = $img_url . '/hqdefault.jpg';
						}
					}
					break;
				case '\"vimeo\"':
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
		if( ! empty( $thumb ) && is_admin() ) {
			// add attached file
			add_action('add_attachment', array( &$this, 'add_featured_image' ) );

			// load the attachment from the URL
			media_sideload_image( $thumb, $post_id, $post_id);

			// remove the hook
			remove_action('add_attachment', array( &$this, 'add_featured_image' ) );
		}
		return $thumb;
	}

	/*
	 *	Save feature image to database
	 */
	function add_featured_image( $post_id ){
		$p = get_post( $post_id );
		update_post_meta($p->post_parent,'_thumbnail_id', $post_id);
	}

	/*
	 * Check if url image exist
	 */
	function is_404_imgurl( $url ) {
		$headers = get_headers( $url );
		if (strpos( $headers[0],'404' ) !== false) {
			return true;
		} else {
			return false;
		}
	}

	/*
	 * Save feature video from $_POST data
	 */
	function action_save_feature_video() {
		if( !empty( $_POST['post_format'] ) && $_POST['post_format'] == 'video' ) {
			if ( !empty( $_POST['slz_options']['video_type']['vimeo']['vimeo_link'] ) || !empty( $_POST['slz_options']['video_type']['youtube']['youtube_link'] ) ) {
				$post_id = get_the_id();
				$status = $_POST['slz_options']['video_type']['video_options'];
				if ( $_POST['slz_options']['thumbnail'] == 'true' ) {
					if ( $status == '\"vimeo\"' ) {
						$vimeo_link = $_POST['slz_options']['video_type']['vimeo']['vimeo_link'];
						$this->get_video_thumb( $post_id, $status, $vimeo_link );
					}elseif ( $status == '\"youtube\"' ) {
						$youtube_link = $_POST['slz_options']['video_type']['youtube']['youtube_link'];
						$this->get_video_thumb( $post_id, $status, $youtube_link );
					}
				}
			}
		}
	}

	/*
	 * Save Post Data
	 */
	function action_save_post_data(){
		$post_id = get_the_id();
		do_action(  'action_solazbiz_save_fearture_video', $post_id );
	}
	
	public static function get_feature_video_iframe( &$url, $post_id, $format = null ) {
		$out = '';
		$iframe = '';
		
		if( $format == null ) {
			$format = '%1$s';
		}
		
		$post_format = get_post_format( $post_id );
		if( $post_format == 'video' ) {

			$data = slz_get_db_post_option( $post_id, 'video_type' );
			$is_video_type = false;

			if( $data['video_options'] == 'youtube' && !empty( $data['youtube']['youtube_link'] ) ) {
				$is_video_type = true;
			}elseif( $data['video_options'] == 'vimeo' && !empty( $data['vimeo']['vimeo_link'] ) ){
				$is_video_type = true;
			}

			if( $is_video_type == true ) {
				if( $data['video_options'] == 'youtube' ) {
					$url = 'https://www.youtube.com/embed/' . esc_attr( $data['youtube']['youtube_link'] ) . '?rel=0';
					$iframe = '<iframe src="'. esc_url( $url ) .'" allowfullscreen="allowfullscreen" class="video-embed"></iframe>';
				}elseif( $data['video_options'] == 'vimeo' ){
					$url = 'https://player.vimeo.com/video/' . esc_attr( $data['vimeo']['vimeo_link'] ) . '?rel=0';
					$iframe = '<iframe src="'. esc_url( $url ) .'" webkitallowfullscreen mozallowfullscreen allowfullscreen class="video-embed"></iframe>';
				}
				$out .= sprintf( $format, $iframe );
			}

		}

		return $out;
	}
	
	public static function get_video_url_iframe( $post_id ) {
		$video_url = '';
		$data = slz_get_db_post_option( $post_id, 'video_type' );
		if( $data['video_options'] == 'youtube' && !empty( $data['youtube']['youtube_link'] ) ) {
			$video_url = 'https://www.youtube.com/embed/' . esc_attr( $data['youtube']['youtube_link'] ) . '?rel=0';
		}elseif( $data['video_options'] == 'vimeo' && !empty( $data['vimeo']['vimeo_link'] ) ){
			$video_url = 'https://player.vimeo.com/video/' . esc_attr( $data['vimeo']['vimeo_link'] ) . '?rel=0';
		}
		return $video_url;
	}
}