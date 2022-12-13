<?php
$sort_by = SLZ_Params::get('sort-other');

$yes_no  = array(
	esc_html__('Yes', 'transera')			=> 'yes',
	esc_html__('No', 'transera')			=> 'no',
);
$method = array(
	esc_html__( 'Category', 'transera' )	=> 'cat',
	esc_html__( 'Testimonial', 'transera' ) => 'testimonial'
);

$args = array('post_type'     => 'slz-testimonial');
$options = array('empty'      => esc_html__( '-All Testimonial-', 'transera' ) );
$testimonials = SLZ_Com::get_post_title2id( $args, $options );

$taxonomy = 'slz-testimonial-cat';
$params_cat = array('empty'   => esc_html__( '-All Testimonial Categories-', 'transera' ) );
$testimonial_cat = SLZ_Com::get_tax_options2slug( $taxonomy, $params_cat );

$animation  = array(
		esc_html__('Slide', 'transera')		=> '0',
		esc_html__('Fade', 'transera')		=> '1'
);


$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'testimonial' );

/* layout */
$layouts = array(
	array(
		'type'          => 'dropdown',
		'heading'       => esc_html__( 'Layout', 'transera' ),
		'param_name'    => 'layout',
		'value'         => $shortcode->get_layouts(),
		'std'           => 'layout-2',
		'description'   => esc_html__( 'Choose layout will be displayed.', 'transera' ),
		'edit_field_class' => 'hidden'
	)
);

/* layout options */
$layouts_option = $shortcode->get_layout_options();

/* title options */
$title = array(
    array(
        'type'        => 'textfield',
        'heading'     => esc_html__( 'Shortcode Title', 'transera' ),
        'param_name'  => 'sc_title',
        'value'       => '',
        'description' => esc_html__( 'Title. If it blank the will not have a title', 'transera' )
    ),
    array(
        'type'        => 'colorpicker',
        'heading'     => esc_html__( 'Shortcode Title Color', 'transera' ),
        'param_name'  => 'sc_title_color',
        'value'       => '',
        'description' => esc_html__( 'Choose a custom title text color.', 'transera' )
    ),
);
/* params */
$params = array(
	array(
		'type'        	=> 'dropdown',
		'heading'     	=> esc_html__( 'Show Position ?', 'transera' ),
		'param_name'  	=> 'show_position',
		'value'       	=> $yes_no,
		'std'      		=> 'yes',
		'description' 	=> esc_html__( 'If choose Yes, block will be show position.', 'transera' ),
	),
	array(
		'type'        	=> 'dropdown',
		'heading'     	=> esc_html__( 'Show Description ?', 'transera' ),
		'param_name'  	=> 'show_description',
		'value'       	=> $yes_no,
		'std'      		=> 'yes',
		'description' 	=> esc_html__( 'If choose Yes, block will be show description.', 'transera' ),
	),
    array(
        'type'        => 'dropdown',
        'heading'     => esc_html__( 'Avatar Image', 'transera' ),
        'param_name'  => 'show_image_1',
        'value'       => array(
            esc_html__('Show Feature Image', 'transera') => '2',
            esc_html__('Show Icon', 'transera') => '1',
            esc_html__('Show Thumbnail Image', 'transera') => '0'
        ),
        'std'         => '',
        'description' => esc_html__( 'Select image type for Avatar.', 'transera' ),
    	'dependency'  => array(
    		'element'   => 'layout',
    		'value_not_equal_to'     => array( 'layout-5' )
    	),
    ),
	array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Addition Image', 'transera' ),
			'param_name'  => 'show_image_2',
			'value'       => array(
					esc_html__('Show Feature Image', 'transera') => '2',
					esc_html__('Show Icon', 'transera') => '1',
					esc_html__('Show Thumbnail Image', 'transera') => '0'
			),
			'std'         => '0',
			'description' => esc_html__( 'Select image for image above title.', 'transera' ),
			'dependency'  => array(
					'element'   => 'layout',
					'value'     => array( 'layout-2' )
			),
	),		
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Limit Posts', 'transera' ),
		'param_name'  => 'limit_post',
		'value'       => '-1',
		'description' => esc_html__( 'Add limit posts per page. Set -1 or empty to show all. The number of posts to display. If it blank the number posts will be the number from Settings -> Reading', 'transera' )
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Offset Post', 'transera' ),
		'param_name'  => 'offset_post',
		'value'       => '',
		'description' => esc_html__( 'Enter offset to pass over posts. If you want to start on record 6, using offset 5', 'transera' )
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Sort By', 'transera' ),
		'param_name'  => 'sort_by',
		'value'       => $sort_by,
		'description' => esc_html__( 'Select order to display list properties.', 'transera' )
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Display By', 'transera' ),
		'param_name'  => 'method',
		'value'       => $method,
		'description' => esc_html__( 'Choose testimonial category or special testimonials to display', 'transera' ),
		'group'       	=> esc_html__('Filter', 'transera'),
	),
	array(
		'type'        => 'param_group',
		'heading'     => esc_html__( 'Category', 'transera' ),
		'param_name'  => 'list_category',
		'params'     => array(
			array(
				'type'        => 'dropdown',
				'admin_label' => true,
				'heading'     => esc_html__( 'Add Category', 'transera' ),
				'param_name'  => 'category_slug',
				'value'       => $testimonial_cat,
				'description' => esc_html__( 'Choose special category to filter', 'transera'  )
			),
		),
		'value'       => '',
		'description' => esc_html__( 'Choose Testimonial Category.', 'transera' ),
		'dependency'  => array(
			'element'   => 'method',
			'value'     => array( 'cat' )
		),
		'group'       	=> esc_html__('Filter', 'transera'),
	),
	array(
		'type'            => 'param_group',
		'heading'         => esc_html__( 'Testimonials', 'transera' ),
		'param_name'      => 'list_post',
		'params'          => array(
			array(
				'type'        => 'dropdown',
				'admin_label' => true,
				'heading'     => esc_html__( 'Add Testimonial', 'transera' ),
				'param_name'  => 'post',
				'value'       => $testimonials,
				'description' => esc_html__( 'Choose special testimonial to show',  'transera')
			),
			
		),
		'value'           => '',
		'description'     => esc_html__( 'Default display All Testimonial if no testimonial is selected and Number testimonial is empty.', 'transera' ),
		'dependency'  => array(
			'element'   => 'method',
			'value'     => array( 'testimonial' )
		),
		'group'       	=> esc_html__('Filter', 'transera'),
	),
);

/*extra class*/
$extra_class = array(
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Extra Class', 'transera' ),
		'param_name'  => 'extra_class',
		'value'       => '',
		'description' => esc_html__( 'Add extra class to block', 'transera' )
	),
);

/* custom css */
$custom_css = array(
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Title Color', 'transera' ),
		'param_name'  => 'title_color',
		'description' => esc_html__( 'Please choose title color', 'transera' ),
		'group'       => esc_html__('Custom CSS', 'transera')
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Position Color', 'transera' ),
		'param_name'  => 'position_color',
		'description' => esc_html__( 'Please choose position color', 'transera' ),
		'group'       => esc_html__('Custom CSS', 'transera')
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Description Color', 'transera' ),
		'param_name'  => 'description_color',
		'description' => esc_html__( 'Please choose description color', 'transera' ),
		'group'       => esc_html__('Custom CSS', 'transera')
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Icon Color', 'transera' ),
		'param_name'  => 'icon_color',
		'description' => esc_html__( 'Please choose icon color', 'transera' ),
		'group'       => esc_html__('Custom CSS', 'transera'),
		'dependency'  => array(
			'element'   => 'show_image_1',
			'value'     => array( '1' )
		),
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Dots Color', 'transera' ),
		'param_name'  => 'dots_color',
		'dependency'    => array(
			'element'   => 'show_dots',
			'value'     => array( 'yes' )
		),
		'description' => esc_html__( 'Please choose dots color', 'transera' ),
		'group'       => esc_html__('Custom CSS', 'transera'),
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Arrows Color', 'transera' ),
		'param_name'  => 'arrows_color',
		'dependency'    => array(
			'element'   => 'show_arrows',
			'value'     => array( 'yes' )
		),
		'description' => esc_html__( 'Please choose arrows color', 'transera' ),
		'group'       => esc_html__('Custom CSS', 'transera'),
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Arrows Hover Color', 'transera' ),
		'param_name'  => 'arrows_hv_color',
		'dependency'    => array(
			'element'   => 'show_arrows',
			'value'     => array( 'yes' )
		),
		'description' => esc_html__( 'Please choose arrows background  color', 'transera' ),
		'group'       => esc_html__('Custom CSS', 'transera'),
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Arrows Background Color', 'transera' ),
		'param_name'  => 'arrows_bg_color',
		'dependency'    => array(
			'element'   => 'show_arrows',
			'value'     => array( 'yes' )
		),
		'description' => esc_html__( 'Please choose arrows background  color', 'transera' ),
		'group'       => esc_html__('Custom CSS', 'transera'),
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Arrows Background Hover Color', 'transera' ),
		'param_name'  => 'arrows_bg_hv_color',
		'value'       => '#337ab7',
		'dependency'    => array(
			'element'   => 'show_arrows',
			'value'     => array( 'yes' )
		),
		'description' => esc_html__( 'Please choose arrows background  color', 'transera' ),
		'group'       => esc_html__('Custom CSS', 'transera'),
	),
);
/* custom slide */
$custom_slide = array(
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Slides To Show', 'transera' ),
		'param_name'  => 'num_item_show',
		'value'       => '5',
		'description' => esc_html__( 'Please input number of item show in slider.', 'transera' ),
		'group'       => esc_html__('Slide Custom', 'transera')
	),
	array(
		'type'        	=> 'dropdown',
		'heading'     	=> esc_html__( 'Show Dots ?', 'transera' ),
		'param_name'  	=> 'show_dots',
		'value'       	=> $yes_no,
		'std'      		=> 'yes',
		'description' 	=> esc_html__( 'If choose Yes, block will be show dots.', 'transera' ),
		'group'       => esc_html__('Slide Custom', 'transera'),
		'dependency'  => array(
			'element'   => 'layout',
			'value_not_equal_to'     => array( 'layout-3' )
		),
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
	$layouts,
	$title,
	$params,
	$layouts_option,
	$custom_css,
	$custom_slide,
	$extra_class
);