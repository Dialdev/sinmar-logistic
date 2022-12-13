<?php

if ( ! defined( 'ABSPATH' ) ) {
	die ( 'Forbidden' );
}

$cfg = array ();

$cfg ['page_builder'] = array (
	'title'			=> esc_html__( 'SLZ Team List', 'slz' ),
	'description'	=> esc_html__( 'List of team', 'slz' ),
	'tab'			=> slz()->theme->manifest->get('name'),
	'icon'			=> 'icon-slzcore-team-list slz-vc-slzcore',
	'tag'			=> 'slz_team_list' 
);

$cfg ['image_size'] = array (
	'default' => array(
		'large'				=> '600x600',
		'small'				=> '350x350',
	),
	'layout-1' => array(
		'large'				=> '450x700',
		'small'				=> '450x700',
	)
);

$cfg ['layouts'] = array (
	'layout-1' 		=> esc_html__( 'United States', 'slz' ),
	'layout-2' 		=> esc_html__( 'India', 'slz' ),
//	'layout-3' 		=> esc_html__( 'United Kingdom', 'slz' ),
	'layout-4' 		=> esc_html__( 'Italy', 'slz' ),
	'layout-5' 		=> esc_html__( 'Turkey', 'slz' ),
//	'layout-6' 		=> esc_html__( 'Brazil', 'slz' )
);

$cfg ['default_value'] = array (
	'extension'				=> 'teams',
	'shortcode'				=> 'team_list',
	'template'				=> 'team',
	'image_size'			=> $cfg ['image_size'],

	'layout'				=> 'layout-1',
	'column'				=> '3',
	'exclude_id'			=> '',
	'offset_post'			=> '',
	'limit_post'			=> '-1',
	'max_post'				=> '',
	'sort_by'				=> '',
    'btn_content'           => '',
	'extra_class'			=> '',
	'pagination'			=> 'no',
	'method' 				=> 'cat',
	'list_category' 		=> '',
	'list_post' 			=> '',
	'category_slug' 		=> '',
	'show_thumbnail'		=> 'yes',
	'show_description'		=> 'yes',
	'description_lenghth'	=> '',
	'show_position'			=> 'yes',
	'show_contact_info'		=> 'no',
	'show_quote'			=> 'yes',
	'show_social'			=> 'yes',

	'is_slide'				=> 'no',
	'slide_autoplay'		=> 'yes',
	'slide_dots'			=> 'yes',
	'slide_arrows'			=> 'yes',
	'slide_infinite'		=> 'yes',
	'slide_speed'			=> '600',

	'color_title'			=> '',
	'color_title_hv'		=> '',
	'color_position'		=> '',
	'color_quote'			=> '',
	'color_quote_icon'		=> '',
	'color_info'			=> '',
	'color_hv_info'			=> '',
	'color_description'		=> '',
	'color_social'			=> '',
	'color_social_hv'		=> '',

	'color_slide_arrow'		=> '',
	'color_slide_arrow_hv'	=> '',
	'color_slide_arrow_bg'	=> '',
	'color_slide_arrow_bg_hv'=> '',
	'color_slide_dots'		=> '',
	'color_slide_dots_at'	=> '',

	'color_carousel_arrow'		=> '',
	'color_carousel_arrow_hv'	=> '',
	'color_carousel_arrow_bg'	=> '',
	'color_carousel_arrow_bg_hv'=> '',
);