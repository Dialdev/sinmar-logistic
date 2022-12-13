<?php
$sort_by = SLZ_Params::get('sort-other');

$yes_no  = array(
	esc_html__('Yes', 'slz')			=> 'yes',
	esc_html__('No', 'slz')			=> 'no',
);
$method = array(
	esc_html__( 'Category', 'slz' )	=> 'cat',
	esc_html__( 'Testimonial', 'slz' ) => 'testimonial'
);

$args = array('post_type'     => 'slz-testimonial');
$options = array('empty'      => esc_html__( '-All Testimonial-', 'slz' ) );
$testimonials = SLZ_Com::get_post_title2id( $args, $options );

$taxonomy = 'slz-testimonial-cat';
$params_cat = array('empty'   => esc_html__( '-All Testimonial Categories-', 'slz' ) );
$testimonial_cat = SLZ_Com::get_tax_options2slug( $taxonomy, $params_cat );

$animation  = array(
	esc_html__('Slide', 'slz')		=> '0',
	esc_html__('Fade', 'slz')		=> '1'
);


$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'testimonial' );

/* layout */
$layouts = array(
	array(
		'type'          => 'dropdown',
		'heading'       => esc_html__( 'Layout', 'slz' ),
		'admin_label'   => true,
		'param_name'    => 'layout',
		'value'         => $shortcode->get_layouts(),
		'std'           => 'layout-1',
		'description'   => esc_html__( 'Choose layout will be displayed.', 'slz' )
	)
);

/* layout options */
$layouts_option = $shortcode->get_layout_options();

/* title options */
$title = array(
    array(
        'type'        => 'textfield',
        'heading'     => esc_html__( 'Shortcode Title', 'slz' ),
        'param_name'  => 'sc_title',
        'value'       => '',
        'description' => esc_html__( 'Title. If it blank the will not have a title', 'slz' )
    ),
    array(
        'type'        => 'colorpicker',
        'heading'     => esc_html__( 'Shortcode Title Color', 'slz' ),
        'param_name'  => 'sc_title_color',
        'value'       => '',
        'description' => esc_html__( 'Choose a custom title text color.', 'slz' )
    ),
);
/* params */
$params = array(
	array(
		'type'        	=> 'dropdown',
		'heading'     	=> esc_html__( 'Show Position ?', 'slz' ),
		'param_name'  	=> 'show_position',
		'value'       	=> $yes_no,
		'std'      		=> 'yes',
		'description' 	=> esc_html__( 'If choose Yes, block will be show position.', 'slz' ),
	),
	array(
		'type'        	=> 'dropdown',
		'heading'     	=> esc_html__( 'Show Description ?', 'slz' ),
		'param_name'  	=> 'show_description',
		'value'       	=> $yes_no,
		'std'      		=> 'yes',
		'description' 	=> esc_html__( 'If choose Yes, block will be show description.', 'slz' ),
	),
    array(
        'type'        => 'dropdown',
        'heading'     => esc_html__( 'Avatar Image', 'slz' ),
        'param_name'  => 'show_image_1',
        'value'       => array(
            esc_html__('Show Feature Image', 'slz') => '2',
            esc_html__('Show Icon', 'slz') => '1',
            esc_html__('Show Thumbnail Image', 'slz') => '0'
        ),
        'std'         => '',
        'description' => esc_html__( 'Select image type for Avatar.', 'slz' ),
    	'dependency'  => array(
    		'element'   => 'layout',
    		'value_not_equal_to'     => array( 'layout-5' )
    	),
    ),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Limit Posts', 'slz' ),
		'param_name'  => 'limit_post',
		'value'       => '-1',
		'description' => esc_html__( 'Add limit posts per page. Set -1 or empty to show all. The number of posts to display. If it blank the number posts will be the number from Settings -> Reading', 'slz' )
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Offset Post', 'slz' ),
		'param_name'  => 'offset_post',
		'value'       => '',
		'description' => esc_html__( 'Enter offset to pass over posts. If you want to start on record 6, using offset 5', 'slz' )
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Sort By', 'slz' ),
		'param_name'  => 'sort_by',
		'value'       => $sort_by,
		'description' => esc_html__( 'Select order to display list properties.', 'slz' )
	),
    array(
        'type'        => 'dropdown',
        'heading'     => esc_html__( 'Addition Image', 'slz' ),
        'param_name'  => 'show_image_2',
        'value'       => array(
            esc_html__('Show Feature Image', 'slz') => '2',
            esc_html__('Show Icon', 'slz') => '1',
            esc_html__('Show Thumbnail Image', 'slz') => '0'
        ),
        'std'         => '0',
        'description' => esc_html__( 'Select image for image above title.', 'slz' ),
        'dependency'  => array(
            'element'   => 'layout',
            'value'     => array( 'layout-2' )
        ),
    ),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Display By', 'slz' ),
		'param_name'  => 'method',
		'value'       => $method,
		'description' => esc_html__( 'Choose testimonial category or special testimonials to display', 'slz' ),
		'group'       	=> esc_html__('Filter', 'slz'),
	),
	array(
		'type'        => 'param_group',
		'heading'     => esc_html__( 'Category', 'slz' ),
		'param_name'  => 'list_category',
		'params'     => array(
			array(
				'type'        => 'dropdown',
				'admin_label' => true,
				'heading'     => esc_html__( 'Add Category', 'slz' ),
				'param_name'  => 'category_slug',
				'value'       => $testimonial_cat,
				'description' => esc_html__( 'Choose special category to filter', 'slz'  )
			),
		),
		'value'       => '',
		'description' => esc_html__( 'Choose Testimonial Category.', 'slz' ),
		'dependency'  => array(
			'element'   => 'method',
			'value'     => array( 'cat' )
		),
		'group'       	=> esc_html__('Filter', 'slz'),
	),
	array(
		'type'            => 'param_group',
		'heading'         => esc_html__( 'Testimonials', 'slz' ),
		'param_name'      => 'list_post',
		'params'          => array(
			array(
				'type'        => 'dropdown',
				'admin_label' => true,
				'heading'     => esc_html__( 'Add Testimonial', 'slz' ),
				'param_name'  => 'post',
				'value'       => $testimonials,
				'description' => esc_html__( 'Choose special testimonial to show',  'slz')
			),
			
		),
		'value'           => '',
		'description'     => esc_html__( 'Default display All Testimonial if no testimonial is selected and Number testimonial is empty.', 'slz' ),
		'dependency'  => array(
			'element'   => 'method',
			'value'     => array( 'testimonial' )
		),
		'group'       	=> esc_html__('Filter', 'slz'),
	),
);

/*extra class*/
$extra_class = array(
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Extra Class', 'slz' ),
		'param_name'  => 'extra_class',
		'value'       => '',
		'description' => esc_html__( 'Add extra class to block', 'slz' )
	),
);

/* custom css */
$custom_css = array(
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Title Color', 'slz' ),
		'param_name'  => 'title_color',
		'description' => esc_html__( 'Please choose title color', 'slz' ),
		'group'       => esc_html__('Custom CSS', 'slz')
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Position Color', 'slz' ),
		'param_name'  => 'position_color',
		'description' => esc_html__( 'Please choose position color', 'slz' ),
		'group'       => esc_html__('Custom CSS', 'slz')
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Description Color', 'slz' ),
		'param_name'  => 'description_color',
		'description' => esc_html__( 'Please choose description color', 'slz' ),
		'group'       => esc_html__('Custom CSS', 'slz')
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Icon Color', 'slz' ),
		'param_name'  => 'icon_color',
		'description' => esc_html__( 'Please choose icon color', 'slz' ),
		'group'       => esc_html__('Custom CSS', 'slz'),
		'dependency'  => array(
			'element'   => 'show_image_1',
			'value'     => array( '1' )
		),
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Dots Color', 'slz' ),
		'param_name'  => 'dots_color',
		'dependency'    => array(
			'element'   => 'show_dots',
			'value'     => array( 'yes' )
		),
		'description' => esc_html__( 'Please choose dots color', 'slz' ),
		'group'       => esc_html__('Custom CSS', 'slz'),
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Arrows Color', 'slz' ),
		'param_name'  => 'arrows_color',
		'dependency'    => array(
			'element'   => 'show_arrows',
			'value'     => array( 'yes' )
		),
		'description' => esc_html__( 'Please choose arrows color', 'slz' ),
		'group'       => esc_html__('Custom CSS', 'slz'),
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Arrows Hover Color', 'slz' ),
		'param_name'  => 'arrows_hv_color',
		'dependency'    => array(
			'element'   => 'show_arrows',
			'value'     => array( 'yes' )
		),
		'description' => esc_html__( 'Please choose arrows background  color', 'slz' ),
		'group'       => esc_html__('Custom CSS', 'slz'),
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Arrows Background Color', 'slz' ),
		'param_name'  => 'arrows_bg_color',
		'dependency'    => array(
			'element'   => 'show_arrows',
			'value'     => array( 'yes' )
		),
		'description' => esc_html__( 'Please choose arrows background  color', 'slz' ),
		'group'       => esc_html__('Custom CSS', 'slz'),
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Arrows Background Hover Color', 'slz' ),
		'param_name'  => 'arrows_bg_hv_color',
		'value'       => '#337ab7',
		'dependency'    => array(
			'element'   => 'show_arrows',
			'value'     => array( 'yes' )
		),
		'description' => esc_html__( 'Please choose arrows background  color', 'slz' ),
		'group'       => esc_html__('Custom CSS', 'slz'),
	),
);
/* custom slide */
$custom_slide = array(
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Slides To Show', 'slz' ),
		'param_name'  => 'num_item_show',
		'value'       => '5',
		'description' => esc_html__( 'Please input number of item show in slider.', 'slz' ),
		'group'       => esc_html__('Slide Custom', 'slz')
	),
	array(
		'type'        	=> 'dropdown',
		'heading'     	=> esc_html__( 'Show Dots ?', 'slz' ),
		'param_name'  	=> 'show_dots',
		'value'       	=> $yes_no,
		'std'      		=> 'yes',
		'description' 	=> esc_html__( 'If choose Yes, block will be show dots.', 'slz' ),
		'group'       => esc_html__('Slide Custom', 'slz'),
		'dependency'  => array(
			'element'   => 'layout',
			'value_not_equal_to'     => array( 'layout-3' )
		),
	),
	array(
		'type'        	=> 'dropdown',
		'heading'     	=> esc_html__( 'Show Arrow ?', 'slz' ),
		'param_name'  	=> 'show_arrows',
		'value'       	=> $yes_no,
		'std'      		=> 'yes',
		'description' 	=> esc_html__( 'If choose Yes, block will be show arrow.', 'slz' ),
		'group'       => esc_html__('Slide Custom', 'slz'),
		'dependency'  => array(
			'element'   => 'layout',
			'value_not_equal_to'     => array( 'layout-3' )
		),
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
	$layouts,
    $title,
	$params,
	$layouts_option,
	$custom_css,
	$custom_slide,
	$extra_class
);