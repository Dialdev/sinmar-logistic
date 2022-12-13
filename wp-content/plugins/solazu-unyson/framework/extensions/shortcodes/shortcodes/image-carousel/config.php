<?php
if ( ! defined( 'ABSPATH' ) ) {
	die ( 'Forbidden' );
}

$cfg = array ();

$cfg ['styles'] = array (
	'1' => esc_html__( 'Florida', 'slz' ),
	'2' => esc_html__( 'California', 'slz' ),
	'3' => esc_html__( 'Georgia', 'slz' )
);

$cfg['layouts'] = array(
	'layout-1'   => esc_html__( 'United States', 'slz' ),
	'layout-2'   => esc_html__( 'India', 'slz' ),
	'layout-3'   => esc_html__( 'United Kingdom', 'slz' )
);

$cfg['yes_no'] = array(
	esc_html__( 'Yes', 'slz' )   => 'yes',
	esc_html__( 'No', 'slz' )    => 'no',
);

$cfg['image_options'] = array(
	esc_html__( 'Full', 'slz' )            => 'full',
	esc_html__( 'Large', 'slz' )           => 'large',
	esc_html__( 'Post Thumbnail', 'slz' )  => 'post-thumbnail',
);

$cfg ['image_size'] = array (
		'large' => '250x300',
		'no-image-large' => '250x300',
);

$cfg ['page_builder'] = array (
		'title' => esc_html__ ( 'SLZ Image Carousel', 'slz' ),
		'description' => esc_html__ ( 'Slider of upload image', 'slz' ),
		'tab' => slz()->theme->manifest->get('name'),
		'icon' => 'icon-slzcore-image-carousel slz-vc-slzcore',
		'tag' => 'slz_image_carousel'
);

$cfg ['default_value'] = array (
	'layout'                => 'layout-1',
	'style'                 => '1',
	'img_slider'            => '',
	'extra_class'           => '',
	'slidetoshow'           => '2',
	'arrow'                 => 'yes',
	'dots'                  => 'yes',
	'slide_autoplay'        => 'yes',
	'slide_infinite'        => 'yes',
	'arrow_text_color'      => '',
	'arrow_hover_color'     => '',
	'arrow_bg_color'        => '',
	'arrow_bg_hv_color'     => '',
	'dots_color'            => '',
	'dots_color_active'     => '',
	'mobile_img_2'          => 'yes',
	'upload_mobile_img_2'   => '',
// 	'arrow_2'               => 'yes',
// 	'slidetoshow_3'         => '4',
// 	'arrow_3'               => 'yes',
	'image_options'         => 'post-thumbnail',
);