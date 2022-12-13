<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function _action_slz_ext_mailer_option_types_init() {
	require_once dirname(__FILE__) . '/includes/option-type-mailer/class-slz-option-type-mailer.php';
}
add_action('slz_option_types_init', '_action_slz_ext_mailer_option_types_init');

function _filter_slz_ext_mailer_default_send_methods($send_methods) {
	require_once dirname(__FILE__) . '/includes/send-methods/class-slz-ext-mailer-send-method-wpmail.php';
	$send_methods[] = new SLZ_Ext_Mailer_Send_Method_WPMail;

	require_once dirname(__FILE__) . '/includes/send-methods/class-slz-ext-mailer-send-method-smtp.php';
	$send_methods[] = new SLZ_Ext_Mailer_Send_Method_SMTP;

	return $send_methods;
}
add_filter('slz_ext_mailer_send_methods', '_filter_slz_ext_mailer_default_send_methods');
