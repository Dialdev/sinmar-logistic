<?php if (!defined('SLZ')) die('Forbidden');

/** @internal */
function _transera_filter_disable_posts( $args ) {
	$args = array(
		'post_04',
	);
	return $args;
}
add_filter( 'slz_ext_posts_disabled_posts' , '_transera_filter_disable_posts');