<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$cfg = array();

$cfg['general'] = array(
	'id'             => esc_html__( 'slz_post_block', 'slz' ),
	'name'           => esc_html__( 'SLZ: Post Block', 'slz' ),
	'description'    => esc_html__( 'Show post with layouts', 'slz' ),
	'classname'      => 'slz-widget-post-block'
);
$cfg['check_box'] = array(
    'show_thumbnail' => esc_html__( 'Display Thumbnail', 'slz' ),
    'show_date'      => esc_html__( 'Display Post Date', 'slz' ),
    'show_author'    => esc_html__( 'Display Author', 'slz' ),
    'show_view'      => esc_html__( 'Display View', 'slz' ),
    'show_comment'   => esc_html__( 'Display Comment', 'slz' )
);
$cfg ['thumb-size'] = array (
	'large'             => '800x400',
	'no-image-large'    => '800x400',
);

