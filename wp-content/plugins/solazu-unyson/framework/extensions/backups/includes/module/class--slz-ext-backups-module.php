<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

abstract class _SLZ_Ext_Backups_Module {
	final public function __construct(SLZ_Access_Key $access_key) {
		if ($access_key->get_key() !== 'slz:ext:backups') {
			// only the Backups extension can create instances
			trigger_error(__METHOD__ .' denied', E_USER_ERROR);
		}
	}

	abstract public function _init();
}
