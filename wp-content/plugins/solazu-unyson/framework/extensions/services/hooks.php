<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

/**
 * Select custom page template on frontend
 *
 * @internal
 *
 * @param string $template
 *
 * @return string
 */
function _filter_slz_ext_service_template_include( $template ) {

	/**
	 * @var SLZ_Extension_Events $services
	 */
	$services  = slz()->extensions->get( 'services' );
	$post_type = $services->get_post_type_name();
	$taxonomy  = $services->get_taxonomy_name();

	if ( is_singular( $post_type ) && $services->locate_view_path( 'single' ) ) {
		return $services->locate_view_path( 'single' );
	}
	else if ( ( is_post_type_archive( $post_type ) || is_tax( $taxonomy ) ) && $services->locate_view_path( 'archive' ) ) {
		return $services->locate_view_path( 'archive' );
	}

	return $template;
}

add_filter( 'template_include', '_filter_slz_ext_service_template_include' );