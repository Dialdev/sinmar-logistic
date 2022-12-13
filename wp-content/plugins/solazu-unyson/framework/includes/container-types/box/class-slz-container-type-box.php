<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class SLZ_Container_Type_Box extends SLZ_Container_Type {
	public function get_type() {
		return 'box';
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
		$html = '';

		foreach ( $containers as $id => &$box ) {
			if (empty($box['options'])) {
				continue;
			}

			unset( $box['attr']['id'] ); // do not allow id overwrite, it is sent in first argument of render_box()

			$html .= slz()->backend->render_box(
				'slz-options-box-' . $id,
				empty( $box['title'] ) ? ' ' : $box['title'],
				slz()->backend->render_options( $box['options'], $values, $data ),
				array(
					'attr' => $box['attr']
				)
			);
		}

		if (!empty($html)) {
			$html =
				'<div class="slz-backend-postboxes metabox-holder">'
				. $html
				. '</div>';
		}

		return $html;
	}
}
SLZ_Container_Type::register('SLZ_Container_Type_Box');
