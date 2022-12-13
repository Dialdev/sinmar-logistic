<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class SLZ_Container_Type_Tab extends SLZ_Container_Type {
	public function get_type() {
		return 'tab';
	}

	protected function _get_defaults() {
		return array(
			'title' => '',
		);
	}

	protected function _enqueue_static($id, $option, $values, $data) {
		//
	}

	protected function _render($containers, $values, $data) {
		return slz_render_view(
			dirname(__FILE__) .'/view.php',
			array(
				'tabs'         => &$containers,
				'values'       => &$values,
				'options_data' => &$data,
			)
		);
	}
}
SLZ_Container_Type::register('SLZ_Container_Type_Tab');
