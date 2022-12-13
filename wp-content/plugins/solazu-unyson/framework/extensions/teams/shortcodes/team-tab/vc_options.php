<?php
$sort_by = SLZ_Params::get('sort-other');
$yes_no  = array(
	esc_html__('Yes', 'slz')         => 'yes',
	esc_html__('No', 'slz')	         => 'no'
);
$method = array(
	esc_html__( 'Category', 'slz' )  => 'cat',
	esc_html__( 'Team', 'slz' )      => 'team'
);

$args = array('post_type'     => 'slz-team');
$options = array('empty'      => esc_html__( '-All Team-', 'slz' ) );
$teams = SLZ_Com::get_post_title2id( $args, $options );

$taxonomy = 'slz-team-cat';
$params_cat = array('empty'   => esc_html__( '-All Team Categories-', 'slz' ) );
$team_cat = SLZ_Com::get_tax_options2slug( $taxonomy, $params_cat );


$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'team_tab' );

$column = array(
	esc_html__( 'One', 'slz' )      => '1',
	esc_html__( 'Two', 'slz' )      => '2',
	esc_html__( 'Three', 'slz' )    => '3',
	esc_html__( 'Four', 'slz' )     => '4'
);


$filters =  array(
	
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
				'value'       => $team_cat,
				'description' => esc_html__( 'Choose special category to filter', 'slz'  )
			)
		),
		'value'         => '',
		'description'   => esc_html__( 'Choose Team Category.', 'slz' ),
		'group'         => esc_html__('Filter', 'slz')
	)
);

$params = array(

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
		'heading'       => esc_html__( 'Column', 'slz' ),
		'admin_label'   => true,
		'param_name'    => 'column',
		'value'         => $column,
		'std'           => '3',
		'description'   => esc_html__( 'Choose number column will be displayed.', 'slz' )
	),
	array(
		'type'          => 'dropdown',
		'heading'       => esc_html__( 'Sort By', 'slz' ),
		'param_name'    => 'sort_by',
		'value'         => $sort_by,
		'description'   => esc_html__( 'Select order to display list properties.', 'slz' )
	),
    array(
        'type'          => 'textfield',
        'heading'       => esc_html__( 'Button "Read More" Text', 'slz' ),
        'param_name'    => 'btn_content',
        'value'         => '',
        'description'   => esc_html__( 'Enter text to button. If it blank will not have a button.', 'slz' )
    ),
	array(
		'type'          => 'textfield',
		'heading'       => esc_html__( 'Extra Class', 'slz' ),
		'param_name'    => 'extra_class',
		'value'         => '',
		'description'   => esc_html__( 'Add extra class to block', 'slz' )
	)
);

$info_setting = array(
	array(
		'type'          => 'dropdown',
		'heading'       => esc_html__( 'Show Thumbnail ?', 'slz' ),
		'param_name'    => 'show_thumbnail',
		'value'         => $yes_no,
		'std'      	    => 'yes',
		'description'   => esc_html__( 'If choose Yes, block will be show thumbnail image.', 'slz' ),
		'group'         => esc_html__(' Info Settings', 'slz')
	),
	array(
		'type'          => 'dropdown',
		'heading'       => esc_html__( 'Show Position ?', 'slz' ),
		'param_name'    => 'show_position',
		'value'         => $yes_no,
		'std'      	    => 'yes',
		'description'   => esc_html__( 'If choose Yes, block will be show position.', 'slz' ),
		'group'         => esc_html__(' Info Settings', 'slz')
	),
	array(
		'type'          => 'dropdown',
		'heading'       => esc_html__( 'Show Contact Info ?', 'slz' ),
		'param_name'    => 'show_contact_info',
		'value'         => $yes_no,
		'std'      	    => 'no',
		'description'   => esc_html__( 'If choose Yes, block will show contact info.', 'slz' ),
		'group'         => esc_html__(' Info Settings', 'slz')
	),
	array(
		'type'          => 'dropdown',
		'heading'       => esc_html__( 'Show Social ?', 'slz' ),
		'param_name'    => 'show_social',
		'value'         => $yes_no,
		'std'      	    => 'yes',
		'description'   => esc_html__( 'If choose Yes, block will be show social.', 'slz' ),
		'group'         => esc_html__(' Info Settings', 'slz')
	),
	array(
		'type'          => 'dropdown',
		'heading'       => esc_html__( 'Show Description ?', 'slz' ),
		'param_name'    => 'show_description',
		'value'         => $yes_no,
		'std'           => 'yes',
		'description'   => esc_html__( 'If choose Yes, block will be show description.', 'slz' ),
		'group'         => esc_html__(' Info Settings', 'slz')
	),
	array(
		'type'          => 'textfield',
		'heading'       => esc_html__( 'Description Length', 'slz' ),
		'param_name'    => 'description_lenghth',
		'description'   => esc_html__( 'Limit words to display.', 'slz' ),
		'dependency'    => array(
			'element'   => 'show_description',
			'value'     => array( 'yes' )
		),
		'group'         => esc_html__(' Info Settings', 'slz')
	),
);

$custom_css = array(
	array(
		'type'          => 'colorpicker',
		'heading'       => esc_html__( 'Category Active Color', 'slz' ),
		'param_name'    => 'color_cat',
		'value'         => '',
		'description'   => esc_html__( 'Choose the color for the active category.', 'slz' ),
		'group'         => esc_html__('Custom Css', 'slz')
	),
	array(
		'type'          => 'colorpicker',
		'heading'       => esc_html__( 'Title Color', 'slz' ),
		'param_name'    => 'color_title',
		'value'         => '',
		'description'   => esc_html__( 'Choose color title for block.', 'slz' ),
		'group'         => esc_html__('Custom Css', 'slz')
	),
	array(
		'type'          => 'colorpicker',
		'heading'       => esc_html__( 'Title Color Hover', 'slz' ),
		'param_name'    => 'color_title_hv',
		'value'         => '',
		'description'   => esc_html__( 'Choose color title for block when hover.', 'slz' ),
		'group'         => esc_html__('Custom Css', 'slz')
	),
	array(
		'type'          => 'colorpicker',
		'heading'       => esc_html__( 'Position Color', 'slz' ),
		'param_name'    => 'color_position',
		'value'         => '',
		'description'   => esc_html__( 'Choose color position for block.', 'slz' ),
		'group'         => esc_html__('Custom Css', 'slz')
	),
	array(
		'type'          => 'colorpicker',
		'heading'       => esc_html__( 'Info Color', 'slz' ),
		'param_name'    => 'color_info',
		'value'         => '',
		'description'   => esc_html__( 'Choose color for contact info.', 'slz' ),
		'group'         => esc_html__('Custom Css', 'slz')
	),
	array(
		'type'          => 'colorpicker',
		'heading'       => esc_html__( 'Info Hover Color', 'slz' ),
		'param_name'    => 'color_hv_info',
		'value'         => '',
		'description'   => esc_html__( 'Choose hover color for contact info.', 'slz' ),
		'group'         => esc_html__('Custom Css', 'slz')
	),
	array(
		'type'          => 'colorpicker',
		'heading'       => esc_html__( 'Description Color', 'slz' ),
		'param_name'    => 'color_description',
		'value'         => '',
		'description'   => esc_html__( 'Choose color description for block.', 'slz' ),
		'group'         => esc_html__('Custom Css', 'slz')
	),
	array(
		'type'          => 'colorpicker',
		'heading'       => esc_html__( 'Social Color', 'slz' ),
		'param_name'    => 'color_social',
		'value'         => '',
		'description'   => esc_html__( 'Choose color social for block.', 'slz' ),
		'group'         => esc_html__('Custom Css', 'slz')
	),
	array(
		'type'          => 'colorpicker',
		'heading'       => esc_html__( 'Social Color Hover', 'slz' ),
		'param_name'    => 'color_social_hv',
		'value'         => '',
		'description'   => esc_html__( 'Choose color social for block when hover.', 'slz' ),
		'group'         => esc_html__('Custom Css', 'slz')
	)
);

$vc_options = array_merge( 
	$params,
	$filters,
	$info_setting,
	$custom_css
);
