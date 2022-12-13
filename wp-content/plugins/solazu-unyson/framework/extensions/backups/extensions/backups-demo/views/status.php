<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * @var bool $install_is_executing
 * @var bool $install_is_pending
 * @var null|SLZ_Ext_Backups_Task $executing_task
 * @var null|SLZ_Ext_Backups_Task $pending_task
 */

$backups = slz_ext( 'backups' ); /** @var SLZ_Extension_Backups $backups */
$active_collection = $backups->tasks()->get_active_task_collection();
?>
<?php if ($install_is_executing): ?>
	<h2 class="slz-text-muted">
		<img src="<?php echo get_site_url() ?>/wp-admin/images/spinner.gif" alt="Loading" class="wp-spinner" />
		<?php esc_html_e('Installing', 'slz') ?>
	</h2>
	<p class="slz-text-muted">
	<em><?php esc_html_e('We are currently installing your content.') ?></em><br/>
	<?php if ($executing_task): ?>
		<em><?php
			echo esc_html($backups->tasks()->get_task_type_title(
				$executing_task->get_type(),
				$executing_task->get_args(),
				$executing_task->get_result()
			));
		?></em>
	<?php elseif ($pending_task): ?>
		<em><?php
			echo esc_html($backups->tasks()->get_task_type_title(
				$pending_task->get_type(),
				$pending_task->get_args(),
				$pending_task->get_result()
			));
		?></em>
	<?php endif; ?>
	</p>
<?php elseif ($install_is_pending): ?>
	<p><img src="<?php echo get_site_url() ?>/wp-admin/images/spinner.gif" alt="Loading"></p>
	<em class="slz-text-muted"><?php esc_html_e('Pending', 'slz') ?></em>
<?php endif; ?>

<?php if ($active_collection && $active_collection->is_cancelable()): ?>
	<a href="#" onclick="slzEvents.trigger('slz:ext:backups-demo:cancel'); return false;"><em><?php
		esc_html_e('Cancel', 'slz');
	?></em></a>
<?php endif; ?>
