<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

/**
 * Unyson option type that allows to group option in a popup window
 *
 * Class SLZ_Option_Type_Popup
 */
class SLZ_Option_Type_Popup extends SLZ_Option_Type {
	public function _get_backend_width_type() {
		return 'fixed';
	}

	/**
	 * @internal
	 * {@inheritdoc}
	 */
	protected function _enqueue_static( $id, $option, $data ) {
		static $enqueue = true;

		if ($enqueue) {
			wp_enqueue_style(
				'slz-option-' . $this->get_type(),
				slz_get_framework_directory_uri( '/includes/option-types/' . $this->get_type() . '/static/css/styles.css' ),
				array( 'slz' )
			);

			wp_enqueue_script(
				'slz-option-' . $this->get_type(),
				slz_get_framework_directory_uri( '/includes/option-types/' . $this->get_type() . '/static/js/' . $this->get_type() . '.js' ),
				array( 'underscore', 'slz-events', 'jquery-ui-sortable', 'slz' ),
				false,
				true
			);

			$enqueue = false;
		}

		slz()->backend->enqueue_options_static( $option['popup-options'] );

		return true;
	}

	/**
	 * Generate option's html from option array
	 *
	 * @param string $id
	 * @param array $option
	 * @param array $data
	 *
	 * @return string HTML
	 * @internal
	 */
	protected function _render( $id, $option, $data ) {
		unset( $option['attr']['name'], $option['attr']['value'] );

		$option['attr']['data-for-js'] = json_encode( array(
			'title'   => ( isset( $option['popup-title'] ) ) ? $option['popup-title'] : ( string ) $option['label'],
			'options' => $this->transform_options( $option['popup-options'] ),
			'button'  => $option['button'],
			'size'    => $option['size'],
			'custom-events' => $option['custom-events']
		) );

		if ( ! empty( $data['value'] ) ) {
			if ( is_array( $data['value'] ) ) {
				$data['value'] = json_encode( $data['value'] );
			}
		} else {
			$data['value'] = '';
		}

		$sortable_image = slz_get_framework_directory_uri( '/static/img/sort-vertically.png' );

		return slz_render_view( slz_get_framework_directory( '/includes/option-types/' . $this->get_type() . '/views/view.php' ),
			compact( 'id', 'option', 'data', 'sortable_image' ) );
	}

	/**
	 * Option's unique type, used in option array in 'type' key
	 * @return string
	 */
	public function get_type() {
		return 'popup';
	}

	private function transform_options( $options ) {
		$new_options = array();
		foreach ( $options as $id => $option ) {
			if ( is_int( $id ) ) {
				/**
				 * this happens when in options array are loaded external options using slz()->theme->get_options()
				 * and the array looks like this
				 * array(
				 *    'hello' => array('type' => 'text'), // this has string key
				 *    array('hi' => array('type' => 'text')) // this has int key
				 * )
				 */
				$new_options[] = $option;
			} else {
				$new_options[] = array( $id => $option );
			}
		}

		return $new_options;
	}

	/**
	 * Extract correct value for $option['value'] from input array
	 * If input value is empty, will be returned $option['value']
	 *
	 * @param array $option
	 * @param array|string|null $input_value
	 *
	 * @return string|array|int|bool Correct value
	 * @internal
	 */
	protected function _get_value_from_input( $option, $input_value ) {
		if ( empty( $input_value ) ) {
			if ( empty( $option['popup-options'] ) ) {
				return array();
			}

			/**
			 * $option['value'] has DB format (not $input_value HTML format)
			 * so it can't be used as second parameter in slz_get_options_values_from_input()
			 * thus we need to move each option value in option array default values
			 */
			$popup_options = array();
			foreach (slz_extract_only_options($option['popup-options']) as $popup_option_id => $popup_option) {
				if (isset($option['value'][$popup_option_id])) {
					$popup_option['value'] = $option['value'][$popup_option_id];
				}
				$popup_options[ $popup_option_id ] = $popup_option;
			}

			$values = slz_get_options_values_from_input($popup_options, array());
		} else if (is_array( $input_value )) {
			/**
			 * Don't decode if we have already an array
			 */
			$values = slz_get_options_values_from_input($option['popup-options'], $input_value);
		} else {
			$values = slz_get_options_values_from_input($option['popup-options'], json_decode( $input_value, true ));
		}

		return $values;
	}

	/**
	 * Default option array
	 *
	 * This makes possible an option array to have required only one parameter: array('type' => '...')
	 * Other parameters are merged with array returned from this method
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
			/*
			 * Popup button text
			 */
			'button'        => __( 'Edit', 'slz' ),
			/*
			 * Title text that will appear in popup header
			 */
			'popup-title'   => null,
			/*
			 * Array of options that you need to add in the popup
			 */
			'popup-options' => array(),

			/*
			 * Popup size
			 */
			'size' => 'medium',

			/*
			 * Array of default values for the popup options
			 */
			'value'         => array(),

			'custom-events' => array(
				'open' => false,
				'close' => false,
				'render' => false
			)
		);
	}

}

SLZ_Option_Type::register( 'SLZ_Option_Type_Popup' );
