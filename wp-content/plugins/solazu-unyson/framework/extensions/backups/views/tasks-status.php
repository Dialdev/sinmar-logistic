<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * @var null|SLZ_Ext_Backups_Task_Collection $active_task_collection
 * @var null|SLZ_Ext_Backups_Task $executing_task
 * @var null|SLZ_Ext_Backups_Task $pending_tasks
 */

/**
 * @var SLZ_Extension_Backups $backups
 */
$backups = slz_ext('backups');
?>
<?php if ($active_task_collection): ?>
		<img src="<?php echo get_site_url() ?>/wp-admin/images/spinner.gif" alt="Loading">
		<em class="slz-text-muted"><?php
		if ($executing_task) {
			echo esc_html($backups->tasks()->get_task_type_title(
				$executing_task->get_type(),
				$executing_task->get_args(),
				$executing_task->get_result()
			));
		} elseif ($pending_tasks) {
			echo esc_html($backups->tasks()->get_task_type_title(
				$pending_tasks->get_type(),
				$pending_tasks->get_args(),
				$pending_tasks->get_result()
			));
		} else {
			esc_html_e('Unknown task');
		}
	?></em>
<?php else: ?>
	<em class="slz-text-muted" style="color: transparent;"><?php esc_html_e('Nothing running in background', 'slz'); ?></em>
<?php endif; ?>

<?php if ($active_task_collection && $active_task_collection->is_cancelable()): ?>
	<a href="#" onclick="slzEvents.trigger('slz:ext:backups:cancel'); return false;"><em><?php
		esc_html_e('Cancel', 'slz');
	?></em></a>
<?php endif; ?>


