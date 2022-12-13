<?php
$shortcode  = slz_ext( 'shortcodes' )->get_shortcode( 'service_tab' );

$show_icon  = array(
	esc_html__('Show Icon', 'slz')	 => 'icon',
	esc_html__('Show Image', 'slz') => 'image'
);
$method     = array(
	esc_html__( 'Category', 'slz' )	=> 'cat',
	esc_html__( 'Service', 'slz' ) 	=> 'service'
);
$description     = array(
	esc_html__( 'Excerpt', 'slz' )	        => 'excerpt',
	esc_html__( 'Content', 'slz' ) 	        => 'content',
	esc_html__( 'Description meta', 'slz' ) => 'des'
);
$sort_by    = SLZ_Params::get('sort-other');

$args       = array('post_type' => 'slz-service');
$options    = array('empty'     => esc_html__( '-All Services-', 'slz' ) );
$services   = SLZ_Com::get_post_title2id( $args, $options );

$taxonomy   = 'slz-service-cat';
$params_cat = array('empty'   => esc_html__( '-All Service Categories-', 'slz' ) );
$categories = SLZ_Com::get_tax_options2slug( $taxonomy, $params_cat );


$vc_options = array(
	array(
		'type'            => 'dropdown',
		'heading'      	  => esc_html__( 'Show Icon or Image', 'slz' ),
		'param_name'  	  => 'show_icon',
		'value'       	  => $show_icon,
		'std'      		  => 'icon',
		'description' 	  => esc_html__( 'Choose show icon or image of service.', 'slz' )
	),
	array(
		'type'            => 'dropdown',
		'heading'      	  => esc_html__( 'Description', 'slz' ),
		'param_name'  	  => 'description',
		'value'       	  => $description,
		'description' 	  => esc_html__( 'Choose what content of service to display.', 'slz' )
	),
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
		'heading'     => esc_html__( 'Extra Class', 'slz' ),
		'param_name'  => 'extra_class',
		'value'       => '',
		'description' => esc_html__( 'Add extra class to block.', 'slz' )
	),
	array(
		'type'            => 'dropdown',
		'heading'         => esc_html__( 'Display By', 'slz' ),
		'param_name'      => 'method',
		'value'           => $method,
		'description'     => esc_html__( 'Choose service category or special services to display.', 'slz' ),
		'group'        	  => esc_html__('Filter', 'slz')
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
		'description'     => esc_html__( 'Choose service category.', 'slz' ),
		'dependency'      => array(
			'element'     => 'method',
			'value'       => array( 'cat' )
		),
		'group'       	  => esc_html__('Filter', 'slz')
	),
	array(
		'type'            => 'param_group',
		'heading'         => esc_html__( 'Services', 'slz' ),
		'param_name'      => 'list_post',
		'params'          => array(
			array(
				'type'        => 'dropdown',
				'admin_label' => true,
				'heading'     => esc_html__( 'Add service', 'slz' ),
				'param_name'  => 'post',
				'value'       => $services,
				'description' => esc_html__( 'Choose special service to show.',  'slz'  )
			)
		),
		'value'           => '',
		'dependency'      => array(
			'element'     => 'method',
			'value'       => array( 'service' )
		),
		'description'     => esc_html__( 'Default display all services if no service is selected.', 'slz' ),
		'group'       	  => esc_html__('Filter', 'slz')
	),
	array(
		'type'            => 'colorpicker',
		'heading'         => esc_html__( 'Icon Color', 'slz' ),
		'param_name'      => 'icon_color',
		'value'           => '',
		'description'     => esc_html__( 'Choose color for block icon.', 'slz' ),
		'dependency'      => array(
			'element'     => 'show_icon',
			'value'       => array( 'icon' )
		),
		'group'       	  => esc_html__('Custom', 'slz')
	),
	array(
		'type'            => 'colorpicker',
		'heading'         => esc_html__( 'Title Color', 'slz' ),
		'param_name'      => 'title_color',
		'value'           => '',
		'description'     => esc_html__( 'Choose color for block title.', 'slz' ),
		'group'       	  => esc_html__('Custom', 'slz')
	),
	array(
		'type'            => 'colorpicker',
		'heading'         => esc_html__( 'Title Active Color', 'slz' ),
		'param_name'      => 'title_active_color',
		'value'           => '',
		'description'     => esc_html__( 'Choose color for block title when activating tab.', 'slz' ),
		'group'       	  => esc_html__('Custom', 'slz')
	)
);
