<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$cfg = array();

$cfg['general'] = array(
	'id'       		 => __( 'ads-banner', 'slz' ),
	'name' 			 => __( 'SLZ: Ads Banner', 'slz' ),
	'description'    => __( 'Show ads banner.', 'slz' ),
	'classname'		 => 'slz-widget-ads-banner'
);

$cfg['default_value'] = array(
	'title'		 	=> __( 'Ads Banner', 'slz' ),
	'block_title_color'		=> '#',
	'adspot'				=> '',
	'extra_class'			=> ''
);