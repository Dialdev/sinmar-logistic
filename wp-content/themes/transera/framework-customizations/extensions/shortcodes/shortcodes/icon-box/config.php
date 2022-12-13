<?php

if (! defined ( 'SLZ' )) {
	die ( 'Forbidden' );
}

$cfg = array ();

$cfg ['page_builder'] = array (
		'title' => esc_html__( 'SLZ Icon Box', 'transera' ),
		'description' => esc_html__( 'Icon Box of info', 'transera' ),
		'tab' => slz()->theme->manifest->get('name'),
		'icon' => 'icon-slzcore-icon-box slz-vc-slzcore',
		'tag' => 'slz_icon_box' 
);

$cfg ['layouts'] = array (
	'layout-1' => esc_html__( 'Layout 1', 'transera' ),
);

$cfg ['default_value'] = array (
	'layout'      => 'layout-1',
	'column'      => '',
	'icon_box_2'  => '',
	'icon_box'    => '',
    'image_box'   => '',
	'extra_class' => '',
    'style_layout_1' => '1',
    'title'       => '',
    'title_color' => ''
);