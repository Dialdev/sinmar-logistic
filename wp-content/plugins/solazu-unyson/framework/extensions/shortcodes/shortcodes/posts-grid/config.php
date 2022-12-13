<?php

if ( ! defined( 'ABSPATH' ) ) {
	die ( 'Forbidden' );
}

$cfg = array ();

$cfg ['page_builder'] = array (
		'title' => __ ( 'SLZ Posts Grid', 'slz' ),
		'description' => __ ( 'Grid of posts', 'slz' ),
		'tab' => slz()->theme->manifest->get('name'),
		'icon' => 'icon-slzcore-posts-grid slz-vc-slzcore',
		'tag' => 'slz_posts_grid' 
);

$cfg['styles'] = array(
	'style-1' => esc_html__( 'United States', 'slz' ),
	'style-2' => esc_html__( 'India', 'slz' ),
	'style-3' => esc_html__( 'United Kingdom', 'slz' ),
	'style-4' => esc_html__( 'Italy', 'slz' ),
	'style-5' => esc_html__( 'Turkey', 'slz' ),
	'style-6' => esc_html__( 'Brazil', 'slz' ),
	'style-7' => esc_html__( 'Germany', 'slz' )
);

$cfg ['image_size'] = array (
	'large'          => '800x500',
	'no-image-large' => '800x500',
	'small'          => '800x400',
	'no-image-small' => '800x400',
);

$cfg['position'] = array(
	esc_html__( 'Left', 'slz' )  => 'left',
	esc_html__( 'Right', 'slz' ) => 'right',
);

$cfg['title_length'] = 15;

$cfg['excerpt_length'] = 30;

$cfg ['default_value'] = array (
		'shortcode'           => 'posts-grid',
		'layout'              => 'posts-grid',
		'style'               => 'style-1',
		'position'            => 'left',
		'image_size'          => $cfg ['image_size'],
		'limit_post'          => '5',
		'show_excerpt'        => 'show',
		'excerpt_length'      => '15',
		'block_title'         => '',
		'block_title_color'   => '',
		'block_title_class'   => 'slz-title-shortcode',
		'show_excerpt'        => '',
		'offset_post'         => '0',
		'post_format'         => '',
		'sort_by'             => '',
		'category_filter'     => '',
		'category_filter_text' => esc_html__ ( 'All', 'slz' ),
		'extra_class'         => '',
		'category_list'       => '',
		'tag_list'            => '',
		'author_list'         => '' 
);