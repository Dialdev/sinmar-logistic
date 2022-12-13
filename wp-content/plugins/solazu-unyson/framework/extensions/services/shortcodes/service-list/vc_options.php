<?php

$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'service_list' );

$layouts = array(
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Layout', 'slz' ),
		'admin_label' => true,
		'param_name'  => 'layout',
		'value'       => $shortcode->get_layouts(),
		'std'         => 'layout-1',
		'description' => esc_html__( 'Choose layout to show.', 'slz' )
	)
);
$description     = array(
	esc_html__( 'Description meta', 'slz' ) => 'des',
	esc_html__( 'Excerpt', 'slz' )	        => 'excerpt'
);

$layout_options = $shortcode->get_layout_options();

$yes_no  = array(
	esc_html__('Yes', 'slz')			     => 'yes',
	esc_html__('No', 'slz')		         => 'no'
);
$show_icon  = array(
	esc_html__('Show Icon', 'slz')	 => 'icon',
	esc_html__('Show Image', 'slz') => 'image',
    esc_html__('Show Featured Images', 'slz') => 'feature-image'
);
$column = array(
	esc_html__( 'One', 'slz' )   	 	 => '1',
	esc_html__( 'Two', 'slz' )   		 => '2',
	esc_html__( 'Three', 'slz' ) 		 => '3',
	esc_html__( 'Four', 'slz' )  		 => '4'
);
$method = array(
	esc_html__( 'Category', 'slz' )	=> 'cat',
	esc_html__( 'Service', 'slz' ) 	=> 'service'
);
$sort_by = SLZ_Params::get('sort-other');

$args       = array('post_type' => 'slz-service');
$options    = array('empty'     => esc_html__( '-All Services-', 'slz' ) );
$services   = SLZ_Com::get_post_title2id( $args, $options );

$taxonomy   = 'slz-service-cat';
$params_cat = array('empty'   => esc_html__( '-All Service Categories-', 'slz' ) );
$categories = SLZ_Com::get_tax_options2slug( $taxonomy, $params_cat );


$params = array(
	array(
		'type'            => 'dropdown',
		'heading'      	  => esc_html__( 'Show Icon or Image', 'slz' ),
		'param_name'  	  => 'show_icon',
		'value'       	  => $show_icon,
		'std'      		  => 'icon',
		'description' 	  => esc_html__( 'Choose show icon or image of service.', 'slz' )
	),
	array(
		'type'        => 'checkbox',
		'heading'     => esc_html__( 'Show Numerical Order?', 'slz' ),
		'param_name'  => 'show_number',
		'description' => esc_html__( 'Displays the number order of each item', 'slz' ),
		'dependency'      => array(
			'element'     => 'show_icon',
			'value'       => array( 'icon' )
		)
	),
	array(
		'type'            => 'dropdown',
		'heading'      	  => esc_html__( 'Description', 'slz' ),
		'param_name'  	  => 'description',
		'value'       	  => $description,
		'description' 	  => esc_html__( 'Choose what content of service to display.', 'slz' )
	),
	array(
		'type'            => 'dropdown',
		'heading'      	  => esc_html__( 'Column', 'slz' ),
		'param_name'  	  => 'column',
		'value'       	  => $column,
		'std'      		  => '3',
		'description' 	  => esc_html__( 'Choose number column will be displayed.', 'slz' )
	),
	array(
		'type'        	  => 'dropdown',
		'heading'     	  => esc_html__( 'Show Pagination', 'slz' ),
		'param_name'  	  => 'pagination',
		'value'       	  => $yes_no,
		'std'      		  => 'no',
		'description' 	  => esc_html__( 'If choose Yes, block will be show pagination.', 'slz' ),
		'dependency'      => array(
			'element'     => 'is_carousel',
			'value'       => array( 'no' )
		)
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Button Text', 'slz' ),
		'param_name'  => 'btn_content',
		'value'       => 'Read More',
		'description' => esc_html__( 'Enter block button text.', 'slz' )
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
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Block Background Color', 'lawplus' ),
		'param_name'  => 'block_bg_color',
		'value'       => '',
		'description' => esc_html__( 'Choose background color for this block.', 'lawplus' ),
		'group'       => esc_html__('Custom', 'slz')
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Block Background Hover Color', 'slz' ),
		'param_name'  => 'block_bg_hv_color',
		'value'       => '',
		'description' => esc_html__( 'Choose background color for this block when hover.', 'slz' ),
		'group'       => esc_html__('Custom', 'slz')
	),
	array(
		'type'            => 'colorpicker',
		'heading'         => esc_html__( 'Icon Color', 'slz' ),
		'param_name'      => 'icon_color',
		'value'           => '',
		'description'     => esc_html__( 'Choose color for block icon.', 'slz' ),
		'group'       	  => esc_html__('Custom', 'slz')
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Icon Border Color', 'slz' ),
		'param_name'  => 'icon_bd_color',
		'value'       => '',
		'dependency'    => array(
    		'element'   => 'layout',
  			'value'     => array( 'layout-1' )
  		),
		'description' => esc_html__( 'Choose icon border color.', 'slz' ),
		'group'       => esc_html__('Custom', 'slz')
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Icon Border Hover Color', 'slz' ),
		'param_name'  => 'icon_bd_hv_color',
		'value'       => '',
		'dependency'    => array(
    		'element'   => 'layout',
  			'value'     => array( 'layout-1' )
  		),
		'description' => esc_html__( 'Choose icon border color when hover.', 'slz' ),
		'group'       => esc_html__('Custom', 'slz')
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
		'heading'         => esc_html__( 'Description Color', 'slz' ),
		'param_name'      => 'des_color',
		'value'           => '',
		'description'     => esc_html__( 'Choose color for block description.', 'slz' ),
		'group'       	  => esc_html__('Custom', 'slz')
	),
	array(
		'type'            => 'colorpicker',
		'heading'         => esc_html__( 'Button Color', 'slz' ),
		'param_name'      => 'btn_color',
		'value'           => '',
		'description'     => esc_html__( 'Choose color for block button.', 'slz' ),
		'group'       	  => esc_html__('Custom', 'slz')
	),
	array(
		'type'            => 'colorpicker',
		'heading'         => esc_html__( 'Button Background Color', 'slz' ),
		'param_name'      => 'btn_bg_color',
		'value'           => '',
		'description'     => esc_html__( 'Choose color for block button background.', 'slz' ),
		'group'       	  => esc_html__('Custom', 'slz')
	),
	array(
		'type'            => 'colorpicker',
		'heading'         => esc_html__( 'Carousel Navigation Color', 'slz' ),
		'param_name'      => 'nav_color',
		'value'           => '',
		'description'     => esc_html__( 'Choose color for block navigation.', 'slz' ),
		'dependency'      => array(
			'element'     => 'is_carousel',
			'value'       => array( 'yes' )
		),
		'group'       	  => esc_html__('Custom', 'slz')
	),

	array(
		'type'        	  => 'dropdown',
		'heading'     	  => esc_html__( 'Is Carousel ?', 'slz' ),
		'param_name'  	  => 'is_carousel',
		'value'       	  => $yes_no,
		'std'      		  => 'no',
		'description' 	  => esc_html__( 'If choose Yes, block will be display with carousel style.', 'slz'),
		'group'           => esc_html__('Slide Custom', 'slz')
	),
	array(
		'type'            => 'dropdown',
		'heading'     	  => esc_html__( 'Show Dots ?', 'slz' ),
		'param_name'  	  => 'show_dots',
		'value'       	  => $yes_no,
		'std'      		  => 'yes',
		'description' 	  => esc_html__( 'If choose Yes, block will be show dots.', 'slz' ),
		'group'           => esc_html__('Slide Custom', 'slz'),
		'dependency'    => array(
			'element'   => 'is_carousel',
			'value'     => array( 'yes' )
		)
	),
	array(
		'type'        	  => 'dropdown',
		'heading'     	  => esc_html__( 'Show Arrow ?', 'slz' ),
		'param_name'  	  => 'show_arrows',
		'value'       	  => $yes_no,
		'std'      		  => 'yes',
		'description' 	  => esc_html__( 'If choose Yes, block will be show arrow.', 'slz' ),
		'group'           => esc_html__('Slide Custom', 'slz'),
		'dependency'    => array(
			'element'   => 'is_carousel',
			'value'     => array( 'yes' )
		)
	),
	array(
		'type'        	  => 'dropdown',
		'heading'     	  => esc_html__( 'Is Auto Play ?', 'slz' ),
		'param_name'  	  => 'slide_autoplay',
		'value'       	  => $yes_no,
		'std'      		  => 'yes',
		'description' 	  => esc_html__( 'Choose YES to slide auto play.', 'slz' ),
		'group'           => esc_html__('Slide Custom', 'slz'),
		'dependency'    => array(
			'element'   => 'is_carousel',
			'value'     => array( 'yes' )
		)
	),
	array(
		'type'        	  => 'dropdown',
		'heading'     	  => esc_html__( 'Is Loop Infinite ?', 'slz' ),
		'param_name'  	  => 'slide_infinite',
		'value'       	  => $yes_no,
		'std'      		  => 'yes',
		'description' 	  => esc_html__( 'Choose YES to slide loop infinite.', 'slz' ),
		'group'           => esc_html__('Slide Custom', 'slz'),
		'dependency'    => array(
			'element'   => 'is_carousel',
			'value'     => array( 'yes' )
		)
	),
	array(
		'type'            => 'textfield',
		'heading'         => esc_html__( 'Speed Slide', 'slz' ),
		'param_name'      => 'slide_speed',
		'value'			  => '',
		'description'     => esc_html__( 'Enter number value. Unit is millisecond. Example: 600.', 'slz' ),
		'group'           => esc_html__('Slide Custom', 'slz'),
		'dependency'    => array(
			'element'   => 'is_carousel',
			'value'     => array( 'yes' )
		)
	)
);

$vc_options = array_merge( 
	$layouts,
	$layout_options,
	$params
);
