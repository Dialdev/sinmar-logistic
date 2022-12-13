<?php
if (! defined ( 'SLZ' )) {
	die ( 'Forbidden' );
}

$cfg = array ();

$cfg ['styles'] = array (
	'1' => esc_html__( 'Style 1', 'transera' ),
	'2' => esc_html__( 'Style 2', 'transera' ),
	'3' => esc_html__( 'Style 3', 'transera' )
);

$cfg['layouts'] = array(
	'layout-1'   => esc_html__( 'Layout 1', 'transera' ),
	'layout-2'   => esc_html__( 'Layout 2', 'transera' ),
	'layout-3'   => esc_html__( 'Layout 3', 'transera' )
);

$cfg['yes_no'] = array(
	esc_html__( 'Yes', 'transera' )   => 'yes',
	esc_html__( 'No', 'transera' )    => 'no',
);

$cfg['image_options'] = array(
	esc_html__( 'Full', 'transera' )            => 'full',
	esc_html__( 'Large', 'transera' )           => 'large',
	esc_html__( 'Post Thumbnail', 'transera' )  => 'post-thumbnail',
);

$cfg ['image_size'] = array (
		'large' => '250x300',
		'no-image-large' => '250x300',
);

$cfg ['page_builder'] = array (
		'title' => esc_html__ ( 'SLZ Image Carousel', 'transera' ),
		'description' => esc_html__ ( 'Slider of upload image', 'transera' ),
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
	'image_options'         => 'post-thumbnail',
);