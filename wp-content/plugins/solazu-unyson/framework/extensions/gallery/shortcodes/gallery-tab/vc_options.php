<?php
$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'gallery_tab' );
$sort_by = SLZ_Params::get('sort-other');

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

$filter_title = array(
	esc_html__( 'Post Title', 'slz' )	=> 'title',
	esc_html__( 'Icon', 'slz' ) => 'icon'
);


$args = array('post_type'     => 'slz-portfolio');
$options = array('empty'      => esc_html__( '-All Portfolio-', 'slz' ) );
$portfolio = SLZ_Com::get_post_title2id( $args, $options );

$taxonomy_portfolio = 'slz-portfolio-cat';
$params_cat = array('empty'   => esc_html__( '-All Portfolio Categories-', 'slz' ) );
$portfolio_cat = SLZ_Com::get_tax_options2slug( $taxonomy_portfolio, $params_cat );

$layouts = array(
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Layout', 'slz' ),
		'param_name'  => 'layout',
		'value'       => $shortcode->get_layouts(),
		'admin_label' => true,
		'std'         => 'layout-1',
		'description' => esc_html__( 'Choose style to show', 'slz' ),
	),
);
$layouts_option = $shortcode->get_layout_options();

$params = array(
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Post Type', 'slz' ),
		'param_name'  => 'post_type',
		'admin_label' => true,
		'value'       => $post_type_arr,
		'std'         => 'slz-gallery',
		'description' => esc_html__( 'Choose post type to show. Images will be taken from the gallery of the posts.', 'slz' ),
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Number Image', 'slz' ),
		'param_name'  => 'limit_post',
		'value'       => '-1',
		'description' => esc_html__( 'Add limit posts per page. Set -1 or empty to show all. The number of posts to display. If it blank the number posts will be the number from Settings -> Reading', 'slz' ),
		'dependency'  => array(
			'element'   => 'layout',
			'value'     => array( 'layout-1' )
		)
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Load More Button Text', 'slz' ),
		'param_name'  => 'load_more_btn_text',
		'value'       => '',
		'description' => esc_html__( 'Enter load more button text. If empty, not show button.', 'slz' ),
		'dependency'  => array(
			'element'   => 'layout',
			'value'     => array( 'layout-2' )
		)
	)
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
	array('type'        => 'dropdown',
		'heading'     => esc_html__( 'Filter Title', 'slz' ),
		'param_name'  => 'filter_title_gallery',
		'value'       => $filter_title,
		'description' => esc_html__( 'Choose type of filter title', 'slz' ),
		'group'       	=> esc_html__('Filter', 'slz'),
		'dependency'  => array(
			'element'   => 'method_gallery',
			'value'     => array( 'gallery' )
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
	array('type'        => 'dropdown',
		'heading'     => esc_html__( 'Filter Title', 'slz' ),
		'param_name'  => 'filter_title_portfolio',
		'value'       => $filter_title,
		'description' => esc_html__( 'Choose type of filter title', 'slz' ),
		'group'       	=> esc_html__('Filter', 'slz'),
		'dependency'  => array(
			'element'   => 'method_portfolio',
			'value'     => array( 'portfolio' )
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

$extra_class = array(
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Extra Class', 'slz' ),
		'param_name'  => 'extra_class',
		'value'       => '',
		'description' => esc_html__( 'Add extra class to block', 'slz' )
	)
);

$vc_options = array_merge(
	$layouts,
	$filter1,
	$filter2,
	$layouts_option,
	$params,
	$extra_class
);