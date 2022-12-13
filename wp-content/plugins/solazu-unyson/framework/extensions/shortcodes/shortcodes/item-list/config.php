<?php

if ( ! defined( 'ABSPATH' ) ) {
	die ( 'Forbidden' );
}

$cfg = array ();

$cfg ['page_builder'] = array (
		'title' => esc_html__ ( 'SLZ Item List', 'slz' ),
		'description' => esc_html__ ( 'list of text info', 'slz' ),
		'tab' => slz()->theme->manifest->get('name'),
		'icon' => 'icon-slzcore-item-list slz-vc-slzcore',
		'tag' => 'slz_item_list',
);

$cfg ['default_value'] = array (
	'item_list'      => '',
	'icon_color'     =>'',
	'margin_top'     => '0',
	'margin_bottom'  => '0',
	'extra_class'    => '',
);