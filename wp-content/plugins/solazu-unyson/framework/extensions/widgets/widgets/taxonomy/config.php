<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$cfg = array();

$cfg['general'] = array(
	'id'             => esc_html__( 'slz_taxonomy', 'slz' ),
	'name'           => esc_html__( 'SLZ: Taxonomy', 'slz' ),
	'description'    => esc_html__( 'A list of taxonomy', 'slz' ),
	'classname'      => 'slz-widget-taxonomy'
);
$cfg['taxonomy'] = array(
	''                   => esc_html__( 'Posts Categories', 'slz' ),
	'slz-portfolio-cat'  => esc_html__( 'Portfolio Categories', 'slz' ),
	'slz-service-cat'    => esc_html__( 'Service Categories', 'slz' ),
	'slz-team-cat'       => esc_html__( 'Team Categories', 'slz' ),
);
$cfg['style'] = array(
	''               => esc_html__( 'Style 01', 'slz' ),
	'style 02'       => esc_html__( 'Style 02', 'slz' ),
);