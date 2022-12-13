<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * @var array $extension_names
 * @var array $installed_extensions
 * @var array $list_page_link
 */

$count = count($extension_names);
?>

<p><?php echo _n(
	'You are about to remove the following extension:',
	'You are about to remove the following extensions:',
	$count,
	'slz'
) ?></p>

<ul class="ul-disc">
	<?php foreach ($extension_names as $extension_name): ?>
		<li><strong><?php echo slz()->extensions->manager->get_extension_title($extension_name); ?></strong></li>
	<?php endforeach; ?>
</ul>

<p><?php
	echo _n(
		'Are you sure you wish to delete this extension?',
		'Are you sure you wish to delete these extensions?',
		$count,
		'slz'
	)
?></p>

<input type="submit" name="submit" id="submit" class="button" value="<?php
	echo esc_attr( _n(
		'Yes, Delete this extension',
		'Yes, Delete these extensions',
		$count,
		'slz'
	) )
?>">

<a class="button" href="<?php echo esc_attr($list_page_link) ?>" ><?php _e('No, Return me to the extension list', 'slz') ?></a>

<p>
	<a href="#" onclick="jQuery('#files-list').toggle(); return false;"><?php _e('Click to view entire list of directories which will be deleted', 'slz') ?></a>
</p>
<div id="files-list" style="display: none;">
	<ul class="code">
		<?php $replace_regex = '/^'. preg_quote(slz_get_framework_directory('/extensions'), '/') .'/'; ?>
		<?php foreach ($extension_names as $extension_name): ?>
			<?php if (!isset($installed_extensions[$extension_name])) continue; ?>
			<li><?php echo preg_replace($replace_regex, '', $installed_extensions[$extension_name]['path']) ?>/</li>
		<?php endforeach; ?>
	</ul>
</div>