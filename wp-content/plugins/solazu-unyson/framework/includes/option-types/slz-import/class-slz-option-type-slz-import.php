<?php

class SLZ_Option_Type_Slz_Import extends SLZ_Option_Type {
	private $option_type = 'slz-import';

	public function get_type() {
		return $this->option_type;
	}

	/**
	 * @internal
	 */
	protected function _enqueue_static( $id, $option, $data ) {

		$uri = slz_get_framework_directory_uri('/includes/option-types/'. $this->get_type() .'/static');

		wp_enqueue_style(
			'slz-option-' . $this->get_type(),
			$uri . '/css/styles.css'
		);

		wp_enqueue_script(
			'slz-option-' . $this->get_type(),
			$uri . '/js/scripts.js',
			array( 'slz' ),
			'',
			true
		);

		wp_localize_script(
			'slz-option-' . $this->get_type(),
			'slzAjaxUrl',
			admin_url( 'admin-ajax.php', 'relative' )
		);

		wp_localize_script(
			'slz-option-' . $this->get_type(),
			'slz_import_id',
			$id
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

		return slz_render_view( dirname(__FILE__) . '/view.php', array(
			'import' 		=> $this,
			'id'            => $id,
			'option'        => $option,
			'data'          => $data,
			'defaults'      => $this->get_defaults()
		) );

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

	/**
	 * @internal
	 */
	public static function _action_ajax_options_import(){

		if ( empty( $_POST['type'] ) || empty ( $_POST['data'] ) ) {
			wp_send_json_error( 
				array(
					'message' => 'Invalid input data for import options'
				)
			);
			exit;
		}

		$data = $_POST['data'];

		if ( $_POST['type'] == 'url' ) {

			$args = array(
			    'timeout'     => 5,
			    'redirection' => 5,
			    'httpversion' => '1.0',
			    'user-agent'  => 'WordPress/' . $wp_version . '; ' . home_url(),
			    'blocking'    => true,
			    'headers'     => array(),
			    'cookies'     => array(),
			    'body'        => null,
			    'compress'    => false,
			    'decompress'  => true,
			    'sslverify'   => true,
			    'stream'      => false,
			    'filename'    => null
			);

			$data = wp_remote_get( $data, $args );

			$data = wp_remote_retrieve_body( $data );

		}

		try {

			if ( base64_decode( $data, true ) != false ) {

				$data = base64_decode( $data );

				$data = json_decode( $data, true );

				if ( !empty ( $data ) && json_last_error() == JSON_ERROR_NONE ) {

					update_option( 'slz_theme_settings_options:'. slz()->theme->manifest->get_id(), $data );

					wp_send_json_success( 
						array(
							'values' => 'import successfully'
						)
					);

					exit;

				}

			}

		} catch (Exception $e) {
			
		}

		wp_send_json_error( 
			array(
				'message' => 'Invalid input data for import options'
			)
		);
		exit;
	}
}

add_action('wp_ajax_slz_backend_options_import', array('SLZ_Option_Type_Slz_Import', '_action_ajax_options_import'));
add_action('wp_ajax_nopriv_slz_backend_options_import', array('SLZ_Option_Type_Slz_Import', '_action_ajax_options_import'));

SLZ_Option_Type::register( 'SLZ_Option_Type_Slz_Import' );