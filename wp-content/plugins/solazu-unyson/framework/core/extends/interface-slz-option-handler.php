<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * @deprecated since 2.5.0
 * Will be removed soon https://github.com/ThemeFuse/Unyson/issues/1937
 */
interface SLZ_Option_Handler
{
	function get_option_value($option_id, $option, $data = array());

	function save_option_value($option_id, $option, $value, $data = array());
}

