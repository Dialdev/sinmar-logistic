<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$cfg = array();

$cfg['general'] = array(
	'id'       		 => __( 'tags', 'slz' ),
	'name' 			 => __( 'SLZ: Tags', 'slz' ),
	'description'    => __( 'List of tags', 'slz' ),
	'classname'		 => 'slz-widget-tags'
);

$cfg['default_value'] = array(
	'title' 		=> esc_html__( 'Title', 'slz' ),
	'block_title_color' => '#',
	'number'			=>	'5',
	'extra_class'			=>	'',
);