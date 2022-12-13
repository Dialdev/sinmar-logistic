<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$cfg = array();

$cfg['general'] = array(
	'id'             => esc_html__( 'slz_gallery', 'slz' ),
	'name'           => esc_html__( 'SLZ: Gallery', 'slz' ),
	'description'    => esc_html__( 'A list image from post type "Gallery".', 'slz' ),
	'classname'      => 'slz-widget-gallery'
);
$cfg ['image_size'] = array (
    'large'             => '150x150',
    'no-image-large'    => '150x150',
);
$cfg['post-type'] = array(
	'slz-gallery'   => esc_html__('Gallery','slz'),
	'slz-portfolio' => esc_html__('Portfolio','slz')
	);

