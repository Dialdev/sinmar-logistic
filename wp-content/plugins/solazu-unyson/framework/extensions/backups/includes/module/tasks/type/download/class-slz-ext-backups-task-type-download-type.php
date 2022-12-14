<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

abstract class SLZ_Ext_Backups_Task_Type_Download_Type extends SLZ_Type {
	/**
	 * @param array $args
	 * @param array $state
	 * @return string User friendly title
	 */
	abstract public function get_title(array $args = array(), array $state = array());

	/**
	 * {@inheritdoc}
	 * @param array $args
	 * * destination_dir - Path to dir where the downloaded files must be placed
	 */
	abstract public function download(array $args, array $state = array());

	public function get_custom_timeout(array $args, array $state = array()) {
		/**
		 * Usually downloading a file takes long time
		 */
		return slz_ext('backups')->get_config('max_timeout');
	}
}
