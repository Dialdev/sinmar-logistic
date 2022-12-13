<?php if ( ! defined( 'ABSPATH' ) ) {
    die( 'Forbidden' );
}

$cfg = array();

$cfg['general'] = array(
    'id'           => esc_html__( 'slz_events', 'slz' ),
    'name'         => esc_html__( 'SLZ: Events', 'slz' ),
    'description'  => '',
    'classname'    => 'slz-widget-events',
);

$cfg ['image_size'] = array (
    'large'             => '360x148',
    'no-image-large'    => '360x148',
);

$cfg['default_value'] = array(
    'title'             => esc_html__( 'Events', 'slz' ),
    'limit_post'		=> '-1',
    'offset_post'		=> '0',
    'cat_id'            => '',
);