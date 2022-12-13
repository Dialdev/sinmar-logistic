<?php
class SLZ_Util {
	/**
	 * Debug method
	 *
	 * @param string $search_name
	 */
	public static function dump( $val_arr, $search_name = '' ) {
	
		echo '<pre class="warning-msg">';
		echo '<span>' . __METHOD__ . ' => ' . $search_name . '</span></br>';
	
		if(is_array($val_arr) || is_object($val_arr)){
			print_r($val_arr);
		}else{
			print($val_arr);
		}
		echo '</pre>';
	
	}
	/**
	* enque fonts visuacomposer
	*/
	public static function slz_icon_fonts_enqueue( $font ) {
		switch ( $font ) {
			case 'vs':
				wp_enqueue_style( 'font-awesome' );
				break;
			case 'openiconic':
				wp_enqueue_style( 'vc_openiconic' );
				break;
			case 'typicons':
				wp_enqueue_style( 'vc_typicons' );
				break;
			case 'entypo':
				wp_enqueue_style( 'vc_entypo' );
				break;
			case 'linecons':
				wp_enqueue_style( 'vc_linecons' );
				break;
			case 'monosocial':
				wp_enqueue_style( 'vc_monosocialiconsfont' );
				break;
			case 'material':
				wp_enqueue_style( 'vc_material' );
				break;
			default:
				do_action( 'vc_enqueue_font_icon_element', $font ); // hook to custom do enqueue style
		}
	}
	/**
	* get class from css editor of visuacomposer
	*/
	public static function slz_shortcode_custom_css_class( $param_value, $prefix = '' ) {
		$css_class = preg_match( '/\s*\.([^\{]+)\s*\{\s*([^\}]+)\s*\}\s*/', $param_value ) ? $prefix . preg_replace( '/\s*\.([^\{]+)\s*\{\s*([^\}]+)\s*\}\s*/', '$1', $param_value ) : '';

		return $css_class;
	}

	/**
	* Parse vc_link visual composer to array
	*/

	public static function get_link( $url ) {
		$result = array();
		$url_title = '';
		$target = '';
		$link = '';
		if( !empty( $url ) ){
			$vc_link = vc_build_link( $url );
			$link = !empty($vc_link['url']) ? $vc_link['url'] : '';
			$url_title = !empty($vc_link['title']) ? 'title="'.esc_attr($vc_link['title']) . '"' :'';
			$target = !empty($vc_link['target']) ? 'target="'.esc_attr(trim($vc_link['target'])) . '"' : '';
			$result['link'] = $link;
			$result['url_title'] = $url_title;
			$result['target'] = $target;
		}
		return $result;
	}
	/**
	 * Parse vc_link to array
	 *
	 * @param string  $param
	 * @return array  Result array (url:string , title: title="title value", target: target="target value", rel: rel="rel value")
	 */
	public static function parse_vc_link( $vc_link ){
		$result = array(
			'url'    => '',
			'title'  => '',
			'target' => '',
			'rel'    => '',
			'other_atts' => '',
		);
		if( !empty( $vc_link ) ){
			$vc_link = vc_build_link( $vc_link );
			$result = array_merge($result, $vc_link );
			$other_atts = array();
			if( !empty($vc_link['title']) ) {
				$other_atts[] = 'title="'.esc_attr($vc_link['title']).'"';
			}
			if( !empty($vc_link['target']) ) {
				$other_atts[] = 'target="'.esc_attr(trim($vc_link['target'])).'"';
			}
			if( !empty($vc_link['rel']) ) {
				$other_atts[] = 'rel="'.esc_attr($vc_link['rel']).'"';
			}
			if($other_atts) {
				$result['other_atts'] = implode(' ', $other_atts);
			}
		}
		return $result;
	}

	public static function set_default_data( $args, $arvals = array(), $default = array() ) {

		$result = array();

		foreach( $args as $item ) {

			$val = '';

			if( isset( $arvals[$item] ) ) {

				$val = $arvals[$item];

			}

			if( isset( $default[$item] ) && empty( $val ) ) {

				$val = $default[$item];

			}

			$result[$item] = $val;

		}

		return $result;
	}

	public static function get_list_vc_param_group( $obj, $field_list, $field_item ) {

		$list_params = '';

		$params = array();

		if( isset( $obj[$field_list] ) && ! empty( $obj[$field_list] ) && function_exists('vc_param_group_parse_atts') ) {

			$list_params = (array) vc_param_group_parse_atts($obj[$field_list] );

			if( $list_params ) {

				foreach( $list_params as $param ) {

					if( isset( $param[$field_item] ) ) {

						$params[] = $param[$field_item];

					}

				}
			}
		}
		return array( $list_params, $params );
	}
	
	public static function get_thumb_size( $sizes, $options= array(), $theme_prefix = '' ) {

		if ( empty( $theme_prefix ) )
			$theme_prefix = slz()->theme->manifest->get('prefix');

		$thumb_size = array(

			'large' => 'post-thumbnail',

		);
		if( !isset($options['column'])) {

			$options['column'] = '';

		}

		$small_column = 'small-' . $options['column'];

		if( $sizes ) {

			if ( !empty( $options['template'] )) {
				$theme_block_image_size = slz()->theme->manifest->get('block_image_size');
				if ( !empty( $theme_block_image_size[$options['template']] ) ) {
					$image_size_theme = $theme_block_image_size[$options['template']];
					$sizes = array_merge($sizes, $image_size_theme);
				}			
			}

			foreach( $sizes as $key => $value ) {

				$prefix = 'thumb-';

				$ext = '.png';

				if( $key == 'large' || $key == 'small' || $key == $small_column ) {

					$prefix = $theme_prefix . '-thumb-';

					$ext = '';

				}

				$thumb_size[$key] = $prefix . $value . $ext;

			}

			if( ! isset( $thumb_size['no-image'] ) ) {

				$thumb_size['no-image'] = 'thumb-' . $sizes['large'] . '.png';

			}

		} else {

			$thumb_size['no-image'] = 'thumb-no-image.gif';

		}

		if( ! isset( $thumb_size['small'] ) ) {

			$thumb_size['small'] = $thumb_size['large'];

		}

		if( isset( $thumb_size[$small_column] ) ) {

			$thumb_size['small'] = $thumb_size[$small_column];

			if( isset( $thumb_size['no-image-' . $small_column] ) ) {

				$thumb_size['no-image-small'] = $thumb_size['no-image-' . $small_column];

			}
		}

		return $thumb_size;

	}

	public static function get_no_image( $atts = array(), $post = null, $thumb_type = 'large', $options = array() ){

		$alt = $width = $height = '';

		if( $post ) {
			$alt = trim( strip_tags( $post->post_title ) );;
		}

		if( isset($atts['no-image-' . $thumb_type])) {

			$no_image = $atts['no-image-' . $thumb_type];

		} else {

			$no_image = isset($atts['no-image']) ? $atts['no-image'] :'thumb';

		}

		$str_size = str_replace( slz()->theme->manifest->get('prefix') . '-thumb-', '', $atts[$thumb_type]);

		$str_arr = explode("x", $str_size);

		if ( !empty ( $str_arr ) && count ( $str_arr ) == 2 ) {

			$width = ' width="' . esc_attr ( $str_arr[0] ) . '"';

			$height = ' height="' . esc_attr ( $str_arr[1] ) . '"';

		}

		$theme_no_img_dir = apply_filters('slz_util_theme_no_image_dir', '/static/img/no-image/');

		$core_no_img_dir = apply_filters('slz_util_core_no_image_dir', '/static/img/no-image/');

		if( strpos( $no_image, '.png' ) === false ){
			$no_image = $no_image . '.png';
		}
		if ( slz_locate_theme_path( $theme_no_img_dir . $no_image ) != false ) {

			$no_image = slz_locate_theme_path_uri( $theme_no_img_dir . $no_image );

		} elseif ( file_exists( slz_get_framework_directory( $core_no_img_dir . $no_image ) ) ) {

			$no_image = slz_get_framework_directory_uri( $core_no_img_dir . $no_image );

		} else {
			if( is_admin() && !isset($atts['is_ajax']) ){
				$no_image = slz_get_framework_directory_uri('/static/img/no-image/thumb_admin.png');
			} else {
				$no_image = slz_get_framework_directory_uri('/static/img/no-image/thumb.png');
			}

		}
				
		$thumb_class = SLZ_Com::get_value($options, 'thumb_class', 'img-responsive');

		$thumb_img = sprintf('<img src="%1$s" alt="%2$s" class="%3$s" %4$s %5$s />', esc_url($no_image), esc_attr($alt), esc_attr($thumb_class), $width, $height);

		return $thumb_img;
	}


	/* Video Helper Function */

    /**
     * Get Youtube ID from Youtube URL
     * @param $url
     * @return string
     */
    public static function get_youtube_id ($url ){

		$video_id = '';

		if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
		    $video_id = $match[1];
		}

		return $video_id;
	}

    /**
     * Get Vimeo ID from Vimeo URL
     * @param $url
     * @return mixed
     */
    public static function get_vimeo_id($url)
	{

		$regex = '~
		# Match Vimeo link and embed code
		(?:<iframe [^>]*src=")?         # If iframe match up to first quote of src
		(?:                             # Group vimeo url
				https?:\/\/             # Either http or https
				(?:[\w]+\.)*            # Optional subdomains
				vimeo\.com              # Match vimeo.com
				(?:[\/\w]*\/videos?)?   # Optional video sub directory this handles groups links also
				\/                      # Slash before Id
				([0-9]+)                # $1: VIDEO_ID is numeric
				[^\s]*                  # Not a space
		)                               # End group
		"?                              # Match end quote if part of src
		(?:[^>]*></iframe>)?            # Match the end of the iframe
		(?:<p>.*</p>)?                  # Match any title information stuff
		~ix';
	
		preg_match( $regex, $url, $matches );
		
		return $matches[1];
	}

    /**
     * Get Video Info Meta
     * Support: Youtube, Vimeo
     * @param $video_type
     * @param $video_id
     * @return array
     */
    public static function get_video_info_meta( $video_type, $video_id ) {
        // Get protocol
        $protocol = is_ssl() ? 'https' : 'http';

        $video_meta_info = array();

        if( $video_id && $video_type ) {
            switch ( $video_type ) {
                case 'youtube':
                    if( $video_id ) {
                        $video_info_url = $protocol . '://youtube.com/get_video_info?video_id=' . $video_id;
                        $response = wp_remote_get( $video_info_url );
                        if( ! empty( $response['body'] ) ) {
                            @parse_str( $response['body'], $body );
                            $video_meta_info = array(
                                'title'      => !empty( $body['title'] )          ? $body['title']          : '',
                                'thumb_url'  => !empty( $body['iurlmaxres'] )     ? $body['iurlmaxres']     : !empty( $body['iurlhq'] ) ? $body['iurlhq'] : '',
                                'author'     => !empty( $body['author'] )         ? $body['author']         : '',
                                'length'     => !empty( $body['length_seconds'] ) ? intval( $body['length_seconds'] ) : 0,
                                'view_count' => !empty( $body['view_count'] )     ? intval( $body['view_count'] )     : 0,
                                'video_url'  => 'https://www.youtube.com/embed/'. esc_attr( $video_id ) .'?rel=0&autoplay=1',
                            );
                        }
                    }
                    break;
                case 'vimeo':
                    if( $video_id ) {
                        $video_info_url = $protocol . '://vimeo.com/api/v2/video/' . $video_id . '.php';
                        $response = wp_remote_get( $video_info_url );
                        if( ! empty( $response['body'] ) ) {
                            $body = @unserialize( $response['body'] );
                            $body = !empty( $body[0] ) ? $body[0] : array();
                            $video_meta_info = array(
                                'title'      => !empty( $body['title'] )                 ? $body['title']                 : '',
                                'thumb_url'  => !empty( $body['thumbnail_large'] )       ? $body['thumbnail_large']       : '',
                                'author'     => !empty( $body['user_name'] )             ? $body['user_name']             : '',
                                'length'     => !empty( $body['duration'] )              ? $body['duration']              : 0,
                                'view_count' => !empty( $body['stats_number_of_plays'] ) ? $body['stats_number_of_plays'] : 0,
                                'video_url'  => 'https://player.vimeo.com/video/'. esc_attr( $video_id ) .'?rel=0&autoplay=1',
                            );
                        }
                    }
                    break;
            }
        }
        return $video_meta_info;
    }

	public static function get_icon_for_extension( $ext ) {
		switch ( $ext ) {
			/* PDF */
			case 'pdf' :
				return '<i class="icons fa fa-file-pdf-o"></i>';
					
				/* Images */
			case 'jpg' :
			case 'png' :
			case 'gif' :
			case 'bmp' :
			case 'jpeg' :
			case 'tiff' :
			case 'tif' :
				return '<i class="icons fa fa-file-image-o"></i>';
					
				/* Text */
			case 'txt' :
			case 'log' :
			case 'tex' :
				return '<i class="icons fa fa-file-text-o"></i>';
					
				/* Documents */
			case 'doc' :
			case 'odt' :
			case 'msg' :
			case 'docx' :
			case 'rtf' :
			case 'wps' :
			case 'wpd' :
			case 'pages' :
				return '<i class="icons fa fa-file-word-o"></i>';
					
				/* Spread Sheets */
			case 'csv' :
			case 'xlsx' :
			case 'xls' :
			case 'xml' :
			case 'xlr' :
				return '<i class="icons fa fa-file-excel-o"></i>';
					
				/* PowerPoint */
			case 'ppt' :
			case 'pptx' :
			case 'pptm' :
				return '<i class="icons fa fa-file-powerpoint-o"></i>';
					
				/* Zip */
			case 'zip' :
			case 'rar' :
			case '7z' :
			case 'zipx' :
			case 'tar.gz' :
			case 'gz' :
			case 'pkg' :
				return '<i class="icons fa fa-file-zip-o"></i>';
					
				/* Audio */
			case 'mp3' :
			case 'wav' :
			case 'm4a' :
			case 'aif' :
			case 'wma' :
			case 'ra' :
			case 'mpa' :
			case 'iff' :
			case 'm3u' :
				return '<i class="icons fa fa-file-audio-o"></i>';
					
				/* Video */
			case 'avi' :
			case 'flv' :
			case 'm4v' :
			case 'mov' :
			case 'mp4' :
			case 'mpg' :
			case 'rm' :
			case 'swf' :
			case 'wmv' :
				return '<i class="icons fa fa-file-video-o"></i>';
					
				/* Others */
			default :
				return '<i class="icons fa fa-file-o"></i>';
		}
	}
	public static function get_single_attachments($attachment){
		$out = '';
		$format = '<li class="att-item %4$s"><a class="btn-has-icon" target="_blank" href="%3$s" title="'.esc_html__('Click here to download', 'slz').'" download>%1$s%2$s</a></li>';
		if( !empty($attachment ) ) {
			$attach = explode(',', $attachment);
			if( $attach ) {
				foreach( $attach as $attachment_id ){
					$file_path = wp_get_attachment_url( $attachment_id );
					if( $file_path ){
						$file_type = wp_check_filetype( $file_path );
						$out .= sprintf($format,
								self::get_icon_for_extension( $file_type['ext'] ),
								get_the_title( $attachment_id ),
								$file_path,
								$file_type['ext']
						);
					}
				}
			}
		}
		if( !empty($out)) {
			$out = sprintf('<ul class="list-unstyled list-inline attachments-list">%s</ul>', $out);
		}
		return $out;
	}
	/**
	 * Generate qrcode by googleapi
	 * 
	 * @param string $content     Content to generate qrcode.
	 * @param number $size        Defaut: 120. ( Unit px ).
	 * @return string             Image src.
	 */
	public static function generate_qrcode( $content = '', $size = 120 ){
		$protocol = is_ssl() ? 'https' : 'http';
		if( empty($content) ) {
			$content = $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		}
		if( !empty($content) ){
			$content = urlencode($content);
			$image = 'https://chart.googleapis.com/chart?chs=' . $size . 'x' . $size . '&cht=qr&chld=H%7C1&chl=' . $content;
			return $image;
		}
		return '';
	}
	/**
	 * Get operating system of mobile device
	 * 
	 */

	public static function get_mobile_operating_system(){

		$user_agent =  $_SERVER['HTTP_USER_AGENT'];
	
		$os_platform = '';

		$os_array  =   array(

            '/windows/i'     =>   'Windows',
            '/macintosh|mac os x/i' =>  'Mac OS X',
            '/mac_powerpc/i'        =>  'Mac OS 9',
            '/linux/i'              =>  'Linux',
            '/ubuntu/i'             =>  'Ubuntu',
            '/iphone/i'             =>  'iPhone',
            '/ipod/i'               =>  'iPod',
            '/ipad/i'               =>  'iPad',
            '/android/i'            =>  'Android',
            '/blackberry/i'         =>  'BlackBerry',
            '/webos/i'              =>  'Mobile'
        );

	    foreach ($os_array as $regex => $value) { 

	        if (preg_match($regex, $user_agent)) {
	            $os_platform    =   $value;
	        }

	    } 
	    return $os_platform;  
	}
	public static function format_date( $date, $format = '' ) {
		if( $date ) {
			$d = DateTime::createFromFormat('m-d-Y', $date);
			if( $d ) {
				if( empty($format) ) {
					$format = get_option( 'date_format' );
				}
				return $d->format($format);
			}
		}
	}
	public static function get_numerics ($str) {
		preg_match('/\d+/', $str, $matches);
		if( $matches ) {
			return $matches[0];
		}
	}
	public static function get_non_numerics ($str) {
		preg_match('/\D+/', $str, $matches);
		if( $matches ) {
			return $matches[0];
		}
	}
}