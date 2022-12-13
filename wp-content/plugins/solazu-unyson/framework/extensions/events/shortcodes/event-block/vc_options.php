<?php
$sort_by = SLZ_Params::get('sort-other');
$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'event_block' );

$image_display = $shortcode->get_config( 'show_hide' );
$description_display = $shortcode->get_config( 'show_hide' );
$event_time_display = $shortcode->get_config( 'show_hide' );
$event_location_display = $shortcode->get_config( 'show_hide' );
$filter_method = $shortcode->get_config( 'filter_method' );
$yes_no = $shortcode->get_config( 'yes_no' );
$show_hide = $shortcode->get_config( 'show_hide' );

$taxonomy = 'slz-event-cat';
$params_cat = array('empty'   => esc_html__( '-All Event Categories-', 'slz' ) );
$event_cat = SLZ_Com::get_tax_options2slug( $taxonomy, $params_cat );

$args = array('post_type' => 'slz-event');
$options = array('empty'  => esc_html__( '-All Event-', 'slz' ) );
$events = SLZ_Com::get_post_title2id( $args, $options );

$column = array(
    esc_html__( 'One', 'slz' )    => '1',
    esc_html__( 'Two', 'slz' )    => '2',
    esc_html__( 'Three', 'slz' )  => '3',
    esc_html__( 'Four', 'slz' )   => '4',
);

$layouts = array(
    array (
        'type'        => 'dropdown',
        'heading'     => esc_html__( 'Layout', 'slz' ),
        'admin_label' => true,
        'param_name'  => 'layout',
        'value'       => $shortcode->get_layouts(),
        'description' => esc_html__( 'Choose layout will be displayed.', 'slz' )
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
		'heading'     => esc_html__( 'Image', 'slz' ),
		'param_name'  => 'image_display',
		'value'       => $image_display,
		'description' => esc_html__( 'Choose show or hide image.', 'slz' ),
		'group'       => esc_html__('Custom Options', 'slz'),
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Description', 'slz' ),
		'param_name'  => 'description_display',
		'value'       => $description_display,
		'description' => esc_html__( 'Choose show or hide description.', 'slz' ),
		'group'       => esc_html__('Custom Options', 'slz'),
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Event Time', 'slz' ),
		'param_name'  => 'event_time_display',
		'value'       => $event_time_display,
		'description' => esc_html__( 'Choose show or hide event time.', 'slz' ),
		'group'       => esc_html__('Custom Options', 'slz'),
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Event Location', 'slz' ),
		'param_name'  => 'event_location_display',
		'value'       => $event_location_display,
		'description' => esc_html__( 'Choose show or hide event location.', 'slz' ),
		'group'       => esc_html__('Custom Options', 'slz'),
	),
);

$params = array(
    array(
        'type'        => 'dropdown',
        'heading'     => esc_html__( 'Columns', 'slz' ),
        'param_name'  => 'column',
        'value'       => $column,
        'std'         => '1',
        'description' => esc_html__( 'Choose number column will be displayed.', 'slz' ),
        'dependency'    => array(
            'element'   => 'layout',
            'value'     => array( 'layout-1' )
        ),
    ),
	array(
		'type'        	=> 'textfield',
		'heading'     	=> esc_html__( 'Title Shortcode', 'slz' ),
		'param_name'  	=> 'title',
		'value'       	=> '',
		'std'      		=> '',
		'description' 	=> esc_html__( 'Add title for shortcode.', 'slz' ),
	),
    array(
        'type'        => 'dropdown',
        'heading'     => esc_html__( 'Show Search Bar', 'slz' ),
        'param_name'  => 'show_searchbar',
        'value'       => $show_hide,
        'std'         => 'hide',
        'dependency'    => array(
            'element'   => 'layout',
            'value'     => array( 'layout-2' )
        ),
        'description' => esc_html__( 'Choose Search Bar display.', 'slz' )
    ),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Pagination', 'slz' ),
		'param_name'  => 'pagination',
		'value'       => $yes_no,
		'description' => esc_html__( 'Choose pagination display.', 'slz' )
	),
    array(
        'type'        	=> 'textfield',
        'heading'     	=> esc_html__( 'Limit Posts', 'slz' ),
        'param_name'  	=> 'limit_post',
        'value'       	=> '-1',
        'std'      		=> '',
        'description' 	=> esc_html__( 'Add limit posts per page. Set -1 or empty to show all. The number of posts to display. If it blank the number posts will be the number from Settings -> Reading', 'slz' ),
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
	$filters
);