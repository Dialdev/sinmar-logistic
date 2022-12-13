<?php

if (! defined ( 'SLZ' )) {
	die ( 'Forbidden' );
}

$cfg = array ();

$cfg ['page_builder'] = array (
		'title' => esc_html__ ( 'SLZ Counter', 'transera' ),
		'description' => esc_html__ ( 'Create counter block.', 'transera' ),
		'tab' => slz()->theme->manifest->get('name'),
		'icon' => 'icon-slzcore-counter slz-vc-slzcore',
		'tag' => 'slz_counter'
);

$cfg ['layouts'] = array (
		'layout-1' => esc_html__ ( 'Layout 1', 'transera' ),
);

$cfg ['default_value'] = array (
		'layout'        => 'layout-1',
		'title' 	    => '',
		'icon_type'     => '',
		'icon_flaticon' => '',
		'img_up'        => '',
		'title_color'   => '',
		'number'        => '',
		'number_color'  => '',
		'icon_color'    => '',
		'extra_class'   => '',
		'animation'     => '',
		'alignment'     => 'counter-left',
		'show_line'     => '',
		'border_color'  => '',
		// update icon
		'icon_library'     => 'vs',
		'icon_vs'          => '',
		'icon_openiconic'  => '',
		'icon_typicons'    => '',
		'icon_linecons'    => '',
		'icon_monosocial'  => '',
		'icon_entypo'      => '',
);