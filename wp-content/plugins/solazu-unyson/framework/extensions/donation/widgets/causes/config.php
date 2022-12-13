<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$cfg = array();

$cfg['general'] = array(
	'id'             => esc_html__( 'slz_causes', 'slz' ),
	'name'           => esc_html__( 'SLZ: Causes', 'slz' ),
	'description'    => esc_html__( 'A list image from post type "Causes".', 'slz' ),
	'classname'      => 'slz-widget-causes'
);
$cfg ['image_size'] = array (
    'large'             => '140x92',
    'no-image-large'    => '140x92',
);

$cfg['method'] = array(
	'causes'   => esc_html__('Causes','slz'),
	'cat' => esc_html__('Category','slz')
);

