<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class SLZ_Option_Type_Radio_Text extends SLZ_Option_Type
{
	private $js_uri;
	private $css_uri;
	private $custom_choice_key = 'Ku$+03';

	public function get_type()
	{
		return 'radio-text';
	}

	/**
	 * @internal
	 */
	protected function _get_defaults()
	{
		return array(
			'value' => '',
			'choices' => array(
				'25' => __('25%', 'slz'),
				'50' => __('50%', 'slz'),
				'100' => __('100%', 'slz'),
			),
		);
	}

	/**
	 * @internal
	 */
	public function _get_backend_width_type()
	{
		return 'auto';
	}

	/**
	 * @internal
	 */
	protected function _init()
	{
		$static_uri         = slz_get_framework_directory_uri('/includes/option-types/' . $this->get_type() . '/static');
		$this->js_uri       = $static_uri . '/js';
		$this->css_uri      = $static_uri . '/css';
	}

	/**
	 * @internal
	 * {@inheritdoc}
	 */
	protected function _enqueue_static($id, $option, $data)
	{
		wp_enqueue_style(
			'slz-option-' . $this->get_type(),
			$this->css_uri .'/styles.css',
			array(),
			slz()->manifest->get_version()
		);
		wp_enqueue_script(
			'slz-option-' . $this->get_type(),
			$this->js_uri .'/scripts.js',
			array( 'jquery', 'slz-events' ),
			slz()->manifest->get_version(),
			true
		);
	}

	/**
	 * @internal
	 */
	protected function _render($id, $option, $data)
	{
		$option['choices'][ $this->custom_choice_key ] = '';

		return slz_render_view( dirname(__FILE__) .'/view.php', array(
			'id'     => $id,
			'option' => $option,
			'data'   => $data,
			'custom_choice_key' => $this->custom_choice_key,
		) );
	}

	/**
	 * @internal
	 */
	protected function _get_value_from_input($option, $input_value)
	{
		if (is_null($input_value)) {
			return $option['value'];
		}

		$option['choices'][ $this->custom_choice_key ] = '';


		/*
		 * Sometimes $input_value comes as a string because when you serialize
		 * the form with js, it gives you the value as a string
		 * and we need to treat this case accordingly.
		 */
		if (is_string($input_value)) {
			$tmp_array = array(
				'predefined' => $input_value,
				'custom' => $input_value
			);

			$input_value = $tmp_array;
		}


		$selected = slz()->backend->option_type( 'radio' )->get_value_from_input( array(
				'value' => $option['value'],
				'choices' => $option['choices']
			),
			$input_value['predefined']
		);

		if ( $selected === $this->custom_choice_key ) {
			return (string)$input_value['custom'];
		} else {
			return $selected;
		}
	}
}
SLZ_Option_Type::register('SLZ_Option_Type_Radio_Text');
