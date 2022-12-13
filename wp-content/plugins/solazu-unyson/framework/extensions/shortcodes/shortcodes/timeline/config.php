<?php

if ( ! defined( 'ABSPATH' ) ) {
	die ( 'Forbidden' );
}

$cfg = array ();

$cfg ['page_builder'] = array (
	'title' => esc_html__ ( 'SLZ Timeline', 'slz' ),
	'description' => esc_html__ ( 'Timeline of events', 'slz' ),
	'tab' => slz()->theme->manifest->get('name'),
	'icon' => 'icon-slzcore-timeline slz-vc-slzcore',
	'tag' => 'slz_timeline'
);

$cfg ['default_value'] = array (
	'layout'                 => '',
	'timeline_info'          => '',
	'milestone_point_color'  => '',
	'timeline_line_color'    => '',	
	'extra_class'            => '',
);