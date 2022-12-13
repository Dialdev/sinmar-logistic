<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }

$video_url = '';
if ( $type == 'youtube' && !empty( $video_id ) ) {
    $video_url = 'https://www.youtube.com/embed/' . esc_attr( $video_id ) . '?rel=0';
}
elseif ( $type == 'vimeo' && !empty( $video_id ) ) {
    $video_url = 'https://player.vimeo.com/video/' . esc_attr( $video_id ) . '?rel=0';
}

if( !empty( $content ) ) {
    $content = '<div class="content">' . $content . '</div>';
}

if( !empty( $bg_image ) ) {
    $bg_image = '<img src="'. $bg_image .'" alt="" class="img-full"/>';
}

echo $before_widget;?>
    <div class="slz-widget-video slz-block-video slz-widget-video-<?php echo esc_attr( $unique_id ); ?>">
        <?php echo wp_kses_post($title); ?>
        <div class="widget-content">
            <div class="block-video <?php echo esc_attr( $align ); ?>">
                <div>
                    <div class="btn-play">
                        <i class="icons fa fa-play"></i>
                    </div>
                    <div class="btn-close" data-src="<?php echo esc_url( $video_url ); ?>"><i class="icons fa fa-times"></i></div>
                    <?php echo wp_kses_post( $content ); ?>
                    <?php echo wp_kses_post( $bg_image ); ?>
                    <iframe src="<?php echo esc_url( $video_url ); ?>" allowfullscreen="allowfullscreen" class="video-embed"></iframe>
                </div>
            </div>
        </div>
    </div>
<?php echo $after_widget;?>