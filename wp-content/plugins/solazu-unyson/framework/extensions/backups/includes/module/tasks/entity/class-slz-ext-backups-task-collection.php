<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * @since 2.0.0
 */
final class SLZ_Ext_Backups_Task_Collection {
	/**
	 * @var string
	 * @since 2.0.0
	 */
	private $id;

	/**
	 * @var string
	 * @since 2.0.0
	 */
	private $title;

	/**
	 * @var SLZ_Ext_Backups_Task[]
	 * @since 2.0.0
	 */
	private $tasks = array();

	/**
	 * @param string $id
	 */
	public function __construct($id = null) {
		$this->id = (string)(is_null($id) ? slz_rand_md5() : $id);
	}

	/**
	 * @param SLZ_Ext_Backups_Task $task
	 *
	 * @return bool
	 * @since 2.0.0
	 */
	public function add_task(SLZ_Ext_Backups_Task $task) {
		if (in_array($task, $this->tasks, true)) {
			return false;
		} else {
			foreach ($this->tasks as $_task) {
				if ($_task->get_id() === $task->get_id()) {
					return false;
				}
			}

			$this->tasks[] = $task;

			return true;
		}
	}

	/**
	 * @return string
	 * @since 2.0.0
	 */
	public function get_id() {
		return $this->id;
	}

	public function get_title() {
		if (is_null($this->title)) {
			return slz_id_to_title($this->id);
		} else {
			return $this->title;
		}
	}

	public function set_title($title) {
		$this->title = $title;

		return $this;
	}

	/**
	 * @return SLZ_Ext_Backups_Task[]
	 * @since 2.0.0
	 */
	public function get_tasks() {
		return $this->tasks;
	}

	/**
	 * @param string $id
	 *
	 * @return SLZ_Ext_Backups_Task|null
	 * @since 2.0.0
	 *
	 * Note: The returned instance will be changed by reference https://3v4l.org/Ps5hs (use `clone $instance`)
	 */
	public function get_task($id) {
		if (empty($this->tasks)) {
			return null;
		}

		foreach ($this->tasks as $task) {
			if ($task->get_id() === $id) {
				return $task;
			}
		}

		return null;
	}

	/**
	 * If none of the task has executed and the entire collection can be cancelled
	 * @return bool
	 */
	public function is_cancelable() {
		return (
			($tasks = $this->get_tasks())
			&&
			($first_task = reset($tasks))
			&&
			!$first_task->get_last_execution_start_time()
		);
	}

	/**
	 * @return array
	 * @since 2.0.0
	 */
	public function to_array() {
		$tasks = array();
		foreach ($this->get_tasks() as $task) {
			$tasks[] = $task->to_array();
		}

		return array(
			'id' => $this->get_id(),
			'title' => $this->title,
			'tasks' => $tasks,
		);
	}

	/**
	 * @param array $c
	 *
	 * @return SLZ_Ext_Backups_Task_Collection
	 * @since 2.0.0
	 */
	public static function from_array(array $c) {
		if (empty($c)) {
			return null;
		}

		$collection = new self($c['id']);

		if (isset($c['title'])) {
			$collection->set_title($c['title']);
		}

		foreach ($c['tasks'] as $t) {
			$collection->add_task(
				SLZ_Ext_Backups_Task::from_array($t)
			);
		}

		return $collection;
	}
}
