<?php
if ( ! defined( 'ABSPATH' ) ) {
	die ( 'Forbidden' );
}

$cfg = array ();

$cfg ['page_builder'] = array (
	'title'			=> esc_html__ ( 'SLZ Project Carousel', 'slz' ),
	'description'	=> esc_html__ ( 'Animated Carousel with projects', 'slz' ),
	'tab'			=> slz()->theme->manifest->get('name'),
	'icon'			=> 'icon-slzcore-portfolio-carousel slz-vc-slzcore',
	'tag'			=> 'slz_portfolio_carousel' 
);

$cfg ['image_size'] = array (
	'large'				=> '800x500',
	'small'				=> '350x350',
	'no-image-large'	=> '800x500',
	'no-image-small'	=> '350x350' 
);

$cfg ['layouts'] = array (
	'layout-1' => esc_html__( 'United States', 'slz' ),
	'layout-2' => esc_html__( 'India', 'slz' ),
	'layout-3' => esc_html__( 'United Kingdom', 'slz' )
);

$cfg ['default_value'] = array (
	'extension'				=> 'portfolios',
	'shortcode'				=> 'portfolio_carousel',
	'template'				=> 'portfolio',
	'image_size'			=> $cfg ['image_size'],
	'layout'				=> '',
	'layout_style_2'        => '',
	'column'                => '',
	'offset_post'			=> '',
	'limit_post'			=> '-1',
	'sort_by'				=> '',
	'extra_class'			=> '',
	'pagination'			=> '',
	'method' 				=> 'cat',
	'list_category' 		=> '',
	'category_slug' 		=> '',
	'list_team' 	     	=> '',
	'team_slug' 		    => '',
	'list_post' 			=> '',
	'category_filter'		=> '',
	'category_filter_text'	=> esc_html__('All', 'slz'),
	'author'                => '',
	'post__not_in'          => '',
	'show_thumbnail'		=> '',
	'show_featured_image'   => '', // layout 3
	'show_category'			=> 'no',
	'show_meta_info'		=> 'no',
	'show_description'		=> 'yes',
	'description_length'	=> '',
	'button_text'			=> '',
	'custom_link'           => '',
	'color_title'			=> '',
	'color_title_hv'		=> '',
	'color_category'		=> '',
	'color_category_hv'		=> '',
	'color_meta_info'		=> '',
	'color_meta_info_hv'	=> '',
	'color_description'		=> '',
	'color_item_bg_hv'		=> '',
	'color_button'			=> '',
	'color_button_hv'		=> '',
	'slide_to_show'         => '3',
	'slide_autoplay'        => 'yes',
	'slide_dots'            => 'yes',
	'slide_arrows'          => 'yes',
	'slide_infinite'        => 'yes',
	'slide_speed'           => '',
	'color_slide_arrow'     => '',
	'color_slide_arrow_hv'  => '',
	'color_slide_arrow_bg'  => '',
	'color_slide_arrow_bg_hv' => '',
	'color_slide_dots'      => '',
	'color_slide_dots_at'   => '',

	//update option
	'team'                  => '',
);