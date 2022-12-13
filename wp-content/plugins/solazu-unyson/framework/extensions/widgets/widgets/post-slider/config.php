<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$cfg = array();

$cfg['general'] = array(
	'id'             => esc_html__( 'slz_post_slider', 'slz' ),
	'name'           => esc_html__( 'SLZ: Post Slider', 'slz' ),
	'description'    => esc_html__( 'Show post with slider', 'slz' ),
	'classname'      => 'slz-widget-post-slider'
);
$cfg ['thumb-size'] = array (
	'large'             => '770x460',
	'no-image-large'    => '770x460',
);

