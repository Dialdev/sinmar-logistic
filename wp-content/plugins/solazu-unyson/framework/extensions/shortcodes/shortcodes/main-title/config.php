<?php

if ( ! defined( 'ABSPATH' ) ) {
	die ( 'Forbidden' );
}

$cfg = array ();

$cfg ['page_builder'] = array (
		'title' => esc_html__ ( 'SLZ Main Title', 'slz' ),
		'description' => esc_html__ ( 'Main Title', 'slz' ),
		'tab' => slz()->theme->manifest->get('name'),
		'icon' => 'icon-slzcore-main-title slz-vc-slzcore',
		'tag' => 'slz_main_title'
);
$cfg ['styles'] = array (
	''        => esc_html__( 'Florida', 'slz' ),
	'style-1' => esc_html__( 'California', 'slz' ),
	'style-2' => esc_html__( 'Georgia', 'slz' ),
	'style-3' => esc_html__( 'New York', 'slz' )
);
$cfg ['default_value'] = array (
	'style'                  => '',
	'align'                  => 'left',
	'subtitle'               => '',
	'title'                  => '',
	'show_icon'	             => '2',
	'image'                  => '',
	'icon_library'           => 'vs',
    'icon_vs'                => '',
    'icon_openiconic'        => '',
    'icon_typicons'          => '',
    'icon_entypo'            => '',
    'icon_linecons'          => '',
    'icon_monosocial'        => '',
	'extra_title'            => '',
	'subtitle_color'         => '',
	'title_color'            => '',
	'extra_title_color'      => '',
	'extra_class'            => '',
	'css'                    => '',
	//options override from theme
	'subtitle_line_color'    => '',
	'extra_title_line_color' => '',
	'line_color'             => ''
);