<?php

if ( ! defined( 'ABSPATH' ) ) {
	die ( 'Forbidden' );
}

$cfg = array ();

$cfg ['page_builder'] = array (
		'title' => __ ( 'SLZ About Me', 'slz' ),
		'description' => __ ( 'Show about me block', 'slz' ),
		'tab' => slz()->theme->manifest->get('name'),
		'icon' => 'icon-slzcore-about-me slz-vc-slzcore',
		'tag' => 'slz_about_me' 
);

$cfg['layouts'] = array(
	'layout-1'  => esc_html__('United States','slz'),
	'layout-2'  => esc_html__('India','slz'),
);

$cfg ['default_value'] = array (
		'layout'           => 'layout-1',
		'block_title'	=>	'',
		'block_title_color' => '',
		'name'			=>	'',
		'avatar'		=>	'',
		'detail'		=>	'',
		'social'		=>	'',
		'extra_class'	=>	'',
		'block_title_class' => 'slz-title-shortcode',
		// update icon
);
