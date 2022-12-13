<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

class SLZ_Option_Type_Oembed extends SLZ_Option_Type {

	/**
	 * Option's unique type, used in option array in 'type' key
	 * @return string
	 */
	public function get_type() {
		return 'oembed';
	}

	/**
	 * Generate html
	 *
	 * @param string $id
	 * @param array $option Option array merged with _get_defaults()
	 * @param array $data {value => _get_value_from_input(), id_prefix => ..., name_prefix => ...}
	 *
	 * @return string HTML
	 * @internal
	 */
	protected function _render( $id, $option, $data ) {

		$defaults                   = $this->_get_defaults();
		$option['preview']          = array_merge( $defaults['preview'], $option['preview'] );
		$option['attr']             =array_merge($defaults['attr'], $option['attr']);

		return slz_render_view(
			slz_get_framework_directory( '/includes/option-types/' . $this->get_type() . '/view.php' ),
			compact( 'id', 'option', 'data' )
		);
	}

	/**
	 * Extract correct value for $option['value'] from input array
	 * If input value is empty, will be returned $option['value']
	 *
	 * @param array $option Option array merged with _get_defaults()
	 * @param array|string|null $input_value
	 *
	 * @return string|array|int|bool Correct value
	 * @internal
	 */
	protected function _get_value_from_input( $option, $input_value ) {
		return (string) ( is_null( $input_value ) ? $option['value'] : $input_value );
	}

	/**
	 * Default option array
	 *
	 * This makes possible an option array to have required only one parameter: array('type' => '...')
	 * Other parameters are merged with the array returned by this method.
	 *
	 * @return array
	 *
	 * array(
	 *     'value' => '',
	 *     ...
	 * )
	 * @internal
	 */
	protected function _get_defaults() {
		return array(
			'value'   => '',
			'attr' => array(
				'placeholder' => 'https://www.youtube.com'
			),
			'preview' => array(
				'width'      => 428,
				'height'     => 320,
				/**
				 * by default wp_get_embed maintain ratio and return changed width and height values of the iframe,
				 * if you set it to false , the dimensions will be forced to change as in preview.width and preview.height
				 */
				'keep_ratio' => true
			)
		);
	}

	protected function _enqueue_static( $id, $option, $data ) {
		wp_enqueue_style(
			'slz-option-' . $this->get_type(),
			slz_get_framework_directory_uri( '/includes/option-types/' . $this->get_type() . '/static/css/styles.css' ),
			array( 'slz' )
		);

		wp_enqueue_script(
			'slz-option-' . $this->get_type(),
			slz_get_framework_directory_uri( '/includes/option-types/' . $this->get_type() . '/static/js/' . $this->get_type() . '.js' ),
			array( 'underscore', 'slz-events', 'slz', 'wp-util' ),
			false,
			true
		);
	}

	public static function _action_get_oembed_response() {

		if ( wp_verify_nonce( SLZ_Request::POST( '_nonce' ), '_action_get_oembed_response' ) ) {

			$url        = SLZ_Request::POST( 'url' );
			$width      = SLZ_Request::POST( 'preview/width' );
			$height     = SLZ_Request::POST( 'preview/height' );
			$keep_ratio = ( SLZ_Request::POST( 'preview/keep_ratio' ) === 'true' );

			$iframe = empty( $keep_ratio ) ?
				slz_oembed_get( $url, compact( 'width', 'height' ) ) :
				wp_oembed_get( $url, compact( 'width', 'height' ) );

			wp_send_json_success( array( 'response' => $iframe ) );
		}

		wp_send_json_error( array( 'message' => 'Invalid nonce' ) );
	}
}

SLZ_Option_Type::register( 'SLZ_Option_Type_Oembed' );

add_action(
	'wp_ajax_get_oembed_response',
	array( "SLZ_Option_Type_Oembed", '_action_get_oembed_response' )
);
