<?php if ( ! defined( 'SLZ' ) ) {
	die( 'Forbidden' );
}

$cfg = array();

$cfg['general'] = array(
	'id'             => esc_html__( 'slz_gallery', 'transera' ),
	'name'           => esc_html__( 'SLZ: Gallery', 'transera' ),
	'description'    => esc_html__( 'A list image from post type "Gallery".', 'transera' ),
	'classname'      => 'slz-widget-gallery'
);
$cfg ['image_size'] = array (
    'large'             => '350x350',
    'no-image-large'    => '350x350',
);
