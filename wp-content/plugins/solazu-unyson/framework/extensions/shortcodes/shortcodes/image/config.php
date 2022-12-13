<?php

if ( ! defined( 'ABSPATH' ) ) {
	die ( 'Forbidden' );
}

$cfg = array ();

$cfg ['page_builder'] = array (
		'title' => esc_html__ ( 'SLZ Image', 'slz' ),
		'description' => esc_html__ ( 'Create an image with multiple custom.', 'slz' ),
		'tab' => slz()->theme->manifest->get('name'),
		'icon' => 'icon-slzcore-image slz-vc-slzcore',
		'tag' => 'slz_image'
);
$cfg ['default_value'] = array (

	'delay_animation' => '0.5s',
	'image_animation' => '',
	'left'            => '',
	'right'           => '',
	'top'             => '',
	'bottom'          => '',
	'image_position'  => '',
	'img'             => '',
	'extra_class'     => ''

);