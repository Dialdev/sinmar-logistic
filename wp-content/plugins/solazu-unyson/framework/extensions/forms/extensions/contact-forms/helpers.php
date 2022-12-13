<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

/**
 * Returns value of the form option
 *
 * @param $form_id
 * @param null $multikey
 *
 * @return mixed
 */
function slz_ext_contact_forms_get_option( $form_id, $multikey = null ) {
	return slz_ext( 'contact-forms' )->get_option( $form_id, $multikey );
}