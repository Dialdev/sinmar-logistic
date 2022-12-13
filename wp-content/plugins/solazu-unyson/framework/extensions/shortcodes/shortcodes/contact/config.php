<?php

if ( ! defined( 'ABSPATH' ) ) {
	die ( 'Forbidden' );
}

$cfg = array ();

$cfg ['page_builder'] = array (
		'title'         => esc_html__ ( 'SLZ Contact', 'slz' ),
		'description'   => esc_html__ ( 'Contact information', 'slz' ),
		'tab'           => slz()->theme->manifest->get('name'),
		'icon'          => 'icon-slzcore-contact slz-vc-slzcore',
		'tag'           => 'slz_contact'
);

$cfg ['default_info'] = array (
    'column'                => '3',
	'array_info_item'       => '',
    'array_sub_info_item'   => '',
    'description'           => ''
);

$cfg ['default_main_info'] = array (
	'title'  => ''
);

$cfg ['default_sub_info'] = array(
    'sub_info'         => ''
);

$cfg ['default_value'] = array (
	'array_info'        => '',
    'array_more_info'   => '',
    'column'            => '3',
	'bg_color'          => '',
	'border_color'      => '',
	'info_color'        => '',
	'title_color'       => '',
    'main_bg_color'     => '',
    'main_icon_color'   => '',
    'sub_icon_color'    => '',
    'extra_class'       => '',
    'des_color'         => ''
);