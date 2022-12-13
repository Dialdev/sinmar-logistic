<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

class SLZ_Option_Type_Form_Builder_Item_Form_Header_Title extends SLZ_Option_Type_Form_Builder_Item {
	public function get_type() {
		return 'form-header-title';
	}

	private function get_uri( $append = '' ) {
		return slz_get_framework_directory_uri( '/extensions/forms/includes/option-types/' . $this->get_builder_type() . '/items/' . $this->get_type() . $append );
	}

	public function get_thumbnails() {
		return array(
			array(
				'html' => ''
			)
		);
	}

	public function enqueue_static() {
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
			'slz_form_builder_item_type_' . str_replace( '-', '_', $this->get_type() ),
			array(
				'l10n'     => array(
					'edit_title'    => __( 'Edit Title', 'slz' ),
					'edit_subtitle' => __( 'Edit Subtitle', 'slz' ),
				),
				'options'  => $this->get_options(),
				'defaults' => array(
					'type'    => $this->get_type(),
					'options' => slz_get_options_values_from_input( $this->get_options(), array() )
				)
			)
		);

		slz()->backend->enqueue_options_static( $this->get_options() );
	}

	private function get_options() {
		return array(
			'title'    => array(
				'type'  => 'text',
				'label' => __( 'Title', 'slz' ),
				'desc'  => __( 'The title will be displayed on contact form header', 'slz' ),
				'value' => '',
			),
			'subtitle' => array(
				'type'  => 'textarea',
				'label' => __( 'Subtitle', 'slz' ),
				'desc'  => __( 'The form header subtitle text', 'slz' ),
				'value' => '',
			)
		);
	}

	protected function get_fixed_attributes( $attributes ) {
		// do not allow sub items
		unset( $attributes['_items'] );

		$default_attributes = array(
			'type'      => $this->get_type(),
			'shortcode' => 'form-header-title',
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

			foreach ( slz_extract_only_options( $this->get_options() ) as $option_id => $option ) {
				if ( array_key_exists( $option_id, $attributes['options'] ) ) {
					$option['value'] = $attributes['options'][ $option_id ];
				}
				$only_options[ $option_id ] = $option;
			}

			$attributes['options'] = slz_get_options_values_from_input( $only_options, array() );

			unset( $only_options, $option_id, $option );
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
		return slz_render_view(
			$this->locate_path( '/views/view.php', dirname( __FILE__ ) . '/view.php' ),
			array(
				'title'    => $item['options']['title'],
				'subtitle' => $item['options']['subtitle'],
			)
		);
	}

	/**
	 * {@inheritdoc}
	 */
	public function frontend_validate( array $item, $input_value ) {
	}

	/**
	 * {@inheritdoc}
	 */
	public function visual_only() {
		return true;
	}
}

SLZ_Option_Type_Builder::register_item_type( 'SLZ_Option_Type_Form_Builder_Item_Form_Header_Title' );
