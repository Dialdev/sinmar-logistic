<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * @since 2.4.10
 */
abstract class SLZ_Type {
	/**
	 * @return string Unique type
	 */
	abstract public function get_type();
}
