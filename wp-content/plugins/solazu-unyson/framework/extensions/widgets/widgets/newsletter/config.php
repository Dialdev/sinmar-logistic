<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$cfg = array();
// can not override config of Newsletter widget

$cfg['style'] = array(
	'01'             => esc_html__( 'Style 01', 'slz' ),
	'02'             => esc_html__( 'Style 02', 'slz' )
);

$cfg['show_hide'] = array(
	'show'    => esc_html__( 'Show', 'slz' ),
	'hide'    => esc_html__( 'Hide', 'slz' ),
);