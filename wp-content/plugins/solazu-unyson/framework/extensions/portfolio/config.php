<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$cfg = array();
// Enable/Disable taxonomy status
$cfg['enable_status'] = false;
// Enable/Disable taxonomy tags
$cfg['enable_tag'] = false;

$cfg['supports_comment'] = false;
$cfg['supports_author'] = true;

// Include {history, other } tab to Project Options
$cfg['has_gallery'] = false;
$cfg['has_history_tab'] = false; // This tab is needs enable_status = true
$cfg['has_other_tab'] = false;
$cfg['has_team_tab'] = false;
$cfg['has_album_tab'] = false;

$cfg['image_size'] = array (
	'portfolio' => array(
		'large'				=> '550x350',
		'small'				=> '320x320',
		'no-image-large'	=> '550x350',
		'no-image-small'	=> '320x320'
	)
);
$cfg['mbox_name'] = esc_html__('Project Options', 'slz');

$cfg['sort_portfolio'] = array(
	esc_html__( '- Latest -', 'slz' )         => '',
	esc_html__('A to Z', 'slz')               => 'az_order',
	esc_html__('Z to A', 'slz')               => 'za_order',
	esc_html__('Post is selected', 'slz')     => 'post__in',
	esc_html__('Random', 'slz')               => 'random_posts',
);
$cfg['enqueue_styles'] = true;