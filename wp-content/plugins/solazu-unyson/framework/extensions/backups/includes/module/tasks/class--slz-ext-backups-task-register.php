<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class _SLZ_Ext_Backups_Task_Type_Register {
	/**
	 * @var SLZ_Ext_Backups_Task_Type[]
	 */
	private $task_types = array();

	public function register(SLZ_Ext_Backups_Task_Type $type) {
		if (isset($this->task_types[$type->get_type()])) {
			throw new Exception('Backup Task Type '. $type->get_type() .' already exists');
		}

		$this->task_types[$type->get_type()] = $type;
	}

	/**
	 * @param SLZ_Access_Key $access_key
	 *
	 * @return SLZ_Ext_Backups_Task_Type[]
	 * @internal
	 */
	public function _get_task_types(SLZ_Access_Key $access_key) {
		if ($access_key->get_key() !== 'slz:ext:backups:tasks') {
			trigger_error('Method call denied', E_USER_ERROR);
		}

		return $this->task_types;
	}
}
