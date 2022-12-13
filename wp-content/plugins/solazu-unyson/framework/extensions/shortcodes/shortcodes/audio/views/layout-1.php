<div  class="sc-audio-style-1">
<?php if( !empty( $data['title'] ) ) : ?>
	<div class="title"><?php echo esc_html( $data['title'] ); ?></div>
<?php endif; ?>
<?php if( !empty( $data['content'] ) ) : ?>
    <?php if( function_exists('wpb_js_remove_wpautop') ) : ?>
	   <div class="description"><?php echo wpb_js_remove_wpautop( $data['content'], true ) ?></div>
    <?php endif; ?>
<?php endif; ?>
<?php if( !empty( $data['audio_url'] ) ) : ?>
    <?php
        preg_match( '/`{`(.*?)`}`/' , $data['audio_url'], $matches );
        if( empty( $matches ) ) {
            $matches[1] = '';
        }
        $arr = explode(',', $matches[1] );
        $audio = array();
        foreach ($arr as $item) {
            $audio_url = wp_get_attachment_url($item);
            $info_audio = wp_get_attachment_metadata( $item, true );
            $mime_type = get_post_mime_type( $item );
            $file_type = wp_check_filetype( $audio_url );

            if( ! empty( $mime_type ) && preg_match( '/^audio\/(.*?)$/', $mime_type ) ) {
                $audio[] = array('audio_url' => $audio_url, 'info_audio' => $info_audio);
            }

        }
        if (count($audio) > 0):
        ?>
        <div class="audio-container">
            <audio class="sc-audio-default" controls="controls" src="<?php echo esc_url( $audio[0]['audio_url'] ); ?>"></audio>
            <div class="slz-audio-control">
                <span class="btn-play"></span>
            </div>
        </div>
<?php   endif;endif; ?>
</div>
