<?php

if ( ! defined( 'ABSPATH' ) ) {
	die ( 'Forbidden' );
}

$cfg = array ();

$cfg ['page_builder'] = array (
		'title' => esc_html__ ( 'SLZ Video', 'slz' ),
		'description' => esc_html__ ( 'Create video block.', 'slz' ),
		'tab' => slz()->theme->manifest->get('name'),
		'icon' => 'icon-slzcore-video slz-vc-slzcore',
		'tag' => 'slz_video'
);

$cfg ['styles'] = array (
    'style-1' => esc_html__( 'Florida', 'slz' ),
    'style-2' => esc_html__( 'California', 'slz' )
);

$cfg ['default_value'] = array (
    'style'        => 'style-1',
    'image_video'   => '',
    'height' 	    => '',
    'video_type'    => 'youtube',
    'id_youtube'    => '',
    'id_vimeo'      => '',
    'title'         => '',
    'extra_class'   => '',
    'align'         => 'text-l',
);