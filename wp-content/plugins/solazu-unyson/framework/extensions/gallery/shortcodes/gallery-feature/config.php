<?php

if ( ! defined( 'ABSPATH' ) ) {
	die ( 'Forbidden' );
}

$cfg = array ();

$cfg ['page_builder'] = array (
	'title'         => esc_html__( 'SLZ Gallery Feature', 'slz' ),
	'description'   => esc_html__( 'Display feature image with carousel effect.', 'slz' ),
	'tab'           => slz()->theme->manifest->get('name'),
	'icon'          => 'icon-slzcore-gallery-feature slz-vc-slzcore',
	'tag'           => 'slz_gallery_feature' 
);

$cfg['styles'] = array(
	'style-1'   => esc_html__( 'Florida', 'slz' ),
	'style-2'   => esc_html__( 'California', 'slz' )
);

$cfg ['image_size'] = array (
	'large'             => '800x600',
	'small'             => '800x300',
	'no-image-large'    => '800x600',
	'no-image-small'    => '800x300',
);

$cfg ['default_value'] = array (
	'post_type'                  => 'slz-gallery',
	'style'                      => 'style-1',
	'image-upload'               => '',
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
	'show_title'                 => 'yes',
	'show_description'           => 'yes',
	'show_read_more'             => 'yes',
	'read_more_text'             => '',
	'title_color'                => '',
	'title_color_hover'          => '',
	'description_color'          => '',
	'btn_color'                  => '',
	'btn_hover_color'            => '',
	'btn_bg_color'               => '',
	'btn_bg_hover_color'         => '',
	'icon_color'                 => '',
	'icon_bg_color'              => '',
	'icon_bd_hv_color'           => '',
	'icon_bd_color'              => '',
	'icon_hv_color'              => '',
	'icon_bg_hv_color'           => '',
);