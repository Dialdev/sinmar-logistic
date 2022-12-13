<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * @var array $updates
 */
?>

<?php if ($updates['framework'] !== false): ?>
<div id="slz-ext-update-framework">
	<a name="slz-framework"></a>
	<h3><?php _e('Framework', 'slz') ?></h3>
	<?php if (empty($updates['framework'])): ?>
		<p><?php echo sprintf(__('You have the latest version of %s.', 'slz'), slz()->manifest->get_name()) ?></p>
	<?php else: ?>
		<?php if (is_wp_error($updates['framework'])): ?>
			<p class="wp-ui-text-notification"><?php echo $updates['framework']->get_error_message() ?></p>
		<?php else: ?>
			<form id="slz-ext-update-framework" method="post" action="update-core.php?action=slz-update-framework">
				<p><?php
					_e(sprintf('You have version %s installed. Update to %s.',
						slz()->manifest->get_version(),
						$updates['framework']['fixed_latest_version']
					), 'slz')
				?></p>
				<?php wp_nonce_field(-1, '_nonce_slz_ext_update_framework'); ?>
				<p><input class="button" type="submit" value="<?php echo esc_attr(__('Update Framework', 'slz')) ?>" name="update"></p>
			</form>
		<?php endif; ?>
	<?php endif; ?>
</div>
<?php endif; ?>

<?php if ($updates['theme'] !== false): ?>
<div id="slz-ext-update-theme">
	<a name="slz-theme"></a>
	<h3><?php $theme = wp_get_theme(); _e(sprintf('%s Theme', (is_child_theme() ? $theme->parent()->get('Name') : $theme->get('Name'))), 'slz') ?></h3>
	<?php if (empty($updates['theme'])): ?>
		<p><?php _e('Your theme is up to date.', 'slz') ?></p>
	<?php else: ?>
		<?php if (is_wp_error($updates['theme'])): ?>
			<p class="wp-ui-text-notification"><?php echo $updates['theme']->get_error_message() ?></p>
		<?php else: ?>
			<form id="slz-ext-update-theme" method="post" action="update-core.php?action=slz-update-theme">
				<p><?php
					_e(sprintf('You have version %s installed. Update to %s.',
						slz()->theme->manifest->get_version(),
						$updates['theme']['fixed_latest_version']
					), 'slz')
				?></p>
				<?php wp_nonce_field(-1, '_nonce_slz_ext_update_theme'); ?>
				<p><input class="button" type="submit" value="<?php echo esc_attr(__('Update Theme', 'slz')) ?>" name="update"></p>
			</form>
		<?php endif; ?>
	<?php endif; ?>
</div>
<?php endif; ?>

<?php if (true): ?>
<div id="slz-ext-update-extensions">
	<a name="slz-extensions"></a>
	<h3><?php echo sprintf(__('%s Extensions', 'slz'), slz()->manifest->get_name()) ?></h3>
	<?php if (empty($updates['extensions'])): ?>
		<p><?php echo sprintf(__('You have the latest version of %s Extensions.', 'slz'), slz()->manifest->get_name()); ?></p>
	<?php else: ?>
		<?php
		$one_update_mode = slz()->extensions->get('update')->get_config('extensions_as_one_update');

		foreach ($updates['extensions'] as $extension) {
			if (is_wp_error($extension)) {
				/**
				 * Cancel the "One update mode" and display all extensions list table with details
				 * if at least one extension has an error that needs to be visible
				 */
				$one_update_mode = false;
				break;
			}
		}
		?>
		<form id="slz-ext-update-extensions" method="post" action="update-core.php?action=slz-update-extensions">
			<div class="slz-ext-update-extensions-form-detailed" <?php if ($one_update_mode): ?>style="display: none;"<?php endif; ?>>
				<p><input class="button" type="submit" value="<?php echo esc_attr(__('Update Extensions', 'slz')) ?>" name="update"></p>
				<?php
				if (!class_exists('_SLZ_Ext_Update_Extensions_List_Table')) {
					slz_include_file_isolated(
						slz()->extensions->get('update')->get_declared_path('/includes/classes/class--slz-ext-update-extensions-list-table.php')
					);
				}

				$list_table = new _SLZ_Ext_Update_Extensions_List_Table(array(
					'extensions' => $updates['extensions']
				));

				$list_table->display();
				?>
				<?php wp_nonce_field(-1, '_nonce_slz_ext_update_extensions'); ?>
				<p><input class="button" type="submit" value="<?php echo esc_attr(__('Update Extensions', 'slz')) ?>" name="update"></p>
			</div>
			<?php if ($one_update_mode): ?>
			<div class="slz-ext-update-extensions-form-simple">
				<p style="color:#d54e21;"><?php _e('New extensions updates available.', 'slz'); ?></p>
				<p><input class="button" type="submit" value="<?php echo esc_attr(__('Update Extensions', 'slz')) ?>" name="update"></p>
				<script type="text/javascript">
					jQuery(function($){
						$('form#slz-ext-update-extensions').on('submit', function(){
							$(this).find('.check-column input[type="checkbox"]').prop('checked', true);
						});
					});
				</script>
			</div>
			<?php endif; ?>
		</form>
	<?php endif; ?>
</div>
<?php endif; ?>
