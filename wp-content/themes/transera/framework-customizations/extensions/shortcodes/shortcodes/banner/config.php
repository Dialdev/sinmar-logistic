<?php

if (! defined ( 'SLZ' )) {
	die ( 'Forbidden' );
}

$cfg = array ();

$cfg ['page_builder'] = array (
	'title' => esc_html__ ( 'SLZ Banner', 'transera' ),
	'description' => esc_html__ ( 'Banner for advertisement', 'transera' ),
	'tab' => slz()->theme->manifest->get('name'),
	'icon' => 'icon-slzcore-banner slz-vc-slzcore',
	'tag' => 'slz_banner'
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
	'icon_type_1'                   => 'none',
	'icon_fontawsome_1'             => '',
	'icon_flaticon_1'               => '',
	'icon_type_2'                   => 'none',
	'icon_fontawsome_2'             => '',
	'icon_flaticon_2'               => '',
);