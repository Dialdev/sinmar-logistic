<?php

if (! defined ( 'SLZ' )) {
	die ( 'Forbidden' );
}

$cfg = array ();

$cfg ['page_builder'] = array (
	'title'			=> esc_html__( 'SLZ Team List', 'transera' ),
	'description'	=> esc_html__( 'List of team', 'transera' ),
	'tab'			=> slz()->theme->manifest->get('name'),
	'icon'			=> 'icon-slzcore-team-list slz-vc-slzcore',
	'tag'			=> 'slz_team_list' 
);

$cfg ['image_size'] = array (
	'large'				=> '600x600',
	'small'				=> '350x350',
	'no-image-large'	=> '600x600',
	'no-image-small'	=> '350x350' 
);

$cfg ['layouts'] = array (
	'layout-5' 		=> esc_html__( 'Layout 01', 'transera' ),
	'layout-6' 		=> esc_html__( 'Layout 02 - Carousel', 'transera' ),
);

$cfg ['default_value'] = array (
	'extension'				=> 'teams',
	'shortcode'				=> 'team_list',
	'template'				=> 'team',
	'image_size'			=> $cfg ['image_size'],

	'layout'				=> 'layout-5',
	'column'				=> '3',
	'exclude_id'			=> '',
	'offset_post'			=> '',
	'limit_post'			=> '-1',
	'max_post'				=> '',
	'sort_by'				=> '',
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