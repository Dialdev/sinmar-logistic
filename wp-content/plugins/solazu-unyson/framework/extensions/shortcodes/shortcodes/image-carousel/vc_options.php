<?php

$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'image_carousel' );
$yes_no = $shortcode->get_config('yes_no');
$layouts = array(
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Layout', 'slz' ),
		'param_name'  => 'layout',
		'value'       => $shortcode->get_layouts(),
		'std'         => 'layout-1',
		'description' => esc_html__( 'Choose layout to show', 'slz' )
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Image Options', 'slz' ),
		'param_name'  => 'image_options',
		'value'       => $shortcode->get_config('image_options'),
		'std'         => 'post-thumbnail',
		'description' => esc_html__( 'Choose image size to show', 'slz' ),
	),
);

$layout_options = $shortcode->get_layout_options();

$params = array(
	array(
		'type'       => 'param_group',
		'heading'    => esc_html__( 'Image Slider', 'slz' ),
		'param_name' => 'img_slider',
		'params'     => array(	
			array(
				'type'           => 'attach_image',
				'heading'        => esc_html__( 'Upload Image', 'slz' ),
				'param_name'     => 'img',
				'description'    => esc_html__('Choose image to add to slider.', 'slz'),
			),
		    array(
				'type'        => 'vc_link',
		    	'admin_label' => true,
				'heading'     => esc_html__( 'URL', 'slz' ),
				'param_name'  => 'link',
				'description' => esc_html__( 'Input a URL to redirect the website to it when user click on the image.', 'slz' )
			),
		),
	),
);

$extra_class = array(
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Extra Class', 'slz' ),
		'param_name'  => 'extra_class',
		'value'       => '',
		'description' => esc_html__( 'Add extra class to button', 'slz' )
	)
);
$custom_slide = array(
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Slide to Show', 'slz' ),
		'param_name'  => 'slidetoshow',
		'value'       => '2',
		'description' => esc_html__( 'Choose number of item show.', 'slz' ),
		'group'       => esc_html__( 'Custom Slider', 'slz' ),
		'dependency'  => array(
			'element'   => 'layout',
			'value_not_equal_to'     => array( 'layout-2' )
		),
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Show Arrows?', 'slz' ),
		'param_name'  => 'arrow',
		'value'       => $yes_no,
		'std'         => 'yes',
		'description' => esc_html__( 'Choose if want to show arrow or not.', 'slz' ),
		'group'       => esc_html__( 'Custom Slider', 'slz' )
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Show Dots?', 'slz' ),
		'param_name'  => 'dots',
		'value'       => $yes_no,
		'std'         => 'yes',
		'description' => esc_html__( 'Choose if want to show dots or not.', 'slz' ),
		'group'       => esc_html__( 'Custom Slider', 'slz' )
	),
	array(
		'type'        	=> 'dropdown',
		'heading'     	=> esc_html__( 'Is Auto Play ?', 'slz' ),
		'param_name'  	=> 'slide_autoplay',
		'value'       	=> $yes_no,
		'std'      		=> 'yes',
		'description' 	=> esc_html__( 'Choose YES to slide auto play.', 'slz' ),
		'group'         => esc_html__('Custom Slider', 'slz')
	),
	array(
		'type'        	=> 'dropdown',
		'heading'     	=> esc_html__( 'Is Loop Infinite ?', 'slz' ),
		'param_name'  	=> 'slide_infinite',
		'value'       	=> $yes_no,
		'std'      		=> 'yes',
		'description' 	=> esc_html__( 'Choose YES to slide loop infinite.', 'slz' ),
		'group'         => esc_html__('Custom Slider', 'slz')
	),
	array(
		'type'          => 'colorpicker',
		'heading'       => esc_html__( 'Arrows Color', 'slz' ),
		'param_name'    => 'arrow_text_color',
		'value'         => '',
		'description'   => esc_html__( 'Choose color to slide arrows.', 'slz' ),
		'dependency'    => array(
			'element'   => 'arrow',
			'value'     => array( 'yes' )
		),
		'group'       	=> esc_html__('Custom Color', 'slz')
	),
	array(
		'type'          => 'colorpicker',
		'heading'       => esc_html__( 'Arrows Hover Color', 'slz' ),
		'param_name'    => 'arrow_hover_color',
		'value'         => '',
		'description'   => esc_html__( 'Choose hover color to slide arrows.', 'slz' ),
		'dependency'    => array(
			'element'   => 'arrow',
			'value'     => array( 'yes' )
		),
		'group'       	=> esc_html__('Custom Color', 'slz')
	),
	array(
		'type'          => 'colorpicker',
		'heading'       => esc_html__( 'Arrows Background Color', 'slz' ),
		'param_name'    => 'arrow_bg_color',
		'value'         => '',
		'description'   => esc_html__( 'Choose background color to slide arrows.', 'slz' ),
		'dependency'    => array(
			'element'   => 'arrow',
			'value'     => array( 'yes' )
		),
		'group'       	=> esc_html__('Custom Color', 'slz')
	),
	array(
		'type'          => 'colorpicker',
		'heading'       => esc_html__( 'Arrows Background Hover Color', 'slz' ),
		'param_name'    => 'arrow_bg_hv_color',
		'value'         => '',
		'description'   => esc_html__( 'Choose background hover color to slide arrow.', 'slz' ),
		'dependency'    => array(
			'element'   => 'arrow',
			'value'     => array( 'yes' )
		),
		'group'       	=> esc_html__('Custom Color', 'slz')
	),
	array(
		'type'          => 'colorpicker',
		'heading'       => esc_html__( 'Dots Color', 'slz' ),
		'param_name'    => 'dots_color',
		'value'         => '',
		'description'   => esc_html__( 'Choose color to slide dots.', 'slz' ),
		'dependency'    => array(
			'element'   => 'dots',
			'value'     => array( 'yes' )
		),
		'group'       	=> esc_html__('Custom Color', 'slz')
	),
	array(
		'type'          => 'colorpicker',
		'heading'       => esc_html__( 'Dots Color Active', 'slz' ),
		'param_name'    => 'dots_color_active',
		'value'         => '',
		'description'   => esc_html__( 'Choose color to slide dots when active, hover.', 'slz' ),
		'dependency'    => array(
			'element'   => 'dots',
			'value'     => array( 'yes' )
		),
		'group'       	=> esc_html__('Custom Color', 'slz')
	)
);

$vc_options = array_merge(
	$layouts,
	$layout_options,
	$params,
	$extra_class,
	$custom_slide
);