<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$manifest = array();

$manifest['name'] = __('Forms', 'slz');
$manifest['description'] = __(
	'This extension adds the possibility to create a contact form.'
	.' Use the drag & drop form builder to create any contact form you\'ll ever want or need.',
	'slz'
);
$manifest['version'] = '2.0.24';
$manifest['standalone'] = false;
$manifest['display'] = false;
$manifest['github_update'] = 'ThemeFuse/Unyson-Forms-Extension';
$manifest['requirements']  = array(
	'extensions' => array(
		'builder' => array(),
	),
);