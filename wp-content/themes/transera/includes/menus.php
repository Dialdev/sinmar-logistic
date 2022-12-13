<?php if ( ! defined( 'ABSPATH' ) ) {
    die( 'Direct access forbidden.' );
}

register_nav_menus( array(
	'top-nav'     => esc_html__('Top menu', 'transera' ),
	'main-nav'    => esc_html__('Main menu', 'transera' ),
	'bottom-nav'  => esc_html__('Bottom menu', 'transera' )
) );
