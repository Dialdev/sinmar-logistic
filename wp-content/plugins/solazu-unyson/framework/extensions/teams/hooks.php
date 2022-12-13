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
function _filter_slz_ext_teams_template_include( $template ) {

	/**
	 * @var SLZ_Extension_Events $teams
	 */
	$teams = slz()->extensions->get( 'teams' );
	$post_type = $teams->get_post_type_name();
	$taxonomy  = $teams->get_taxonomy_name();

	if ( is_singular( $post_type ) && $teams->locate_view_path( 'single' ) ) {
		return $teams->locate_view_path( 'single' );
	}
	else if ( ( is_post_type_archive( $post_type ) || is_tax( $taxonomy ) ) && $teams->locate_view_path( 'archive' ) ) {
		return $teams->locate_view_path( 'archive' );
	}

	return $template;
}

add_filter( 'template_include', '_filter_slz_ext_teams_template_include' );

