<?php

class SLZ_Option_Type_Code_Editor extends SLZ_Option_Type {
	private $option_type = 'code-editor';

	public function get_type() {
		return $this->option_type;
	}

	/**
	 * @internal
	 */
	protected function _enqueue_static( $id, $option, $data ) {
		$uri = slz_get_framework_directory_uri('/includes/option-types/'. $this->get_type() .'/static');

		wp_enqueue_script(
			'slz-option-' . $this->get_type() . '-ace-editor',
			$uri . '/libs/ace/ace.js',
			array(),
			'',
			true
		);

		wp_enqueue_script(
			'slz-option-' . $this->get_type(),
			$uri . '/js/scripts.js',
			array( 'slz-option-' . $this->get_type() . '-ace-editor' ),
			'',
			true
		);
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
		$out = '';

		$option['value'] = (string) $data['value'];

		unset( $option['attr']['value'] ); // be sure to remove value from attributes

		$option['attr'] = array_merge( array( 'rows' => '6' ), $option['attr'] );
		$option['attr']['class'] .= ' code code-editor slz-hidden';

		if ( !empty ( $option['mode'] ) )
			$option['attr']['data-mode'] = $option['mode'];

		if ( !empty ( $option['theme'] ) )
			$option['attr']['data-theme'] = $option['theme'];

		if ( !empty ( $option['min-line'] ) )
			$option['attr']['data-min-line'] = $option['min-line'];

		if ( !empty ( $option['max-line'] ) )
			$option['attr']['data-max-line'] = $option['max-line'];

		$unique_id = SLZ_Com::make_id();
		$option['attr']['data-editor'] = 'data-editor-' . $unique_id;

		$out .= '<textarea ' . slz_attr_to_html( $option['attr'] ) . '>' .
			   htmlspecialchars( $option['value'], ENT_COMPAT, 'UTF-8' ) .
			   '</textarea>';

	   $out .= '<textarea id="' . $option['attr']['data-editor'] . '" rows="10">' .
			   htmlspecialchars( $option['value'], ENT_COMPAT, 'UTF-8' ) .
			   '</textarea>';

	   return $out;

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

SLZ_Option_Type::register( 'SLZ_Option_Type_Code_Editor' );