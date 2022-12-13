<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Forbidden' ); }

// Check Visual Composer is active or not
if ( ! is_plugin_active( 'js_composer/js_composer.php' ) ) { return; }

// Get instance of shortcode video carousel
$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'video_carousel' );

// Get list videos from vc param group
$data['list_video'] = (array) vc_param_group_parse_atts( $data['list_video'] );

// Get list video type
$temp_arr = $shortcode->get_config( 'params_group_list' );

// Set default value
$url_video = $image_video = '';

// Make unique_id
$unique_id = SLZ_Com::make_id();

// CSS class
$block_class = 'video-carousel-'.$unique_id;
$block_cls = $block_class.' '.$data['extra_class'];

// Set Item formats
$html_options = array(
	'title_format' => '<div class="slz-title-shortcode">%s</div>',
);

// Get Style
$style = !empty( $data['style'] ) ? $data['style'] : 'style-1';

// Get Title
$block_title = !empty( $data['block_title'] ) ? esc_html( $data['block_title'] ) : '';
?>
<div class="slz-shortcode sc_video_carousel <?php echo esc_attr( $block_cls ) ?>">
    <?php
    // Print block title
    printf( $html_options['title_format'], $block_title );
    // Check has video or empty
    if( !empty( $data['list_video'] ) ) {
        // Switch style to show
	    switch ( $style ) {
		    case 'style-1':
			    ?>
                <div id="videoModal-<?php echo esc_attr( $unique_id ) ?>" tabindex="-1" role="dialog" aria-labelledby="videoModal-<?php echo esc_attr( $unique_id ) ?>" aria-hidden="true" class="slz-video-modal modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body">
                                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                                <div>
                                    <iframe width="700" height="400"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="slz-carousel-wrapper slz-video-carousel horizontal-style">
                    <div class="carousel-overflow">
                        <div data-slidestoshow="1" class="slz-carousel sc-video-carousel-item">
                        <?php foreach ( $data['list_video'] as $video ) {
                            $url_video = $image_video = '';
                            $video = array_merge( $temp_arr, $video );
                            if( ( $video['video_type'] == 'youtube' && empty( $video['youtube_id'] ) ) || ( $video['video_type'] == 'vimeo' && empty( $video['vimeo_id'] ) ) ) {
								    continue;
							    }
                            if( $video['video_type'] == 'youtube' && !empty( $video['youtube_id'] ) ) {
								    $url_video = 'https://www.youtube.com/embed/'.esc_attr( $video['youtube_id'] ).'?rel=0&autoplay=1';
								    $image_video = $instance->get_video_thumb_general( 'youtube', $video['youtube_id'] );
							    }elseif ( $video['video_type'] == 'vimeo' && !empty( $video['vimeo_id'] ) ) {
								    $url_video = 'https://player.vimeo.com/video/'.esc_attr( $video['vimeo_id'] ).'?rel=0&autoplay=1';
								    $image_video = $instance->get_video_thumb_general( 'vimeo', $video['vimeo_id'] );
							    }
                        ?>
                        <div class="item">
                            <div class="slz-block-video style-4">
                                <div class="block-video">
                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#videoModal-<?php echo esc_attr( $unique_id ); ?>" data-thevideo="<?php echo esc_url( $url_video ); ?>" class="link">
                                        <div class="btn-play">
                                            <i class="icons fa fa-play"></i>
                                        </div>
                                    </a>
                                    <img src="<?php echo esc_url( $image_video ) ?>" alt="" class="img-full">
                                </div>
                            </div>
                        </div>
                        <?php
                        }
                        ?>
                        </div>
                    </div>
                </div>
			    <?php
			    break;
		    case 'style-2':
			    ?>
                <div id="videoModal-<?php echo esc_attr( $unique_id ) ?>" tabindex="-1" role="dialog" aria-labelledby="videoModal-<?php echo esc_attr( $unique_id ) ?>" aria-hidden="true" class="slz-video-modal modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body">
                                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                                <div>
                                    <iframe width="700" height="400"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="slz-carousel-wrapper slz-video-carousel vertical-style">
                    <div class="carousel-overflow">
                        <div data-slidestoshow="1" class="slz-carousel-vertical sc-video-carousel-item">
						    <?php foreach ( $data['list_video'] as $video ) {
							    $url_video = $image_video = '';
							    $video = array_merge( $temp_arr, $video );
							    if( ( $video['video_type'] == 'youtube' && empty( $video['youtube_id'] ) ) || ( $video['video_type'] == 'vimeo' && empty( $video['vimeo_id'] ) ) ) {
								    continue;
							    }
							    if( $video['video_type'] == 'youtube' && !empty( $video['youtube_id'] ) ) {
								    $url_video = 'https://www.youtube.com/embed/'.esc_attr( $video['youtube_id'] ).'?rel=0&autoplay=1';
								    $image_video = $instance->get_video_thumb_general( 'youtube', $video['youtube_id'] );
							    }elseif ( $video['video_type'] == 'vimeo' && !empty( $video['vimeo_id'] ) ) {
								    $url_video = 'https://player.vimeo.com/video/'.esc_attr( $video['vimeo_id'] ).'?rel=0&autoplay=1';
								    $image_video = $instance->get_video_thumb_general( 'vimeo', $video['vimeo_id'] );
							    }
							    ?>
                                <div class="item">
                                    <div class="slz-block-video style-4">
                                        <div class="block-video">
                                            <a href="javascript:void(0)" data-toggle="modal" data-target="#videoModal-<?php echo esc_attr( $unique_id ); ?>" data-thevideo="<?php echo esc_url( $url_video ); ?>" class="link">
                                                <div class="btn-play">
                                                    <i class="icons fa fa-play"></i>
                                                </div>
                                            </a>
                                            <img src="<?php echo esc_url( $image_video ) ?>" alt="" class="img-full">
                                        </div>
                                    </div>
                                </div>
							    <?php
						    }
						    ?>
                        </div>
                    </div>
                </div>
			    <?php
			    break;
            case 'style-3':
                $out_for = $out_nav = '';
	            foreach ( $data['list_video'] as $video ) {
		            $url_video = $image_video = $video_title = '';
		            $video = array_merge( $temp_arr, $video );
		            // If no id entered -> continue
		            if( ( $video['video_type'] == 'youtube' && empty( $video['youtube_id'] ) ) || ( $video['video_type'] == 'vimeo' && empty( $video['vimeo_id'] ) ) ) {
			            continue;
		            }
		            if( $video['video_type'] == 'youtube' && !empty( $video['youtube_id'] ) ) {
			            $video_info = SLZ_Util::get_video_info_meta( 'youtube', $video['youtube_id'] );
		            }elseif ( $video['video_type'] == 'vimeo' && !empty( $video['vimeo_id'] ) ) {
                        $video_info = SLZ_Util::get_video_info_meta( 'vimeo', $video['vimeo_id'] );
		            }

                    $url_video   = ! empty( $video_info['video_url'] ) ? $video_info['video_url'] : '';
                    $image_video = ! empty( $video_info['thumb_url'] ) ? $video_info['thumb_url'] : '';
                    $video_title = ! empty( $video_info['title'] )     ? $video_info['title']     : '';

		            $out_for .= '<div class="item">
                                    <div class="slz-block-video style-4">
                                        <div class="block-video">
                                            <a href="javascript:void(0)" data-toggle="modal" data-target="#videoModal-'. esc_attr( $unique_id ) .'" data-thevideo="'. esc_url( $url_video ) .'" class="link">
                                                <div class="btn-play">
                                                    <i class="icons fa fa-play"></i>
                                                </div>
                                            </a>
                                            <img src="'. esc_url( $image_video ) .'" alt="" class="img-full">
                                            <span class="title">'. esc_html( $video_title ) .'</span>
                                        </div>
                                    </div>
                                </div>';

		            $out_nav .= '<div class="item">
                                    <div class="image-gallery-wrapper">
                                        <img src="'. esc_url( $image_video ) .'" alt="" class="img-full">
                                        <span class="title">'. esc_html( $video_title ) .'</span>
                                    </div>
                                </div>';
	            }
                ?>
                <div id="videoModal-<?php echo esc_attr( $unique_id ) ?>" tabindex="-1" role="dialog" aria-labelledby="videoModal-<?php echo esc_attr( $unique_id ) ?>" aria-hidden="true" class="slz-video-modal modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body">
                                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                                <div>
                                    <iframe width="700" height="400"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="slz-carousel-wrapper slz-video-carousel style-3">
                    <div class="sc-video-carousel-item slz-carousel-syncing">
                        <div class="slider-for">
			                <?php echo ( $out_for ); ?>
                        </div>
                        <div class="slider-nav" data-slidetoshow="<?php echo esc_attr( $data['slide_to_show'] ); ?>">
			                <?php echo ( $out_nav ); ?>
                        </div>
                    </div>
                </div>
                <?php
                break;
	    }
    }
    ?>
</div>
<?php
    // Set custom CSS
    $custom_css = sprintf( '.%1$s.sc_video_carousel { z-index: inherit; }', $block_class );
    if( !empty( $custom_css ) ) {
	    do_action( 'slz_add_inline_style', $custom_css );
    }
?>
