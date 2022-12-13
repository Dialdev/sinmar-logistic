<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

class SLZ_Option_Type_Recaptcha extends SLZ_Option_Type {

	/**
	 * @internal
	 */
	public function _init() {
	}

	public function get_type() {
		return 'recaptcha';
	}

	private function get_uri( $append = '' ) {
		return slz_get_framework_directory_uri( '/extensions/forms/includes/option-types/form-builder/items/recaptcha/includes/option-type-recaptcha' . $append );
	}

	/**
	 * @internal
	 */
	public function _get_backend_width_type() {
		return 'full';
	}

	/**
	 * @internal
	 */
	protected function _get_defaults() {
		return array(
			'label'         => false,
			'type'          => 'multi',
			'inner-options' => array(
				'site-key'    => array(
					'label' => __( 'Site key', 'slz' ),
					'desc'  => __( 'Your website key. More on how to configure ReCaptcha', 'slz' ) . ': <a href="https://www.google.com/recaptcha" target="_blank">https://www.google.com/recaptcha</a>',
					'type'  => 'text'
				),
				'secret-key'    => array(
					'label' => __( 'Secret key', 'slz' ),
					'desc'  => __( 'Your secret key. More on how to configure ReCaptcha', 'slz' ) . ': <a href="https://www.google.com/recaptcha" target="_blank">https://www.google.com/recaptcha</a>',
					'type'  => 'text'
				),
			),
			'value'         => array()
		);
	}

	/**
	 * @internal
	 * {@inheritdoc}
	 */
	protected function _enqueue_static( $id, $option, $data ) {
		wp_enqueue_style(
			'slz-option-type-'. $this->get_type(),
			$this->get_uri( '/static/css/styles.css' )
		);
	}

	/**
	 * @internal
	 */
	protected function _render( $id, $option, $data ) {
		$data['value'] = slz_ext( 'forms' )->get_db_settings_option('recaptcha-keys');

		return slz()->backend->option_type( 'multi' )->render( $id, $option, $data );
	}

	/**
	 * @internal
	 *
	 * @param array $option
	 * @param array|null|string $input_value
	 *
	 * @return array|bool|int|string
	 */
	protected function _get_value_from_input( $option, $input_value ) {

		if ( is_array( $input_value ) && ! empty( $input_value ) ) {
			slz_ext( 'forms' )->set_db_settings_option( 'recaptcha-keys', $input_value );
		}

		return slz_ext( 'forms' )->get_db_settings_option('recaptcha-keys', array());
	}
}

SLZ_Option_Type::register( 'SLZ_Option_Type_Recaptcha' );