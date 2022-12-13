<?php

if ( ! defined( 'ABSPATH' ) ) {
	die ( 'Forbidden' );
}

$cfg = array ();

$cfg ['page_builder'] = array (
		'title' => esc_html__ ( 'SLZ Counter', 'slz' ),
		'description' => esc_html__ ( 'Create counter block.', 'slz' ),
		'tab' => slz()->theme->manifest->get('name'),
		'icon' => 'icon-slzcore-counter slz-vc-slzcore',
		'tag' => 'slz_counterv2'
);

$cfg ['layouts'] = array (
		'layout-1' => esc_html__ ( 'United States', 'slz' ),
		'layout-2' => esc_html__ ( 'India', 'slz' )
);
$cfg ['default_value'] = array (
	'layout'        => 'layout-1',
	'column' 	    => '',
	'counter_items' => '',
	'title_color'   => '',
	'number_color'  => '',
	'icon_color'    => '',
    'icon_bg_color' => '',
	'line_color'    => '',
	'extra_class'   => '',
	'animation'     => '',
	'alignment'     => 'counter-center',
	'show_line'     => ''
);
$cfg ['counter_group'] = array (
	'title'            => '',
	'number'           => '',
	'suffix'           => '',
	'icon_type'        => '',
	'img_up'           => ''
);