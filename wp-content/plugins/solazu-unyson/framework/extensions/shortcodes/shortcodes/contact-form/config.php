<?php

if ( ! defined( 'ABSPATH' ) ) {
	die ( 'Forbidden' );
}

$cfg = array ();

$cfg ['page_builder'] = array (
		'title' => esc_html__ ( 'SLZ Contact Form 7', 'slz' ),
		'description' => esc_html__ ( 'Create an block contain contact form 7', 'slz' ),
		'tab' => slz()->theme->manifest->get('name'),
		'icon' => 'icon-slzcore-contact-form slz-vc-slzcore',
		'tag' => 'slz_contact_form'
);

$cfg ['default_value'] = array (
	'ctf'          => '',
	'extra_class'  =>'',
	'bg_image'     => '',
	'box_shadow'   =>'',
	'padding_top'     =>'',
	'padding_bottom'  =>'',
	'padding_left'    =>'',
	'padding_right'   =>'',
	'bg_color'        => '',
	'btn_bg_color'        => '',
	'btn_bg_color_hover'  => '',
	'btn_color'           => '',
	'btn_color_hover'     => '',
);