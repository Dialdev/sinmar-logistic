<?php
if ( ! defined( 'ABSPATH' ) ) {
	die ( 'Forbidden' );
}

$cfg = array ();

$cfg ['page_builder'] = array (
	'title'			=> esc_html__( 'SLZ Partner', 'slz' ),
	'description'	=> esc_html__( 'List of partner', 'slz' ),
	'tab'			=> slz()->theme->manifest->get('name'),
	'icon'			=> 'icon-slzcore-partner slz-vc-slzcore',
	'tag'			=> 'slz_partner' 
);

$cfg ['image_size'] = array (
);

$cfg['layouts'] = array(
	'layout-1'  => esc_html__( 'United States', 'slz' ),
	'layout-2'  => esc_html__( 'India', 'slz' )
);

$cfg ['styles'] = array (
	'style-grid-1' 			=> esc_html__( 'Style Grid', 'slz' ),
	'style-carousel-1' 		=> esc_html__( 'Style Carousel', 'slz' ),
);

$cfg ['default_value'] = array (
	'extension'				=> 'shortcodes',
	'shortcode'				=> 'partner',
	'template'				=> 'partner',
	'image_size'			=> $cfg ['image_size'],

	'layout'				=> 'layout-1',
	'style'					=> 'grid',
	'column'				=> '6',
	'item_padding'			=> 'yes',
	'gr_list_item'			=> '',
	'extra_class'			=> '',

	'slide_autoplay'		=> 'no',
	'slide_dots'			=> 'yes',
	'slide_arrows'			=> 'yes',
	'slide_infinite'		=> 'yes',
	'slide_speed'			=> '600',

	'color_slide_arrow'		=> '',
	'color_slide_arrow_hv'	=> '',
	'color_slide_arrow_bg'	=> '',
	'color_slide_arrow_bg_hv'=> '',
	'color_slide_dots'		=> '',
	'color_slide_dots_at'	=> '',
);