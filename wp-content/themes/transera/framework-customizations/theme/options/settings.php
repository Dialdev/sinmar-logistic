<?php if ( ! defined( 'SLZ' ) ) {
	die( 'Forbidden' );
}
/**
 * Framework options
 *
 * @var array $options Fill this array with options to generate framework settings form in backend
 */

$options = array(
	slz()->theme->get_options( 'general-settings' ),
	slz()->theme->get_options( 'header-settings' ),
	slz()->theme->get_options( 'footer-settings' ),
	slz()->theme->get_options( 'template-settings' ),
	slz()->theme->get_options( 'advertisement-settings' ),
	slz()->theme->get_options( 'post-settings' ),
    slz()->theme->get_options( 'page-header-settings' ),
	slz()->theme->get_options( 'page-404-settings' ),
	slz()->theme->get_options( 'typography' ),
	slz()->theme->get_options( 'custom-styles' ),
	slz()->theme->get_options( 'custom-scripts' ),
	slz()->theme->get_options( 'speed-optimize' ),		
	slz()->theme->get_options( 'theme-requirements' ),
	slz()->theme->get_options( 'import-export' ),
);
