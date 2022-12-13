<?php if (!defined('SLZ')) die('Forbidden');

/** @internal */
function _transera_filter_disable_articles( $args ) {
	$args = array(
		'article_02',
		'article_04',
	);
	return $args;
}
add_filter( 'slz_ext_articles_disabled_articles' , '_transera_filter_disable_articles');