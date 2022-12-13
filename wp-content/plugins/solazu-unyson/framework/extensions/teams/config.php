<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$cfg = array();
$cfg['has_icon_tab'] = false;
$cfg['image_size'] = array (
	'large'				=> '600x600',
	'small'				=> '350x350',
	'no-image-large'	=> '600x600',
	'no-image-small'	=> '350x350'
);
$cfg['default_values'] = array(
	'show_thumbnail'		=> 'yes',
	'show_description'		=> 'no',
	'show_position'			=> 'yes',
	'show_contact_info'		=> 'no',
	'show_quote'			=> 'yes',
	'show_social'			=> 'yes'
);
$cfg['archive_columns'] = array(
	'has_sidebar' => 2,
	'no_sidebar'  => 3,
);
$cfg['enqueue_styles'] = true;
