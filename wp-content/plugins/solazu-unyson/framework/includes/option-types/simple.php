<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

/**
 * Simple option types (without scripts, styles or views)
 *
 * Convention: Simple options like text|select|input|textarea, should always generate only input, without div wrappers
 */
class SLZ_Option_Type_Hidden extends SLZ_Option_Type {
	public function get_type() {
		return 'hidden';
	}

	/**
	 * @internal
	 * {@inheritdoc}
	 */
	protected function _enqueue_static( $id, $option, $data ) {
	}

	/**
	 * @param string $id
	 * @param array $option
	 * @param array $data
	 *
	 * @return string
	 *
	 * @internal
	 */
	protected function _render( $id, $option, $data ) {
		$option['attr']['value'] = (string) $data['value'];

		return '<input ' . slz_attr_to_html( $option['attr'] ) . ' type="hidden" />';
	}

	/**
	 * @param array $option
	 * @param array|null|string $input_value
	 *
	 * @return string
	 *
	 * @internal
	 */
	protected function _get_value_from_input( $option, $input_value ) {
		return (string) ( is_null( $input_value ) ? $option['value'] : $input_value );
	}

	/**
	 * @internal
	 */
	public function _get_backend_width_type() {
		return 'auto';
	}

	/**
	 * @internal
	 */
	protected function _get_defaults() {
		return array(
			'value' => ''
		);
	}
}

SLZ_Option_Type::register( 'SLZ_Option_Type_Hidden' );

class SLZ_Option_Type_Text extends SLZ_Option_Type {
	public function get_type() {
		return 'text';
	}

	/**
	 * @internal
	 * {@inheritdoc}
	 */
	protected function _enqueue_static( $id, $option, $data ) {
	}

	/**
	 * @param string $id
	 * @param array $option
	 * @param array $data
	 *
	 * @return string
	 *
	 * @internal
	 */
	protected function _render( $id, $option, $data ) {
		$option['attr']['value'] = (string) $data['value'];

		return '<input ' . slz_attr_to_html( $option['attr'] ) . ' type="text" />';
	}

	/**
	 * @param array $option
	 * @param array|null|string $input_value
	 *
	 * @return string
	 *
	 * @internal
	 */
	protected function _get_value_from_input( $option, $input_value ) {
		return (string) ( is_null( $input_value ) ? $option['value'] : $input_value );
	}

	/**
	 * @internal
	 */
	protected function _get_defaults() {
		return array(
			'value' => ''
		);
	}
}

SLZ_Option_Type::register( 'SLZ_Option_Type_Text' );

class SLZ_Option_Type_Short_Text extends SLZ_Option_Type_Text {
	public function get_type() {
		return 'short-text';
	}

	/**
	 * @param string $id
	 * @param array $option
	 * @param array $data
	 *
	 * @return string
	 *
	 * @internal
	 */
	protected function _render( $id, $option, $data ) {
		$option['attr']['class'] .= ' slz-option-width-short';

		return parent::_render( $id, $option, $data );
	}

	/**
	 * {@inheritdoc}
	 * @internal
	 */
	public function _get_backend_width_type() {
		return 'auto';
	}
}

SLZ_Option_Type::register( 'SLZ_Option_Type_Short_Text' );

class SLZ_Option_Type_Password extends SLZ_Option_Type {
	public function get_type() {
		return 'password';
	}

	/**
	 * @internal
	 * {@inheritdoc}
	 */
	protected function _enqueue_static( $id, $option, $data ) {
	}

	/**
	 * @param string $id
	 * @param array $option
	 * @param array $data
	 *
	 * @return string
	 *
	 * @internal
	 */
	protected function _render( $id, $option, $data ) {
		$option['attr']['value'] = (string) $data['value'];

		return '<input ' . slz_attr_to_html( $option['attr'] ) . ' type="password" />';
	}

	/**
	 * @param array $option
	 * @param array|null|string $input_value
	 *
	 * @return string
	 *
	 * @internal
	 */
	protected function _get_value_from_input( $option, $input_value ) {
		return (string) ( is_null( $input_value ) ? $option['value'] : $input_value );
	}

	/**
	 * @internal
	 */
	protected function _get_defaults() {
		return array(
			'value' => ''
		);
	}
}

SLZ_Option_Type::register( 'SLZ_Option_Type_Password' );

class SLZ_Option_Type_Textarea extends SLZ_Option_Type {
	public function get_type() {
		return 'textarea';
	}

	/**
	 * @internal
	 * {@inheritdoc}
	 */
	protected function _enqueue_static( $id, $option, $data ) {
	}

	/**
	 * @param string $id
	 * @param array $option
	 * @param array $data
	 *
	 * @return string
	 *
	 * @internal
	 */
	protected function _render( $id, $option, $data ) {
		$option['value'] = (string) $data['value'];

		unset( $option['attr']['value'] ); // be sure to remove value from attributes

		$option['attr'] = array_merge( array( 'rows' => '6' ), $option['attr'] );
		$option['attr']['class'] .= ' code';

		return '<textarea ' . slz_attr_to_html( $option['attr'] ) . '>' .
		       htmlspecialchars( $option['value'], ENT_COMPAT, 'UTF-8' ) .
		       '</textarea>';
	}

	/**
	 * @param array $option
	 * @param array|null|string $input_value
	 *
	 * @return string
	 *
	 * @internal
	 */
	protected function _get_value_from_input( $option, $input_value ) {
		return (string) ( is_null( $input_value ) ? $option['value'] : $input_value );
	}

	/**
	 * @internal
	 */
	protected function _get_defaults() {
		return array(
			'value' => ''
		);
	}
}

SLZ_Option_Type::register( 'SLZ_Option_Type_Textarea' );

class SLZ_Option_Type_Html extends SLZ_Option_Type {
	public function get_type() {
		return 'html';
	}

	/**
	 * @internal
	 * {@inheritdoc}
	 */
	protected function _enqueue_static( $id, $option, $data ) {
	}

	/**
	 * @param string $id
	 * @param array $option
	 * @param array $data
	 *
	 * @return string
	 *
	 * @internal
	 */
	protected function _render( $id, $option, $data ) {
		$option['attr']['value'] = (string) $data['value'];

		$div_attr = $option['attr'];
		unset( $div_attr['name'] );
		unset( $div_attr['value'] );

		return '<div ' . slz_attr_to_html( $div_attr ) . '>' .
		       slz()->backend->option_type( 'hidden' )->render( $id, array(
			       'attr'  => array(
				       'class' => 'slz-option-html-value',
			       ),
			       'value' => $option['attr']['value'],
		       ),
			       array(
				       'id_prefix'   => $data['id_prefix'],
				       'name_prefix' => $data['name_prefix']
			       )
		       ) .
		       '<div class="slz-option-html">' . $option['html'] . '</div>' .
		       '</div>';
	}

	/**
	 * @param array $option
	 * @param array|null|string $input_value
	 *
	 * @return string
	 *
	 * @internal
	 */
	protected function _get_value_from_input( $option, $input_value ) {
		return (string) ( is_null( $input_value ) ? $option['value'] : $input_value );
	}

	/**
	 * @internal
	 */
	public function _get_backend_width_type() {
		return 'auto';
	}

	/**
	 * @internal
	 */
	protected function _get_defaults() {
		return array(
			'value' => '',
			'html'  => '<em>default html</em>',
		);
	}
}

SLZ_Option_Type::register( 'SLZ_Option_Type_Html' );

/**
 * Same html but displayed in fixed width
 */
class SLZ_Option_Type_Html_Fixed extends SLZ_Option_Type_Html {
	public function get_type() {
		return 'html-fixed';
	}

	/**
	 * @internal
	 */
	public function _get_backend_width_type() {
		return 'fixed';
	}
}

SLZ_Option_Type::register( 'SLZ_Option_Type_Html_Fixed' );

/**
 * Same html but displayed in full width
 */
class SLZ_Option_Type_Html_Full extends SLZ_Option_Type_Html {
	public function get_type() {
		return 'html-full';
	}

	/**
	 * @internal
	 */
	public function _get_backend_width_type() {
		return 'full';
	}
}

SLZ_Option_Type::register( 'SLZ_Option_Type_Html_Full' );

class SLZ_Option_Type_Checkbox extends SLZ_Option_Type {
	public function get_type() {
		return 'checkbox';
	}

	/**
	 * @internal
	 * {@inheritdoc}
	 */
	protected function _enqueue_static( $id, $option, $data ) {
	}

	/**
	 * @param string $id
	 * @param array $option
	 * @param array $data
	 *
	 * @return string
	 *
	 * @internal
	 */
	protected function _render( $id, $option, $data ) {
		if (
			defined('DOING_AJAX') && DOING_AJAX
			&&
			is_string($data['value'])
			&&
			in_array($data['value'], array('false', 'true'))
		) {
			/**
			 * This happens on slz.OptionsModal open/render
			 * When the checkbox is used by other option types
			 * then this script http://bit.ly/1QshDoS can't fix nested values
			 *
			 * Check if values is 'true' or 'false' then transform/fix it to boolean
			 */
			if ($data['value'] === 'true') {
				$data['value'] = true;
			} else {
				$data['value'] = false;
			}
		}

		$option['value'] = (bool) $data['value'];

		unset( $option['attr']['value'] );

		return ''.
			'<input type="checkbox" name="' . esc_attr( $option['attr']['name'] ) . '" value="" checked="checked" style="display: none">' .
			'<!-- used for "' . esc_attr( $id ) . '" to be present in _POST -->' .
			'' .
			'<label for="' . esc_attr( $option['attr']['id'] ) . '">' .
				'<input ' . slz_attr_to_html( $option['attr'] ) . ' type="checkbox" value="true" ' .
					( $option['value'] ? 'checked="checked" ' : '' ) .
				'> ' . htmlspecialchars( $option['text'], ENT_COMPAT, 'UTF-8' ) .
			'</label>';
	}

	/**
	 * @param array $option
	 * @param array|null|string $input_value
	 *
	 * @return bool
	 *
	 * @internal
	 */
	protected function _get_value_from_input( $option, $input_value ) {
		return (bool) ( is_null( $input_value ) ? $option['value'] : $input_value );
	}

	/**
	 * @internal
	 */
	public function _get_backend_width_type() {
		return 'auto';
	}

	/**
	 * @internal
	 */
	protected function _get_defaults() {
		return array(
			'value' => false,
			'text'  => __( 'Yes', 'slz' ),
		);
	}
}

SLZ_Option_Type::register( 'SLZ_Option_Type_Checkbox' );

/**
 * Checkboxes list
 */
class SLZ_Option_Type_Checkboxes extends SLZ_Option_Type {
	public function get_type() {
		return 'checkboxes';
	}

	/**
	 * @internal
	 * {@inheritdoc}
	 */
	protected function _enqueue_static( $id, $option, $data ) {
	}

	/**
	 * @param string $id
	 * @param array $option
	 * @param array $data
	 *
	 * @return string
	 *
	 * @internal
	 */
	protected function _render( $id, $option, $data ) {
		$option['value'] = is_array( $data['value'] ) ? $data['value'] : array();

		$div_attr = $option['attr'];
		unset( $div_attr['name'] );
		unset( $div_attr['value'] );

		if ( $option['inline'] ) {
			$div_attr['class'] .= ' slz-option-type-checkboxes-inline slz-clearfix';
		}

		$html = '<div ' . slz_attr_to_html( $div_attr ) . '>';

		$html .= '<input type="checkbox" name="' . esc_attr( $option['attr']['name'] ) . '[]" value="" checked="checked" style="display: none">' .
		         '<!-- used for "' . esc_attr( $id ) . '" to be present in _POST -->';

		foreach ( $option['choices'] as $value => $choice ) {
			if (is_string($choice)) {
				$choice = array(
					'text' => $choice,
					'attr' => array(),
				);
			}

			$choice['attr'] = array_merge(
				isset($choice['attr']) ? $choice['attr'] : array(),
				array(
					'type' => 'checkbox',
					'name' => $option['attr']['name'] . '[' . $value . ']',
					'value' => 'true',
					'id' => $option['attr']['id'] . '-' . $value,
				),
				isset( $option['value'][ $value ] ) && $option['value'][ $value ]
					? array('checked' => 'checked') : array()
			);

			$html .=
				'<div>' .
					'<label for="' . esc_attr( $choice['attr']['id'] ) . '">' .
						'<input  ' . slz_attr_to_html($choice['attr']) . '>' .
						' ' . htmlspecialchars( $choice['text'], ENT_COMPAT, 'UTF-8' ) .
					'</label>' .
				'</div>';
		}

		$html .= '</div>';

		return $html;
	}

	/**
	 * @param array $option
	 * @param array|null|string $input_value
	 *
	 * @return array
	 *
	 * @internal
	 */
	protected function _get_value_from_input( $option, $input_value ) {
		if ( is_array( $input_value ) ) {
			$value = array();

			foreach ( $input_value as $choice => $val ) {
				if ( $val === '' ) {
					continue;
				}

				if ( ! isset( $option['choices'][ $choice ] ) ) {
					continue;
				}

				$value[ $choice ] = true;
			}
		} else {
			$value = $option['value'];
		}

		return $value;
	}

	/**
	 * @internal
	 */
	public function _get_backend_width_type() {
		return 'auto';
	}

	/**
	 * @internal
	 */
	protected function _get_defaults() {
		return array(
			'inline'  => false, // Set this parameter to true in case you want all checkbox inputs to be rendered inline
			'value'   => array(
				// 'choice_id' => bool
			),
			/**
			 * Avoid bool or int keys http://bit.ly/1cQgVzk
			 */
			'choices' => array(
				// 'choice_id' => 'Choice Label'
			),
		);
	}
}

SLZ_Option_Type::register( 'SLZ_Option_Type_Checkboxes' );

/**
 * Radio list
 */
class SLZ_Option_Type_Radio extends SLZ_Option_Type {
	public function get_type() {
		return 'radio';
	}

	/**
	 * @internal
	 * {@inheritdoc}
	 */
	protected function _enqueue_static( $id, $option, $data ) {
	}

	/**
	 * @param string $id
	 * @param array $option
	 * @param array $data
	 *
	 * @return string
	 *
	 * @internal
	 */
	protected function _render( $id, $option, $data ) {
		$option['value'] = (string) $data['value'];

		$div_attr = $option['attr'];
		unset( $div_attr['name'] );
		unset( $div_attr['value'] );

		if ( $option['inline'] ) {
			$div_attr['class'] .= ' slz-option-type-radio-inline slz-clearfix';
		}

		$html = '<div ' . slz_attr_to_html( $div_attr ) . '>';

		foreach ( $option['choices'] as $value => $choice ) {
			if (is_string($choice)) {
				$choice = array(
					'text' => $choice,
					'attr' => array(),
				);
			}

			$choice['attr'] = array_merge(
				isset($choice['attr']) ? $choice['attr'] : array(),
				array(
					'type' => 'radio',
					'name' => $option['attr']['name'],
					'value' => $value,
					'id' => $option['attr']['id'] . '-' . $value,
				),
				$option['value'] == $value ? array('checked' => 'checked') : array()
			);

			$html .=
			'<div>' .
				'<label for="' . esc_attr( $choice['attr']['id'] ) . '">' .
					'<input  ' . slz_attr_to_html($choice['attr']) . '>' .
					' ' . htmlspecialchars( $choice['text'], ENT_COMPAT, 'UTF-8' ) .
				'</label>' .
			'</div>';
		}

		$html .= '</div>';

		return $html;
	}

	/**
	 * @param array $option
	 * @param array|null|string $input_value
	 *
	 * @return string
	 *
	 * @internal
	 */
	protected function _get_value_from_input( $option, $input_value ) {
		if ( ! isset( $option['choices'][ $input_value ] ) ) {
			if (
				empty( $option['choices'] ) ||
				isset( $option['choices'][ $option['value'] ] )
			) {
				$input_value = $option['value'];
			} else {
				reset( $option['choices'] );
				$input_value = key( $option['choices'] );
			}
		}

		return (string) $input_value;
	}

	/**
	 * @internal
	 */
	public function _get_backend_width_type() {
		return 'auto';
	}

	/**
	 * @internal
	 */
	protected function _get_defaults() {
		return array(
			'inline'  => false, // Set this parameter to true in case you want all radio inputs to be rendered inline
			'value'   => '', // 'choice_id'
			/**
			 * Avoid bool or int keys http://bit.ly/1cQgVzk
			 */
			'choices' => array(
				// 'choice_id' => 'Choice Label'
			)
		);
	}
}

SLZ_Option_Type::register( 'SLZ_Option_Type_Radio' );

/**
 * Select
 */
class SLZ_Option_Type_Select extends SLZ_Option_Type {
	public function get_type() {
		return 'select';
	}

	/**
	 * @internal
	 * {@inheritdoc}
	 */
	protected function _enqueue_static( $id, $option, $data ) {
	}

	/**
	 * @param string $id
	 * @param array $option
	 * @param array $data
	 *
	 * @return string
	 *
	 * @internal
	 */
	protected function _render( $id, $option, $data ) {
		$option['value'] = $data['value'];

		if ( !isset ( $option['attr']['data-saved-value'] ) )
			$option['attr']['data-saved-value'] = $data['value'];
		
		$option['value'] = $option['attr']['data-saved-value'];

		unset(
			$option['attr']['value'],
			$option['attr']['multiple']
		);

		if ( ! isset( $option['choices'] ) ) {
			$option['choices'] = array();
		}

		$html = '<select ' . slz_attr_to_html( $option['attr'] ) . '>' .
		        $this->render_choices( $option['choices'], $option['value'] ) .
		        '</select>';

		return $html;
	}

	/**
	 * @param array $option
	 * @param array|null|string $input_value
	 *
	 * @return string
	 *
	 * @internal
	 */
	protected function _get_value_from_input( $option, $input_value ) {
		if ( is_null( $input_value ) ) {
			return $option['value'];
		}

		if ( empty( $option['no-validate'] ) ) {
			$all_choices = $this->get_choices( $option['choices'] );

			if ( ! isset( $all_choices[ $input_value ] ) ) {
				if (
					empty( $all_choices ) ||
					isset( $all_choices[ $option['value'] ] )
				) {
					$input_value = $option['value'];
				} else {
					reset( $all_choices );
					$input_value = key( $all_choices );
				}
			}

			unset( $all_choices );
		}

		return (string) $input_value;
	}

	/**
	 * Extract recursive from optgroups all choices as one level array
	 *
	 * @param array|null $choices
	 *
	 * @return array
	 *
	 * @internal
	 */
	protected function get_choices( $choices ) {
		$result = array();

		foreach ( $choices as $cid => $choice ) {
			if ( is_array( $choice ) && isset( $choice['choices'] ) ) {
				// optgroup
				$result += $this->get_choices( $choice['choices'] );
			} else {
				$result[ $cid ] = $choice;
			}
		}

		return $result;
	}

	protected function render_choices( &$choices, &$value ) {
		if ( empty( $choices ) || ! is_array( $choices ) ) {
			return '';
		}

		$html = '';

		foreach ( $choices as $c_value => $choice ) {
			if ( is_array( $choice ) ) {
				if ( ! isset( $choice['attr'] ) ) {
					$choice['attr'] = array();
				}

				if ( isset( $choice['choices'] ) ) { // optgroup
					$html .= '<optgroup ' . slz_attr_to_html( $choice['attr'] ) . '>' .
					         $this->render_choices( $choice['choices'], $value ) .
					         '</optgroup>';
				} else { // choice as array (with custom attributes)
					$choice['attr']['value'] = $c_value;

					unset( $choice['attr']['selected'] ); // this is not allowed

					$html .= '<option ' . slz_attr_to_html( $choice['attr'] ) . ' ' .
					         ( $c_value == $value ? 'selected="selected" ' : '' ) . '>' .
					         htmlspecialchars( isset( $choice['text'] ) ? $choice['text'] : '', ENT_COMPAT, 'UTF-8' ) .
					         '</option>';
				}
			} else { // simple choice
				$html .= '<option value="' . esc_attr( $c_value ) . '" ' .
				         ( $c_value == $value ? 'selected="selected" ' : '' ) . '>' .
				         htmlspecialchars( $choice, ENT_COMPAT, 'UTF-8' ) .
				         '</option>';
			}
		}

		return $html;
	}

	/**
	 * @internal
	 */
	protected function _get_defaults() {
		return array(
			'value'   => '',
			'choices' => array()
		);
	}
}

SLZ_Option_Type::register( 'SLZ_Option_Type_Select' );

class SLZ_Option_Type_Short_Select extends SLZ_Option_Type_Select {
	public function get_type() {
		return 'short-select';
	}

	/**
	 * @param string $id
	 * @param array $option
	 * @param array $data
	 *
	 * @return string
	 *
	 * @internal
	 */
	protected function _render( $id, $option, $data ) {
		$option['attr']['class'] .= ' slz-option-width-short';

		return parent::_render( $id, $option, $data );
	}

	/**
	 * {@inheritdoc}
	 * @internal
	 */
	public function _get_backend_width_type() {
		return 'auto';
	}
}

SLZ_Option_Type::register( 'SLZ_Option_Type_Short_Select' );

/**
 * Select Multiple
 */
class SLZ_Option_Type_Select_Multiple extends SLZ_Option_Type_Select {
	public function get_type() {
		return 'select-multiple';
	}

	/**
	 * @internal
	 * {@inheritdoc}
	 */
	protected function _enqueue_static( $id, $option, $data ) {
	}

	/**
	 * @param string $id
	 * @param array $option
	 * @param array $data
	 *
	 * @return string
	 *
	 * @internal
	 */
	protected function _render( $id, $option, $data ) {
		$option['value'] = $data['value'];

		unset( $option['attr']['value'] );

		$html = '<input type="hidden" name="' . $option['attr']['name'] . '" value="">';

		$option['attr']['name'] .= '[]';
		$option['attr']['multiple'] = 'multiple';

		if ( ! isset( $option['attr']['size'] ) ) {
			$option['attr']['size'] = '7';
		}

		$html .= '<select ' . slz_attr_to_html( $option['attr'] ) . '>' .
		         $this->render_choices( $option['choices'], $option['value'] ) .
		         '</select>';

		return $html;
	}

	/**
	 * @param array $option
	 * @param array|null|string $input_value
	 *
	 * @return array|null|string
	 *
	 * @internal
	 */
	protected function _get_value_from_input( $option, $input_value ) {
		if ( is_null( $input_value ) ) {
			$input_value = $option['value'];
		}

		if ( ! is_array( $input_value ) ) {
			$input_value = array();
		}

		if ( empty( $option['no-validate'] ) ) {
			$all_choices = $this->get_choices( $option['choices'] );

			foreach ( $input_value as $key => $value ) {
				if ( ! isset( $all_choices[ $value ] ) ) {
					unset( $input_value[ $key ] );
				}
			}

			unset( $all_choices );
		}

		return $input_value;
	}

	protected function render_choices( &$choices, &$value ) {
		if ( empty( $choices ) || ! is_array( $choices ) ) {
			return '';
		}

		$html = '';

		foreach ( $choices as $c_value => $choice ) {
			if ( is_array( $choice ) ) {
				if ( ! isset( $choice['attr'] ) ) {
					$choice['attr'] = array();
				}

				if ( isset( $choice['choices'] ) ) { // optgroup
					$html .= '<optgroup ' . slz_attr_to_html( $choice['attr'] ) . '>' .
					         $this->render_choices( $choice['choices'], $value ) .
					         '</optgroup>';
				} else { // choice as array (with custom attributes)
					$choice['attr']['value'] = $c_value;

					unset( $choice['attr']['selected'] ); // this is not allowed

					$html .= '<option ' . slz_attr_to_html( $choice['attr'] ) . ' ' .
					         ( in_array( $c_value, $value ) ? 'selected="selected" ' : '' ) . '>' .
					         htmlspecialchars( isset( $choice['text'] ) ? $choice['text'] : '', ENT_COMPAT, 'UTF-8' ) .
					         '</option>';
				}
			} else { // simple choice
				$html .= '<option value="' . esc_attr( $c_value ) . '" ' .
				         ( in_array( $c_value, $value ) ? 'selected="selected" ' : '' ) . '>' .
				         htmlspecialchars( $choice, ENT_COMPAT, 'UTF-8' ) .
				         '</option>';
			}
		}

		return $html;
	}

	/**
	 * @internal
	 */
	protected function _get_defaults() {
		return array(
			'value'   => array(),
			'choices' => array()
		);
	}
}

SLZ_Option_Type::register( 'SLZ_Option_Type_Select_Multiple' );


class SLZ_Option_Type_Unique extends SLZ_Option_Type
{
	private static $ids = array();
	private static $should_do_regeneration = true;

	public function get_type()
	{
		return 'unique';
	}

	protected function _get_defaults()
	{
		return array(
			'value' => '',
			'length' => 0, // Limit id length
		);
	}

	protected function _render($id, $option, $data) {
		return slz_html_tag('input', array(
			'type' => 'hidden',
			'name' => $option['attr']['name'],
			'id' => $option['attr']['id'],
			'value' => $data['value'],
		));
	}

	protected function _init() {
		add_action('save_post', array($this, '_action_reset_post_ids'), 8);
		add_filter('slz:option-type:addable-popup:value-from-input', array($this, '_filter_addable_popup_value_from_input'), 10, 2);
	}

	/**
	 * @param null|int $length_limit
	 * @return string
	 */
	protected function generate_id($length_limit = null)
	{
		$id = slz_rand_md5();

		if ($length_limit) {
			$id = substr($id, 0, (int)$length_limit);
		}

		return $id;
	}

	/**
	 * After the post has been saved
	 * other scripts may call wp_update_post() and the save will start again
	 * If the unique ids array will not be reset, on the next save
	 * the previously processed ids will all be detected as duplicate and will be regenerated
	 *
	 * @param $post_id
	 * @internal
	 */
	public function _action_reset_post_ids($post_id)
	{
		if ( wp_is_post_autosave( $post_id ) ) {
			$original_id = wp_is_post_autosave( $post_id );
		} else if ( wp_is_post_revision( $post_id ) ) {
			$original_id = wp_is_post_revision( $post_id );
		} else {
			$original_id = $post_id;
		}

		self::$ids[$post_id] = array();
		self::$ids[$original_id] = array();
	}

	public function set_should_do_regeneration($new) {
		self::$should_do_regeneration = $new;
	}

	protected function _get_value_from_input($option, $input_value) {
		if (is_null($input_value)) {
			$id = empty($option['value']) ? $this->generate_id($option['length']) : $option['value'];
		} else {
			$id = $input_value;
		}

		if (empty($id) || !is_string($id)) {
			$id = $this->generate_id($option['length']);
		}

		/**
		 * Regenerate if found the same id again
		 *
		 * Sometimes you don't need to to regeneration of ids.
		 * You can use set_should_do_regeneration() method in order to skip
		 * this step. You really should use this hook only if you know what
		 * you're doing. You can really break some things around without
		 * proper care.
		 */
		if (self::$should_do_regeneration) {
			global $post;

			if ($post) {
				$post_id = $post->ID;
			} else {
				$post_id = '~';
			}

			if (!isset(self::$ids[$post_id])) {
				self::$ids[$post_id] = array();
			}

			while (isset(self::$ids[$post_id][$id])) {
				$id = $this->generate_id($option['length']);
			}

			self::$ids[$post_id][$id] = true;
		}

		return $id;
	}

	/**
	 * Make sure there are no duplicate ids
	 *
	 * @param array $value
	 * @param array $option
	 *
	 * @return array
	 */
	public function _filter_addable_popup_value_from_input($value, $option) {
		/**
		 * Extract only options type 'unique'
		 */
		{
			$update_options = array();

			slz_collect_options($update_options, $option['popup-options'], array(
				'limit_option_types' => array($this->get_type())
			));

			if (empty($update_options)) {
				return $value;
			}
		}

		foreach ($value as &$row) {
			foreach ($update_options as $opt_id => $opt) {
				if (isset($row[$opt_id])) { // should not happen, but just in case, prevent notice
					$row[$opt_id] = slz()->backend->option_type($opt['type'])->get_value_from_input(
						array_merge($opt, array('value' => $row[$opt_id])),
						null
					);
				}
			}
		}

		return $value;
	}
}
SLZ_Option_Type::register('SLZ_Option_Type_Unique');

/**
 * Input for Google Maps API Key which is stored in a wp_option
 * @since 2.5.7
 */
class SLZ_Option_Type_GMap_Key extends SLZ_Option_Type_Text {

	private static $original_value = null;

	/**
	 * Returns wp_options key where the key is stored
	 *
	 * @return string
	 */
	public static function get_key_option_id() {
		return 'slz-option-types:gmap-key';
	}

	public static function get_key() {
		return (string) get_option( self::get_key_option_id() );
	}

	public function _init() {
		if ( is_null( self::$original_value ) ) {
			self::$original_value = self::get_key();
		}
	}

	public function get_type() {
		return 'gmap-key';
	}

	/**
	 * @internal
	 */
	protected function _get_defaults() {
		return array(
			'value'      => self::get_key(),
			'slz-storage' => array(
				'type'      => 'wp-option',
				'wp-option' => self::get_key_option_id(),
			),
		);
	}

	/**
	 * Restrict option save if the option value is same as the one in the database
	 * @inheritdoc
	 */
	protected function _storage_save( $id, array $option, $value, array $params ) {
		if ( $value == self::$original_value ) {
			return $value;
		}
		return parent::_storage_save( $id, $option, $value, $params );
	}
}

SLZ_Option_Type::register( 'SLZ_Option_Type_GMap_Key' );
