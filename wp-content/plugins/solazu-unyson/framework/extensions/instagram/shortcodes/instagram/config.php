<?php

if ( ! defined( 'ABSPATH' ) ) {
	die ( 'Forbidden' );
}

$cfg = array ();

$cfg ['page_builder'] = array (
		'title' => __ ( 'SLZ Instagram', 'slz' ),
		'description' => __ ( 'Show Instagram Image', 'slz' ),
		'tab' => slz()->theme->manifest->get('name'),
		'icon' => 'icon-slzcore-instagram slz-vc-slzcore',
		'tag' => 'slz_instagram' 
);

$cfg ['default_value'] = array (
		'block_title_class' 	=> 'slz-title-shortcode',
		'block_title'           => '',
		'block_title_color'     => '',
		'extra_class'           => '',
		'instagram_id'			=> '',
		'limit_image'        	=> 12,
		'column'    			=> 4,
		'number_items'			=> 6,
		'template'				=> 'grid'
);
