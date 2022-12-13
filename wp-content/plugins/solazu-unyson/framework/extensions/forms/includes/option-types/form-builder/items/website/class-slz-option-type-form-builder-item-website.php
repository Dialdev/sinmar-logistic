<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

class SLZ_Option_Type_Form_Builder_Item_Website extends SLZ_Option_Type_Form_Builder_Item {
	public function get_type() {
		return 'website';
	}

	private function get_uri( $append = '' ) {
		return slz_get_framework_directory_uri( '/extensions/forms/includes/option-types/' . $this->get_builder_type() . '/items/' . $this->get_type() . $append );
	}

	public function get_thumbnails() {
		return array(
			array(
				'html' =>
					'<div class="item-type-icon-title" data-hover-tip="' . __( 'Add a Website field', 'slz' ) . '">' .
					'<div class="item-type-icon">' .
					'<img src="' . esc_attr( $this->get_uri( '/static/images/icon.png' ) ) . '" />' .
					'</div>' .
					'<div class="item-type-title">' . __( 'Website', 'slz' ) . '</div>' .
					'</div>'
			)
		);
	}

	public function enqueue_static() {
		wp_enqueue_style(
			'slz-builder-' . $this->get_builder_type() . '-item-' . $this->get_type(),
			$this->get_uri( '/static/css/styles.css' )
		);

		wp_enqueue_script(
			'slz-builder-' . $this->get_builder_type() . '-item-' . $this->get_type(),
			$this->get_uri( '/static/js/scripts.js' ),
			array(
				'slz-events',
			),
			false,
			true
		);

		wp_localize_script(
			'slz-builder-' . $this->get_builder_type() . '-item-' . $this->get_type(),
			'slz_form_builder_item_type_' . $this->get_type(),
			array(
				'l10n'     => array(
					'item_title'      => __( 'Website', 'slz' ),
					'label'           => __( 'Label', 'slz' ),
					'toggle_required' => __( 'Toggle mandatory field', 'slz' ),
					'edit'            => __( 'Edit', 'slz' ),
					'delete'          => __( 'Delete', 'slz' ),
					'edit_label'      => __( 'Edit Label', 'slz' ),
				),
				'options'  => $this->get_options(),
				'defaults' => array(
					'type'    => $this->get_type(),
					'width' => slz_ext('forms')->get_config('items/width'),
					'options' => slz_get_options_values_from_input( $this->get_options(), array() )
				)
			)
		);

		slz()->backend->enqueue_options_static( $this->get_options() );
	}

	private function get_options() {
		return array(
			array(
				'g1' => array(
					'type'    => 'group',
					'options' => array(
						array(
							'label' => array(
								'type'  => 'text',
								'label' => __( 'Label', 'slz' ),
								'desc'  => __( 'Enter field label (it will be displayed on the web site)', 'slz' ),
								'value' => __( 'Website', 'slz' ),
							)
						),
						array(
							'required' => array(
								'type'  => 'switch',
								'label' => __( 'Mandatory Field', 'slz' ),
								'desc'  => __( 'Make this field mandatory?', 'slz' ),
								'value' => true,
							)
						),
					)
				)
			),
			array(
				'g2' => array(
					'type'    => 'group',
					'options' => array(
						array(
							'placeholder' => array(
								'type'  => 'text',
								'label' => __( 'Placeholder', 'slz' ),
								'desc'  => __( 'This text will be used as field placeholder', 'slz' ),
							)
						),
						array(
							'default_value' => array(
								'type'  => 'text',
								'label' => __( 'Default Value', 'slz' ),
								'desc'  => __( 'This text will be used as field default value', 'slz' ),
							)
						)
					)
				)
			),
			array(
				'g4' => array(
					'type'    => 'group',
					'options' => array(
						array(
							'info' => array(
								'type'  => 'textarea',
								'label' => __( 'Instructions for Users', 'slz' ),
								'desc'  => __( 'The users will see these instructions in the tooltip near the field',
									'slz' ),
							)
						),
					)
				)
			),
			$this->get_extra_options()
		);
	}

	protected function get_fixed_attributes( $attributes ) {
		// do not allow sub items
		unset( $attributes['_items'] );

		$default_attributes = array(
			'type'      => $this->get_type(),
			'shortcode' => false, // the builder will generate new shortcode if this value will be empty()
			'width'     => '',
			'options'   => array()
		);

		// remove unknown attributes
		$attributes = array_intersect_key( $attributes, $default_attributes );

		$attributes = array_merge( $default_attributes, $attributes );

		/**
		 * Fix $attributes['options']
		 * Run the _get_value_from_input() method for each option
		 */
		{
			$only_options = array();

			foreach (slz_extract_only_options($this->get_options()) as $option_id => $option) {
				if (array_key_exists($option_id, $attributes['options'])) {
					$option['value'] = $attributes['options'][$option_id];
				}
				$only_options[$option_id] = $option;
			}

			$attributes['options'] = slz_get_options_values_from_input($only_options, array());

			unset($only_options, $option_id, $option);
		}

		return $attributes;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_value_from_attributes( $attributes ) {
		return $this->get_fixed_attributes( $attributes );
	}

	/**
	 * {@inheritdoc}
	 */
	public function frontend_render( array $item, $input_value ) {
		$options = $item['options'];

		// prepare attributes
		{
			$attr = array(
				'type'        => 'text',
				'name'        => $item['shortcode'],
				'placeholder' => $options['placeholder'],
				'value'       => is_null( $input_value ) ? $options['default_value'] : $input_value,
				'id'          => 'id-' . slz_unique_increment(),
			);

			if ( $options['required'] ) {
				$attr['required'] = 'required';
			}
		}

		return slz_render_view(
			$this->locate_path( '/views/view.php', dirname( __FILE__ ) . '/view.php' ),
			array(
				'item' => $item,
				'attr' => $attr,
			)
		);
	}

	/**
	 * {@inheritdoc}
	 */
	public function frontend_validate( array $item, $input_value ) {
		$options = $item['options'];

		$messages = array(
			'required'  => str_replace(
				array( '{label}' ),
				array( $options['label'] ),
				__( 'The {label} field is required', 'slz' )
			),
			'incorrect' => str_replace(
				array( '{label}' ),
				array( $options['label'] ),
				__( 'The {label} field must be a valid website name', 'slz' )
			),
		);

		if ( ! $options['required'] && ! slz_strlen( trim( $input_value ) ) ) {
			return null;
		}

		if ( $options['required'] && ! slz_strlen( trim( $input_value ) ) ) {
			return $messages['required'];
		}

		if ( ! preg_match( '/^https?:\/\//', $input_value ) ) {
			$input_value = 'http://' . $input_value;
		}

		if ( ! empty( $input_value ) && ! filter_var( $input_value, FILTER_VALIDATE_URL ) ) {
			return $messages['incorrect'];
		}
	}
}

SLZ_Option_Type_Builder::register_item_type( 'SLZ_Option_Type_Form_Builder_Item_Website' );
