<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class SLZ_Extension_Backups_Demo extends SLZ_Extension {
	/**
	 * Cache
	 * @var SLZ_Ext_Backups_Demo[]
	 */
	private static $demos;

	private static $wp_ajax_install = 'slz:ext:backups-demo:install';
	private static $wp_ajax_status  = 'slz:ext:backups-demo:status';
	private static $wp_ajax_cancel  = 'slz:ext:backups-demo:cancel';

	private static $task_collection_id = 'demo-content-install';

	private static $wp_option_active_demo = 'slz:ext:backups-demo:active-demo';

	/**
	 * @return SLZ_Extension_Backups
	 */
	public static function backups() {
		return slz_ext('backups');
	}

	/**
	 * @var SLZ_Access_Key
	 */
	private static $access_key;

	/**
	 * @return SLZ_Access_Key
	 */
	private static function get_access_key() {
		if (empty(self::$access_key)) {
			self::$access_key = new SLZ_Access_Key('slz:ext:backups-demo');
		}

		return self::$access_key;
	}

	public function get_page_slug() {
		return 'slz-backups-demo-content';
	}

	/**
	 * @internal
	 */
	protected function _init() {
		add_action('admin_menu', array($this, '_admin_action_admin_menu'));
		add_action('admin_enqueue_scripts', array($this, '_action_admin_enqueue_scripts'));
		add_action(
			'slz:ext:backups:tasks:fail:id:'. self::$task_collection_id,
			array($this, '_action_tasks_fail')
		);
		add_action(
			'slz:ext:backups:tasks:success:id:'. self::$task_collection_id,
			array($this, '_action_tasks_success')
		);

		add_action(
			'wp_ajax_'. self::$wp_ajax_status,
			array($this, '_action_ajax_status')
		);
		add_action(
			'wp_ajax_'. self::$wp_ajax_install,
			array($this, '_action_ajax_install')
		);
		add_action(
			'wp_ajax_'. self::$wp_ajax_cancel,
			array($this, '_action_ajax_cancel')
		);

		add_filter(
			'slz_ext_backups_db_export_exclude_option',
			array($this, '_filter_slz_ext_backups_db_export_exclude_option'),
			10, 3
		);
		add_filter(
			'slz_ext_backups_db_restore_keep_options',
			array($this, '_filter_slz_ext_backups_db_restore_keep_options')
		);
	}

	/**
	 * @internal
	 */
	public function _admin_action_admin_menu() {
		if (
			!current_user_can(self::backups()->get_capability())
			||
		    !$this->get_demos()
		) {
			return;
		}

		add_submenu_page(
			slz()->theme->manifest->get('id'),
			__('Demo Install', 'slz'),
			__('Demo Install', 'slz'),
			self::backups()->get_capability(),
			$this->get_page_slug(),
			array($this, '_display_page')
		);
	}

	/**
	 * @internal
	 */
	public function _display_page() {
		echo '<div class="wrap">';

		$this->render_view('page', array(
			'demos' => $this->get_demos(),
		), false);

		echo '</div>';
	}

	/**
	 * @return SLZ_Ext_Backups_Demo[]
	 */
	private function get_demos() {
		if (is_null(self::$demos)) {
			$demos = array();

			if (!class_exists('SLZ_Ext_Backups_Demo')) {
				require_once dirname(__FILE__) .'/includes/entity/class-slz-ext-backups-demo.php';
			}

			foreach (apply_filters('slz_ext_backups_demo_dirs', array(
				slz_fix_path(get_template_directory()) .'/demo-content'
				=>
				get_template_directory_uri() .'/demo-content',
			)) as $dir_path => $dir_uri) {
				if (
					!is_dir($dir_path)
					||
					!($dirs = glob($dir_path .'/*', GLOB_ONLYDIR))
				) {
					continue;
				}

				foreach (array_map('slz_fix_path', $dirs) as $demo_dir) {
					$demo_dir_name = basename($demo_dir);

					{
						if (!file_exists($demo_dir .'/manifest.php')) {
							continue;
						}

						$manifest = slz_get_variables_from_file(
							$demo_dir .'/manifest.php',
							array('manifest' => array()),
							array('uri' => $dir_uri .'/'. $demo_dir_name)
						);

						$manifest = array_merge(array(
							'title' => slz_id_to_title($demo_dir_name),
							'screenshot' => slz_get_framework_directory_uri('/static/img/no-image.png'),
							'preview_link' => '',
						), $manifest['manifest']);
					}

					$demo = new SLZ_Ext_Backups_Demo(
						'local-'. md5($demo_dir),
						'local',
						array('source' => $demo_dir)
					);
					$demo->set_title($manifest['title']);
					$demo->set_screenshot($manifest['screenshot']);
					$demo->set_preview_link($manifest['preview_link']);

					$demos[ $demo->get_id() ] = $demo;

					unset($demo);
				}
			}

			self::$demos = array_merge(
				apply_filters('slz:ext:backups-demo:demos', array()),
				$demos
			);
		}

		return self::$demos;
	}

	/**
	 * @param string $id
	 *
	 * @return SLZ_Ext_Backups_Demo|null
	 */
	private function get_demo($id) {
		$demos = $this->get_demos();

		return isset($demos[$id]) ? $demos[$id] : null;
	}

	/**
	 * If currently is displayed the Demo list page
	 * @return bool
	 */
	private function is_page() {
		return (
			($current_screen = get_current_screen())
			&&
			$current_screen->id === slz()->theme->manifest->get('id') . '_page_'. $this->get_page_slug()
		);
	}

	public function _action_admin_enqueue_scripts() {
		if ($this->is_page()) {
			wp_enqueue_style('slz');
			wp_enqueue_media(); // needed for modals
			wp_enqueue_style(
				'slz-ext-backups-demo',
				$this->get_uri('/static/page.css'),
				array('slz'),
				$this->manifest->get_version()
			);
			wp_enqueue_script(
				'slz-ext-backups-demo',
				$this->get_uri('/static/page.js'),
				array('slz'),
				$this->manifest->get_version()
			);
			wp_localize_script(
				'slz-ext-backups-demo',
				'_slz_ext_backups_demo',
				array(
					'ajax_action' => array(
						'install' => self::$wp_ajax_install,
						'status' => self::$wp_ajax_status,
						'cancel' => self::$wp_ajax_cancel,
					),
				)
			);
		}
	}

	private function install_is_pending() {
		foreach (self::backups()->tasks()->get_pending_task_collections() as $collection) {
			if ($collection->get_id() === self::$task_collection_id) {
				return true;
			}
		}

		return false;
	}

	private function install_is_active() {
		if ($active_task_collection = self::backups()->tasks()->get_active_task_collection()) {
			return $active_task_collection->get_id() === self::$task_collection_id;
		} else {
			return false;
		}
	}

	private function install_is_busy() {
		return $this->install_is_active() || $this->install_is_pending();
	}

	private function get_active_demo() {
		return get_option(self::$wp_option_active_demo, array('id' => '', 'result' => null));
	}

	private function set_active_demo($data) {
		$active_demo = $this->get_active_demo();

		update_option(
			self::$wp_option_active_demo,
			array_merge(array(
				'id' => $active_demo['id'],
				'result' => null, // 'string' - error message, true - success
			), $data),
			false
		);
	}

	public function _action_ajax_status() {
		if (!current_user_can(self::backups()->get_capability())) {
			wp_send_json_error(new WP_Error(
				'forbidden',
				__('Forbidden', 'slz')
			));
		}

		$install_is_executing = $this->install_is_active();
		$install_is_pending = $this->install_is_pending();
		$is_busy = $this->install_is_busy();
		$active_demo = $this->get_active_demo();

		if ($active_demo['result']) {
			// if result is finished, reset, to prevent same message on next request
			$this->set_active_demo(array('id' => '', 'result' => null));
		}

		// in case the execution chain stopped and there is a pending task
		self::backups()->tasks()->_request_next_step_execution(self::get_access_key());

		wp_send_json_success(array(
			'is_busy' => $is_busy,
			'active_demo' => $active_demo,
			'home_url' => home_url(),
			'html' => $is_busy
				? $this->render_view('status', array(
					'install_is_executing' => $install_is_executing,
					'install_is_pending' => $install_is_pending,
					'executing_task' => self::backups()->tasks()->get_executing_task(),
					'pending_task' => self::backups()->tasks()->get_pending_task(),
				))
				: '',
			'ajax_steps' => array(
				'token' => md5(
					defined('NONCE_SALT')
						? NONCE_SALT
						: self::backups()->manifest->get_version()
				),
				'active_tasks_hash' => (($collection = self::backups()->tasks()->get_active_task_collection())
					? md5(serialize($collection))
					: ''
				)
			),
		));
	}

	public function _action_ajax_install() {
		if (!current_user_can(self::backups()->get_capability())) {
			wp_send_json_error(new WP_Error(
				'forbidden',
				__('Forbidden', 'slz')
			));
		}

		if (
			!isset($_POST['id'])
			||
			!is_string($_POST['id'])
			||
			!($demo = $this->get_demo($_POST['id']))
		) {
			wp_send_json_error(new WP_Error(
				'invalid_id',
				__('Invalid demo', 'slz')
			));
		}

		if ($this->install_is_busy()) {
			wp_send_json_error(new WP_Error(
				'already_running',
				__('A content install is currently running', 'slz')
			));
		}

		$this->do_install($demo);

		wp_send_json_success();
	}

	public function _action_ajax_cancel() {
		if (!current_user_can(self::backups()->get_capability())) {
			wp_send_json_error(new WP_Error(
				'forbidden',
				__('Forbidden', 'slz')
			));
		}

		if (self::backups()->tasks()->do_cancel()) {
			wp_send_json_success();
		} else {
			wp_send_json_error();
		}
	}

	private function do_install(SLZ_Ext_Backups_Demo $demo) {
		$tmp_dir = self::backups()->get_tmp_dir();
		$id_prefix = 'demo:';

		$collection = new SLZ_Ext_Backups_Task_Collection(self::$task_collection_id);

		if (!self::backups()->is_disabled()) {
			$collection = self::backups()->tasks()->add_backup_tasks($collection);
		}

		$collection->set_title(__('Demo Content Install', 'slz'));

		$collection->add_task(new SLZ_Ext_Backups_Task(
			$id_prefix .'tmp-dir-clean:before',
			'dir-clean',
			array('dir' => $tmp_dir)
		));
		$collection->add_task(new SLZ_Ext_Backups_Task(
			$id_prefix .'demo-download',
			'download',
			array(
				'type' => $demo->get_source_type(),
				'type_args' => $demo->get_source_args(),
				'destination_dir' => $tmp_dir,

				// used only for https://github.com/ThemeFuse/Unyson-Backups-Extension/issues/15
				'demo_id' => $demo->get_id(),
			)
		));

		self::backups()->tasks()->add_restore_tasks($collection);

		$this->set_active_demo(array('id' => $demo->get_id(), 'result' => null));

		self::backups()->tasks()->execute_task_collection($collection);
	}

	/**
	 * @param bool $exclude
	 * @param string $option_name
	 * @param bool $is_full_backup
	 * @return bool
	 */
	public function _filter_slz_ext_backups_db_export_exclude_option($exclude, $option_name, $is_full_backup) {
		if ($option_name === self::$wp_option_active_demo) {
			return true;
		}

		return $exclude;
	}

	/**
	 * @param array $options {option_name: true}
	 * @return array
	 */
	public function _filter_slz_ext_backups_db_restore_keep_options($options) {
		$options[ self::$wp_option_active_demo] = true;

		return $options;
	}

	public function _action_tasks_fail(SLZ_Ext_Backups_Task_Collection $collection) {
		$error = __('Error', 'slz');

		foreach ($collection->get_tasks() as $task) {
			if ($task->result_is_fail()) {
				if (is_wp_error($task->get_result())) {
					$error = $task->get_result()->get_error_message();
				}
				break;
			}
		}

		$this->set_active_demo(array('result' => $error));
	}

	public function _action_tasks_success(SLZ_Ext_Backups_Task_Collection $collection) {
		$this->set_active_demo(array('result' => true));
	}

	/**
	 * @param SLZ_Access_Key $access_Key
	 * @return int
	 * @internal
	 * @since 2.0.3
	 */
	public function _get_demos_count(SLZ_Access_Key $access_Key) {
		if ($access_Key->get_key() !== 'slz:ext:backups-demo:helper:count') {
			trigger_error('Method call denied', E_USER_ERROR);
		}

		return count($this->get_demos());
	}
}
