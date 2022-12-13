<?php

if ( ! defined( 'ABSPATH' ) ) {
	die ( 'Forbidden' );
}

$cfg = array ();

$cfg ['page_builder'] = array (
	'title'         => esc_html__( 'SLZ Causes Carousel', 'slz' ),
	'description'   => esc_html__( 'Show post type Causes with layouts', 'slz' ),
	'tab'           => slz()->theme->manifest->get('name'),
	'icon'          => 'icon-slzcore-causes-carousel slz-vc-slzcore',
	'tag'           => 'slz_causes_carousel' 
);

$cfg ['image_size'] = array(
	'large'          => '800x400',
	'no-image-large' => '800x400',
);

$cfg['layouts'] = array(
	'layout-1'   => esc_html__( 'United States', 'slz' ),
//	'layout-2'   => esc_html__( 'India', 'slz' ),
);

$cfg['yes_no'] = array(
	esc_html__('Yes', 'slz')   => 'yes',
	esc_html__('No', 'slz')    => 'no'
);

$cfg['method'] = array(
	esc_html__( 'Category', 'slz' )  => 'cat',
	esc_html__( 'Causes', 'slz' )    => 'causes'
);


$cfg['social'] = array(
	esc_html__('-Choose Social-', 'slz')  => '',
	esc_html__('Facebook', 'slz')         => 'facebook',
	esc_html__('Twitter', 'slz')          => 'twitter',
	esc_html__('Google Plus', 'slz')      => 'google-plus',
	esc_html__('Pinterest', 'slz')        => 'pinterest',
	esc_html__('Linkedint', 'slz')        => 'linkedin',
	esc_html__('Digg', 'slz')             => 'digg'
);

$cfg ['default_value'] = array (
	'extension'				=> 'donation',
	'shortcode'				=> 'causes_carousel',
	'image_size'			=> $cfg ['image_size'],

	'layout'				=> 'layout-1',
	'exclude_id'			=> '',
	'offset_post'			=> '',
	'limit_post'			=> '-1',
	'sort_by'				=> '',
	'btn_content'           => '',
	'show_progress_bar'     => 'yes',

	'pagination'			=> 'no',
	'method' 				=> 'cat',
	'list_category' 		=> '',
	'list_post' 			=> '',
	'category_slug' 		=> '',

	'category_filter'      => '',
	'category_filter_text' => esc_html__ ( 'All', 'slz' ),

	//layout 1
	'show_goal_raised'		=> 'yes',
	'show_goal_raised2'		=> 'yes',
	'column_1'              => '1',

	//layout 2
	'show_social_share_2'   => 'no',
	'list_social_share_2'   => '',
	'extra_class'			=> '',

//    slider
    'slide_autoplay'        => 'yes',
    'slide_dots'            => 'yes',
    'slide_arrows'          => 'yes',
    'slide_infinite'        => '',
    'slide_speed'           => '600'

);