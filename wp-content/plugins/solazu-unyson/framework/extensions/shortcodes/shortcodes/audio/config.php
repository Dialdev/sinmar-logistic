<?php

if ( ! defined( 'ABSPATH' ) ) {
	die ( 'Forbidden' );
}

$cfg = array ();

$cfg ['page_builder'] = array (
		'title' => esc_html__( 'SLZ Audio', 'slz' ),
		'description' => esc_html__( 'Audio Player with Layouts', 'slz' ),
		'tab' => slz()->theme->manifest->get('name'),
		'icon' => 'icon-slzcore-audio slz-vc-slzcore',
		'tag' => 'slz_audio' 
);

$cfg['layouts'] = array(
	'layout-1'  => esc_html__( 'United States', 'slz' ),
    'layout-2'  => esc_html__( 'India', 'slz' ),
	'layout-3'  => esc_html__( 'United Kingdom', 'slz' )
);

$cfg['playlist_default'] = array(
	'audio_title' => '',
	'audio_url'   => ''
);

$cfg ['default_value'] = array (
		'layout'                => 'layout-1',
		'title'                 => '',
		'audio_url'             => '',
		'playlist'              => '',
		'extra_class'           => '',
        'allow_download'        => 'yes',
);