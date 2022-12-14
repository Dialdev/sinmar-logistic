<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'main' => array(
		'type'    => 'box',
		'title'   => '',
		'options' => array(
			'id'       => array(
				'type'  => 'unique',
			),
			'builder'  => array(
				'type'    => 'tab',
				'title'   => __( 'Form Fields', 'slz' ),
				'options' => array(
					'form' => array(
						'label' => false,
						'type'  => 'form-builder',
						'value' => array(
							'json' => apply_filters('slz:ext:forms:builder:load-item:form-header-title', true)
								? json_encode( array(
									array(
										'type'      => 'form-header-title',
										'shortcode' => 'form_header_title',
										'width'     => '',
										'options'   => array(
											'title'    => '',
											'subtitle' => '',
										)
									)
								) )
								: '[]'
						),
						'fixed_header' => true,
					),
				),
			),
			'settings' => array(
				'type'    => 'tab',
				'title'   => __( 'Settings', 'slz' ),
				'options' => array(
					'settings-options' => array(
						'title'   => __( 'Options', 'slz' ),
						'type'    => 'tab',
						'options' => array(
							'form_email_settings' => array(
								'type'    => 'group',
								'options' => array(
									'email_to' => array(
										'type'  => 'text',
										'label' => __( 'Email To', 'slz' ),
										'help' => __( 'We recommend you to use an email that you verify often', 'slz' ),
										'desc'  => __( 'The form will be sent to this email address.', 'slz' ),
									),
								),
							),
							'form_text_settings'  => array(
								'type'    => 'group',
								'options' => array(
									'subject-group' => array(
										'type' => 'group',
										'options' => array(
											'subject_message'    => array(
												'type'  => 'text',
												'label' => __( 'Subject Message', 'slz' ),
												'desc' => __( 'This text will be used as subject message for the email', 'slz' ),
												'value' => __( 'New message', 'slz' ),
											),
										)
									),
									'submit-button-group' => array(
										'type' => 'group',
										'options' => array(
											'submit_button_text' => array(
												'type'  => 'text',
												'label' => __( 'Submit Button', 'slz' ),
												'desc' => __( 'This text will appear in submit button', 'slz' ),
												'value' => __( 'Send', 'slz' ),
											),
										)
									),
									'success-group' => array(
										'type' => 'group',
										'options' => array(
											'success_message'    => array(
												'type'  => 'text',
												'label' => __( 'Success Message', 'slz' ),
												'desc' => __( 'This text will be displayed when the form will successfully send', 'slz' ),
												'value' => __( 'Message sent!', 'slz' ),
											),
										)
									),
									'failure_message'    => array(
										'type'  => 'text',
										'label' => __( 'Failure Message', 'slz' ),
										'desc' => __( 'This text will be displayed when the form will fail to be sent', 'slz' ),
										'value' => __( 'Oops something went wrong.', 'slz' ),
									),
								),
							),
						)
					),
					'mailer-options'   => array(
						'title'   => __( 'Mailer', 'slz' ),
						'type'    => 'tab',
						'options' => array(
							'mailer' => array(
								'label' => false,
								'type'  => 'mailer'
							)
						)
					)
				),
			),
		),
	)
);