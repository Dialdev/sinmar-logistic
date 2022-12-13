<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$cfg = array();

$cfg['general'] = array(
	'id'             => esc_html__( 'slz_video', 'slz' ),
	'name'           => esc_html__( 'SLZ: Video', 'slz' ),
	'description'    => esc_html__( 'A block video.', 'slz' ),
	'classname'      => 'slz-widget-video'
);
