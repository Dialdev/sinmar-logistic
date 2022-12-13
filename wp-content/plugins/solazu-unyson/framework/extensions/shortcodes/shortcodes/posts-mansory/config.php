<?php

if ( ! defined( 'ABSPATH' ) ) {
	die ( 'Forbidden' );
}

$cfg = array ();

$cfg ['page_builder'] = array (
		'title' => esc_html__( 'SLZ Posts Mansory', 'slz' ),
		'description' => esc_html__( 'Post with mansory layout', 'slz' ),
		'tab' => slz()->theme->manifest->get('name'),
		'icon' => 'icon-slzcore-posts-mansory slz-vc-slzcore',
		'tag' => 'slz_posts_mansory' 
);

$cfg ['image_size'] = array (
	'large'           => '550x350',
	'small'           => '800x300',
	'no-image-large'  => '550x350',
	'no-image-small'  => '800x300',
);

$cfg['layouts'] = array(
	'layout-1'  => esc_html__( 'United States', 'slz' ),
	'layout-2'  => esc_html__( 'India', 'slz' )
);

$cfg['title_length'] = 15;

$cfg['excerpt_length'] = 30;

$cfg ['default_value'] = array (
		'shortcode'  => 'posts-mansory',
		'layout' => 'layout-1',
		'style'	=> 1,
		'image_size' => '',
		'column'	=> 	'2',
		'limit_post' => '6',
		'excerpt_length' => '15',
		'excerpt'	=> 'show',
		'readmore'	=> 'show',
		'block_title' => '',
		'block_title_color' => '',
		'block_title_class' => 'slz-title-shortcode',
		'show_excerpt' => '',
		'offset_post' => '0',
		'post_format' => '',
		'sort_by' => '',
		'pagination' => '',
		'category_filter' => '',
		'category_filter_text' => esc_html__ ( 'All', 'slz' ),
		'extra_class' => '',
		'category_list' => '',
		'tag_list' => '',
		'author_list' => '' 
);