<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$cfg = array();

$cfg['general'] = array(
	'id'       		 => __( 'new-tweet', 'slz' ),
	'name' 			 => __( 'SLZ: New Tweet', 'slz' ),
	'description'    => __( 'Show twitter new tweet', 'slz' ),
	'classname'		 => 'slz-widget-new-tweet'
);

$cfg['default_value'] = array(
	'block_title'  				=> esc_html__( "New Tweet", 'slz'),
	'block_title_color'			=> '#',
	'extra_class'           	=> '',
	'limit_tweet'  				=> '3',
	'screen_name'       		=> '',
    'show_author'               => '',
    'show_author_name'          => '',
    'show_time'                 => ''
);