<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$cfg = array();

$cfg['general'] = array(
	'id'             => esc_html__( 'slz_gallery_carousel', 'slz' ),
	'name'           => esc_html__( 'SLZ: Gallery Carousel', 'slz' ),
	'description'    => esc_html__( 'A list image from post type "Gallery" with carousel animation.', 'slz' ),
	'classname'      => 'slz-widget-gallery-carousel'
);
$cfg ['image_size'] = array (
    'large'             => '350x350',
    'no-image-large'    => '350x350',
);
