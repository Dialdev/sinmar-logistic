<?php
$shortcode  = slz_ext( 'shortcodes' )->get_shortcode( 'recruitment_list' );

$method     = array(
	esc_html__( 'Category', 'slz' )	    => 'cat',
	esc_html__( 'Recruitment', 'slz' ) 	=> 'recruitment'
);
$description     = array(
	esc_html__( 'Excerpt', 'slz' )	    => 'excerpt',
	esc_html__( 'Content', 'slz' ) 	    => 'content'
);
$sort_by    = SLZ_Params::get('sort-other');

$args       = array('post_type' => 'slz-recruitment');
$options    = array('empty'     => esc_html__( '-All Recruitments-', 'slz' ) );
$recruitments   = SLZ_Com::get_post_title2id( $args, $options );

$taxonomy   = 'slz-recruitment-cat';
$params_cat = array('empty'   => esc_html__( '-All Recruitment Categories-', 'slz' ) );
$categories = SLZ_Com::get_tax_options2slug( $taxonomy, $params_cat );


$vc_options = array(
	
	array(
		'type'            => 'textfield',
		'heading'         => esc_html__( 'Limit Posts', 'slz' ),
		'param_name'      => 'limit_post',
		'value'           => '-1',
		'description'     => esc_html__( 'Add limit posts per page. Set -1 or empty to show all.', 'slz' )
	),
	array(
		'type'            => 'textfield',
		'heading'         => esc_html__( 'Offset Posts', 'slz' ),
		'param_name'      => 'offset_post',
		'value'           => '0',
		'description'     => esc_html__( 'Enter offset to pass over posts. If you want to start on record 6, using offset 5.', 'slz' )
	),
	array(
		'type'            => 'dropdown',
		'heading'         => esc_html__( 'Sort By', 'slz' ),
		'param_name'      => 'sort_by',
		'value'           => $sort_by,
		'description'     => esc_html__( 'Select order to display list posts.', 'slz' ),
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Button Text', 'slz' ),
		'param_name'  => 'button_text',
		'value'       => '',
		'description' => esc_html__( 'Enter button text.', 'slz' )
	),
	array(
		'type'        => 'vc_link',
		'heading'     => esc_html__( 'Button Link', 'slz' ),
		'param_name'  => 'button_link',
		'value'       => '',
		'description' => esc_html__( 'Choose button link.', 'slz' )
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Extra Class', 'slz' ),
		'param_name'  => 'extra_class',
		'value'       => '',
		'description' => esc_html__( 'Add extra class to block.', 'slz' )
	),
	array(
		'type'            => 'param_group',
		'heading'         => esc_html__( 'Category', 'slz' ),
		'param_name'      => 'list_category',
		'params'          => array(
			array(
				'type'        => 'dropdown',
				'admin_label' => true,
				'heading'     => esc_html__( 'Add Category', 'slz' ),
				'param_name'  => 'category_slug',
				'value'       => $categories,
				'description' => esc_html__( 'Choose special category to filter.', 'slz'  )
			)
		),
		'value'           => '',
		'description'     => esc_html__( 'Choose recruitment category.', 'slz' ),
		'group'       	  => esc_html__('Filter', 'slz')
	),
	array(
		'type'            => 'colorpicker',
		'heading'         => esc_html__( 'Tab Active Color', 'slz' ),
		'param_name'      => 'active_color',
		'value'           => '',
		'description'     => esc_html__( 'Choose background color for item when activating tab.', 'slz' ),
		'group'       	  => esc_html__('Custom', 'slz')
	),
	array(
		'type'            => 'colorpicker',
		'heading'         => esc_html__( 'Ribbon Box Color', 'slz' ),
		'param_name'      => 'ribbon_color',
		'value'           => '',
		'description'     => esc_html__( 'Choose background color for ribbon box.', 'slz' ),
		'group'       	  => esc_html__('Custom', 'slz')
	),
	array(
		'type'            => 'colorpicker',
		'heading'         => esc_html__( 'Button Color', 'slz' ),
		'param_name'      => 'button_color',
		'value'           => '',
		'description'     => esc_html__( 'Choose color for button.', 'slz' ),
		'group'       	  => esc_html__('Custom', 'slz')
	),
	array(
		'type'            => 'colorpicker',
		'heading'         => esc_html__( 'Button Hover Color', 'slz' ),
		'param_name'      => 'button_hv_color',
		'value'           => '',
		'description'     => esc_html__( 'Choose color for button when hover.', 'slz' ),
		'group'       	  => esc_html__('Custom', 'slz')
	)
);
