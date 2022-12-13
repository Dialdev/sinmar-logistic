<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

class SLZ_Option_Type_Slider_Short extends SLZ_Option_Type_Slider {
	public function get_type() {
		return 'short-slider';
	}

	protected function _render( $id, $option, $data ) {
		$option['attr']['class'] .= ' short-slider slz-option-type-slider';

		return parent::_render( $id, $option, $data );
	}
}

SLZ_Option_Type::register( 'SLZ_Option_Type_Slider_Short' );
