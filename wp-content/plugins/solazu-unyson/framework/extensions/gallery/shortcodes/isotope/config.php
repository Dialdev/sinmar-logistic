<?php

if ( ! defined( 'ABSPATH' ) ) {
	die ( 'Forbidden' );
}

$cfg = array ();

$cfg ['page_builder'] = array (
	'title'         => esc_html__( 'SLZ Isotope', 'slz' ),
	'description'   => esc_html__( 'Isotope of post feature image from custom post type', 'slz' ),
	'tab'           => slz()->theme->manifest->get('name'),
	'icon'          => 'icon-slzcore-isotope slz-vc-slzcore',
	'tag'           => 'slz_isotope' 
);

$cfg['styles'] = array(
	'style-1'   => esc_html__( 'Florida', 'slz' ),
	'style-2'   => esc_html__( 'California', 'slz' ),
	'style-3'   => esc_html__( 'Georgia', 'slz' ),
	'style-4'   => esc_html__( 'New York', 'slz' ),
	'style-5'   => esc_html__( 'Illinois', 'slz' ),
	'style-6'   => esc_html__( 'Connecticut', 'slz' ),
	'style-7'   => esc_html__( 'Texas', 'slz' ),
	'style-8'   => esc_html__( 'Arizona', 'slz' ),
	'style-9'   => esc_html__( 'Oregon', 'slz' ),
	'style-10'  => esc_html__( 'Kentucky', 'slz' ),
	'style-11'  => esc_html__( 'Missouri', 'slz' ),
	'style-12'  => esc_html__( 'Ohio', 'slz' )
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
	'image_size'                 => $cfg ['image_size'],
	'offset_post'                => '',
	'limit_post'                 => '-1',
	'sort_by'                    => '',
	'extra_class'                => '',
	'method_portfolio'           => 'cat',
	'list_category_portfolio'    => '',
	'list_post_portfolio'        => '',
	'method_gallery'             => 'cat',
	'list_category_gallery'      => '',
	'list_post_gallery'          => '',
	'show_category_filter'       => 'yes',
	'load_more_btn_text'         => '',
	'show_title'                 => 'yes',
	'show_category'              => 'yes',
	'show_meta_data'             => 'no',
	'show_description'           => 'yes',
	'show_read_more'             => 'yes',
	'show_fancybox_zoomin'       => 'yes',
	'cat_color'                  => '',
	'title_color'                => '',
	'title_color_hover'          => '',
	'meta_data_color'            => '',
	'meta_data_hover_color'      => '',
	'description_color'          => '',
	'readmore_btn_color'         => '',
	'readmore_btn_hover_color'   => '',
	'zoomin_btn_color'           => '',
	'zoomin_btn_hover_color'     => '',
	'align_category_filter'      => 'text-c',
	'pagination'                 => 'load_more'
);