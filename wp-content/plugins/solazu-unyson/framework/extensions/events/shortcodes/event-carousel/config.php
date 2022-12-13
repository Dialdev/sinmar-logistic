<?php

if ( ! defined( 'ABSPATH' ) ) {
	die ( 'Forbidden' );
}

$cfg = array ();

$cfg ['page_builder'] = array (
	'title'			=> esc_html__( 'SLZ Events Carousel', 'slz' ),
	'description'	=> esc_html__( 'Banner of events', 'slz' ),
	'tab'			=> slz()->theme->manifest->get('name'),
	'icon'			=> 'icon-slzcore-event-carousel slz-vc-slzcore',
	'tag'			=> 'slz_event_carousel'
);

$cfg ['layouts'] = array (
	'layout-1' => esc_html__( 'United States', 'slz' ),
	'layout-2' => esc_html__( 'India', 'slz' )
);

$cfg ['image_size'] = array (
    'large'              => '341x257',
	'no-image-large'     => '341x257',
);

$cfg ['show_hide'] = array (
	esc_html__( 'Show' ) => 'show',
	esc_html__( 'Hide' ) => 'hide',
);

$cfg ['yes_no'] = array (
	esc_html__( 'Yes' ) => 'yes',
	esc_html__( 'No' ) => 'no',
);

$cfg ['filter_method'] = array(
	esc_html__( 'Category', 'slz' )  => 'cat',
	esc_html__( 'Event', 'slz' )      => 'event'
);

$cfg ['default_value'] = array (
	'extension'				  => 'events',
	'layout'			      => 'layout-1',
	'shortcode'				  => 'event_block',
	'title'                   => '',
	'limit_post'			  => '-1',
	'sort_by'				  => '',
	'extra_class'			  => '',
	'image_display'           => 'show',
	'description_display'     => 'show',
	'event_time_display'      => 'show',
	'event_location_display'  => 'show',
	'title_color'             => '',
	'slide_to_show'           => '3',
	'slide_autoplay'          => 'yes',
	'slide_dots'              => 'yes',
	'slide_arrows'            => 'yes',
	'slide_infinite'          => 'yes',
	'slide_speed'             => '600',
	'method' 				  => 'cat',
	'category_slug' 		  => '',
	'list_category' 		  => '',
	'list_post' 			  => '',
	'posts'                   => '',
	'countdown_display'       => 'show',
);