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
function _filter_slz_ext_recruitment_template_include( $template ) {

	/**
	 * @var SLZ_Extension_Events $recruitment
	 */
	$recruitment  = slz()->extensions->get( 'recruitment' );
	$post_type = $recruitment->get_post_type_name();
	$taxonomy  = $recruitment->get_taxonomy_name();

	if ( is_singular( $post_type ) && $recruitment->locate_view_path( 'single' ) ) {
		return $recruitment->locate_view_path( 'single' );
	}
	else if ( ( is_post_type_archive( $post_type ) || is_tax( $taxonomy ) ) && $recruitment->locate_view_path( 'archive' ) ) {
		return $recruitment->locate_view_path( 'archive' );
	}

	return $template;
}

add_filter( 'template_include', '_filter_slz_ext_recruitment_template_include' );