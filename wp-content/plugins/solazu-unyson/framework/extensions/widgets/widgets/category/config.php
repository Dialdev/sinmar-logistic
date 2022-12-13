<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$cfg = array();

$cfg['general'] = array(
	'id'       		 => __( 'category', 'slz' ),
	'name' 			 => __( 'SLZ: Categories', 'slz' ),
	'description'    => __( 'A list of categories.', 'slz' ),
	'classname'		 => 'slz-widget-category'
);

$cfg['default_value'] = array(
	'title' 				=> esc_html__( 'Categories', 'slz' ),
	'category_slug' 		=> array(''),
	'block_title_color' 	=> '#',
	'style' 				=> 1
);