<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


class SLZ_Option_Type_Datetime_Range extends SLZ_Option_Type {

	private function  _get_static_uri() {
		return slz_get_framework_directory_uri('/includes/option-types/datetime-range/static');
	}

	public function get_type() {
		return 'datetime-range';
	}

	public function _get_backend_width_type() {
		return 'auto';
	}

	/**
	 * Avaible options on http://xdsoft.net/jqplugins/datetimepicker/ excepts: [value, format]
	 * @internal
	 */
	protected function _get_defaults() {
		return array(
			'datetime-pickers' => array(
				'from' => array(
					'minDate' => '1970/01/01',
					'maxDate' => '2038/01/19',
					'format'  => 'Y/m/d H:i',
					'timepicker'  => true,
					'datepicker'  => true,
					'scrollInput' => false,
				),
				'to' => array(
					'minDate' => '1970/01/01',
					'maxDate' => '2038/01/19',
					'format'  => 'Y/m/d H:i',
					'timepicker'  => true,
					'datepicker'  => true,
					'scrollInput' => false,
				)
			),
			'value' => array(
				'from' => '',
				'to' => ''
			)
		);
	}

	/**
	 * @internal
	 * {@inheritdoc}
	 */
	protected function _enqueue_static($id, $option, $data)
	{
		wp_enqueue_style('slz-option-datetime-range-CSS', $this->_get_static_uri() . '/css/styles.css' );
		wp_enqueue_script( 'slz-option-datetime-range-js', $this->_get_static_uri() . '/js/script.js', array('jquery', 'slz-events'));

		slz()->backend->option_type('datetime-picker')->enqueue_static();
	}

	protected function _render( $id, $option, $data ) {

		//replace option datetime formats with moment.js compatible datetime format
		foreach($option['datetime-pickers'] as &$datetime_picker) {
			if (isset($datetime_picker['timepicker']) && isset($datetime_picker['datepicker'])) {
				if ($datetime_picker['timepicker'] === false && $datetime_picker['datepicker'] ) {
					$datetime_picker['format'] = 'Y/m/d';
					$datetime_picker['moment-format'] = 'YYYY/MM/DD';
				} elseif ($datetime_picker['datepicker'] === false && $datetime_picker['timepicker']) {
					$datetime_picker['format'] = 'H:i';
					$datetime_picker['moment-format'] = 'HH:mm';
				} else {
					$datetime_picker['format'] = 'Y/m/d H:i';
					$datetime_picker['moment-format'] = 'YYYY/MM/DD HH:mm';
				}
			}  else {
				$datetime_picker['format'] = 'Y/m/d H:i';
				$datetime_picker['moment-format'] = 'YYYY/MM/DD HH:mm';
			}

			if (!isset($datetime_picker['scrollInput'])) {
				$datetime_picker['scrollInput'] = false;
			}
		}

		return slz_render_view( dirname(__FILE__) . '/view.php', array(
			'id' => $id,
			'option' => $option,
			'data' => $data
		));
	}

	/**
	 * @internal
	 */
	protected function _get_value_from_input($option, $input_value)
	{
		if (is_null($input_value) or !isset($input_value['from']) or !isset($input_value['to']) ) {
			return $option['value'];
		}

		$from = slz()->backend->option_type('datetime-picker')->get_value_from_input(array('datetime-picker' => $option['datetime-pickers']['from'], 'value' => $option['value']['from'] ), $input_value['from']);
		$to = slz()->backend->option_type('datetime-picker')->get_value_from_input(array('datetime-picker' => $option['datetime-pickers']['to'],  'value' => $option['value']['to']), $input_value['to']);

		if (empty($from) or empty($to) or (strtotime($from) > strtotime($to)) ) {
			return $option['value'];
		}

		if ( (( strtotime($from) % 86400 ) !== 0)  and (strtotime($from) === strtotime($to)) ) {
			return $option['value'];
		}

		 return $input_value;
	}


}
SLZ_Option_Type::register('SLZ_Option_Type_Datetime_Range');
