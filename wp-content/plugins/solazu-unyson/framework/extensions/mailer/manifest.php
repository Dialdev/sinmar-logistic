<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$manifest = array();

$manifest['name'] = __('Mailer', 'slz');
$manifest['description'] = __('This extension will let you set some global email options and it is used by other extensions (like Forms) to send emails.', 'slz');
$manifest['version'] = '1.2.7';
$manifest['standalone'] = false;
$manifest['display'] = false;
$manifest['github_update'] = 'ThemeFuse/Unyson-Mailer-Extension';
