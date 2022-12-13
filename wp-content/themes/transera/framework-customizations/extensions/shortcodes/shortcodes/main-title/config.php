<?php

if (! defined ( 'SLZ' )) {
	die ( 'Forbidden' );
}

$cfg = array ();

$cfg ['page_builder'] = array (
		'title' => esc_html__ ( 'SLZ Main Title', 'transera' ),
		'description' => esc_html__ ( 'Main Title', 'transera' ),
		'tab' => slz()->theme->manifest->get('name'),
		'icon' => 'icon-slzcore-main-title slz-vc-slzcore',
		'tag' => 'slz_main_title'
);
$cfg ['styles'] = array (
	'style-1' => esc_html__( 'Style 1', 'transera' ),
	'style-2' => esc_html__( 'Style 2', 'transera' ),
);
$cfg ['default_value'] = array (
	'style'                  => 'style-1',
	'align' 			     => 'left',
	'subtitle' 			     => '',
	'title' 			     => '',
	'extra_title'            => '',
  	'image'                  => '',
  	'icon_fontawesome'       => '',
  	'show_icon'              => '2',
	'subtitle_color'         => '',
	'title_color'            => '',
	'extra_title_color'      => '',
	'extra_class' 		     => '',
	'css'                    => '',
	//options override from theme
	'subtitle_line_color'    => '',
	'extra_title_line_color' => '',
);