<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$manifest = array();

$manifest['name'] = __('Update', 'slz');
$manifest['description'] = __('Keep you framework, extensions and theme up to date.', 'slz');
$manifest['standalone'] = true;

$manifest['version'] = '1.0.11';
$manifest['github_update'] = 'ThemeFuse/Unyson-Update-Extension';
