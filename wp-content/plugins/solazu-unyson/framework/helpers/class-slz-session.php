<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Work with $_SESSION
 *
 * Advantages: Do not session_start() on every refresh, but only when it is accessed
 */
class SLZ_Session
{
	private static function start_session()
	{
		if (!session_id()) {
			session_start();
		}
	}

	public static function get($key, $default_value = null)
	{
		self::start_session();

		return slz_akg($key, $_SESSION, $default_value);
	}

	public static function set($key, $value)
	{
		self::start_session();

		slz_aks($key, $value, $_SESSION);
	}

	public static function del( $key ) {
		self::start_session();

		slz_aku( $key, $_SESSION );
	}
}
