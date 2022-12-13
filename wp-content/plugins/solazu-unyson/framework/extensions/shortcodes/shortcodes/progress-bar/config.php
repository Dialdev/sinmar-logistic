<?php

if ( ! defined( 'ABSPATH' ) ) {
	die ( 'Forbidden' );
}

$cfg = array ();

$cfg ['page_builder'] = array (
		'title' => esc_html__( 'SLZ Progress Bar', 'slz' ),
		'description' => esc_html__( 'Bar of progress percent', 'slz' ),
		'tab' => slz()->theme->manifest->get('name'),
		'icon' => 'icon-slzcore-progress-bar slz-vc-slzcore',
		'tag' => 'slz_progress_bar' 
);

$cfg['layouts'] = array(
	'layout-1'  => esc_html__( 'United States', 'slz' ),
	'layout-2'  => esc_html__( 'India', 'slz' )
);

$cfg ['default_value'] = array (
		'layout'                => 'layout-1',
		'style'                 => 'style-1',
		'progress_bar_list_1'   => '5',
		'progress_bar_list_2'   => '',
		'column'                => '1',
		'progress_bar_list_3'   => '',
		'unit'                  => '%',
		'extra_class'           => '',
);