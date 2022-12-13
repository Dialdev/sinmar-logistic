<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$cfg = array();

$cfg['general'] = array(
	'id'             => esc_html__( 'slz_custom_post', 'slz' ),
	'name'           => esc_html__( 'SLZ: Custom Posts', 'slz' ),
	'description'    => esc_html__( 'A list of posts from custom post type', 'slz' ),
	'classname'      => 'slz-widget-custom-post'
);

$cfg['post_type'] = array(
	'slz-portfolio'    => esc_html__( 'Portfolio', 'slz' ),
	'slz-service'      => esc_html__( 'Service', 'slz' ),
	'slz-team'         => esc_html__( 'Team', 'slz' ),
	'slz-recruiment'   => esc_html__( 'Recruiment', 'slz' ),
);
$cfg['extensions'] = array(
	'slz-portfolio'    => 'portfolio',
	'slz-service'      => 'services',
	'slz-team'         => 'teams',
	'slz-recruiment'   => 'recruitment',
);