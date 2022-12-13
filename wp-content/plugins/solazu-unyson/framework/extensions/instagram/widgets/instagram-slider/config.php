<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$cfg = array();

$cfg['general'] = array(
	'id'       		 => esc_html__( 'instagram-slider', 'slz' ),
	'name' 			 => esc_html__( 'SLZ: Instagram Carousel', 'slz' ),
	'description'    => esc_html__( 'Show instagram images in carousel', 'slz' ),
	'classname'		 => 'slz-widget-instagram-slider'
);

$cfg['default_value'] = array(
	'block_title'  				=> esc_html__( "Instagram Carousel", 'slz'),
	'block_title_color'			=> '#',
	'instagram_id' 				=> '',
	'number_items' 				=> 6,
	'limit_image'		 		=> 12,
);