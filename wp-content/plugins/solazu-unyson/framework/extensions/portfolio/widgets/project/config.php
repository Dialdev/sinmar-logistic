<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$cfg = array();

$cfg['general'] = array(
	'id'             => esc_html__( 'slz_project', 'slz' ),
	'name'           => esc_html__( 'SLZ: Project', 'slz' ),
	'description'    => esc_html__( 'A project list', 'slz' ),
	'classname'      => 'slz-widget-project'
);
$cfg['check_box'] = array(
	'show_image'       => esc_html__( 'Display Thumbnail', 'slz' ),
	'show_category'    => esc_html__( 'Display Category', 'slz' ),
	'show_description' => esc_html__( 'Display Description', 'slz' ),
);
$cfg ['thumb-size'] = array (
    'large'             => '350x350',
    'no-image-large'    => '350x350',
);
$cfg ['image_type'] = array (
    esc_html__( 'Thumbnail', 'slz' )       => 'thumbnail',
	esc_html__( 'Feature Image', 'slz' )   => 'feature_image',
);