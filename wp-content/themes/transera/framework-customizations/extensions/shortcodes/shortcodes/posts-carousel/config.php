<?php

if (! defined ( 'SLZ' )) {
	die ( 'Forbidden' );
}

$cfg = array ();

$cfg ['page_builder'] = array (
		'title' => esc_html__ ( 'SLZ Posts Carousel', 'transera' ),
		'description' => esc_html__ ( 'Block Carousel of posts', 'transera' ),
		'tab' => slz()->theme->manifest->get('name'),
		'icon' => 'icon-slzcore-posts-carousel slz-vc-slzcore',
		'tag' => 'slz_block_posts_carousel' 
);

$cfg ['image_size'] = array (
		'large' => '570x320',
		'no-image-large' => '570x320',
		'small'  => '160x84',
		'no-image-small'  => '160x84',
);

$cfg ['styles'] = array (
	'3'  => esc_html__( 'Layout 3', 'transera' ),
);

$cfg['title_length'] = 15;

$cfg['excerpt_length'] = 30;

$cfg ['default_value'] = array (
	'shortcode' => 'posts-carousel',
	'layout' => 'posts-carousel',
	'style'	=> 3,
	'template' => 1,
	'column'	=> 3,
	'image_size' => '',
	'excerpt'	=> 'show',
	'readmore'	=> 'show',
	'button_text'  => esc_html__( 'Read More', 'transera' ),
	'limit_post' => '5',
	'block_title' => '',
	'block_title_color' => '',
	'block_title_class' => 'slz-title-shortcode',
	'show_excerpt' => '',
    'excerpt_length' => '30',
	'offset_post' => '0',
	'post_format' => '',
	'sort_by' => '',
	'pagination' => '',
	'category_filter' => '',
	'category_filter_text' => esc_html__ ( 'All', 'transera' ),
	'extra_class' => '',
	'category_list' => '',
	'tag_list' => '',
	'author_list' => '',
	'show_dots'           => 'yes',
	'show_arrows'         => 'yes',
	'slide_autoplay'      => 'yes',
	'slide_infinite'      => 'yes',
	'slide_speed'         => '',
	'animation'   => ''
);