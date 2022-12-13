<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$cfg = array();

$cfg['general'] = array(
	'id'             => esc_html__( 'slz_social_counter', 'slz' ),
	'name'           => esc_html__( 'SLZ: Social Counter', 'slz' ),
	'description'    => esc_html__( 'Social counter.', 'slz' ),
	'classname'      => 'slz-widget-social-counter'
);

$cfg['default_value'] = array(
	'block_title_class' 	=> 'slz-title-shortcode',
	'block_title'           => esc_html__( 'Social Counter', 'slz' ),
	'block_title_color'     => '#',
	'extra_class'           => '',
	'facebook'				=> '',
	'facebook_appid'        => '',
	'facebook_secretkey'    => '',
	'twitter'				=> '',
	'google'				=> '',
	'vimeo'					=> '',
	'instagram'				=> '',
	'soundcloud'			=> '',
	'style'					=> 1
);