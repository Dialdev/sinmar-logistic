<?php

if ( ! defined( 'ABSPATH' ) ) {
	die ( 'Forbidden' );
}

$cfg = array ();

$cfg ['page_builder'] = array (
	'title'			=> esc_html__( 'SLZ Recruitment Tab', 'slz' ),
	'description'	=> esc_html__( 'A list recruitment by tab.', 'slz' ),
	'tab'			=> slz()->theme->manifest->get('name'),
	'icon'			=> 'icon-slzcore-recruitment-tab slz-vc-slzcore',
	'tag'			=> 'slz_recruitment_tab' 
);

$cfg ['image_size'] = array (
	'large'				=> '550x350',
);

$cfg ['default_value'] = array (
	'title'                 => '',
	'description'           => 'excerpt',
	'limit_post'            => '-1',
	'offset_post'           => '0',
	'sort_by'               => '',
	'method'                => 'cat',
	'list_category'         => '',
	'button_text'           => '',
	'button_link'           => '',
	'extra_class'           => '',
	'active_color'          => '',
	'ribbon_color'          => '',
	'button_hv_color'       => '',
	'button_color'          => '',
);