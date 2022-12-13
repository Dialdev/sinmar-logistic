<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class SLZ_Ext_Mailer_Send_Method_SMTP extends SLZ_Ext_Mailer_Send_Method {

	/**
	 * @return string
	 */
	public function get_id() {
		return 'smtp';
	}

	/**
	 * @return string
	 */
	public function get_title() {
		return 'SMTP';
	}

	/**
	 * @return array
	 */
	public function get_settings_options() {
		return array(
			'host' => array(
				'label' => __( 'Server Address', 'slz' ),
				'desc'  => __( 'Enter your email server', 'slz' ),
				'type'  => 'text',
				'value' => '',
			),
			'username' => array(
				'label' => __( 'Username', 'slz' ),
				'desc'  => __( 'Enter your username', 'slz' ),
				'type'  => 'text',
				'value' => '',
			),
			'password' => array(
				'label' => __( 'Password', 'slz' ),
				'desc'  => __( 'Enter your password', 'slz' ),
				'type'  => 'password',
				'value' => '',
			),
			'secure' => array(
				'label'   => __( 'Secure Connection', 'slz' ),
				'type'    => 'radio',
				'inline'  => true,
				'value'   => 'no',
				'choices' => array(
					'no'  => 'No',
					'ssl' => 'SSL',
					'tls' => 'TLS'
				)
			),
			'port' => array(
				'label' => __( 'Custom Port', 'slz' ),
				'desc'  => __( 'Optional - SMTP port number to use.', 'slz' ),
				'help'  => __( 'Leave blank for default (SMTP - 25, SMTPS - 465)', 'slz' ),
				'type'  => 'text',
				'attr'  => array(
					'maxlength' => 5,
				),
				'value' => '',
			),
		);
	}

	/**
	 * @param array $values
	 * @return array|WP_Error
	 */
	public function prepare_settings_options_values($values) {
		$conf = array(
			'host'      => trim($values['host']),
			'username'  => trim($values['username']),
			'password'  => trim($values['password']),
			'secure'    => $values['secure'],
			'port'      => trim($values['port'])
		);

		if (empty($conf['username'])) {
			return new WP_Error(
				'empty_username',
				__('Username cannot be empty', 'slz')
			);
		}

		if (empty($conf['password'])) {
			return new WP_Error(
				'empty_password',
				__('Password cannot be empty', 'slz')
			);
		}

		if (!slz_is_valid_domain_name($conf['host'])) {
			return new WP_Error(
				'invalid_host',
				__('Invalid host', 'slz')
			);
		}

		if (!in_array($conf['secure'], array('ssl', 'tls'))) {
			$conf['secure'] = false;
		}

		// in case the port is missing or invalid
		if (empty($conf['port']) || !is_numeric($conf['port'])) {
			$conf['port'] = 25;

			if ($conf['secure']) {
				if ($conf['secure'] === 'ssl') {
					$conf['port'] = 465;
				} elseif ($conf['secure'] === 'tls') {
					$conf['port'] = 587;
				}
			}
		}

		return $conf;
	}

	/**
	 * @param array $settings_options_values
	 * @param SLZ_Ext_Mailer_Email $email
	 * @param array $data
	 * @return bool|WP_Error
	 */
	public function send(SLZ_Ext_Mailer_Email $email, $settings_options_values, $data = array()) {
		if (!class_exists('PHPMailer')) {
			require_once ABSPATH . WPINC . '/class-phpmailer.php';
		}

		$config = self::prepare_settings_options_values($settings_options_values);

		if (is_wp_error($config)) {
			return $config;
		}

		$mailer = new PHPMailer();

		$mailer->isSMTP();
		$mailer->IsHTML(true);
		$mailer->Host       = $config['host'];
		$mailer->Port       = $config['port'];
		$mailer->SMTPSecure = $config['secure'];
		$mailer->SMTPAuth   = true;
		$mailer->Username   = $config['username'];
		$mailer->Password   = $config['password'];
		$mailer->CharSet    = 'utf-8';

		if (trim($email->get_from())) {
			$mailer->From = $email->get_from();

			if (trim($email->get_from_name())) {
				$mailer->FromName = $email->get_from_name();
			}
		}

		if (is_array($email->get_to())) {
			foreach ($email->get_to() as $to_address) {
				$mailer->AddAddress($to_address);
			}
		} else {
			$mailer->AddAddress($email->get_to());
		}

		if (method_exists($email, 'get_reply_to') && $email->get_reply_to()) {
			if (is_array($email->get_reply_to())) {
				foreach ($email->get_reply_to() as $to_address => $to_name) {
					$mailer->addReplyTo($to_address, $to_name);
				}
			} else {
				$mailer->addReplyTo($email->get_reply_to());
			}
		}

		$mailer->Subject = $email->get_subject();
		$mailer->Body    = $email->get_body();

		//$mailer->SMTPDebug = true;

		try {
			return $mailer->send()
				? true
				: new WP_Error(
					'failed',
					__('Could not send the email', 'slz')
				);
		} catch (phpmailerException $e) {
			return new WP_Error(
				'failed',
				$e->errorMessage()
			);
		} catch (Exception $e) {
			return new WP_Error(
				'failed',
				$e->getMessage()
			);
		}
	}
}
