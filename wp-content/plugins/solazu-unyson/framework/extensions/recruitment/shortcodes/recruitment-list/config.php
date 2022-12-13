<?php

if ( ! defined( 'ABSPATH' ) ) {
	die ( 'Forbidden' );
}

$cfg = array ();

$cfg ['page_builder'] = array (
	'title'			=> esc_html__( 'SLZ Recruitment List', 'slz' ),
	'description'	=> esc_html__( 'A recruitment list.', 'slz' ),
	'tab'			=> slz()->theme->manifest->get('name'),
	'icon'			=> 'icon-slzcore-recruitment-list slz-vc-slzcore',
	'tag'			=> 'slz_recruitment_list' 
);

$cfg ['default_value'] = array (
		'title'                 => '',
		'description'           => 'excerpt',
		'limit_post'            => '-1',
		'offset_post'           => '0',
		'sort_by'               => '',
		'button_text'           => '',
		'button_link'           => '',
		'extra_class'           => '',
		'method'                => 'cat',
		'list_category'         => '',
		'list_post'             => '',
		'title_color'           => '',
		'active_color'          => ''
);