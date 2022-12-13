<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

slz_include_file_isolated( dirname( __FILE__ ) . '/includes/includes.php', true );


class SLZ_Option_Type_Form_Builder_Item_Recaptcha extends SLZ_Option_Type_Form_Builder_Item {

	protected $number_regex = '/^\-?([\d]+)?[,\.]?([\d]+)?$/';

	public function get_type() {
		return 'recaptcha';
	}

	private function get_uri( $append = '' ) {
		return slz_get_framework_directory_uri( '/extensions/forms/includes/option-types/' . $this->get_builder_type() . '/items/' . $this->get_type() . $append );
	}

	public function get_thumbnails() {
		return array(
			array(
				'html' =>
					'<div class="item-type-icon-title" data-hover-tip="' . __( 'Add a Recaptcha field', 'slz' ) . '">' .
					'<div class="item-type-icon"><img src="' . esc_attr( $this->get_uri( '/static/images/icon.png' ) ) . '" /></div>' .
					'<div class="item-type-title">' . __( 'Recaptcha', 'slz' ) . '</div>' .
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
				'options'  => $this->get_options(),
				'l10n'     => array(
					'item_title' => __( 'Recaptcha', 'slz' ),
					'label'      => __( 'Label', 'slz' ),
					'edit_label' => __( 'Edit Label', 'slz' ),
					'edit'       => __( 'Edit', 'slz' ),
					'delete'     => __( 'Delete', 'slz' ),
					'site_key'   => __( 'Set site key', 'slz' ),
					'secret_key' => __( 'Set secret key', 'slz' ),
				),
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
			'label'     => array(
				'type'  => 'text',
				'label' => __( 'Label', 'slz' ),
				'desc'  => __( 'Enter field label (it will be displayed on the web site)', 'slz' ),
				'value' => __( 'Recaptcha', 'slz' ),
			),
			'recaptcha' => array(
				'type'  => 'recaptcha',
				'label' => false,
				'value' => null,
			)
		);
	}

	protected function get_fixed_attributes( $attributes ) {
		return $attributes;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_value_from_attributes( $attributes ) {
		return $attributes;
		//return $this->get_fixed_attributes( $attributes );
	}

	/**
	 * {@inheritdoc}
	 */
	public function frontend_render( array $item, $input_value ) {

		$keys = slz_ext( 'forms' )->get_db_settings_option( 'recaptcha-keys' );

		if ( empty( $keys ) ) {
			return '';
		}

		wp_register_script(
			'g-recaptcha',
			'https://www.google.com/recaptcha/api.js?onload=slz_forms_builder_item_recaptcha_init&render=explicit&hl=' . get_locale(),
			array( 'jquery' ),
			null,
			true
		);

		wp_enqueue_script( 'frontend-recaptcha',
			$this->get_uri( '/static/js/frontend-recaptcha.js' ),
			array( 'g-recaptcha' ),
			slz_ext( 'forms' )->manifest->get_version(),
			true
		);
		wp_localize_script( 'frontend-recaptcha', 'form_builder_item_recaptcha', array(
			'site_key' => $keys['site-key']
		) );

		return slz_render_view(
			$this->locate_path( '/views/view.php', dirname( __FILE__ ) . '/view.php' ),
			array(
				'item'  => $item,
				'label' => ( isset( $input_value['label'] ) ) ? $input_value['label'] : __( 'Security Code', 'slz' ),
				'attr'  => array(
					'class' => 'form-builder-item-recaptcha',
				),
			)
		);
	}

	/**
	 * {@inheritdoc}
	 */
	public function frontend_validate( array $item, $input_value ) {

		$mesages = array(
			'not-configured' => __( 'Could not validate the form', 'slz' ),
			'not-human'      => __( 'Please fill the recaptcha', 'slz' ),
		);

		$keys = slz_ext( 'forms' )->get_db_settings_option( 'recaptcha-keys' );

		if ( empty( $keys ) ) {
			return $mesages['not-configured'];
		}

		$recaptcha = new ReCaptcha(
			$keys['secret-key'],
			(function_exists('ini_get') && ini_get('allow_url_fopen')) ? null : new ReCaptchaSocketPost()
		);
		$gRecaptchaResponse = SLZ_Request::POST( 'g-recaptcha-response' );

		if ( empty( $gRecaptchaResponse ) ) {
			return $mesages['not-human'];
		}
		$resp = $recaptcha->verify( $gRecaptchaResponse );

		if ( $resp->isSuccess() ) {
			return false;
		} else {
			$errors = $resp->getErrorCodes();

			return $mesages['not-human'];
		}
	}
}

SLZ_Option_Type_Builder::register_item_type( 'SLZ_Option_Type_Form_Builder_Item_Recaptcha' );