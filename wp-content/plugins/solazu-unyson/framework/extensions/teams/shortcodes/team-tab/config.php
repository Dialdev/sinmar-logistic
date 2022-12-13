<?php

if ( ! defined( 'ABSPATH' ) ) {
	die ( 'Forbidden' );
}

$cfg = array ();

$cfg ['page_builder'] = array (
	'title'			=> esc_html__( 'SLZ Team Tab', 'slz' ),
	'description'	=> esc_html__( 'List of team in tab panel', 'slz' ),
	'tab'			=> slz()->theme->manifest->get('name'),
	'icon'			=> 'icon-slzcore-team-tab slz-vc-slzcore',
	'tag'			=> 'slz_team_tab' 
);

$cfg ['image_size'] = array (
	'large'				=> '450x700',
	'small'				=> '450x700',
);

$cfg ['default_value'] = array (
	'extension'				=> 'teams',
	'shortcode'				=> 'team_tab',
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
	'show_social'			=> 'yes',

	'color_title'			=> '',
	'color_cat'             => '',
	'color_title_hv'		=> '',
	'color_position'		=> '',
	'color_quote'			=> '',
	'color_quote_icon'		=> '',
	'color_info'			=> '',
	'color_hv_info'			=> '',
	'color_description'		=> '',
	'color_social'			=> '',
	'color_social_hv'		=> '',
);