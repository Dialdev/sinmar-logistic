<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * @var SLZ_Ext_Backups_Demo[] $demos
 */

/**
 * @var SLZ_Extension_Backups $backups
 */
$backups = slz_ext('backups');

if ($backups->is_disabled()) {
	$confirm = '';
} else {
	$confirm = esc_html__(
		'IMPORTANT: Installing this demo content will delete the content you currently have on your website.'
		. ' However, we create a backup of your current content in (Tools > Backup).'
		. ' You can restore the backup from there at any time in the future.',
		'slz'
	);
}
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
			<li>
				<a href="<?php echo esc_url ( admin_url( 'admin.php?page=' . slz_ext('backups')->get_page_slug() ) ); ?>">
					<span><?php echo esc_html__('Backup Data', 'slz'); ?></span>
				</a>
			</li>
		<?php endif; ?>
		<?php if ( slz()->extensions->_get_db_active_extensions('backups-demo') ) : ?>
			<li class="active">
				<a href="<?php echo esc_url ( admin_url( 'admin.php?page=' . slz_ext('backups-demo')->get_page_slug() ) ); ?>">
					<span><?php echo esc_html__('Demo Install', 'slz'); ?></span>
				</a>
			</li>
		<?php endif; ?>
	</ul>
</div>

<h2 class="tab-heading"><?php esc_html_e('Demo Content Install', 'slz') ?></h2>

<div class="slz-notice slz-notice-info">
    <strong><?php esc_html_e( 'Notice:', 'slz' ); ?></strong>
    <ul>
        <li>
	        <?php
	        printf(
		        esc_html__( 'Please %s before click Install Demo.', 'slz' ),
		        '<a href="' . esc_url( admin_url( 'admin.php?page=slz-settings#slz-options-tab-requirements_tab' ) ) . '" target="_blank">' . esc_html__( 'Check Requirement Here', 'slz' ) . '</a>'
	        ); ?>
        </li>
        <li>
	        <?php
	        printf(
		        esc_html__( 'After install demo, please install plugin %s, go to %s to regenerate thumbnails for all images.', 'slz' ),
		        '<a href="https://wordpress.org/plugins/regenerate-thumbnails/" target="_blank">Regenerate Thumbnails</a>',
		        '<strong>Tools → Regen. Thumbnails</strong>'
	        ); ?>
        </li>
    </ul>
</div>

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
	<?php endif; ?>
	<?php if (
		$http_loopback_warning 
		// || (function_exists('is_wpe') && is_wpe()) // WpEngine
	): ?>
		<script type="text/javascript">var slz_ext_backups_loopback_failed = true;</script>
	<?php endif; ?>
</div>

<p></p>
<div class="theme-browser rendered" id="slz-ext-backups-demo-list">
<?php foreach ($demos as $demo): ?>
	<div class="theme slz-ext-backups-demo-item" id="demo-<?php echo esc_attr($demo->get_id()) ?>">
		<div class="theme-screenshot">
			<img src="<?php echo esc_attr($demo->get_screenshot()); ?>" alt="Screenshot" />
		</div>
		<?php if ($demo->get_preview_link()): ?>
			<a class="more-details" target="_blank" href="<?php echo esc_attr($demo->get_preview_link()) ?>">
				<?php esc_html_e('Live Preview', 'slz') ?>
			</a>
		<?php endif; ?>
		<h3 class="theme-name"><?php echo esc_html($demo->get_title()); ?></h3>
		<div class="theme-actions">
			<a class="button button-primary"
			   href="#" onclick="return false;"
			   data-confirm="<?php echo esc_attr($confirm); ?>"
			   data-install="<?php echo esc_attr($demo->get_id()) ?>"><?php esc_html_e('Install', 'slz'); ?></a>
		</div>
	</div>
<?php endforeach; ?>
</div>
