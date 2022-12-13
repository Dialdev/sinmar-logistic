<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$cfg = array();

$footers_extension = slz_ext( 'footers' )->get_footer('footer_01');

$cfg['general'] = array(
	'name' 			 => __( 'Footer 01', 'slz' ),
	'description'    => __( 'Footer 01', 'slz' ),
	'small_img'  	 => array(
        'height' => 70,
        'src'    => $footers_extension->locate_URI('/static/img/thumbnail.png')
    ),
    'large_img'  	 => array(
        'height' => 214,
        'src'    => $footers_extension->locate_URI('/static/img/thumbnail.png')
    )
);
