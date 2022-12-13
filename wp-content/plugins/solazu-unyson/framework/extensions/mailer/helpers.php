<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function slz_ext_mailer_send_mail($to, $subject, $message, $data = array()) {
	return slz()->extensions->get('mailer')->send($to, $subject, $message, $data);
}

function slz_ext_mailer_is_configured() {
	return slz()->extensions->get('mailer')->is_configured();
}
