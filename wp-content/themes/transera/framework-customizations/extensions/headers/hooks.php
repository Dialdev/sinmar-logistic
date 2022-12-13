<?php if (!defined('SLZ')) die('Forbidden');

/** @internal */
function _transera_filter_disable_headers( $args ) {
	$args = array(
		'header_03',
		'header_04',
		'header_05',
	);
	return $args;
}
add_filter( 'slz_ext_headers_disabled_headers' , '_transera_filter_disable_headers');