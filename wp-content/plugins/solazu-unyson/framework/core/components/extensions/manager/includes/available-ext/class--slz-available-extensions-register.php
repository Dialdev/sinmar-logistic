<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class _SLZ_Available_Extensions_Register extends SLZ_Type_Register {
	protected function validate_type( SLZ_Type $type ) {
		return $type instanceof SLZ_Available_Extension;
	}
}
