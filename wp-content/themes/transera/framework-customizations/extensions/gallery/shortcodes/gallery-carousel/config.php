<?php

if (! defined ( 'SLZ' )) {
	die ( 'Forbidden' );
}

$cfg = array ();

$cfg ['page_builder'] = array (
	'title'         => esc_html__( 'SLZ Gallery Carousel', 'transera' ),
	'description'   => esc_html__( 'Animated Carousel with gallery or portfolio.', 'transera' ),
	'tab'           => slz()->theme->manifest->get('name'),
	'icon'          => 'icon-slzcore-gallery-carousel slz-vc-slzcore',
	'tag'           => 'slz_gallery_carousel' 
);

$cfg['layouts'] = array(
	'layout-1'   => esc_html__( 'Layout 1', 'transera' ),
	'layout-2'   => esc_html__( 'Layout 2', 'transera' ),
	'layout-3'   => esc_html__( 'Layout 3', 'transera' ),
	'layout-4'   => esc_html__( 'Layout 4', 'transera' ),
	'layout-5'   => esc_html__( 'Layout 5', 'transera' )
);

$cfg ['image_size'] = array (
	'default' => array(
		'large'             => '800x600',
		'small'             => '800x300',
	),
	'layout-1' => array(
		'large'             => '550x350',
	),
	'layout-2' => array(
		'large'             => '450x800',
	),
	'layout-3' => array(
		'large'             => '1200x650',
	),
	'layout-4' => array(
		'large'             => '1200x650',
	),
);
$cfg ['default_value'] = array (
	'post_type'                  => 'slz-gallery',
	'layout'                     => 'layout-1',
	'image-upload'               => '',
	'style'                      => 'style-1',
	'layout_02_style'            => 'style-1',
	'image_size'                 => $cfg ['image_size'],
	'limit_post'                 => '-1',
	'portfolio_limit_post'       => '-1',
	'limit_image'                => '',
	'extra_class'                => '',
	'portfolio'                  => '',
	'filter_title_portfolio'     => 'post',
	'filter_title_gallery'       => 'post',
	'gallery'                    => '',
	'column'                     => '',
	'slide_autoplay'             => 'yes',
	'slide_dots'                 => 'yes',
	'slide_arrows'               => 'yes',
	'slide_infinite'             => 'yes',
// 	'slide_speed'                => '600',
	'slidetoshow'                => '5',
	'color_slide_arrow'          => '',
	'color_slide_arrow_hv'       => '',
	'color_slide_arrow_bg'       => '',
	'color_slide_arrow_bg_hv'    => '',
	'color_slide_dots'           => '',
	'color_slide_dots_at'        => '',

);