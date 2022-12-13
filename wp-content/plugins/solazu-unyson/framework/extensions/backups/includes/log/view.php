<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * @var array $log
 */
?>

<?php if ($log): ?>
	<div id="slz-ext-backups-log-show-button">
		<a href="#" onclick="return false;" class="button-view"><?php esc_html_e('View Activity Log', 'slz'); ?></a>
		<a href="#" onclick="return false;" class="button-hide"><?php esc_html_e('Hide Activity Log', 'slz'); ?></a>
	</div>
	<div id="slz-ext-backups-log-list">
		<ul>
		<?php foreach ($log as $l): ?>
			<?php
			switch (isset($l['type']) ? $l['type'] : '') {
				case 'success': $class = 'slz-text-success'; break;
				case 'info':    $class = 'slz-text-info'; break;
				case 'warning': $class = 'slz-text-warning'; break;
				case 'error':   $class = 'slz-text-danger'; break;
				default:        $class = ''; break;
			}
			?>
			<li>
				<em><?php printf(esc_html__('%s ago', 'slz'), human_time_diff($l['time'])); ?></em>
				<span class="<?php echo esc_attr($class) ?>"><?php echo esc_html($l['title']); ?></span>
			</li>
		<?php endforeach ?>
		</ul>
	</div>
<?php endif; ?>



