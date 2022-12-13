<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$cfg = array();
$cfg['enable_extension_css'] = array(
	'donation',
	'events',
	// 'footers',
	'gallery',
	// 'headers',
	// 'new-tweet',
	'portfolio',
	// 'posts',
	'recruitment',
	// 'social-counter',
	'teams',
	'testimonials',
	'widgets',
);
$cfg['enable_breakingnews'] = false;
$cfg['enable_post_format_gallery'] = true;
$cfg['enable_extension_js'] = array(
	'donation',
	'events',
	'gallery',
	'portfolio',
	// 'posts',
	'services',
	'teams',
	'testimonials',
);
$cfg['enable_shortcodes_css'] = array(
	'about-me',
	'accordion',
	'author-list',
	'banner',
	'button',
	'counter',
	'counterv2',
	'contact',
	// 'contact-form',
	'icon-box',
	'image-carousel',
	'main-title',
	// 'map',
	// 'newsletter',
	// 'partner',
	'posts-carousel',
	'posts-grid',
	'pricing-box',
	// 'progress-bar',
	'timeline',
);
$cfg['extra_css'] = array(
	//'test',
	'icon-boxv2'
);