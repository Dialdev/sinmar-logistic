<?php

if ( ! defined( 'ABSPATH' ) ) {
	die ( 'Forbidden' );
}

$cfg = array ();

$cfg ['page_builder'] = array (
	'title'			=> esc_html__( 'SLZ Events Block', 'slz' ),
	'description'	=> esc_html__( 'Banner of events', 'slz' ),
	'tab'			=> slz()->theme->manifest->get('name'),
	'icon'			=> 'icon-slzcore-event-block slz-vc-slzcore',
	'tag'			=> 'slz_event_block'
);

$cfg ['layouts'] = array (
    'layout-1' => esc_html__( 'United States', 'slz' ),
    'layout-2' => esc_html__( 'India', 'slz' ),
    'layout-3' => esc_html__( 'United Kingdom', 'slz' ),
);

$cfg ['image_size'] = array (
	'default' => array(
		'large'          => '341x257',
		'no-image-small' => '341x257',
	),
	'layout-3' => array(
		'large'          => '450x550',
	),
	'layout-1' => array(
		'large'          => '800x500',
	),
);

$cfg ['show_hide'] = array (
	esc_html__( 'Show' ) => 'show',
	esc_html__( 'Hide' ) => 'hide',
);

$cfg ['filter_method'] = array(
	esc_html__( 'Category', 'slz' )  => 'cat',
	esc_html__( 'Event', 'slz' )     => 'event',
);

$cfg ['yes_no'] = array(
	esc_html__( 'No', 'slz' ) => '',
	esc_html__( 'Yes', 'slz' ) => 'yes',
);

$cfg ['default_value'] = array (
	'extension'				  => 'events',
	'shortcode'				  => 'event_block',
    'layout'                  => 'layout-1',
    'show_searchbar'          => 'hide',
	'title'                   => '',
    'limit_post'			  => '-1',
    'offset_post'			  => '',
	'sort_by'				  => '',
	'extra_class'			  => '',
	'image_display'           => 'show',
	'description_display'     => 'show',
	'event_time_display'      => 'show',
	'event_location_display'  => 'show',
	'event_address_display'   => 'show',
	'title_color'             => '',
	'method' 				  => 'cat',
	'event_goal_donation'	  => '',
	'category_slug' 		  => '',
	'list_category' 		  => '',
	'list_post' 			  => '',
	'posts'                   => '',
	'pagination'              => '',
    'column'			      => '1',

);