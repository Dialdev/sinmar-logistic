<?php

if ( ! defined( 'ABSPATH' ) ) {
	die ( 'Forbidden' );
}

$cfg = array ();

$cfg ['page_builder'] = array (
		'title' => esc_html__ ( 'SLZ Map', 'slz' ),
		'description' => esc_html__ ( 'Map data from google map', 'slz' ),
		'tab' => slz()->theme->manifest->get('name'),
		'icon' => 'icon-slzcore-map slz-vc-slzcore',
		'tag' => 'slz_map'
);


$cfg ['default_info'] = array (
	'title'          => '',
	'address'        => '',
	'array_info_item' => ''
);

$cfg ['default_more_info'] = array (
	'more_title'        => ''
);

$cfg ['default_value'] = array (
	'show_block_info' => '',
	'contact_form'   => '',
	'array_info'     => '',
	'map_marker'     => '',
	'zoom'           => '',
	'bg_color'       => '',
	'border_color'   => '',
	'info_color'     => '',
	'title_color'    => '',
	'extra_class'    => '',
	'map_height'     => '',
);