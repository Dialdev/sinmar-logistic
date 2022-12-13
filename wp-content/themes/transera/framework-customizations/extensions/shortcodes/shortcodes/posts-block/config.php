<?php

if (! defined ( 'SLZ' )) {
	die ( 'Forbidden' );
}

$cfg = array ();

$cfg ['page_builder'] = array (
	'title' => __ ( 'SLZ Posts Block', 'transera' ),
	'description' => __ ( 'Show posts with layouts', 'transera' ),
	'tab' => slz()->theme->manifest->get('name'),
	'icon' => 'icon-slzcore-posts-block slz-vc-slzcore',
	'tag' => 'slz_posts_block'
);

$cfg ['image_size'] = array (
	'large'          => '800x400',
	'small'          => '370x180',
	'no-image-large' => '800x400',
	'no-image-small' => '370x180',
);

$cfg['list_layout'] = array(
	esc_html__( 'List Layout 1', 'transera' ) => 'list-layout-1',
); //option layout 1 3

$cfg['title_length'] = 15;
$cfg['excerpt_length'] = 30;

$cfg['layouts'] = array(
	'layout-3'  => esc_html__( 'Layout 3', 'transera' ),
); // vc options

$cfg['yes_no'] = array(
	esc_html__( 'Yes', 'transera' )   => 'yes',
	esc_html__( 'No', 'transera' )   => 'no',
); // option layout 1 2 3

$cfg['column'] = array(
	esc_html__( 'One', 'transera' )     => '1',
	esc_html__( 'Two', 'transera' )     => '2',
	esc_html__( 'Three', 'transera' )   => '3',
	esc_html__( 'Four', 'transera' )    => '4',
); // option layout 1 3

$cfg ['default_value'] = array (
	'shortcode'            => 'posts-block',
	'layout'               => 'layout-3',
	'image_size'           => $cfg ['image_size'],
	'block_title'          => '',
	'block_title_color'    => '',
	'block_title_class'    => 'slz-title-shortcode',
	'limit_post'           => '5',
	'offset_post'          => '0',
	'excerpt_length'       => '15',
	'post_format'          => '',
	'sort_by'              => '',
	'pagination'           => '',
	'category_filter'      => '',
	'category_filter_text' => esc_html__ ( 'All', 'transera' ),
	'extra_class'          => '',
	'category_list'        => '',
	'tag_list'             => '',
	'author_list'          => '',
	'main_layout'          => 'main-layout-1',
	'list_layout'          => 'list-layout-1',
	'main_show_read_more'  => 'yes',
	'main_show_excerpt'    => 'yes',
	'list_column'          => '1',
	'list_show_image'      => 'yes',
	'list_show_excerpt'    => 'yes',
	'main_show_excerpt_2'  => 'yes',
	'main_show_read_more_2' => 'yes',
	'list_layout_2'        => 'list-layout-1',
	'list_show_image_2'    => 'yes',
	'list_layout_3'        => 'list-layout-1',
	'list_column_3'        => '1',
	'list_show_excerpt_3'  => 'yes',
	'list_show_left_right_3' => 'yes',
	'list_show_read_more_3'  => 'yes',
	'list_read_more_text_3'  => esc_html__( 'Read More', 'transera' ),
	'style_4'              => 'style-1',
);