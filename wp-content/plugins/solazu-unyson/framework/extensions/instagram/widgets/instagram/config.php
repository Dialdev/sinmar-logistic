<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$cfg = array();

$cfg['general'] = array(
	'id'       		 => esc_html__( 'instagram', 'slz' ),
	'name' 			 => esc_html__( 'SLZ: Instagram', 'slz' ),
	'description'    => esc_html__( 'Show instagram images in grid', 'slz' ),
	'classname'		 => 'slz-widget-instagram'
);

$cfg['default_value'] = array(
	'block_title'  				=> esc_html__( "Instagram", 'slz'),
	'block_title_color'			=> '#',
	'instagram_id' 				=> '',
	'column' 					=> 4,
	'limit_image'		 		=> 12,
);