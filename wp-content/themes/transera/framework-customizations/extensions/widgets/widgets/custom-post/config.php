<?php if ( ! defined( 'SLZ' ) ) {
	die( 'Forbidden' );
}

$cfg = array();

$cfg['general'] = array(
	'id'             => esc_html__( 'slz_custom_post', 'transera' ),
	'name'           => esc_html__( 'SLZ: Custom Posts', 'transera' ),
	'description'    => esc_html__( 'A list of posts from custom post type', 'transera' ),
	'classname'      => 'slz-widget-custom-post'
);

$cfg['post_type'] = array(
	'slz-service'      => esc_html__( 'Service', 'transera' ),
	'slz-team'         => esc_html__( 'Team', 'transera' ),
	'slz-recruiment'   => esc_html__( 'Recruiment', 'transera' ),
);