<?php

if (! defined ( 'SLZ' )) {
	die ( 'Forbidden' );
}

$cfg = array ();

$cfg ['page_builder'] = array (
	'title'			=> esc_html__( 'SLZ Testimonial', 'transera' ),
	'description'	=> esc_html__( 'Slider of testimonials', 'transera' ),
	'tab'			=> slz()->theme->manifest->get('name'),
	'icon'			=> 'icon-slzcore-testimonial slz-vc-slzcore',
	'tag'			=> 'slz_testimonial' 
);

$cfg ['layouts'] = array (
	'layout-2'				=> esc_html__('Layout 2', 'transera'),
);

$cfg ['image_size'] = array (
	'large'				=> '350x350',
	'no-image-large'	=> '350x350',
);

$cfg ['default_value'] = array (
	'extension'				=> 'testimonials',
	'shortcode'				=> 'testimonial',
	'layout'				=> 'layout-2',
	'image_size'			=> $cfg ['image_size'],
	'offset_post'			=> '',
	'limit_post'			=> '-1',
	'sort_by'				=> '',
	'show_position'         => 'yes',
	'show_description'      => 'yes',
	'show_image_1'          => '2',
	'show_image_2'          => '0',		
	'extra_class'			=> '',
	'method' 				=> 'cat',
	'list_category' 		=> '',
	'list_post' 			=> '',
	'sc_title'              => '',
	'sc_title_color'        => '',		
	'title_color'           => '',
	'position_color'        => '',
	'description_color'     => '',
	'icon_color'            => '',
	'dots_color'            => '',
	'arrows_color'          => '',
	'arrows_hv_color'       => '',
	'arrows_bg_hv_color'    => '',
	'arrows_bg_color'       => '',
	'slide_infinite'        => 'yes',
	'show_arrows'           => 'yes',
	'show_dots'             => 'yes',
	'slide_speed'           => '',
	'slide_autoplay'        => 'yes',
	'num_item_show'         => '5',
	'show_ratings'          => 'yes',
	'animation'				=> '0'
);