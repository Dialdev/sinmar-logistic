<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class SLZ_Option_Type_Addable_Option extends SLZ_Option_Type
{
	public function get_type()
	{
		return 'addable-option';
	}

	/**
	 * @internal
	 */
	protected function _get_defaults()
	{
		return array(
			'value'  => array(),
			'option' => array(
				'type' => 'text',
			),
			'add-button-text' => __('Add', 'slz'),
			/**
			 * Makes the options sortable
			 *
			 * You can disable this in case the options order doesn't matter,
			 * to not confuse the user that if changing the order will affect something.
			 */
			'sortable' => true,
		);
	}

	/**
	 * @internal
	 * {@inheritdoc}
	 */
	protected function _enqueue_static($id, $option, $data)
	{
		static $enqueue = true;

		if ($enqueue) {
			wp_enqueue_style(
				'slz-option-'. $this->get_type(),
				slz_get_framework_directory_uri('/includes/option-types/'. $this->get_type() .'/static/css/styles.css'),
				array(),
				slz()->manifest->get_version()
			);

			wp_enqueue_script(
				'slz-option-'. $this->get_type(),
				slz_get_framework_directory_uri('/includes/option-types/'. $this->get_type() .'/static/js/scripts.js'),
				array('slz-events', 'jquery-ui-sortable'),
				slz()->manifest->get_version(),
				true
			);

			$enqueue = false;
		}

		slz()->backend->option_type($option['option']['type'])->enqueue_static();

		return true;
	}

	/**
	 * @internal
	 */
	protected function _render($id, $option, $data)
	{
		return slz_render_view(slz_get_framework_directory('/includes/option-types/'. $this->get_type() .'/view.php'), array(
			'id'     => $id,
			'option' => $option,
			'data'   => $data,
			'move_img_src' => slz_get_framework_directory_uri('/static/img/sort-vertically.png'),
		));
	}

	/**
	 * @internal
	 */
	protected function _get_value_from_input($option, $input_value)
	{
		if (!is_array($input_value)) {
			return $option['value'];
		}

		$option_type = slz()->backend->option_type($option['option']['type']);

		$value = array();

		foreach ($input_value as $option_input_value) {
			$value[] = $option_type->get_value_from_input(
				$option['option'],
				$option_input_value
			);
		}

		return $value;
	}
}
SLZ_Option_Type::register('SLZ_Option_Type_Addable_Option');
