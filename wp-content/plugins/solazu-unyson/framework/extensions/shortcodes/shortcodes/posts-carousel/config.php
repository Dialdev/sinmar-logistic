<?php

if ( ! defined( 'ABSPATH' ) ) {
	die ( 'Forbidden' );
}

$cfg = array ();

$cfg ['page_builder'] = array (
		'title' => esc_html__( 'SLZ Posts Carousel', 'slz' ),
		'description' => esc_html__( 'Block Carousel of posts', 'slz' ),
		'tab' => slz()->theme->manifest->get('name'),
		'icon' => 'icon-slzcore-posts-carousel slz-vc-slzcore',
		'tag' => 'slz_block_posts_carousel' 
);

$cfg ['image_size'] = array (
		'large' => '550x350',
		'no-image-large' => '550x350',
		'small'  => '160x84',
		'no-image-small'  => '160x84'
);

$cfg ['styles'] = array (
	'1'  => esc_html__( 'United States', 'slz' ),
	'2'  => esc_html__( 'India', 'slz' ),
	'3'  => esc_html__( 'United Kingdom', 'slz' ),
	'5'  => esc_html__( 'Turkey', 'slz' ),
	'6'  => esc_html__( 'Brazil', 'slz' ),
	'7'  => esc_html__( 'Germany', 'slz' ),
	'8'  => esc_html__( 'Spain', 'slz' ),
);

$cfg['title_length']   = 15;

$cfg['excerpt_length'] = 30;

$cfg ['default_value'] = array (
	'shortcode'           => 'posts-carousel',
	'layout'              => 'posts-carousel',
	'style'	              => 1,
	'template'            => 1,
	'column'	          => 1,
	'image_size'          => '',
	'excerpt'	          => 'show',
    'excerpt_length'      => '30',
	'readmore'	          => 'show',
	'limit_post'          => '5',
	'block_title'         => '',
	'block_title_color'   => '',
	'block_title_class'   => 'slz-title-shortcode',
	'show_excerpt'        => '',
	'offset_post'         => '0',
	'post_format'         => '',
	'sort_by'             => '',
	'pagination'          => '',
	'category_filter'     => '',
	'category_filter_text' => esc_html__ ( 'All', 'slz' ),
	'extra_class'         => '',
	'category_list'       => '',
	'tag_list'            => '',
	'author_list'         => '',
	'show_dots'           => 'yes',
	'show_arrows'         => 'yes',
	'slide_autoplay'      => 'yes',
	'slide_infinite'      => 'yes',
	'slide_speed'         => '',
	'animation'           => '0'		
);