<?php

if ( ! defined( 'ABSPATH' ) ) {
	die ( 'Forbidden' );
}

$cfg = array ();

$cfg ['page_builder'] = array (
	'title' => __ ( 'SLZ Posts Block', 'slz' ),
	'description' => __ ( 'Show posts with layouts', 'slz' ),
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

$cfg['main_layout'] = array(
	esc_html__( 'Florida', 'slz' )    => 'main-layout-1',
	esc_html__( 'California', 'slz' ) => 'main-layout-2',
	esc_html__( 'Georgia', 'slz' )    => 'main-layout-3'
);// option layout 1

$cfg['list_layout'] = array(
	esc_html__( 'Florida', 'slz' )    => 'list-layout-1',
	esc_html__( 'California', 'slz' ) => 'list-layout-2',
	esc_html__( 'Georgia', 'slz' )    => 'list-layout-3'
); //option layout 1

$cfg['list_layout_2'] = array(
	esc_html__( 'Chennai', 'slz' ) => 'list-layout-1',
	esc_html__( 'Mumbai', 'slz' )  => 'list-layout-2'
); // option layout 2

$cfg['list_layout_3'] = array(
	esc_html__( 'London', 'slz' )    => 'list-layout-1',
	esc_html__( 'Harrogate', 'slz' ) => 'list-layout-2',
	esc_html__( 'Leeds', 'slz' )     => 'list-layout-3'
); //option layout 3

$cfg['layout_4_style'] = array(
	esc_html__( 'Milan', 'slz' )   => 'style-1',
	esc_html__( 'Rome', 'slz' )    => 'style-2',
	esc_html__( 'Cascina', 'slz' ) => 'style-3'
); // option layout 4

$cfg['title_length'] = 15;
$cfg['excerpt_length'] = 30;

$cfg['layouts'] = array(
	'layout-1'  => esc_html__( 'United States', 'slz' ),
	'layout-2'  => esc_html__( 'India', 'slz' ),
	'layout-3'  => esc_html__( 'United Kingdom', 'slz' ),
	'layout-4'  => esc_html__( 'Italy', 'slz' )
); // vc options

$cfg['yes_no'] = array(
	esc_html__( 'Yes', 'slz' )   => 'yes',
	esc_html__( 'No', 'slz' )   => 'no',
); // option layout 1 2 3

$cfg['column'] = array(
	esc_html__( 'One', 'slz' )     => '1',
	esc_html__( 'Two', 'slz' )     => '2',
	esc_html__( 'Three', 'slz' )   => '3',
	esc_html__( 'Four', 'slz' )    => '4',
); // option layout 1 3

$cfg ['default_value'] = array (
	'shortcode'            => 'posts-block',
    'btn_read_more'        => esc_html__('Read More','slz'),
	'layout'               => 'layout-1',
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
	'category_filter_text' => esc_html__ ( 'All', 'slz' ),
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
	'list_show_excerpt_2'  => 'no',
	'list_show_image_2'    => 'yes',
	'list_layout_3'        => 'list-layout-1',
	'list_column_3'        => '1',
	'list_show_excerpt_3'  => 'yes',
	'list_show_left_right_3' => 'yes',
	'style_4'              => 'style-1',
);