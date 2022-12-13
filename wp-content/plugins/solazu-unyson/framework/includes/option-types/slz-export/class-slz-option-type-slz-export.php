<?php

class SLZ_Option_Type_Slz_Export extends SLZ_Option_Type {
	private $option_type = 'slz-export';

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
			'slz_export_id',
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

		$secret = md5( md5( AUTH_KEY . SECURE_AUTH_KEY ) . '-' . slz()->theme->manifest->get_id() );
		
		$export_data = SLZ_WP_Option::get( 'slz_theme_settings_options:'. slz()->theme->manifest->get_id() );

		$export_data = json_encode( $export_data );

		$export_data = base64_encode( $export_data );

		$export_url = admin_url( 'admin-ajax.php?action=slz_backend_options_export&secret=' . $secret );

		return slz_render_view( dirname(__FILE__) . '/view.php', array(
			'import' 		=> $this,
			'id'            => $id,
			'option'        => $option,
			'data'          => $data,
			'export_data'	=> $export_data,
			'export_url'	=> $export_url,
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
	public static function _action_ajax_options_export() {

		if ( ! isset( $_GET['secret'] ) || $_GET['secret'] != md5( md5( AUTH_KEY . SECURE_AUTH_KEY ) . '-' . slz()->theme->manifest->get_id() ) ) {
			wp_die( 'Invalid Secret for options use' );
			exit;
		}

		$export_data = SLZ_WP_Option::get( 'slz_theme_settings_options:'. slz()->theme->manifest->get_id() );

		$export_data = json_encode( $export_data );

		$export_data = base64_encode( $export_data );

		if ( isset( $_GET['action'] ) && $_GET['action'] == 'slz_backend_options_export' ) {
			header( 'Content-Description: File Transfer' );
			header( 'Content-type: application/txt' );
			header( 'Content-Disposition: attachment; filename="slz_options_' . slz()->theme->manifest->get_id() . '_backup_' . date( 'd-m-Y' ) . '.json"' );
			header( 'Content-Transfer-Encoding: binary' );
			header( 'Expires: 0' );
			header( 'Cache-Control: must-revalidate' );
			header( 'Pragma: public' );

			echo $export_data;
			exit;
		} else {
			header( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
			header( "Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
			header( 'Expires: Sat, 26 Jul 1997 05:00:00 GMT' );
			header( 'Cache-Control: no-store, no-cache, must-revalidate' );
			header( 'Cache-Control: post-check=0, pre-check=0', false );
			header( 'Pragma: no-cache' );

			echo $export_data;
			exit;
		}

	}
}

add_action('wp_ajax_slz_backend_options_export', array('SLZ_Option_Type_Slz_Export', '_action_ajax_options_export'));
add_action('wp_ajax_nopriv_slz_backend_options_export', array('SLZ_Option_Type_Slz_Export', '_action_ajax_options_export'));

SLZ_Option_Type::register( 'SLZ_Option_Type_Slz_Export' );