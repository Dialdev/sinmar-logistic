<?php

if ( ! defined( 'ABSPATH' ) ) {
	die ( 'Forbidden' );
}

$cfg = array ();

$cfg ['page_builder'] = array (
		'title' => esc_html__ ( 'SLZ Tags', 'slz' ),
		'description' => esc_html__ ( 'List of tags', 'slz' ),
		'tab' => slz()->theme->manifest->get('name'),
		'icon' => 'icon-slzcore-tags slz-vc-slzcore',
		'tag' => 'slz_tags'
);

$cfg ['default_value'] = array (
	'block_title'            => '',
	'block_title_color'      => 'left',
	'number'                 => '5',
	'extra_class'            => '',
	'tag_text_color'         => '',
	'tag_text_hover_color'   => '',
	'tag_bg_color'           => '',
	'tag_bg_hover_color'     => '',
);