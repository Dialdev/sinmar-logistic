<?php
class SLZ_Vc_Params
{
	public function __construct()
	{
		$slz_params_list = SLZ_Vc_Params::params_vc();
		if ( is_plugin_active( 'js_composer/js_composer.php' ) ) {
			if(!empty($slz_params_list)) {
				foreach ($slz_params_list as $param){
					vc_add_shortcode_param( $param, array( &$this, '_' . $param . '_form_field' ) , slz_get_framework_directory_uri().'/static/js/slz-vc-params.js' );
				}
			}
		}
	}

	public static function params_vc() {
		return array(
			'attach_files',
            'datetime_picker',

		);
	}
    
    function _datetime_picker_form_field( $settings, $value ) {
        $dependency = vc_generate_dependencies_attributes( $settings );
        $output = '<input name="' . $settings['param_name'] . '" ';
        $output .= 'class="wpb_vc_param_value wpb-textinput ' . $settings['param_name'] . ' ' . $settings['type'].'_field" ';
        $output .= 'type="text" value="' . $value . '" ' . $dependency . ' id="datetimepicker"/>';
        return $output;
    }

	public function _attach_files_form_field( $settings, $value ) {
		$output = '';
		$file_ids = json_decode( $value );
		$list_html = '';
		$item_format = '<li class="media-box" data-id="%1$s"><a href="javascript:void(0);" class="btn-remove"><i class="icon-remove"></i><div class="title">%2$s</div><div class="thumb" style="background-image:url(%3$s);"></div></a></li>';

		foreach ( $file_ids as $id ) {
		    $file_url = wp_get_attachment_url( $id );
            $filetype = wp_check_filetype($file_url);
            $filename = basename ( get_attached_file( $id ) );

            switch ( $filetype['ext'] ) {
                /* PDF */
                case 'pdf' :
                    $thumb_url = includes_url( 'images/media/document.png' );
                    break;
                /* Images */
                case 'jpg' :
                case 'png' :
                case 'gif' :
                case 'bmp' :
                case 'jpeg' :
                case 'tiff' :
                case 'tif' :
                    $thumb_url = wp_get_attachment_thumb_url( $id );
                    break;
                /* Text */
                case 'txt' :
                case 'log' :
                case 'tex' :
                    $thumb_url = includes_url( 'images/media/text.png' );
                    break;
                /* Documents */
                case 'doc' :
                case 'odt' :
                case 'msg' :
                case 'docx' :
                case 'rtf' :
                case 'wps' :
                case 'wpd' :
                case 'pages' :
                    $thumb_url = includes_url( 'images/media/document.png' );
                    break;
                /* Spread Sheets */
                case 'csv' :
                case 'xlsx' :
                case 'xls' :
                case 'xml' :
                case 'xlr' :
                    $thumb_url = includes_url( 'images/media/spreadsheet.png' );
                    break;
                /* PowerPoint */
                case 'ppt' :
                case 'pptx' :
                case 'pptm' :
                    $thumb_url = includes_url( 'images/media/interactive.png' );
                    break;
                /* Zip */
                case 'zip' :
                case 'rar' :
                case '7z' :
                case 'zipx' :
                case 'tar.gz' :
                case 'gz' :
                case 'pkg' :
                    $thumb_url = includes_url( 'images/media/archive.png' );
                    break;
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
                    $thumb_url = includes_url( 'images/media/audio.png' );
                    break;
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
                    $thumb_url = includes_url( 'images/media/video.png' );
                    break;
                /* Others */
                default :
                    $thumb_url = includes_url( 'images/media/default.png' );
            }
			$list_html .= sprintf( $item_format, $id, $filename, $thumb_url, $file_url );
		}

		$output .= '
            <div class="slz-attach-files-block">
                <div class="' . esc_attr( $settings['type'] ) . '_display">
                    <ul>' .
                        $list_html
                    .'</ul>
                </div>
                <input type="hidden" name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value wpb-textinput ' .
                esc_attr( $settings['param_name'] ) . ' ' .
                esc_attr( $settings['type'] ) . '_field" value="' . esc_attr( $value ) . '" />
                <a class="media-box button_add_media" href="javascript:void(0);">
                    <i class="icon-add"></i>
                    '. esc_html__( 'Add File', 'slz' ) .'
                </a>
            </div>
				  ';

		return $output;
	}

} new SLZ_Vc_Params();