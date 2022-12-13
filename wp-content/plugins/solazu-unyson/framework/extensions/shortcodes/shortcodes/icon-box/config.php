<?php

if ( ! defined( 'ABSPATH' ) ) {
	die ( 'Forbidden' );
}

$cfg = array ();

$cfg ['page_builder'] = array (
		'title' => esc_html__( 'SLZ Icon Box', 'slz' ),
		'description' => esc_html__( 'Icon Box of info', 'slz' ),
		'tab' => slz()->theme->manifest->get('name'),
		'icon' => 'icon-slzcore-icon-box slz-vc-slzcore',
		'tag' => 'slz_icon_box' 
);

$cfg ['layouts'] = array (
	'layout-1' => esc_html__( 'United States', 'slz' ),
	'layout-2' => esc_html__( 'India', 'slz' ),
);

$cfg ['default_value'] = array (
	'layout'      => 'layout-1',
	'column'      => '',
	'icon_box_2'  => '',
	'icon_box'    => '',
	'extra_class' => '',
    'title'       => '',
    'title_color' => '',
    'show_number' => '',
    'delay_animation'    => '0.5s',
	'item_animation'     => ''
);