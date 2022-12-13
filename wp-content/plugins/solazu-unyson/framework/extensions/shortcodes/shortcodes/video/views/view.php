<?php if ( ! defined( 'ABSPATH' ) ) {
    die( 'Forbidden' );
}

$uniq_id = 'video-' . SLZ_Com::make_id();
$video_url = $image_url =  $title  = $description = $class_bg = $custom_css = '';
$styles = ! empty( $data['style'] ) ? $data['style'] : 'style-1';

if( !empty( $data['image_video'] ) ){
    $image_url = wp_get_attachment_url( $data['image_video'] );
}

if ( $data['video_type'] == 'youtube' && !empty( $data['id_youtube'] ) ) {
    $video_url = 'https://www.youtube.com/embed/' . esc_attr( $data['id_youtube'] ) . '?rel=0';
}
elseif ( $data['video_type'] == 'vimeo' && !empty( $data['id_vimeo'] ) ) {
    $video_url = 'https://player.vimeo.com/video/' . esc_attr( $data['id_vimeo'] ) . '?rel=0';
}
if( ! empty( $data['title'] ) ) {
    $title = '<div class="title">'.$data['title'].'</div>';
}

if( ! empty( $data['content'] ) ) {
    $description = '<div class="description">'. $data['content'] .'</div>';
}
$class_bg = '';
if (empty($image_url)){
    $class_bg = 'none-background';
}
if ( !empty( $video_url ) ):
?>
<div class="slz-shortcode sc-video slz-block-video <?php echo esc_attr( $uniq_id ).' '.esc_attr($data['extra_class']).' '.esc_attr($class_bg) ; ?>">
    <?php switch ( $styles ) {
        case 'style-1':
        ?>
            <div class="block-video block-video-style-1 <?php echo esc_attr( $data['align'] ); ?>">
        <div class="video-content">
            <div class="btn-play">
                <i class="icons fa fa-play"></i>
            </div>
            <div class="btn-close" data-src="<?php echo esc_url( $video_url ); ?>"><i class="icons fa fa-times"></i></div>
            <?php echo wp_kses_post($title); ?>
            <?php echo wp_kses_post($description); ?>
            <img src="<?php echo esc_url( $image_url ); ?>" alt="" class="img-full"/>
            <?php echo ( $instance->iframe_render( $video_url ) ); ?>
        </div>
    </div>
        <?php
            break;
        case 'style-2':
        ?>
            <div class="block-video block-video-style-2 <?php echo esc_attr( $data['align'] ); ?>">
                <div class="video-content">
                    <div class="btn-play">
                        <a href="javascript:void(0);" data-toggle="modal" data-target="#sc-video-modal-<?php esc_attr( $uniq_id ) ?>">
                            <i class="icons fa fa-play"></i>
                        </a>
                    </div>
                    <?php echo wp_kses_post($title); ?>
                    <?php echo wp_kses_post($description); ?>
                    <img src="<?php echo esc_url( $image_url ); ?>" alt="" class="img-full"/>
                    <div id="sc-video-modal-<?php esc_attr( $uniq_id ) ?>" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="btn-close" data-src="<?php echo esc_url( $video_url ); ?>">
                                        <a href="javascript:void(0);" data-dismiss="modal"><i class="icons fa fa-times"></i></a>
                                    </div>
                                    <?php echo ( $instance->iframe_render( $video_url ) ); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
            break;
        default:
        ?>
            <div class="block-video block-video-style-1 <?php echo esc_attr( $data['align'] ); ?>">
                <div>
                    <div class="btn-play">
                        <i class="icons fa fa-play"></i>
                    </div>
                    <div class="btn-close" data-src="<?php echo esc_url( $video_url ); ?>"><i class="icons fa fa-times"></i></div>
                    <?php echo wp_kses_post($title); ?>
                    <?php echo wp_kses_post($description); ?>
                    <img src="<?php echo esc_url( $image_url ); ?>" alt="" class="img-full"/>
                    <?php echo ( $instance->iframe_render( $video_url ) ); ?>
                </div>
            </div>
        <?php
    }
    ?>

</div>
<?php
    $custom_css .= sprintf( '.%1$s.slz-block-video { z-index: inherit; }', esc_attr( $uniq_id ) );
    if ( ! empty( $data['height'] ) ) {
        $custom_css .= sprintf( '.%1$s.slz-block-video .block-video::before{ padding-top:%2$s ; }',
                                esc_attr( $uniq_id ),esc_attr( $data['height'] ) );
        $custom_css .= sprintf( '.%1$s.slz-block-video .block-video.block-video-style-2 .modal-body { padding-top:%2$s ; }',
            esc_attr( $uniq_id ),esc_attr( $data['height'] ) );
        $custom_css .= sprintf( '.%1$s.slz-block-video .block-video.block-video-style-2 .modal-dialog { top:%2$s ; }',
            esc_attr( $uniq_id ), '20%' );
    }

    if( ! empty( $custom_css ) ) {
        do_action( 'slz_add_inline_style', $custom_css );
    }

endif;
