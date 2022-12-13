<?php if (!defined('SLZ')) die('Forbidden');

if (! is_admin()) {
	wp_enqueue_style(
			'transera-slz-extension-widgets',
			slz_ext('widgets')->locate_URI('/static/css/transera-widgets.css')
	);
}