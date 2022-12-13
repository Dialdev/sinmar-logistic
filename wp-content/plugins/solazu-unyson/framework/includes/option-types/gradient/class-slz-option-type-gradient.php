<?php if ( ! defined( 'ABSPATH' ) ) {
	die('Forbidden');
}

/**
 * Background Color
 */
class SLZ_Option_Type_Gradient extends SLZ_Option_Type
{
	/**
	 * @internal
	 */
	public function _get_backend_width_type()
	{
		return 'auto';
	}

	/**
	 * @internal
	 * {@inheritdoc}
	 */
	protected function _enqueue_static($id, $option, $data)
	{
		wp_enqueue_style(
			'slz-option-' . $this->get_type(),
			slz_get_framework_directory_uri('/includes/option-types/' . $this->get_type() . '/static/css/styles.css'),
			array(),
			slz()->manifest->get_version()
		);

		slz()->backend->option_type('color-picker')->enqueue_static();

		wp_enqueue_script(
			'slz-option-' . $this->get_type(),
			slz_get_framework_directory_uri('/includes/option-types/' . $this->get_type() . '/static/js/scripts.js'),
			array('jquery', 'slz-events'),
			slz()->manifest->get_version()
		);
	}

	/**
	 * @internal
	 */
	protected function _render($id, $option, $data)
	{
		$output = slz_render_view(slz_get_framework_directory('/includes/option-types/' . $this->get_type() . '/view.php'), array(
			'id' => $id,
			'option' => $option,
			'data' => $data
		));

		return $output;
	}

	public function get_type()
	{
		return 'gradient';
	}

	/**
	 * @internal
	 */
	protected function _get_value_from_input($option, $input_value)
	{
		if (is_array($input_value)) {
			if (!isset($input_value['primary']) || !preg_match('/^#[a-f0-9]{6}$/i', $input_value['primary'])) {
				$input_value['primary'] = $option['value']['primary'];
			}

			if (!isset($input_value['secondary']) || !preg_match('/^#[a-f0-9]{6}$/i', $input_value['secondary'])) {
				$input_value['secondary'] = (isset($option['value']['secondary'])) ? $option['value']['secondary'] : false;
			}
		} else {
			$input_value = $option['value'];
		}

		return $input_value;
	}

	/**
	 * @internal
	 */
	protected function _get_defaults()
	{
		return array(
			'value' => array(
				'primary'   => '#FF0000',
				'secondary' => '#0000FF',
			)
		);
	}
}

SLZ_Option_Type::register('SLZ_Option_Type_Gradient');
