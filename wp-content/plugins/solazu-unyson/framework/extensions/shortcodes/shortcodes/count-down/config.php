<?php

if (! defined ( 'SLZ' )) {
	die ( 'Forbidden' );
}

$cfg = array ();

$cfg ['page_builder'] = array (
		'title'         => esc_html__ ( 'SLZ Count Down', 'floury' ),
		'description'   => esc_html__ ( 'Add Count Down with custom option.', 'floury' ),
		'tab'           => slz()->theme->manifest->get('name'),
		'icon'          => 'icon-slzcore-count-down slz-vc-slzcore',
		'tag'           => 'slz_count_down'
);

$cfg ['default_value'] = array (
	'date'              => '',
    'colon_color'       => '',
	'number_color'      => '',
	'extra_class'       => '',
	'title_color'       => '',
	'bg_color'          => '',
	'animation_color'   => ''
);