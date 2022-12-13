<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * @return int
 * @since 2.0.3
 */
function slz_ext_backups_demo_count() {
	static $access_key = null;

	if (is_null($access_key)) {
		$access_key = new SLZ_Access_Key('slz:ext:backups-demo:helper:count');
	}

	/**
	 * @var SLZ_Extension_Backups_Demo $extension
	 */
	$extension = slz_ext('backups-demo');

	return $extension->_get_demos_count($access_key);
}
