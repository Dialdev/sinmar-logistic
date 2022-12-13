<?php

if ( ! defined( 'ABSPATH' ) ) {
	die ( 'Forbidden' );
}

$cfg = array ();

$cfg ['page_builder'] = array (
		'title' => esc_html__ ( 'SLZ Button', 'slz' ),
		'description' => esc_html__ ( 'Button', 'slz' ),
		'tab' => slz()->theme->manifest->get('name'),
		'icon' => 'icon-slzcore-button slz-vc-slzcore',
		'tag' => 'slz_button'
);

$cfg ['layouts'] = array (
		'layout-1' => esc_html__ ( 'United States', 'slz' ),
		'layout-2' => esc_html__ ( 'India', 'slz' ),
		'layout-3' => esc_html__ ( 'United Kingdom', 'slz' )
);

$cfg ['default_value'] = array (
	'btn'    =>'',
	'alignment'     => 'text-l'

);
$cfg ['param_group_default'] = array(

	'layout'          => '',
	'title'           => '',
	//button
	'button_link'            => '',
	'bg_color'               => '',
	'bg_color_hover'         => '',
    'border_radius'          => '',
    'box_shadow'             => '',
    'btn_color'              => '',
	'btn_color_hover'        => '',
	'btn_border_color'       => '',
	'btn_border_color_hover' => '',
	'btn-image'              => '',
	'margin_right'           => '',
	//icon
    'icon_position'     => '',
    'icon_box_shadow'   =>'',
	'icon_hv_color'     => '',
	'icon_color'        => '',
	'icon_bg_hv_color'  => '',
	'icon_bg_color'     => '',
	'extra_class'       => '',
	'icon_extra_class'  => ''
);