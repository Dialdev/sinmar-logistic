<?php

if ( ! defined( 'ABSPATH' ) ) {
	die ( 'Forbidden' );
}

$cfg = array ();

$cfg ['page_builder'] = array (
	'title'			=> esc_html__( 'SLZ Service Tab', 'slz' ),
	'description'	=> esc_html__( 'A service tab.', 'slz' ),
	'tab'			=> slz()->theme->manifest->get('name'),
	'icon'			=> 'icon-slzcore-service-tab slz-vc-slzcore',
	'tag'			=> 'slz_service_tab' 
);

$cfg ['default_value'] = array (
		'show_icon'             => 'icon',
		'description'           => 'excerpt',
		'limit_post'            => '-1',
		'offset_post'           => '0',
		'sort_by'               => '',
		'extra_class'           => '',
		'method'                => 'cat',
		'list_category'         => '',
		'list_post'             => '',
		'icon_color'            => '',
		'title_color'           => '',
		'title_active_color'    => ''
);