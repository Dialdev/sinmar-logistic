<?php if (!defined('SLZ')) die('Forbidden');

/** @internal */
function _transera_filter_enable_shortcodes($args)
{
	$args = array(
		'accordion',
		'ads_banner',
		'banner',
		'button',
		'category',
		'contact',
		'counter',
		'icon_box',
		'image',
		'image_carousel',
		'item_list',
		'main_title',
		'map',
		'material_download',
		'newsletter',
		'partner',
		'posts_block',
		'posts_carousel',
		'pricing_box',
		'progress_bar',
		'tabs',
		'tags',
		'gallery_feature',
		'gallery_carousel',
		'gallery_tab',
		'isotope',
		'recruitment_list',
		'service_list',
		'team_list',
		'testimonial',
	);
	return $args;
}
add_filter('slz_ext_shortcodes_enable_shortcodes', '_transera_filter_enable_shortcodes');