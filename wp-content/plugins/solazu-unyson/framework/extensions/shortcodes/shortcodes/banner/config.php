<?php

if ( ! defined( 'ABSPATH' ) ) {
	die ( 'Forbidden' );
}

$cfg = array ();

$cfg ['page_builder'] = array (
	'title' => esc_html__ ( 'SLZ Banner', 'slz' ),
	'description' => esc_html__ ( 'Banner for advertisement', 'slz' ),
	'tab' => slz()->theme->manifest->get('name'),
	'icon' => 'icon-slzcore-banner slz-vc-slzcore',
	'tag' => 'slz_banner'
);

$cfg['styles'] = array(
	'1'  => esc_html__('Florida', 'slz'),
	'2'  => esc_html__('California', 'slz')
);

$cfg ['default_value'] = array (
	'style'                         => '1',
	'ads_img'                       => '',
	'title'                         => '',
	'title_color'                   => '',
    'background_color'              => '',
	'number_btn'                    => '',
	'cover_link'                    => '',
	'button_text_1'                 => '',
	'icon_align_1'                  => 'left',
	'btn_link_1'                    => '',
	'btn_text_color_1'              => '',
	'btn_text_hover_color_1'        => '',
	'btn_background_color_1'        => '',
	'btn_background_hover_color_1' 	=> '',
	'btn_border_color_1'            => '',
	'btn_border_hover_color_1'      => '',
	'button_text_2'                 => '',
	'icon_align_2'                  => 'left',
	'btn_link_2'                    => '',
	'btn_text_color_2'              => '',
	'btn_text_hover_color_2'        => '',
	'btn_background_color_2'        => '',
	'btn_background_hover_color_2'  => '',
	'btn_border_color_2'            => '',
	'btn_border_hover_color_2'      => '',
	'extra_class'                   => '',
	// button 01 icon
	'show_icon_1'                   => 'no',
	'icon_library'                  => 'vs',
    'icon_vs'                       => '',
    'icon_openiconic'               => '',
    'icon_typicons'                 => '',
    'icon_entypo'                   => '',
    'icon_linecons'                 => '',
    'icon_monosocial'               => '',
	// button 02 icon
	'show_icon_2'                   => 'no',
	'icon_library_2'                => 'vs',
    'icon_vs_2'                     => '',
    'icon_openiconic_2'             => '',
    'icon_typicons_2'               => '',
    'icon_entypo_2'                 => '',
    'icon_linecons_2'               => '',
    'icon_monosocial_2'             => ''
);