<?php
$sort_by = SLZ_Params::get('sort-other');
$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'event_carousel' );

$show_hide = $shortcode->get_config( 'show_hide' );
$yes_no = $shortcode->get_config( 'yes_no' );
$filter_method = $shortcode->get_config( 'filter_method' );

$taxonomy = 'slz-event-cat';
$params_cat = array('empty'   => esc_html__( '-All Event Categories-', 'slz' ) );
$event_cat = SLZ_Com::get_tax_options2slug( $taxonomy, $params_cat );

$args = array('post_type' => 'slz-event');
$options = array('empty'  => esc_html__( '-All Event-', 'slz' ) );
$events = SLZ_Com::get_post_title2id( $args, $options );

$layouts = array(
	array (
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Layout', 'slz' ),
		'admin_label' => true,
		'param_name'  => 'layout',
		'value'       => $shortcode->get_layouts(),
		'std'         => 'layout-1',
		'description' => esc_html__( 'Choose layout will be displayed.', 'slz' ),
	)
);

$filters =  array(
	array(
		'type'          => 'dropdown',
		'heading'       => esc_html__( 'Display By', 'slz' ),
		'param_name'    => 'method',
		'value'         => $filter_method,
		'description'   => esc_html__( 'Choose team category or special events to display', 'slz' ),
		'group'         => esc_html__('Filter', 'slz')
	),
	array(
		'type'          => 'param_group',
		'heading'       => esc_html__( 'Category', 'slz' ),
		'param_name'    => 'list_category',
		'params'        => array(
			array(
				'type'        => 'dropdown',
				'admin_label' => true,
				'heading'     => esc_html__( 'Add Category', 'slz' ),
				'param_name'  => 'category_slug',
				'value'       => $event_cat,
				'description' => esc_html__( 'Choose special category to filter', 'slz'  )
			)
		),
		'value'         => '',
		'description'   => esc_html__( 'Choose Event Category.', 'slz' ),
		'dependency'    => array(
			'element'   => 'method',
			'value'     => array( 'cat' )
		),
		'group'         => esc_html__('Filter', 'slz')
	),
	array(
		'type'          => 'param_group',
		'heading'       => esc_html__( 'Events', 'slz' ),
		'param_name'    => 'list_post',
		'params'        => array(
			array(
				'type'        => 'dropdown',
				'admin_label' => true,
				'heading'     => esc_html__( 'Add Event', 'slz' ),
				'param_name'  => 'post',
				'value'       => $events,
				'description' => esc_html__( 'Choose special event to show',  'slz'  )
			)
		),
		'value'         => '',
		'description'   => esc_html__( 'Default display All Event if no event is selected and Number event is empty.', 'slz' ),
		'dependency'    => array(
			'element'   => 'method',
			'value'     => array( 'event' )
		),
		'group'         => esc_html__('Filter', 'slz')
	)
);

$slider_options = array(
	array(
		'type'          => 'textfield',
		'heading'       => esc_html__( 'Slide To Show', 'slz' ),
		'param_name'    => 'slide_to_show',
		'value'         => '',
		'std'           => '3',
		'description'   => esc_html__( 'Enter number of items to show.', 'slz' ),
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
		'heading'     	=> esc_html__( 'Is Dots Navigation ?', 'slz' ),
		'param_name'  	=> 'slide_dots',
		'value'       	=> $yes_no,
		'std'      		=> 'yes',
		'description' 	=> esc_html__( 'Choose YES to show dot navigation.', 'slz' ),
		'group'         => esc_html__('Slide Custom', 'slz')
	),
	array(
		'type'        	=> 'dropdown',
		'heading'     	=> esc_html__( 'Is Arrows Navigation ?', 'slz' ),
		'param_name'  	=> 'slide_arrows',
		'value'       	=> $yes_no,
		'std'      		=> 'yes',
		'description' 	=> esc_html__( 'Choose YES to show arrow navigation.', 'slz' ),
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
		'std'           => '600',
		'description'   => esc_html__( 'Enter number value. Unit is millisecond. Example: 600.', 'slz' ),
		'group'         => esc_html__('Slide Custom', 'slz')
	),
);

$custom_tab = array(
	array(
        'type'        => 'colorpicker',
        'heading'     => esc_html__( 'Title Color', 'slz' ),
        'param_name'  => 'title_color',
        'description' => esc_html__( 'Choose a custom color for title.', 'slz' ),
        'group'       => esc_html__('Custom Options', 'slz'),
    ),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Image display', 'slz' ),
		'param_name'  => 'image_display',
		'value'       => $show_hide,
		'description' => esc_html__( 'Choose show or hide image.', 'slz' ),
		'group'       => esc_html__('Custom Options', 'slz'),
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Description display', 'slz' ),
		'param_name'  => 'description_display',
		'value'       => $show_hide,
		'dependency'    => array(
			'element'   => 'layout',
			'value'     => array( 'layout-1' )
		),
		'description' => esc_html__( 'Choose show or hide description.', 'slz' ),
		'group'       => esc_html__('Custom Options', 'slz'),
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Event time display', 'slz' ),
		'param_name'  => 'event_time_display',
		'value'       => $show_hide,
		'dependency'    => array(
			'element'   => 'layout',
			'value'     => array( 'layout-1' )
		),
		'description' => esc_html__( 'Choose show or hide event time.', 'slz' ),
		'group'       => esc_html__('Custom Options', 'slz'),
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Event location display', 'slz' ),
		'param_name'  => 'event_location_display',
		'value'       => $show_hide,
		'dependency'    => array(
			'element'   => 'layout',
			'value'     => array( 'layout-1' )
		),
		'description' => esc_html__( 'Choose show or hide event location.', 'slz' ),
		'group'       => esc_html__('Custom Options', 'slz'),
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Countdown display', 'slz' ),
		'param_name'  => 'countdown_display',
		'value'       => $show_hide,
		'dependency'    => array(
			'element'   => 'layout',
			'value'     => array( 'layout-2' )
		),
		'description' => esc_html__( 'Choose show or hide event countdown.', 'slz' ),
		'group'       => esc_html__('Custom Options', 'slz'),
	),
);

$params = array(
	array(
		'type'        	=> 'textfield',
		'heading'     	=> esc_html__( 'Title shortcode', 'slz' ),
		'param_name'  	=> 'title',
		'value'       	=> '',
		'std'      		=> '',
		'description' 	=> esc_html__( 'Add title for shortcode.', 'slz' ),
	),
	array(
		'type'        	=> 'textfield',
		'heading'     	=> esc_html__( 'Limit post', 'slz' ),
		'param_name'  	=> 'limit_post',
		'value'       	=> '-1',
		'std'      		=> '',
		'description' 	=> esc_html__( 'Add title for shortcode.', 'slz' ),
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Sort By', 'slz' ),
		'param_name'  => 'sort_by',
		'value'       => $sort_by,
		'description' => esc_html__( 'Select order to display list properties.', 'slz' )
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


$vc_options = array_merge(
	$layouts,
	$params,
	$extra_class,
	$custom_tab,
	$slider_options,
	$filters
);