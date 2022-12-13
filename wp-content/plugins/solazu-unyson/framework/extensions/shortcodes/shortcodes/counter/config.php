<?php

if ( ! defined( 'ABSPATH' ) ) {
	die ( 'Forbidden' );
}

$cfg = array ();

$cfg ['page_builder'] = array (
		'title' => esc_html__ ( 'SLZ Old Counter', 'slz' ),
		'description' => esc_html__ ( 'Create counter block.', 'slz' ),
		'tab' => slz()->theme->manifest->get('name') . ' - ' . esc_html__( 'Deprecated', 'slz' ),
		'icon' => 'icon-slzcore-counter slz-vc-slzcore',
		'tag' => 'slz_counter',
);

$cfg ['layouts'] = array (
		'layout-1' => esc_html__ ( 'United States', 'slz' ),
		'layout-2' => esc_html__ ( 'India', 'slz' )
);

$cfg ['default_value'] = array (
		'layout'        => 'layout-1',
		'title' 	    => '',
		'icon_type'     => '',
		'icon_flaticon' => '',
		'img_up'        => '',
		'title_color'   => '',
		'number'        => '',
		'number_color'  => '',
		'icon_color'    => '',
		'extra_class'   => '',
		'animation'     => '',
		'alignment'     => 'counter-center',
		'show_line'     => '',
		'suffix'        => '',
		// update icon
		'icon_library'     => 'vs',
		'icon_vs'          => '',
		'icon_openiconic'  => '',
		'icon_typicons'    => '',
		'icon_linecons'    => '',
		'icon_monosocial'  => '',
		'icon_entypo'      => '',
);