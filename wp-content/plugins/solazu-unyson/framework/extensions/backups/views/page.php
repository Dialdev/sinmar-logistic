<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * @var string $archives_html
 */
?>

<?php
$backups = slz_ext( 'backups' ); /** @var SLZ_Extension_Backups $backups */
$page_url = $backups->get_page_url();
?>
<div class="uns-featured-section">
	<h2 class="heading-title"><?php echo esc_html__('Welcome to', 'slz'); ?> <?php echo esc_html( slz()->theme->manifest->get('name') ); ?></h2>
	<div class="description">
		<?php echo esc_html( slz()->theme->manifest->get('description') ); ?>
	</div>
	<ul class="nav nav-tabs nav-justified">
		<li>
			<a href="<?php echo esc_url ( admin_url( 'admin.php?page=' . slz()->theme->manifest->get('id') ) ); ?>">
				<span><?php echo esc_html__('Plugins', 'slz'); ?></span>
			</a>
		</li>
		<li>
			<a href="<?php echo esc_url ( admin_url( 'admin.php?page=' . slz()->theme->manifest->get('log_page_id') ) ); ?>">
				<span><?php echo esc_html__('Changes Log', 'slz'); ?></span>
			</a>
		</li>
		<li>
			<a href="<?php echo esc_url ( admin_url( 'admin.php?page=' . slz()->extensions->manager->get_page_slug() ) ); ?>">
				<span><?php echo esc_html__('Extension Manager', 'slz'); ?></span>
			</a>
		</li>
		<li>
			<a href="<?php echo esc_url ( admin_url( 'admin.php?page=' . slz()->backend->_get_settings_page_slug() ) ); ?>">
				<span><?php echo esc_html__('Theme Settings', 'slz'); ?></span>
			</a>
		</li>
		<?php if ( slz()->extensions->_get_db_active_extensions('backups') ) : ?>
			<li class="active">
				<a href="<?php echo esc_url ( admin_url( 'admin.php?page=' . slz_ext('backups')->get_page_slug() ) ); ?>">
					<span><?php echo esc_html__('Backup Data', 'slz'); ?></span>
				</a>
			</li>
		<?php endif; ?>
		<?php if ( slz()->extensions->_get_db_active_extensions('backups-demo') ) : ?>
			<li>
				<a href="<?php echo esc_url ( admin_url( 'admin.php?page=' . slz_ext('backups-demo')->get_page_slug() ) ); ?>">
					<span><?php echo esc_html__('Demo Install', 'slz'); ?></span>
				</a>
			</li>
		<?php endif; ?>
	</ul>
</div>

<h2 class="tab-heading"><?php esc_html_e('Backup', 'slz') ?> <span id="slz-ext-backups-status"></span></h2>

<div>
	<?php if ( !class_exists('ZipArchive') ): ?>
		<div class="error below-h2">
			<p>
				<strong><?php _e( 'Important', 'slz' ); ?></strong>:
				<?php printf(
					__( 'You need to activate %s.', 'slz' ),
					'<a href="http://php.net/manual/en/book.zip.php" target="_blank">'. __('zip extension', 'slz') .'</a>'
				); ?>
			</p>
		</div>
	<?php endif; ?>

	<?php if ($http_loopback_warning = slz_ext_backups_loopback_test()) : ?>
		<div class="error">
			<p><strong><?php _e( 'Important', 'slz' ); ?>:</strong> <?php echo $http_loopback_warning; ?></p>
		</div>
		<script type="text/javascript">var slz_ext_backups_loopback_failed = true;</script>
	<?php endif; ?>

	<div class="slz-ext-backups-description">
		<p class="description"><?php esc_html_e( 'Here you can create a backup schedule for your website.', 'slz' ); ?></p>
		<ul>
			<?php if (slz_ext_backups_current_user_can_full()): ?>
			<li>
				<span class="description">
				<strong><?php esc_html_e('Full Backup', 'slz'); ?></strong>
				- <?php esc_html_e('will save your themes, plugins, uploads and full database.'); ?>
				</span>
			</li>
			<?php endif; ?>
			<li>
				<span class="description">
				<strong><?php esc_html_e('Content Backup', 'slz'); ?></strong>
				- <?php esc_html_e('will save your uploads and database without private data like users, admin email, etc.'); ?>
				</span>
			</li>
		</ul>
	</div>

	<div id="slz-ext-backups-schedule-status"></div>

	<div>
		<a href="#" onclick="return false;" id="slz-ext-backups-edit-schedule"
		   class="button button-primary"><?php esc_html_e( 'Edit Backup Schedule', 'slz' ) ?></a>
		&nbsp;
		<?php if (slz_ext_backups_current_user_can_full()): ?>
		<a href="#" onclick="return false;" id="slz-ext-backups-full-backup-now"
		   class="button slz-ext-backups-backup-now" data-full="1"><?php esc_html_e('Create Full Backup Now', 'slz') ?></a>
		&nbsp;
		<?php endif; ?>
		<a href="#" onclick="return false;" id="slz-ext-backups-content-backup-now"
		   class="button slz-ext-backups-backup-now" data-full=""><?php esc_html_e('Create Content Backup Now', 'slz'); ?></a>
	</div>
</div>

<br>
<h3><?php _e( 'Archives', 'slz' ) ?></h3>

<div id="slz-ext-backups-archives"><?php echo $archives_html; ?></div>

<br>
<?php do_action('slz_ext_backups_page_footer'); ?>