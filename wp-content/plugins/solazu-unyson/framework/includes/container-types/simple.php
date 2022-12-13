<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class SLZ_Container_Type_Group extends SLZ_Container_Type {
	public function get_type() {
		return 'group';
	}

	protected function _get_defaults() {
		return array();
	}

	protected function _enqueue_static($id, $option, $values, $data) {
		//
	}

	protected function _render($containers, $values, $data) {
		$html = '';

		foreach ( $containers as $id => &$group ) {
			// prepare attributes
			{
				$attr = isset( $group['attr'] ) ? $group['attr'] : array();

				$attr['id'] = 'slz-backend-options-group-' . $id;

				if ( ! isset( $attr['class'] ) ) {
					$attr['class'] = 'slz-backend-options-group';
				} else {
					$attr['class'] = 'slz-backend-options-group ' . $attr['class'];
				}
			}

			$html .= '<div ' . slz_attr_to_html( $attr ) . '>';
			$html .= slz()->backend->render_options( $group['options'], $values, $data );
			$html .= '</div>';
		}

		return $html;
	}
}
SLZ_Container_Type::register('SLZ_Container_Type_Group');
