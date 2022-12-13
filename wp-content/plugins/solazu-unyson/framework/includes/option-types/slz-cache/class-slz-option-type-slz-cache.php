<?php

class SLZ_Option_Type_Slz_Cache extends SLZ_Option_Type {
	private $option_type = 'slz-cache';

	public function get_type() {
		return $this->option_type;
	}

	/**
	 * @internal
	 */
	protected function _enqueue_static( $id, $option, $data ) {

		$uri = slz_get_framework_directory_uri('/includes/option-types/'. $this->get_type() .'/static');

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
			'slz_cache_id',
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

		return slz_html_tag('button', array(
			'type'    => 'button',
			'onclick' => 'return false;',
			'class'   => 'button ' . $data['id_prefix'] . $id . '-cache-event-button',
			'id'	  =>  $data['id_prefix'] . $id . '-cache-event-button',

		), slz_htmlspecialchars( !empty ( $option['button_text'] ) ? $option['button_text'] : '' ));
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
	public static function _action_ajax_options_clear_cache(){

		$files = glob(WP_CONTENT_DIR . '/uploads/slz-page-cache/' . '*');

		foreach($files as $file){

			if(is_file($file))

				unlink($file);

		}

		wp_send_json_success( 
			array(
				'values' => 'import successfully'
			)
		);

		exit;
	}
}

add_action('wp_ajax_slz_backend_clear_cache', array('SLZ_Option_Type_Slz_Cache', '_action_ajax_options_clear_cache'));

SLZ_Option_Type::register( 'SLZ_Option_Type_Slz_Cache' );