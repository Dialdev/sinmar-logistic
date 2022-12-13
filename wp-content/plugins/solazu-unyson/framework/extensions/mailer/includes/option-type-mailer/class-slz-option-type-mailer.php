<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

class SLZ_Option_Type_Mailer extends SLZ_Option_Type {

	/**
	 * @internal
	 */
	public function _init() {
		add_action('wp_ajax_slz_ext_mailer_test_connection', array($this, '_action_ajax_test_connection'));
	}

	public function get_type() {
		return 'mailer';
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
			'label' => false,
			'value' => array(),
			'slz-storage' => array(
				'type' => 'wp-option',
				'wp-option' => 'slz_ext_settings_options:mailer',
			),
		);
	}

	private function get_inner_options() {
		$methods_choices = array();
		$methods_options = array();

		foreach (slz_ext('mailer')->get_send_methods() as $method) {
			/**
			 * @var SLZ_Ext_Mailer_Send_Method $method
			 */

			$methods_choices[ $method->get_id() ] = $method->get_title();

			$settings_options = $method->get_settings_options();

			if (!empty($settings_options)) {
				$methods_options['method-' . $method->get_id()] = array(
					'type' => 'group',
					'attr' => array(
						'data-method' => $method->get_id()
					),
					'options' => array(
						$method->get_id() => array(
							'label' => false,
							'desc' => false,
							'type' => 'multi',
							'inner-options' => $settings_options,
						),
					)
				);
			}
		}
		unset($settings_options);

		return array(
			'method'  => array(
				'label'   => __( 'Send Method', 'slz' ),
				'desc'    => __( 'Select the send form method', 'slz' ),
				'type'    => 'short-select',
				'attr'    => array(
					'data-select-method' => '~'
				),
				'choices' => $methods_choices
			),
			$methods_options,
			'general' => array(
				'label'         => false,
				'desc'          => false,
				'type'          => 'multi',
				'inner-options' => array(
					'from-group' => array(
						'type' => 'group',
						'options' => array(
							'from_name'    => array(
								'label' => __( 'From Name', 'slz' ),
								'desc'  => __( "The name you'll see in the From filed in your email client.", 'slz' ),
								'type'  => 'text',
								'value' => '',
							),
						)
					),
					'from_address' => array(
						'label' => __( 'From Address', 'slz' ),
						'desc'  => __( 'The form will look like was sent from this email address.', 'slz' ),
						'type'  => 'text',
						'value' => '',
					)
				),
			),
			'test-connection' => array(
				'label'         => false,
				'desc'          => false,
				'type'          => 'multi',
				'inner-options' => array(
					'test-connection' => array(
						'type' => 'html-fixed',
						'attr' => array(
							'class' => 'test-connection-wrapper'
						),
						'html' =>
							'<div class="test-connection">'.
							/**/'<div>'.
							/**//**/'<div>'.
							/**//**//**/'<input type="email" placeholder="'. esc_attr__('Test email destination', 'slz') .'" style="width:100%;">'.
							/**//**/'</div>'.
							/**//**/'<div>'.
							/**//**//**/'<button class="button" type="button">'. esc_html__('Send a test email', 'slz') .'</button>'.
							/**//**/'</div>'.
							/**/'</div>'.
							'</div>'
					),
				),
			),
		);
	}

	/**
	 * @internal
	 * {@inheritdoc}
	 */
	protected function _enqueue_static( $id, $option, $data ) {
		wp_enqueue_style(
			$this->get_type() . '-scripts',
			slz_ext( 'mailer' )->get_uri() . '/includes/option-type-mailer/static/css/style.css'
		);

		wp_enqueue_script(
			$this->get_type() . '-scripts',
			slz_ext( 'mailer' )->get_uri() . '/includes/option-type-mailer/static/js/scripts.js',
			array( 'slz-events' ),
			slz()->manifest->get_version(), true
		);
	}

	/**
	 * @internal
	 */
	protected function _render( $id, $option, $data ) {
		if (empty($data['value'])) {
			$data['value'] = slz_db_option_storage_load($id, $option, $data['value']);
		}

		$wrapper_attr = $option['attr'];
		unset($wrapper_attr['name'], $wrapper_attr['value']);

		return
		'<div '. slz_attr_to_html($wrapper_attr) .'>'.
			slz()->backend->option_type( 'multi' )->render( $id, array(
				'inner-options' => $this->get_inner_options(),
			), $data ) .
		'</div>';
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
		return (is_array( $input_value ) && ! empty( $input_value ))
			? slz_get_options_values_from_input($this->get_inner_options(), $input_value)
			: $option['value'];
	}

	/**
	 * @internal
	 */
	public function _action_ajax_test_connection() {
		if (!current_user_can('manage_options')) {
			return wp_send_json_error(new WP_Error('forbidden', __('Forbidden', 'slz')));
		} elseif (!is_email($to = SLZ_Request::POST('to'))) {
			return wp_send_json_error(new WP_Error('forbidden', __('Invalid email', 'slz')));
		} elseif (!is_array($settings = SLZ_Request::POST('settings'))) {
			return wp_send_json_error(new WP_Error('forbidden', __('Invalid settings', 'slz')));
		}

		/** @var SLZ_Extension_Mailer $ext */
		$ext = slz_ext('mailer');

		$result = $ext->send(
			$to,
			__('Test Subject', 'slz'),
			'<strong>'. __('Test Message', 'slz') .'</strong>',
			array(),
			slz_get_options_values_from_input($this->get_inner_options(), $settings)
		);

		if ($result['status']) {
			wp_send_json_success();
		} else {
			wp_send_json_error(new WP_Error('fail', $result['message']));
		}
	}
}

SLZ_Option_Type::register( 'SLZ_Option_Type_Mailer' );
