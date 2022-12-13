<?php
if ( ! defined( 'ABSPATH' ) ) {
	die ( 'Forbidden' );
}

$cfg = array ();

$cfg ['page_builder'] = array (
		'title' => esc_html__ ( 'SLZ Info Box', 'slz' ),
		'description' => esc_html__ ( 'Information Box', 'slz' ),
		'tab' => slz()->theme->manifest->get('name'),
		'icon' => 'icon-slzcore-info-box slz-vc-slzcore',
		'tag' => 'slz_info_box'
);

$cfg['show_options'] = array(
	esc_html__( 'Icon', 'slz' )  => 'icon',
	esc_html__( 'Image', 'slz' ) => 'image'
);

$cfg ['default_value'] = array (
    'icon_type'            => '1',
    'icon_library'         => '',
	'icon_vs'                => '',
	'icon_openiconic'      => '',
	'icon_typicons'        => '',
	'icon_linecons'        => '',
	'icon_monosocial'      => '',
	'icon_entypo'          => '',
    'img_up'               => '',
    'des_color'            => '',
	'background_color'     => '',
    'border_color'         => '',
    'icon_color'           => '',
	'extra_class'          => '',
);