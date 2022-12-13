<?php
$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'isotope' );

$sort_by = SLZ_Params::get('sort-other');
$columns = array(
	esc_html__('Three', 'slz')  => '3',
	esc_html__('Four', 'slz')   => '4',
	esc_html__('Five', 'slz')   => '5',
);
$yes_no = array(
	esc_html__( 'Yes', 'slz' ) => 'yes',
	esc_html__( 'No', 'slz' )  => 'no',
);
$align = array(
	esc_html__( 'Left', 'slz' ) => 'text-l',
	esc_html__( 'Center', 'slz' ) => 'text-c',
	esc_html__( 'Right', 'slz' )  => 'text-r',
);
/* check exist post type */
if ( post_type_exists( 'slz-portfolio' ) ) {
	$post_type_arr = array(
		esc_html__( 'Gallery', 'slz' )    => 'slz-gallery',
		esc_html__( 'Portfolio', 'slz' )  => 'slz-portfolio',
	);
}else{
	$post_type_arr = array(
		esc_html__( 'Gallery', 'slz' )    => 'slz-gallery',
	);
}

$method_gallery = array(
	esc_html__( 'Category', 'slz' )	=> 'cat',
	esc_html__( 'Gallery', 'slz' ) => 'gallery'
);

$args = array('post_type'     => 'slz-gallery');
$options = array('empty'      => esc_html__( '-All Gallery-', 'slz' ) );
$gallery = SLZ_Com::get_post_title2id( $args, $options );

$taxonomy_gallery = 'slz-gallery-cat';
$params_cat = array('empty'   => esc_html__( '-All Gallery Categories-', 'slz' ) );
$gallery_cat = SLZ_Com::get_tax_options2slug( $taxonomy_gallery, $params_cat );

$method_portfolio = array(
	esc_html__( 'Category', 'slz' )	=> 'cat',
	esc_html__( 'Portfolio', 'slz' ) => 'portfolio'
);

$args = array('post_type'     => 'slz-portfolio');
$options = array('empty'      => esc_html__( '-All Portfolio-', 'slz' ) );
$portfolio = SLZ_Com::get_post_title2id( $args, $options );

$taxonomy_portfolio = 'slz-portfolio-cat';
$params_cat = array('empty'   => esc_html__( '-All Portfolio Categories-', 'slz' ) );
$portfolio_cat = SLZ_Com::get_tax_options2slug( $taxonomy_portfolio, $params_cat );

$post_type = array(
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Style', 'slz' ),
		'param_name'  => 'style',
		'value'       => $shortcode->get_styles(),
		'admin_label' => true,
		'std'         => 'style-1',
		'description' => esc_html__( 'Choose style to show', 'slz' ),
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Post Type', 'slz' ),
		'param_name'  => 'post_type',
		'value'       => $post_type_arr,
		'std'         => 'slz-gallery',
		'description' => esc_html__( 'Choose post type to show', 'slz' ),
	),
);


$params = array(
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Limit Posts', 'slz' ),
		'param_name'  => 'limit_post',
		'value'       => '-1',
		'dependency'  => array(
			'element'   => 'style',
			'value'     => array( 'style-8', 'style-10', 'style-12' )
		),
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
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Extra Class', 'slz' ),
		'param_name'  => 'extra_class',
		'value'       => '',
		'description' => esc_html__( 'Add extra class to block', 'slz' )
	),
);

$filter1 = array(
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Display By', 'slz' ),
		'param_name'  => 'method_gallery',
		'value'       => $method_gallery,
		'description' => esc_html__( 'Choose gallery category or special gallery to display', 'slz' ),
		'group'       	=> esc_html__('Filter', 'slz'),
		'dependency'  => array(
			'element'   => 'post_type',
			'value'     => array( 'slz-gallery' )
		),
	),
	array(
		'type'        => 'param_group',
		'heading'     => esc_html__( 'Category', 'slz' ),
		'param_name'  => 'list_category_gallery',
		'params'     => array(
			array(
				'type'        => 'dropdown',
				'admin_label' => true,
				'heading'     => esc_html__( 'Add Category', 'slz' ),
				'param_name'  => 'category_slug',
				'value'       => $gallery_cat,
				'description' => esc_html__( 'Choose special category to filter', 'slz'  )
			),
		),
		'value'       => '',
		'description' => esc_html__( 'Choose Gallery Category.', 'slz' ),
		'dependency'  => array(
			'element'   => 'method_gallery',
			'value'     => array( 'cat' )
		),
		'group'       	=> esc_html__('Filter', 'slz'),
	),
	array(
		'type'            => 'param_group',
		'heading'         => esc_html__( 'Gallery', 'slz' ),
		'param_name'      => 'list_post_gallery',
		'params'          => array(
			array(
				'type'        => 'dropdown',
				'admin_label' => true,
				'heading'     => esc_html__( 'Add Gallery', 'slz' ),
				'param_name'  => 'post',
				'value'       => $gallery,
				'description' => esc_html__( 'Choose special gallery to show',  'slz'  )
			),
			
		),
		'value'           => '',
		'description'     => esc_html__( 'Default display All Gallery if no gallery is selected and Number gallery is empty.', 'slz' ),
		'dependency'  => array(
			'element'   => 'method_gallery',
			'value'     => array( 'gallery' )
		),
		'group'       	=> esc_html__('Filter', 'slz'),
	),
);

$filter2 = array(
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Display By', 'slz' ),
		'param_name'  => 'method_portfolio',
		'value'       => $method_portfolio,
		'description' => esc_html__( 'Choose portfolio category or special portfolio to display', 'slz' ),
		'group'       	=> esc_html__('Filter', 'slz'),
		'dependency'  => array(
			'element'   => 'post_type',
			'value'     => array( 'slz-portfolio' )
		),
	),
	array(
		'type'        => 'param_group',
		'heading'     => esc_html__( 'Category', 'slz' ),
		'param_name'  => 'list_category_portfolio',
		'params'     => array(
			array(
				'type'        => 'dropdown',
				'admin_label' => true,
				'heading'     => esc_html__( 'Add Category', 'slz' ),
				'param_name'  => 'category_slug',
				'value'       => $portfolio_cat,
				'description' => esc_html__( 'Choose special category to filter', 'slz'  )
			),
		),
		'value'       => '',
		'description' => esc_html__( 'Choose Portfolio Category.', 'slz' ),
		'dependency'  => array(
			'element'   => 'method_portfolio',
			'value'     => array( 'cat' )
		),
		'group'       	=> esc_html__('Filter', 'slz'),
	),
	array(
		'type'            => 'param_group',
		'heading'         => esc_html__( 'Portfolio', 'slz' ),
		'param_name'      => 'list_post_portfolio',
		'params'          => array(
			array(
				'type'        => 'dropdown',
				'admin_label' => true,
				'heading'     => esc_html__( 'Add Portfolio', 'slz' ),
				'param_name'  => 'post',
				'value'       => $portfolio,
				'description' => esc_html__( 'Choose special portfolio to show',  'slz'  )
			),
			
		),
		'value'           => '',
		'description'     => esc_html__( 'Default display All Portfolio if no portfolio is selected and Number portfolio is empty.', 'slz' ),
		'dependency'  => array(
			'element'   => 'method_portfolio',
			'value'     => array( 'portfolio' )
		),
		'group'       	=> esc_html__('Filter', 'slz'),
	),
);

$custom = array(
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Show Category Filter?', 'slz' ),
		'param_name'  => 'show_category_filter',
		'value'       => $yes_no,
		'std'         => 'yes',
		'description' => esc_html__( 'Choose if you want to show category filter tab or not.', 'slz' ),
		'group'       => esc_html__( 'Custom Isotope', 'slz' )
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Alignment Filter', 'slz' ),
		'param_name'  => 'align_category_filter',
		'value'       => $align,
		'std'         => 'text-c',
		'description' => esc_html__( 'Choose alignment for category filter.', 'slz' ),
		'group'       => esc_html__( 'Custom Isotope', 'slz' ),
		'dependency'  => array(
			'element'   => 'show_category_filter',
			'value'     => array( 'yes' )
		),
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Load More Button Text', 'slz' ),
		'param_name'  => 'load_more_btn_text',
		'value'       => '',
		'description' => esc_html__( 'Enter load more button text. If empty, not show buttony.', 'slz' ),
		'group'       => esc_html__( 'Custom Isotope', 'slz' ),
		'dependency'  => array(
			'element'   => 'show_category_filter',
			'value'     => array( 'yes' )
		),
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Show Title?', 'slz' ),
		'param_name'  => 'show_title',
		'value'       => $yes_no,
		'std'         => 'yes',
		'description' => esc_html__( 'Choose if you want to show title or not.', 'slz' ),
		'group'       => esc_html__( 'Custom Isotope', 'slz' ),
		'dependency'  => array(
			'element'   => 'post_type',
			'value'     => array( 'slz-portfolio' )
		),
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Show Category?', 'slz' ),
		'param_name'  => 'show_category',
		'value'       => $yes_no,
		'std'         => 'yes',
		'description' => esc_html__( 'Choose if you want to show category or not.', 'slz' ),
		'group'       => esc_html__( 'Custom Isotope', 'slz' ),
		'dependency'  => array(
			'element'   => 'post_type',
			'value'     => array( 'slz-portfolio' )
		),
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Show Meta Data?', 'slz' ),
		'param_name'  => 'show_meta_data',
		'value'       => $yes_no,
		'std'         => 'no',
		'description' => esc_html__( 'Choose if you want to show meta data or not.', 'slz' ),
		'group'       => esc_html__( 'Custom Isotope', 'slz' ),
		'dependency'  => array(
			'element'   => 'post_type',
			'value'     => array( 'slz-portfolio' )
		),
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Show Description?', 'slz' ),
		'param_name'  => 'show_description',
		'value'       => $yes_no,
		'std'         => 'yes',
		'description' => esc_html__( 'Choose if you want to show description or not.', 'slz' ),
		'group'       => esc_html__( 'Custom Isotope', 'slz' ),
		'dependency'  => array(
			'element'   => 'post_type',
			'value'     => array( 'slz-portfolio' )
		),
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Show Read More Button?', 'slz' ),
		'param_name'  => 'show_read_more',
		'value'       => $yes_no,
		'std'         => 'yes',
		'description' => esc_html__( 'Choose if you want to show read more button or not.', 'slz' ),
		'group'       => esc_html__( 'Custom Isotope', 'slz' ),
		'dependency'  => array(
			'element'   => 'post_type',
			'value'     => array( 'slz-portfolio' )
		),
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Show Zoom Button?', 'slz' ),
		'param_name'  => 'show_fancybox_zoomin',
		'value'       => $yes_no,
		'std'         => 'yes',
		'description' => esc_html__( 'Choose if you want to show fancybox zoom in or not.', 'slz' ),
		'group'       => esc_html__( 'Custom Isotope', 'slz' ),
		'dependency'  => array(
			'element'   => 'post_type',
			'value'     => array( 'slz-portfolio' )
		),
	),
);

$custom_css = array(
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Category Color', 'slz' ),
		'param_name'  => 'cat_color',
		'value'       => '',
		'description' => esc_html__( 'Choose a custom category text color.', 'slz' ),
		'group'       => esc_html__( 'Custom CSS', 'slz' ),
		'dependency'  => array(
			'element'   => 'show_category',
			'value'     => array( 'yes' )
		),
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Title Color', 'slz' ),
		'param_name'  => 'title_color',
		'value'       => '',
		'description' => esc_html__( 'Choose a custom title text color.', 'slz' ),
		'group'       => esc_html__( 'Custom CSS', 'slz' ),
		'dependency'  => array(
			'element'   => 'post_type',
			'value'     => array( 'slz-portfolio' )
		),
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Title Hover Color', 'slz' ),
		'param_name'  => 'title_color_hover',
		'value'       => '',
		'description' => esc_html__( 'Choose a custom title text hover color.', 'slz' ),
		'group'       => esc_html__( 'Custom CSS', 'slz' ),
		'dependency'  => array(
			'element'   => 'post_type',
			'value'     => array( 'slz-portfolio' )
		),
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Meta Data Color', 'slz' ),
		'param_name'  => 'meta_data_color',
		'value'       => '',
		'description' => esc_html__( 'Choose a custom meta data color.', 'slz' ),
		'group'       => esc_html__( 'Custom CSS', 'slz' ),
		'dependency'  => array(
			'element'   => 'show_meta_data',
			'value'     => array( 'yes' )
		),
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Meta Data Hover Color', 'slz' ),
		'param_name'  => 'meta_data_hover_color',
		'value'       => '',
		'description' => esc_html__( 'Choose a custom meta data hover color.', 'slz' ),
		'group'       => esc_html__( 'Custom CSS', 'slz' ),
		'dependency'  => array(
			'element'   => 'show_meta_data',
			'value'     => array( 'yes' )
		),
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Description Color', 'slz' ),
		'param_name'  => 'description_color',
		'value'       => '',
		'description' => esc_html__( 'Choose a custom description color.', 'slz' ),
		'group'       => esc_html__( 'Custom CSS', 'slz' ),
		'dependency'  => array(
			'element'   => 'show_description',
			'value'     => array( 'yes' )
		),
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Read More Button Color', 'slz' ),
		'param_name'  => 'readmore_btn_color',
		'value'       => '',
		'description' => esc_html__( 'Choose a custom read more button text color.', 'slz' ),
		'group'       => esc_html__( 'Custom CSS', 'slz' ),
		'dependency'  => array(
			'element'   => 'show_read_more',
			'value'     => array( 'yes' )
		),
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Read More Button Hover Color', 'slz' ),
		'param_name'  => 'readmore_btn_hover_color',
		'value'       => '',
		'description' => esc_html__( 'Choose a custom read more button hover text color.', 'slz' ),
		'group'       => esc_html__( 'Custom CSS', 'slz' ),
		'dependency'  => array(
			'element'   => 'show_read_more',
			'value'     => array( 'yes' )
		),
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Zoom in Button Color', 'slz' ),
		'param_name'  => 'zoomin_btn_color',
		'value'       => '',
		'description' => esc_html__( 'Choose a custom zoom in button text color.', 'slz' ),
		'group'       => esc_html__( 'Custom CSS', 'slz' ),
		'dependency'  => array(
			'element'   => 'show_fancybox_zoomin',
			'value'     => array( 'yes' )
		),
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Zoom in Button Hover Color', 'slz' ),
		'param_name'  => 'zoomin_btn_hover_color',
		'value'       => '',
		'description' => esc_html__( 'Choose a custom zoom in button hover text color.', 'slz' ),
		'group'       => esc_html__( 'Custom CSS', 'slz' ),
		'dependency'  => array(
			'element'   => 'show_fancybox_zoomin',
			'value'     => array( 'yes' )
		),
	),
);


$vc_options = array_merge(
	$post_type,
	$params,
	$filter1,
	$filter2,
	$custom,
	$custom_css
);