<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * @internal
 * @param array $widths Default widths
 * @return array
 */
function _filter_ext_forms_change_builder_item_widths($widths) {
	foreach ($widths as &$width) {
		$width['frontend_class'] .= ' form-builder-item';
	}

	return $widths;
}
add_filter('slz_builder_item_widths:form-builder', '_filter_ext_forms_change_builder_item_widths');

function _action_slz_ext_forms_option_types_init() {
	require dirname(__FILE__) .'/includes/option-types/form-builder/class-slz-option-type-form-builder.php';
}
add_action('slz_option_types_init', '_action_slz_ext_forms_option_types_init');
