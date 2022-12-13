<?php

if (! defined ( 'SLZ' )) {
	die ( 'Forbidden' );
}

$cfg = array ();

$cfg ['page_builder'] = array (
	'title'			=> esc_html__( 'SLZ Service List', 'transera' ),
	'description'	=> esc_html__( 'A service list.', 'transera' ),
	'tab'			=> slz()->theme->manifest->get('name'),
	'icon'			=> 'icon-slzcore-service-list slz-vc-slzcore',
	'tag'			=> 'slz_service_list' 
);

$cfg['styles'] = array(
	'style-1' => esc_html__( 'Style 1', 'transera' ),
	'style-2' => esc_html__( 'Style 2', 'transera' ),
	'style-3' => esc_html__( 'Style 3', 'transera' ),
	'style-4' => esc_html__( 'Style 4', 'transera' ),
);

$cfg ['default_value'] = array (
		'layout'                => 'layout-2',
		'style'                 => 'style-1',
		'align'                 => '',
		'show_icon'             => 'icon',
		'description'           => 'des',
		'column'                => '3',
		'is_carousel'           => 'no',
		'pagination'            => 'no',
		'btn_more'              => 'yes',
		'limit_post'            => '-1',
		'offset_post'           => '0',
		'sort_by'               => '',
		'btn_content'           => 'Read More',
		'extra_class'           => '',
		'method'                => 'cat',
		'list_category'         => '',
		'list_post'             => '',
		'icon_color'            => '',
		'title_color'           => '',
		'des_color'             => '',
		'btn_color'             => '',
		'btn_bg_color'          => '',
		'nav_color'             => ''
);