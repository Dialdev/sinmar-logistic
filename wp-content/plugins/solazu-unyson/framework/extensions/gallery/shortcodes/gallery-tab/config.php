<?php

if ( ! defined( 'ABSPATH' ) ) {
	die ( 'Forbidden' );
}

$cfg = array ();

$cfg ['page_builder'] = array (
	'title'         => esc_html__( 'SLZ Gallery Tab', 'slz' ),
	'description'   => esc_html__( 'Display image gallery in tab panel.', 'slz' ),
	'tab'           => slz()->theme->manifest->get('name'),
	'icon'          => 'icon-slzcore-gallery-tab slz-vc-slzcore',
	'tag'           => 'slz_gallery_tab' 
);

$cfg['layouts'] = array(
	'layout-1'   => esc_html__( 'United States', 'slz' ),
	'layout-2'   => esc_html__( 'India', 'slz' )
);

$cfg ['image_size'] = array (
	'large'             => '800x600',
	'small'             => '800x600',
	'no-image-large'    => '800x600',
	'no-image-small'    => '800x600',
);

$cfg ['default_value'] = array (
	'extension'	                 => 'gallery',
	'shortcode'	                 => 'gallery',
	'post_type'                  => 'slz-gallery',
	'style'                      => 'style-1',
	'layout'                     => 'layout-1',
	'image_size'                 => $cfg ['image_size'],
	'offset_post'                => '',
	'limit_post'                 => '-1',
	'sort_by'                    => '',
	'extra_class'                => '',
	'method_portfolio'           => 'cat',
	'list_category_portfolio'    => '',
	'list_post_portfolio'        => '',
	'method_gallery'             => 'cat',
	'filter_title_portfolio'     => 'post',
	'filter_title_gallery'       => 'post',
	'list_category_gallery'      => '',
	'list_post_gallery'          => '',
	'slide_autoplay'             => 'yes',
	'slide_dots'                 => 'yes',
	'slide_arrows'               => 'yes',
	'slide_infinite'             => 'yes',
	'slide_speed'                => '',
	'animation'                  => '0',
	'arrows_color'               => '',
	'arrows_hv_color'            => '',
	'dots_color'                 => '',
	'number_slide'               => '5',
	'load_more_btn_text'         => ''
);