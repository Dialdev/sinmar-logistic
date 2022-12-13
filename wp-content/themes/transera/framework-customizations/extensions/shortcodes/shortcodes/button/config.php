<?php

if (! defined ( 'SLZ' )) {
	die ( 'Forbidden' );
}

$cfg = array ();

$cfg ['page_builder'] = array (
		'title' => esc_html__ ( 'SLZ Button', 'transera' ),
		'description' => esc_html__ ( 'Button', 'transera' ),
		'tab' => slz()->theme->manifest->get('name'),
		'icon' => 'icon-slzcore-button slz-vc-slzcore',
		'tag' => 'slz_button'
);

$cfg ['styles'] = array (
		'style-1' => esc_html__ ( 'Style 1', 'transera' ),
		'style-2' => esc_html__ ( 'Style 2', 'transera' ),
);

$cfg ['layouts'] = array (
		'layout-1' => esc_html__ ( 'Style 1 (Normal Icon)', 'transera' ),
);

$cfg ['default_value'] = array (
		'btn'    =>'',
		'alignment'     => 'text-c'		
);
$cfg ['param_group_default'] = array(

	'layout'          => 'layout-1',
	'title'           => '',
	//button
	'button_link'            => '',
	'bg_color'               => '',
	'alignment'     => 'text-l',
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
	'icon_extra_class'  => '',
	// update icon
	'icon_library'     => 'vs',
	'icon_vs'          => '',
	'icon_openiconic'  => '',
	'icon_typicons'    => '',
	'icon_linecons'    => '',
	'icon_monosocial'  => '',
	'icon_entypo'      => '',
);