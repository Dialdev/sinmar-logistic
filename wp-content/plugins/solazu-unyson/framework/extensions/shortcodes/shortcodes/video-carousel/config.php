<?php

if ( ! defined( 'ABSPATH' ) ) {
	die ( 'Forbidden' );
}

$cfg = array ();

$cfg ['page_builder'] = array (
		'title' => esc_html__ ( 'SLZ Video Carousel', 'slz' ),
		'description' => esc_html__ ( 'Show list of video as carousel', 'slz' ),
		'tab' => slz()->theme->manifest->get('name'),
		'icon' => 'icon-slzcore-video-carousel slz-vc-slzcore',
		'tag' => 'slz_video_carousel'
);

$cfg['unique_id'] = SLZ_Com::make_id();

$cfg ['styles'] = array (
	'style-1' => esc_html__( 'Florida', 'slz' ),
	'style-2' => esc_html__( 'California', 'slz' ),
	'style-3' => esc_html__( 'Georgia', 'slz' )
);

$cfg['video_type'] = array(
	esc_html__( 'Youtube', 'slz' )  => 'youtube',
	esc_html__( 'Vimeo', 'slz' )    => 'vimeo',
);

$cfg ['default_value'] = array (
	'style'                  => 'style-1',
	'block_title'            => '',
	'list_video'             => '',
    'slide_to_show'          => '3',
	'extra_class'            => '',
);

$cfg['params_group_list'] = array(
	'video_type'         => 'youtube',
	'youtube_id'         => '',
	'vimeo_id'           => '',
);