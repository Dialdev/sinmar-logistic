<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class _SLZ_Customizer_Setting_Option extends WP_Customize_Setting {
	/**
	 * @var array
	 * This is sent in args and set in parent construct
	 */
	protected $slz_option = array();

	public function get_slz_option() {
		return $this->slz_option;
	}

	public function sanitize($value) {
		$value = json_decode($value, true);

		if (is_null($value) || !is_array($value)) {
			return null;
		}

		$POST = array();

		foreach ($value as $var) {
			slz_aks(
				slz_html_attr_name_to_array_multi_key($var['name'], true),
				$var['value'],
				$POST
			);
		}

		$value = slz()->backend->option_type($this->slz_option['type'])->get_value_from_input(
			$this->slz_option,
			slz_akg(slz_html_attr_name_to_array_multi_key($this->id), $POST)
		);

		return $value;
	}
}
