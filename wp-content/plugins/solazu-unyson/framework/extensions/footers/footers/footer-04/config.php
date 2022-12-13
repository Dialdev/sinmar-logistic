<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$cfg = array();

$footers_extension = slz_ext( 'footers' )->get_footer('footer_04');

$cfg['general'] = array(
	'name' 			 => __( 'Footer 04', 'slz' ),
	'description'    => __( 'Footer 04', 'slz' ),
	'small_img'  	 => array(
        'height' => 70,
        'src'    => $footers_extension->locate_URI('/static/img/thumbnail.png')
    ),
    'large_img'  	 => array(
        'height' => 214,
        'src'    => $footers_extension->locate_URI('/static/img/thumbnail.png')
    )
);
