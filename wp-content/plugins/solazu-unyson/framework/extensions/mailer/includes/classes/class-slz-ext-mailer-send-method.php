<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

abstract class SLZ_Ext_Mailer_Send_Method
{
	/**
	 * @return string
	 */
	abstract public function get_id();

	/**
	 * @return string
	 */
	abstract public function get_title();

	/**
	 * @return array
	 */
	abstract public function get_settings_options();

	/**
	 * @param array $values
	 * @return array|WP_Error
	 */
	abstract public function prepare_settings_options_values($values);

	/**
	 * @param array $settings_options_values
	 * @param SLZ_Ext_Mailer_Email $email
	 * @param array $data
	 * @return bool|WP_Error
	 */
	abstract public function send(SLZ_Ext_Mailer_Email $email, $settings_options_values, $data = array());
}
