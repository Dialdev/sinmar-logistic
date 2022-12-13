<?php

$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'posts_carousel' );

$params = array(
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Layout', 'slz' ),
		'param_name'  => 'template',
		'value'       => $shortcode->get_styles(),
		'std'		  => 1,
		'description' => esc_html__( 'Choose a layout to show.', 'slz' ),
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Column', 'slz' ),
		'param_name'  => 'column',
		'value'       => array(
			esc_html__('One Column', 'slz') 			=>	1,
			esc_html__('Two Column', 'slz')				=>	2,
			esc_html__('Three Column', 'slz')			=>	3,
			esc_html__('Four Column', 'slz')			=>	4
		),
		'std'		  => 1,
		'description' => esc_html__( 'Choose a column for display block.', 'slz' ),
		'dependency'  => array(
			'element' => 'template',
			'value'   => array('1', '3', '5', '6')
		)
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Style', 'slz' ),
		'param_name'  => 'style',
		'value'       => array(
			esc_html__('Florida', 'slz') 			=>	1,
			esc_html__('California', 'slz')			=>	2,
			esc_html__('Georgia', 'slz')			=>	3
		),
		'std'		  => 1,
		'description' => esc_html__( 'Choose a column for display block.', 'slz' ),
		'dependency' => array(
			'element' => 'template',
			'value' => '1',
		),
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Block Title', 'slz' ),
		'param_name'  => 'block_title',
		'value'       => '',
		'description' => esc_html__( 'Block title. If it blank the block will not have a title', 'slz' )
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Block Title Color', 'slz' ),
		'param_name'  => 'block_title_color',
		'value'       => '',
		'description' => esc_html__( 'Choose a custom title text color.', 'slz' )
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Show Excerpt', 'slz' ),
		'param_name'  => 'excerpt',
		'value'       => array(
			esc_html__('Show', 'slz')	=>	'show',
			esc_html__('Hide', 'slz')	=>	'hide'
		),
		'std'         => 'show',
		'description' => esc_html__( 'Show or hide post excerpt', 'slz' )
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
		'heading'     => esc_html__( 'Show Readmore Button', 'slz' ),
		'param_name'  => 'readmore',
		'value'       => array(
			esc_html__('Show', 'slz')	=>	'show',
			esc_html__('Hide', 'slz')	=>	'hide'
		),
		'std'         => 'show',
		'description' => esc_html__( 'Show or hide readmore button', 'slz' )
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Number Posts', 'slz' ),
		'param_name'  => 'limit_post',
		'value'       => '5',
		'description' => esc_html__( 'The number of posts to display. If it blank the number posts will be the number from Settings -> Reading', 'slz' )
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Offset Posts', 'slz' ),
		'param_name'  => 'offset_post',
		'value'       => '',
		'description' => esc_html__( 'Enter offset to display. If you want to start on record 6, using offset 5', 'slz' )
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Sort By', 'slz' ),
		'param_name'  => 'sort_by',
		'value'       => slz()->backend->get_param('sort_blog'),
		'description' => esc_html__( 'Choose criteria to display.', 'slz' )
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Extra Class', 'slz' ),
		'param_name'  => 'extra_class',
		'value'       => '',
		'description' => esc_html__( 'Add extra class to block', 'slz' )
	)
);

$yes_no  = array(
	esc_html__('Yes', 'slz')		=> 'yes',
	esc_html__('No', 'slz')			=> 'no'
);
$animation  = array(
	esc_html__('Slide', 'slz')		=> '0',
	esc_html__('Fade', 'slz')		=> '1'
);
$custom_slide = array(
	array(
		'type'        	=> 'dropdown',
		'heading'     	=> esc_html__( 'Show Dots ?', 'slz' ),
		'param_name'  	=> 'show_dots',
		'value'       	=> $yes_no,
		'std'      		=> 'yes',
		'description' 	=> esc_html__( 'If choose Yes, block will be show dots.', 'slz' ),
		'group'         => esc_html__('Slide Custom', 'slz')
	),
	array(
		'type'        	=> 'dropdown',
		'heading'     	=> esc_html__( 'Show Arrow ?', 'slz' ),
		'param_name'  	=> 'show_arrows',
		'value'       	=> $yes_no,
		'std'      		=> 'yes',
		'description' 	=> esc_html__( 'If choose Yes, block will be show arrow.', 'slz' ),
		'group'         => esc_html__('Slide Custom', 'slz')
	),
	array(
		'type'        	=> 'dropdown',
		'heading'     	=> esc_html__( 'Is Auto Play ?', 'slz' ),
		'param_name'  	=> 'slide_autoplay',
		'value'       	=> $yes_no,
		'std'      		=> 'yes',
		'description' 	=> esc_html__( 'Choose YES to slide auto play.', 'slz' ),
		'group'         => esc_html__('Slide Custom', 'slz')
	),
	array(
		'type'        	=> 'dropdown',
		'heading'     	=> esc_html__( 'Is Loop Infinite ?', 'slz' ),
		'param_name'  	=> 'slide_infinite',
		'value'       	=> $yes_no,
		'std'      		=> 'yes',
		'description' 	=> esc_html__( 'Choose YES to slide loop infinite.', 'slz' ),
		'group'         => esc_html__('Slide Custom', 'slz')
	),
	array(
		'type'          => 'textfield',
		'heading'       => esc_html__( 'Speed Slide', 'slz' ),
		'param_name'    => 'slide_speed',
		'value'			=> '',
		'description'   => esc_html__( 'Enter number value. Unit is millisecond. Example: 600.', 'slz' ),
		'group'         => esc_html__('Slide Custom', 'slz')
	),
	array(
		'type'          => 'dropdown',
		'heading'       => esc_html__( 'Animation?', 'slz' ),
		'param_name'    => 'animation',
		'value'			=> $animation,
		'description'   => esc_html__( 'Choose a animation', 'slz' ),
		'group'         => esc_html__('Slide Custom', 'slz')
	)
);

$vc_options = array_merge( 
	$params,
	slz()->backend->get_param('shortcode_filter'),
	slz()->backend->get_param('shortcode_ajax_filter'),
	$custom_slide
);
