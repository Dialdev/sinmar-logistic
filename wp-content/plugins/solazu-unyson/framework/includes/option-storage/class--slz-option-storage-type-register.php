<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * @internal
 */
class _SLZ_Option_Storage_Type_Register extends SLZ_Type_Register {
	protected function validate_type(SLZ_Type $type) {
		return $type instanceof SLZ_Option_Storage_Type;
	}
}
