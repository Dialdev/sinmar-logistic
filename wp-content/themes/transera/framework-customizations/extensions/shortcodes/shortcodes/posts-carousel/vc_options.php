<?php

$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'posts_carousel' );

$params = array(
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Layout', 'transera' ),
		'param_name'  => 'template',
		'value'       => $shortcode->get_styles(),
		'std'		  => 3,
		'description' => esc_html__( 'Choose a layout to show.', 'transera' ),
		'edit_field_class'  => 'hidden'
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Block Title', 'transera' ),
		'param_name'  => 'block_title',
		'value'       => '',
		'description' => esc_html__( 'Block title. If it blank the block will not have a title', 'transera' )
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Block Title Color', 'transera' ),
		'param_name'  => 'block_title_color',
		'value'       => '',
		'description' => esc_html__( 'Choose a custom title text color.', 'transera' )
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Show Excerpt', 'transera' ),
		'param_name'  => 'excerpt',
		'value'       => array(
			esc_html__('Show', 'transera')	=>	'show',
			esc_html__('Hide', 'transera')	=>	'hide'
		),
		'std'         => 'show',
		'description' => esc_html__( 'Show or hide post excerpt', 'transera' )
	),
    array(
        'type'        => 'textfield',
        'heading'     => esc_html__( 'Excerpt Length', 'transera' ),
        'param_name'  => 'excerpt_length',
        'value'       => '30',
        'description' => esc_html__( 'Input number of excerpt length.', 'transera' ),
        'dependency'  => array(
            'element'   => 'excerpt',
            'value'     => array('show')
        )
    ),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Show Readmore Button', 'transera' ),
		'param_name'  => 'readmore',
		'value'       => array(
			esc_html__('Show', 'transera')	=>	'show',
			esc_html__('Hide', 'transera')	=>	'hide'
		),
		'std'         => 'show',
		'description' => esc_html__( 'Show or hide readmore button', 'transera' )
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Button Text', 'transera' ),
		'param_name'  => 'button_text',
		'value'       => 'Read More',
		'description' => esc_html__( 'Button text. If it blank the button will not have text', 'transera' ),
		'dependency'     => array(
			'element'  => 'readmore',
			'value'    => array( 'show' )
		),
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Number Posts', 'transera' ),
		'param_name'  => 'limit_post',
		'value'       => '5',
		'description' => esc_html__( 'The number of posts to display. If it blank the number posts will be the number from Settings -> Reading', 'transera' )
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Offset Posts', 'transera' ),
		'param_name'  => 'offset_post',
		'value'       => '',
		'description' => esc_html__( 'Enter offset to display. If you want to start on record 6, using offset 5', 'transera' )
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Sort By', 'transera' ),
		'param_name'  => 'sort_by',
		'value'       => slz()->backend->get_param('sort_blog'),
		'description' => esc_html__( 'Choose criteria to display.', 'transera' )
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Extra Class', 'transera' ),
		'param_name'  => 'extra_class',
		'value'       => '',
		'description' => esc_html__( 'Add extra class to block', 'transera' )
	)
);

$yes_no  = array(
	esc_html__('Yes', 'transera')		=> 'yes',
	esc_html__('No', 'transera')		=> 'no'
);
$animation  = array(
	esc_html__('Slide', 'transera')		=> '0',
	esc_html__('Fade', 'transera')		=> '1'
);
$custom_slide = array(
	array(
		'type'        	=> 'dropdown',
		'heading'     	=> esc_html__( 'Show Dots ?', 'transera' ),
		'param_name'  	=> 'show_dots',
		'value'       	=> $yes_no,
		'std'      		=> 'yes',
		'description' 	=> esc_html__( 'If choose Yes, block will be show dots.', 'transera' ),
		'group'         => esc_html__('Slide Custom', 'transera')
	),
	array(
		'type'        	=> 'dropdown',
		'heading'     	=> esc_html__( 'Show Arrow ?', 'transera' ),
		'param_name'  	=> 'show_arrows',
		'value'       	=> $yes_no,
		'std'      		=> 'yes',
		'description' 	=> esc_html__( 'If choose Yes, block will be show arrow.', 'transera' ),
		'group'         => esc_html__('Slide Custom', 'transera')
	),
	array(
		'type'        	=> 'dropdown',
		'heading'     	=> esc_html__( 'Is Auto Play ?', 'transera' ),
		'param_name'  	=> 'slide_autoplay',
		'value'       	=> $yes_no,
		'std'      		=> 'yes',
		'description' 	=> esc_html__( 'Choose YES to slide auto play.', 'transera' ),
		'group'         => esc_html__('Slide Custom', 'transera')
	),
	array(
		'type'        	=> 'dropdown',
		'heading'     	=> esc_html__( 'Is Loop Infinite ?', 'transera' ),
		'param_name'  	=> 'slide_infinite',
		'value'       	=> $yes_no,
		'std'      		=> 'yes',
		'description' 	=> esc_html__( 'Choose YES to slide loop infinite.', 'transera' ),
		'group'         => esc_html__('Slide Custom', 'transera')
	),
	array(
		'type'          => 'textfield',
		'heading'       => esc_html__( 'Speed Slide', 'transera' ),
		'param_name'    => 'slide_speed',
		'value'			=> '',
		'description'   => esc_html__( 'Enter number value. Unit is millisecond. Example: 600.', 'transera' ),
		'group'         => esc_html__('Slide Custom', 'transera')
	),
	array(
		'type'          => 'dropdown',
		'heading'       => esc_html__( 'Animation?', 'transera' ),
		'param_name'    => 'animation',
		'value'			=> $animation,
		'description'   => esc_html__( 'Choose a animation', 'transera' ),
		'group'         => esc_html__('Slide Custom', 'transera')
	)
);

$vc_options = array_merge( 
	$params,
	slz()->backend->get_param('shortcode_filter'),
	slz()->backend->get_param('shortcode_ajax_filter'),
	$custom_slide
);
