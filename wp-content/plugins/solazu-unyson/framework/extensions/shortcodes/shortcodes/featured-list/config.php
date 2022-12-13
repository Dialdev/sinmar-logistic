<?php
if ( ! defined( 'ABSPATH' ) ) {
	die ( 'Forbidden' );
}

$cfg = array ();

$cfg ['page_builder'] = array (
		'title' => esc_html__ ( 'SLZ Featured List', 'slz' ),
		'description' => esc_html__ ( 'List of feature with info', 'slz' ),
		'tab' => slz()->theme->manifest->get('name'),
		'icon' => 'icon-slzcore-featured-list slz-vc-slzcore',
		'tag' => 'slz_featured_list'
);

$cfg['show_options'] = array(
	esc_html__( 'Icon', 'slz' )  => 'icon',
	esc_html__( 'Image', 'slz' ) => 'image'
);

$cfg['styles'] = array(
    esc_html__( 'Florida', 'slz' )  => 'style-1',
    esc_html__( 'California', 'slz' )  => 'style-2'
);

$cfg['params_default_arr'] = array(
	'text'                     => '',
	'show_options'             => 'icon',
    'title'                    => '',
    'description'              => '',
	'image'                    => ''

);

$cfg ['default_value'] = array (
    'styles'               => 'style-1',
	'column'               => '',
    'show_number'          => 'yes',
	'feature_list'         => '',
    'feature_list2'        => '',
	'text_color'           => '',
    'des_color'            => '',
    'number_color'         => '',
	'background_color'     => '',
    'border_color'         => '',
	'background_img'       => '',
	'extra_class'          => ''
);