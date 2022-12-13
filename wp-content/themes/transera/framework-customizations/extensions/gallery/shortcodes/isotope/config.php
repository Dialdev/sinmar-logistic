<?php

if (! defined ( 'SLZ' )) {
	die ( 'Forbidden' );
}

$cfg = array ();

$cfg ['page_builder'] = array (
	'title'         => esc_html__( 'SLZ Isotope', 'transera' ),
	'description'   => esc_html__( 'Isotope of post feature image from custom post type', 'transera' ),
	'tab'           => slz()->theme->manifest->get('name'),
	'icon'          => 'icon-slzcore-isotope slz-vc-slzcore',
	'tag'           => 'slz_isotope' 
);

$cfg['styles'] = array(
	'style-1'   => esc_html__( 'Style 1', 'transera' ),
	'style-2'   => esc_html__( 'Style 2', 'transera' ),
	'style-3'   => esc_html__( 'Style 3', 'transera' ),
	'style-4'   => esc_html__( 'Style 4', 'transera' ),
	'style-5'   => esc_html__( 'Style 5', 'transera' ),
	'style-6'   => esc_html__( 'Style 6', 'transera' ),
	'style-7'   => esc_html__( 'Style 7', 'transera' ),
	'style-8'   => esc_html__( 'Style 8', 'transera' ),
	'style-9'   => esc_html__( 'Style 9', 'transera' ),
	'style-10'  => esc_html__( 'Style 10', 'transera' )
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
	'pagination'                 => 'load_more'
);