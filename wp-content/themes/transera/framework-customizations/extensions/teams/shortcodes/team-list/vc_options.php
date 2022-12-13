<?php
$sort_by = SLZ_Params::get('sort-other');
$yes_no  = array(
	esc_html__('Yes', 'transera')         => 'yes',
	esc_html__('No', 'transera')	         => 'no'
);
$method = array(
	esc_html__( 'Category', 'transera' )  => 'cat',
	esc_html__( 'Team', 'transera' )      => 'team'
);

$args = array('post_type'     => 'slz-team');
$options = array('empty'      => esc_html__( '-All Team-', 'transera' ) );
$teams = SLZ_Com::get_post_title2id( $args, $options );

$taxonomy = 'slz-team-cat';
$params_cat = array('empty'   => esc_html__( '-All Team Categories-', 'transera' ) );
$team_cat = SLZ_Com::get_tax_options2slug( $taxonomy, $params_cat );


$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'team_list' );

$layouts = array(
	array(
		'type'          => 'dropdown',
		'heading'       => esc_html__( 'Layout', 'transera' ),
		'admin_label'   => true,
		'param_name'    => 'layout',
		'value'         => $shortcode->get_layouts(),
		'std'           => 'layout-5',
		'description'   => esc_html__( 'Choose layout will be displayed.', 'transera' ),
	)
);

$layout_options = $shortcode->get_layout_options();

$filters =  array(
	array(
		'type'          => 'dropdown',
		'heading'       => esc_html__( 'Display By', 'transera' ),
		'param_name'    => 'method',
		'value'         => $method,
		'description'   => esc_html__( 'Choose team category or special teams to display', 'transera' ),
		'group'         => esc_html__('Filter', 'transera')
	),
	array(
		'type'          => 'param_group',
		'heading'       => esc_html__( 'Category', 'transera' ),
		'param_name'    => 'list_category',
		'params'        => array(
			array(
				'type'        => 'dropdown',
				'admin_label' => true,
				'heading'     => esc_html__( 'Add Category', 'transera' ),
				'param_name'  => 'category_slug',
				'value'       => $team_cat,
				'description' => esc_html__( 'Choose special category to filter', 'transera'  )
			)
		),
		'value'         => '',
		'description'   => esc_html__( 'Choose Team Category.', 'transera' ),
		'dependency'    => array(
			'element'   => 'method',
			'value'     => array( 'cat' )
		),
		'group'         => esc_html__('Filter', 'transera')
	),
	array(
		'type'          => 'param_group',
		'heading'       => esc_html__( 'Teams', 'transera' ),
		'param_name'    => 'list_post',
		'params'        => array(
			array(
				'type'        => 'dropdown',
				'admin_label' => true,
				'heading'     => esc_html__( 'Add Team', 'transera' ),
				'param_name'  => 'post',
				'value'       => $teams,
				'description' => esc_html__( 'Choose special team to show',  'transera'  )
			)
		),
		'value'         => '',
		'description'   => esc_html__( 'Default display All Team if no team is selected and Number team is empty.', 'transera' ),
		'dependency'    => array(
			'element'   => 'method',
			'value'     => array( 'team' )
		),
		'group'         => esc_html__('Filter', 'transera')
	)
);

$params = array(
	array(
		'type'          => 'dropdown',
		'heading'       => esc_html__( 'Show Thumbnail ?', 'transera' ),
		'param_name'    => 'show_thumbnail',
		'value'         => $yes_no,
		'std'      	    => 'yes',
		'description'   => esc_html__( 'If choose Yes, block will be show thumbnail image.', 'transera' )
	),
	array(
		'type'          => 'dropdown',
		'heading'       => esc_html__( 'Show Position ?', 'transera' ),
		'param_name'    => 'show_position',
		'value'         => $yes_no,
		'std'      	    => 'yes',
		'description'   => esc_html__( 'If choose Yes, block will be show position.', 'transera' )
	),
	array(
		'type'          => 'dropdown',
		'heading'       => esc_html__( 'Show Contact Info ?', 'transera' ),
		'param_name'    => 'show_contact_info',
		'value'         => $yes_no,
		'std'      	    => 'no',
		'description'   => esc_html__( 'If choose Yes, block will show contact info.', 'transera' )
	),
	array(
		'type'          => 'dropdown',
		'heading'       => esc_html__( 'Show Social ?', 'transera' ),
		'param_name'    => 'show_social',
		'value'         => $yes_no,
		'std'      	    => 'yes',
		'description'   => esc_html__( 'If choose Yes, block will be show social.', 'transera' )
	),
	array(
		'type'          => 'dropdown',
		'heading'       => esc_html__( 'Show Description ?', 'transera' ),
		'param_name'    => 'show_description',
		'value'         => $yes_no,
		'std'           => 'yes',
		'description'   => esc_html__( 'If choose Yes, block will be show description.', 'transera' )
	),
	array(
		'type'          => 'textfield',
		'heading'       => esc_html__( 'Description Length', 'transera' ),
		'param_name'    => 'description_lenghth',
		'description'   => esc_html__( 'Limit words to display.', 'transera' ),
		'dependency'    => array(
			'element'   => 'show_description',
			'value'     => array( 'yes' )
		)
	),
	array(
		'type'          => 'textfield',
		'heading'       => esc_html__( 'Limit Posts', 'transera' ),
		'param_name'    => 'limit_post',
		'value'         => '-1',
		'description'   => esc_html__( 'Add limit posts per page. Set -1 or empty to show all. The number of posts to display. If it blank the number posts will be the number from Settings -> Reading', 'transera' )
	),
	array(
		'type'          => 'textfield',
		'heading'       => esc_html__( 'Offset Post', 'transera' ),
		'param_name'    => 'offset_post',
		'value'         => '',
		'description'   => esc_html__( 'Enter offset to pass over posts. If you want to start on record 6, using offset 5', 'transera' )
	),
	array(
		'type'          => 'dropdown',
		'heading'       => esc_html__( 'Sort By', 'transera' ),
		'param_name'    => 'sort_by',
		'value'         => $sort_by,
		'description'   => esc_html__( 'Select order to display list properties.', 'transera' )
	),
	array(
		'type'          => 'textfield',
		'heading'       => esc_html__( 'Extra Class', 'transera' ),
		'param_name'    => 'extra_class',
		'value'         => '',
		'description'   => esc_html__( 'Add extra class to block', 'transera' )
	),

	array(
		'type'          => 'colorpicker',
		'heading'       => esc_html__( 'Title Color', 'transera' ),
		'param_name'    => 'color_title',
		'value'         => '',
		'description'   => esc_html__( 'Choose color title for block.', 'transera' ),
		'group'         => esc_html__('Custom', 'transera')
	),
	array(
		'type'          => 'colorpicker',
		'heading'       => esc_html__( 'Title Color Hover', 'transera' ),
		'param_name'    => 'color_title_hv',
		'value'         => '',
		'description'   => esc_html__( 'Choose color title for block when hover.', 'transera' ),
		'group'         => esc_html__('Custom', 'transera')
	),
	array(
		'type'          => 'colorpicker',
		'heading'       => esc_html__( 'Position Color', 'transera' ),
		'param_name'    => 'color_position',
		'value'         => '',
		'description'   => esc_html__( 'Choose color position for block.', 'transera' ),
		'group'         => esc_html__('Custom', 'transera')
	),
	array(
		'type'          => 'colorpicker',
		'heading'       => esc_html__( 'Info Color', 'transera' ),
		'param_name'    => 'color_info',
		'value'         => '',
		'description'   => esc_html__( 'Choose color for contact info.', 'transera' ),
		'group'         => esc_html__('Custom', 'transera')
	),
	array(
		'type'          => 'colorpicker',
		'heading'       => esc_html__( 'Info Hover Color', 'transera' ),
		'param_name'    => 'color_hv_info',
		'value'         => '',
		'description'   => esc_html__( 'Choose hover color for contact info.', 'transera' ),
		'group'         => esc_html__('Custom', 'transera')
	),
	array(
		'type'          => 'colorpicker',
		'heading'       => esc_html__( 'Description Color', 'transera' ),
		'param_name'    => 'color_description',
		'value'         => '',
		'description'   => esc_html__( 'Choose color description for block.', 'transera' ),
		'group'         => esc_html__('Custom', 'transera')
	),
	array(
		'type'          => 'colorpicker',
		'heading'       => esc_html__( 'Social Color', 'transera' ),
		'param_name'    => 'color_social',
		'value'         => '',
		'description'   => esc_html__( 'Choose color social for block.', 'transera' ),
		'group'         => esc_html__('Custom', 'transera')
	),
	array(
		'type'          => 'colorpicker',
		'heading'       => esc_html__( 'Social Color Hover', 'transera' ),
		'param_name'    => 'color_social_hv',
		'value'         => '',
		'description'   => esc_html__( 'Choose color social for block when hover.', 'transera' ),
		'group'         => esc_html__('Custom', 'transera')
	)
);

$vc_options = array_merge( 
	$layouts,
	$filters,
	$layout_options,
	$params
);
