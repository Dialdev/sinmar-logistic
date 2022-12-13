<?php
$sort_by = SLZ_Params::get('sort-other');

$args = array('post_type'     => 'slz-causes');
$options = array('empty'      => esc_html__( '-All Causes-', 'slz' ) );
$causes = SLZ_Com::get_post_title2id( $args, $options );

$taxonomy = 'slz-causes-cat';
$params_cat = array('empty'   => esc_html__( '-All Causes Categories-', 'slz' ) );
$causes_cat = SLZ_Com::get_tax_options2slug( $taxonomy, $params_cat );

$yes_no = array(
    esc_html__( 'Yes', 'slz' ) => 'yes',
    esc_html__( 'No', 'slz' ) => 'no',
);

$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'causes_block' );

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

$layout_options = $shortcode->get_layout_options();

$filters =  array(
	array(
		'type'          => 'dropdown',
		'heading'       => esc_html__( 'Display By', 'slz' ),
		'param_name'    => 'method',
		'value'         => $shortcode->get_config('method'),
		'description'   => esc_html__( 'Choose causes category or special causes to display', 'slz' ),
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
				'value'       => $causes_cat,
				'description' => esc_html__( 'Choose special category to filter', 'slz'  )
			)
		),
		'value'         => '',
		'description'   => esc_html__( 'Choose Causes Category.', 'slz' ),
		'dependency'    => array(
			'element'   => 'method',
			'value'     => array( 'cat' )
		),
		'group'         => esc_html__('Filter', 'slz')
	),
	array(
		'type'          => 'param_group',
		'heading'       => esc_html__( 'Causes', 'slz' ),
		'param_name'    => 'list_post',
		'params'        => array(
			array(
				'type'        => 'dropdown',
				'admin_label' => true,
				'heading'     => esc_html__( 'Add Cause', 'slz' ),
				'param_name'  => 'post',
				'value'       => $causes,
				'description' => esc_html__( 'Choose special causes to show',  'slz'  )
			)
		),
		'value'         => '',
		'description'   => esc_html__( 'Default display All Causes if no cause is selected and Number cause is empty.', 'slz' ),
		'dependency'    => array(
			'element'   => 'method',
			'value'     => array( 'causes' )
		),
		'group'         => esc_html__('Filter', 'slz')
	)
);

$params = array(
    array(
        'type'          => 'dropdown',
        'heading'       => esc_html__( 'Show Donation Button?', 'slz' ),
        'param_name'    => 'show_donation_button',
        'std'           => 'yes',
        'value'         => $shortcode->get_config( 'yes_no' ),
        'std'           => 'no',
        'description'   => esc_html__( 'Show or hide donation button instead read more button.', 'slz' )
    ),
	array(
		'type'          => 'textfield',
		'heading'       => esc_html__( 'Limit Posts', 'slz' ),
		'param_name'    => 'limit_post',
		'value'         => '-1',
		'description'   => esc_html__( 'Add limit posts per page. Set -1 or empty to show all. The number of posts to display. If it blank the number posts will be the number from Settings -> Reading', 'slz' )
	),
	array(
		'type'          => 'textfield',
		'heading'       => esc_html__( 'Offset Post', 'slz' ),
		'param_name'    => 'offset_post',
		'value'         => '',
		'description'   => esc_html__( 'Enter offset to pass over posts. If you want to start on record 6, using offset 5', 'slz' )
	),
	array(
		'type'          => 'dropdown',
		'heading'       => esc_html__( 'Sort By', 'slz' ),
		'param_name'    => 'sort_by',
		'value'         => $sort_by,
		'description'   => esc_html__( 'Select order to display list properties.', 'slz' )
	),
	array(
		'type'          => 'dropdown',
		'heading'       => esc_html__( 'Show Pagination ?', 'slz' ),
		'param_name'    => 'pagination',
		'value'         => $shortcode->get_config( 'yes_no' ),
		'std'           => 'no',
		'description'   => esc_html__( 'If choose Yes, block will be show pagination.', 'slz' ),
	),
);

$btn_more = array(
	array(
		'type'          => 'dropdown',
		'heading'       => esc_html__( 'Show Progress Bar?', 'slz' ),
		'param_name'    => 'show_progress_bar',
		'std'           => 'yes',
		'value'         => $shortcode->get_config( 'yes_no' ),
		'group'         => esc_html__( 'Options', 'slz' ),
		'description'   => esc_html__( 'Show or hide progress bar of donation money to the cause.', 'slz' )
	),
	array(
		'type'          => 'textfield',
		'heading'       => esc_html__( 'Button Text', 'slz' ),
		'param_name'    => 'btn_content',
		'value'         => '',
		'description'   => esc_html__( 'Add button text.', 'slz' ),
		'group'         => esc_html__( 'Options', 'slz' ),
		'dependency'    => array(
			'element'   => 'layout',
			'value'     => array( 'layout-1', 'layout-2' )
		),
	),
);

$extra_class = array(
	array(
		'type'          => 'textfield',
		'heading'       => esc_html__( 'Extra Class', 'slz' ),
		'param_name'    => 'extra_class',
		'value'         => '',
		'description'   => esc_html__( 'Add extra class to block', 'slz' )
	),
);

$filter_ajax = array(
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Ajax Dropdown - Filter default text', 'slz' ),
		'param_name'  => 'category_filter_text',
		'value'       => esc_html__('All', 'slz'),
		'dependency' => array(
			'element' => 'pagination',
			'value_not_equal_to' => array( 'yes' ),
		),
		'description' => esc_html__( 'The default text for first item.', 'slz' ),
		'group'       => esc_html__('Ajax Filter', 'slz')
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Show Ajax Dropdown - Filter type', 'slz' ),
		'param_name'  => 'category_filter',
		'value'       => array(
							esc_html__( '- No filter -', 'slz' )         => '',
							esc_html__( 'Filter by categories', 'slz' )  => 'category',
							esc_html__( 'Filter by authors', 'slz' )     => 'author',
						),
		'dependency' => array(
			'element' => 'pagination',
			'value_not_equal_to' => array( 'yes' ),
		),
		'description' => esc_html__( 'Show the ajax dropdown filter. If no items are seleted in "Filter" tab, the ajax dropdown filter will show all items ( ex: all categories, all tags, all author )', 'slz' ),
		'group'       => esc_html__('Ajax Filter', 'slz')
	)
);

$vc_options = array_merge( 
	$layouts,
	$filters,
	$params,
	$btn_more,
	$extra_class,
	$layout_options,
	$filter_ajax
);
