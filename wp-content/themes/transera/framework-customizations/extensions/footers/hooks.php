<?php if (!defined('SLZ')) die('Forbidden');

/** @internal */
function _transera_filter_disable_footers( $args ) {
	$args = array(
		'footer_04',
	);
	return $args;
}
add_filter( 'slz_ext_footers_disabled_footers' , '_transera_filter_disable_footers');