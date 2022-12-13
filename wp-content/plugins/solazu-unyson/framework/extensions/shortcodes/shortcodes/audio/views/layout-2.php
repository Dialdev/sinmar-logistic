<div class="sc-audio-style-2">
<?php
if( !empty( $data['playlist'] ) && $data['playlist'] != '%5B%7B%7D%5D' ) {
	$temp = slz_ext( 'shortcodes' )->get_shortcode( 'audio' )->get_config('playlist_default');
	$playlist_arr = (array) vc_param_group_parse_atts( $data['playlist'] );

	if( !empty( $playlist_arr ) ) {
		echo '<div class="slz-album-01 sc-audio-playlist">';
			echo '<div class="main-item">';
				echo '<audio  id="current-audio" controls="controls" class="current-audio main-audio slz-playlist-container" data-allow-download="'. esc_attr( $data['allow_download'] ) .'" >';
					foreach ( $playlist_arr as $item ) {
						$item = array_merge( $temp, $item );
						if( empty( $item['audio_url'] ) ) {
							continue;
						}
						if( !empty( $item['audio_url'] ) ) {
						    $arr = json_decode( $item['audio_url'] );
						    if( ! is_array( $arr ) || empty( $arr ) ) {
						        $arr = array();
                            }
                            $audio = array();
                            foreach ($arr as $obj) {
                                $audio_url = wp_get_attachment_url($obj);
                                $info_audio = wp_get_attachment_metadata( $obj, true );
                                $mime_type = get_post_mime_type( $obj );
                                $file_type = wp_check_filetype( $audio_url );

                                if( empty( $mime_type ) || ! preg_match( '/^audio\/(.*?)$/', $mime_type ) ) {
                                    continue;
                                }

                                if ( !isset($info_audio['length_formatted']) ) {
                                    $info_audio['length_formatted'] = '00:00';
                                }
                                $audio[] = array('audio_url' => $audio_url, 'info_audio' => $info_audio);
                            }

                            if ( count($audio) > 0 ) {
                                echo '<source data-duration="'.esc_attr($audio[0]['info_audio']['length_formatted']).'" src="'. esc_url( ($audio[0]['audio_url']) ) .'" title="'. esc_attr( $item['audio_title'] ) .'">';
                            }
                        }
					}
				echo '</audio>';
			echo '</div>';
			echo '<div class="bar-wrapper"><canvas class="oscilloscope" width="1110"></canvas></div>';
		echo '</div>';
		echo '<div class="oscilloscope-wrapper"></div>';
	}
}
?>
</div>

