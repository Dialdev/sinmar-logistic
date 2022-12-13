<?php

$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'service_list' );

$style_arr = array(
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Style', 'transera' ),
		'admin_label' => true,
		'param_name'  => 'style',
		'value'       => $shortcode->get_styles(),
		'std'         => 'style-1',
		'description' => esc_html__( 'Choose style to show.', 'transera' )
	)
);

$description     = array(
	esc_html__( 'Description meta', 'transera' ) => 'des',
	esc_html__( 'Excerpt', 'transera' )	        => 'excerpt'
);

$yes_no  = array(
	esc_html__('Yes', 'transera')			     => 'yes',
	esc_html__('No', 'transera')		         => 'no'
);
$show_icon  = array(
	esc_html__('Show Icon', 'transera')	 => 'icon',
    esc_html__('Show Image', 'transera') => 'image',
    esc_html__('Show Featured Images', 'transera') => 'feature-image'
		
);
$column = array(
	esc_html__( 'One', 'transera' )   	 	 => '1',
	esc_html__( 'Two', 'transera' )   		 => '2',
	esc_html__( 'Three', 'transera' ) 		 => '3',
	esc_html__( 'Four', 'transera' )  		 => '4'
);
$method = array(
	esc_html__( 'Category', 'transera' )	=> 'cat',
	esc_html__( 'Service', 'transera' ) 	=> 'service'
);
$sort_by = SLZ_Params::get('sort-other');

$args       = array('post_type' => 'slz-service');
$options    = array('empty'     => esc_html__( '-All Services-', 'transera' ) );
$services   = SLZ_Com::get_post_title2id( $args, $options );

$taxonomy   = 'slz-service-cat';
$params_cat = array('empty'   => esc_html__( '-All Service Categories-', 'transera' ) );
$categories = SLZ_Com::get_tax_options2slug( $taxonomy, $params_cat );


$params = array(
	array(
		'type'            => 'dropdown',
		'heading'      	  => esc_html__( 'Show Icon or Image', 'transera' ),
		'param_name'  	  => 'show_icon',
		'value'       	  => $show_icon,
		'std'      		  => 'icon',
		'description' 	  => esc_html__( 'Choose show icon or image of service.', 'transera' )
	),
	array(
		'type'            => 'dropdown',
		'heading'      	  => esc_html__( 'Description', 'transera' ),
		'param_name'  	  => 'description',
		'value'       	  => $description,
		'description' 	  => esc_html__( 'Choose what content of service to display.', 'transera' )
	),
	array(
		'type'            => 'dropdown',
		'heading'      	  => esc_html__( 'Column', 'transera' ),
		'param_name'  	  => 'column',
		'value'       	  => $column,
		'std'      		  => '3',
		'description' 	  => esc_html__( 'Choose number column will be displayed.', 'transera' )
	),
	array(
		'type'        	  => 'dropdown',
		'heading'     	  => esc_html__( 'Is Carousel ?', 'transera' ),
		'param_name'  	  => 'is_carousel',
		'value'       	  => $yes_no,
		'std'      		  => 'no',
		'description' 	  => esc_html__( 'If choose Yes, block will be display with carousel style.', 'transera' )
	),
	array(
		'type'        	  => 'dropdown',
		'heading'     	  => esc_html__( 'Show Pagination', 'transera' ),
		'param_name'  	  => 'pagination',
		'value'       	  => $yes_no,
		'std'      		  => 'no',
		'description' 	  => esc_html__( 'If choose Yes, block will be show pagination.', 'transera' ),
		'dependency'      => array(
			'element'     => 'is_carousel',
			'value'       => array( 'no' )
		)
	),
	array(
		'type'        	  => 'dropdown',
		'heading'     	  => esc_html__( 'Show More Button?', 'transera' ),
		'param_name'  	  => 'btn_more',
		'value'       	  => $yes_no,
		'std'      		  => 'yes',
		'description' 	  => esc_html__( 'If choose Yes, each item will show view more button.', 'transera' ),
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Button Text', 'transera' ),
		'param_name'  => 'btn_content',
		'value'       => 'Read More',
		'description' => esc_html__( 'Enter block button text.', 'transera' )
	),
	array(
		'type'            => 'textfield',
		'heading'         => esc_html__( 'Limit Posts', 'transera' ),
		'param_name'      => 'limit_post',
		'value'           => '-1',
		'description'     => esc_html__( 'Add limit posts per page. Set -1 or empty to show all.', 'transera' )
	),
	array(
		'type'            => 'textfield',
		'heading'         => esc_html__( 'Offset Posts', 'transera' ),
		'param_name'      => 'offset_post',
		'value'           => '0',
		'description'     => esc_html__( 'Enter offset to pass over posts. If you want to start on record 6, using offset 5.', 'transera' )
	),
	array(
		'type'            => 'dropdown',
		'heading'         => esc_html__( 'Sort By', 'transera' ),
		'param_name'      => 'sort_by',
		'value'           => $sort_by,
		'description'     => esc_html__( 'Select order to display list posts.', 'transera' ),
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Extra Class', 'transera' ),
		'param_name'  => 'extra_class',
		'value'       => '',
		'description' => esc_html__( 'Add extra class to block.', 'transera' )
	),
	array(
		'type'            => 'dropdown',
		'heading'         => esc_html__( 'Display By', 'transera' ),
		'param_name'      => 'method',
		'value'           => $method,
		'description'     => esc_html__( 'Choose service category or special services to display.', 'transera' ),
		'group'        	  => esc_html__('Filter', 'transera')
	),
	array(
		'type'            => 'param_group',
		'heading'         => esc_html__( 'Category', 'transera' ),
		'param_name'      => 'list_category',
		'params'          => array(
			array(
				'type'        => 'dropdown',
				'admin_label' => true,
				'heading'     => esc_html__( 'Add Category', 'transera' ),
				'param_name'  => 'category_slug',
				'value'       => $categories,
				'description' => esc_html__( 'Choose special category to filter.', 'transera'  )
			)
		),
		'value'           => '',
		'description'     => esc_html__( 'Choose service category.', 'transera' ),
		'dependency'      => array(
			'element'     => 'method',
			'value'       => array( 'cat' )
		),
		'group'       	  => esc_html__('Filter', 'transera')
	),
	array(
		'type'            => 'param_group',
		'heading'         => esc_html__( 'Services', 'transera' ),
		'param_name'      => 'list_post',
		'params'          => array(
			array(
				'type'        => 'dropdown',
				'admin_label' => true,
				'heading'     => esc_html__( 'Add service', 'transera' ),
				'param_name'  => 'post',
				'value'       => $services,
				'description' => esc_html__( 'Choose special service to show.',  'transera'  )
			)
		),
		'value'           => '',
		'dependency'      => array(
			'element'     => 'method',
			'value'       => array( 'service' )
		),
		'description'     => esc_html__( 'Default display all services if no service is selected.', 'transera' ),
		'group'       	  => esc_html__('Filter', 'transera')
	),
	array(
		'type'            => 'colorpicker',
		'heading'         => esc_html__( 'Icon Color', 'transera' ),
		'param_name'      => 'icon_color',
		'value'           => '',
		'description'     => esc_html__( 'Choose color for block icon.', 'transera' ),
		'group'       	  => esc_html__('Custom', 'transera')
	),
	array(
		'type'            => 'colorpicker',
		'heading'         => esc_html__( 'Title Color', 'transera' ),
		'param_name'      => 'title_color',
		'value'           => '',
		'description'     => esc_html__( 'Choose color for block title.', 'transera' ),
		'group'       	  => esc_html__('Custom', 'transera')
	),
	array(
		'type'            => 'colorpicker',
		'heading'         => esc_html__( 'Description Color', 'transera' ),
		'param_name'      => 'des_color',
		'value'           => '',
		'description'     => esc_html__( 'Choose color for block description.', 'transera' ),
		'group'       	  => esc_html__('Custom', 'transera')
	),
	array(
		'type'            => 'colorpicker',
		'heading'         => esc_html__( 'Button Color', 'transera' ),
		'param_name'      => 'btn_color',
		'value'           => '',
		'description'     => esc_html__( 'Choose color for block button.', 'transera' ),
		'group'       	  => esc_html__('Custom', 'transera')
	),
	array(
		'type'            => 'colorpicker',
		'heading'         => esc_html__( 'Button Background Color', 'transera' ),
		'param_name'      => 'btn_bg_color',
		'value'           => '',
		'description'     => esc_html__( 'Choose color for block button background.', 'transera' ),
		'group'       	  => esc_html__('Custom', 'transera')
	),
	array(
		'type'            => 'colorpicker',
		'heading'         => esc_html__( 'Carousel Navigation Color', 'transera' ),
		'param_name'      => 'nav_color',
		'value'           => '',
		'description'     => esc_html__( 'Choose color for block navigation.', 'transera' ),
		'dependency'      => array(
			'element'     => 'is_carousel',
			'value'       => array( 'yes' )
		),
		'group'       	  => esc_html__('Custom', 'transera')
	)
);

$vc_options = array_merge(
	$style_arr,
	$params
);
