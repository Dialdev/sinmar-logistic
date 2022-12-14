<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class SLZ_Extension_Mailer extends SLZ_Extension
{
	private $is_configured_cache = null;

	/**
	 * @var SLZ_Ext_Mailer_Send_Method[]
	 */
	private $send_methods;

	/**
	 * @internal
	 */
	protected function _init()
	{
		if (is_admin()) {
			add_action(
				'slz_extension_settings_form_render:'. $this->get_name(),
				array($this, '_action_extension_settings_form_render')
			);
		}
	}

	/**
	 * @internal
	 */
	public function _action_extension_settings_form_render()
	{
		wp_enqueue_script(
			'slz_option_email_settings',
			$this->get_uri('/static/js/scripts.js'),
			array('jquery'),
			false,
			true
		);
	}

	/**
	 * @param string $to
	 * @param string $subject
	 * @param string $message
	 * @param array $data
	 * @param array $settings Use this settings instead of db settings | Since 1.2.7
	 * @return array {status: 0, message: '...'}
	 */
	public function send($to, $subject, $message, $data = array(), $settings = array())
	{
		if (empty($settings)) {
			$settings = $this->get_db_settings_option();
		}

		$send_method = $this->get_send_method($settings['method']);

		if (!$send_method) {
			return array(
				'status'  => 0,
				'message' => __('Invalid send method', 'slz')
			);
		}

		if (is_wp_error(
			$send_method_configuration = $send_method->prepare_settings_options_values(
				slz_akg($send_method->get_id(), $settings)
			)
		)) {
			return array(
				'status'  => 0,
				'message' => $send_method_configuration->get_error_message()
			);
		}

		$email = new SLZ_Ext_Mailer_Email();
		$email->set_to($to);
		$email->set_subject($subject);
		$email->set_body($message);

		if (!empty($data['reply_to']) && method_exists($email, 'set_reply_to')) {
			$email->set_reply_to($data['reply_to']);
		}

		$result = $send_method->send(
			$email,
			slz_akg($send_method->get_id(), $settings),
			$data
		);

		return is_wp_error($result)
			? array(
				'status'  => 0,
				'message' => $result->get_error_message()
			)
			: array(
				'status'  => 1,
				'message' => __('The message has been successfully sent!', 'slz')
			);
	}

	/**
	 * Check if extension settings options are valid
	 * @return bool
	 */
	public function is_configured()
	{
		if (is_null($this->is_configured_cache)) {
			$send_method = $this->get_send_method(
				$this->get_db_settings_option('method')
			);

			if ($send_method) {
				$this->is_configured_cache = !is_wp_error(
					$send_method->prepare_settings_options_values(
						$this->get_db_settings_option($send_method->get_id())
					)
				);
			} else {
				$this->is_configured_cache = false;
			}
		}

		return $this->is_configured_cache;
	}

	public function get_send_methods()
	{
		if (empty($this->send_methods)) {
			require_once dirname(__FILE__) . '/includes/classes/class-slz-ext-mailer-email.php';
			require_once dirname(__FILE__) . '/includes/classes/class-slz-ext-mailer-send-method.php';

			$this->send_methods = array();
			foreach (apply_filters('slz_ext_mailer_send_methods', array()) as $send_method) {
				$this->send_methods[ $send_method->get_id() ] = $send_method;
			}
		}

		return $this->send_methods;
	}

	public function get_send_method($method_id)
	{
		$this->get_send_methods(); // init cache

		if (isset($this->send_methods[$method_id])) {
			return $this->send_methods[$method_id];
		} else {
			return null;
		}
	}
}
