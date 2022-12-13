<?php
$sort_by = slz()->extensions->get( 'portfolio' )->get_config('sort_portfolio');

$yes_no  = array(
	esc_html__('Yes', 'slz') => 'yes',
	esc_html__('No', 'slz')  => 'no',
);
$method = array(
	esc_html__( 'Category', 'slz' ) => 'cat',
	esc_html__( 'Project', 'slz' )  => 'portfolio'
);
$category_filter = array(
	esc_html__('No', 'slz')  => '',
	esc_html__('Yes', 'slz') => 'category'
);
$thumbs = array(
	esc_html__( 'Featured Image', 'slz' ) => '',
	esc_html__( 'Thumbnail', 'slz' )      => 'thumbnail',
	esc_html__( 'None', 'slz' )           => 'none',
);

$args = array('post_type'     => 'slz-portfolio');
$options = array('empty'      => esc_html__( '-All Projects-', 'slz' ) );
$portfolios = SLZ_Com::get_post_title2id( $args, $options );

$taxonomy = 'slz-portfolio-cat';
$params_cat = array('empty'   => esc_html__( '-All Project Categories-', 'slz' ) );
$portfolio_cat = SLZ_Com::get_tax_options2slug( $taxonomy, $params_cat );


$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'portfolio_carousel' );

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

$layout_options = $shortcode->get_layout_options();

$params = array(
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Show Image ?', 'slz' ),
		'param_name'  => 'show_thumbnail',
		'value'       => $thumbs,
		'description' => esc_html__( 'Show featured image or thumbnail.', 'slz' ),
		'dependency'  => array(
			'element'   => 'layout',
			'value'     => array('', 'layout-1' )
		),
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Show Category ?', 'slz' ),
		'param_name'  => 'show_category',
		'value'       => $yes_no,
		'std'         => 'no',
		'description' => esc_html__( 'If choose Yes, block will be show category.', 'slz' ),
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Show Meta Info ?', 'slz' ),
		'param_name'  => 'show_meta_info',
		'value'       => $yes_no,
		'std'         => 'no',
		'dependency'  => array(
			'element'   => 'layout',
			'value'     => array('', 'layout-1' )
		),
		'description' => esc_html__( 'If choose Yes, block will be show meta information.', 'slz' ),
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Show Description ?', 'slz' ),
		'param_name'  => 'show_description',
		'value'       => $yes_no,
		'std'         => 'yes',
		'description' => esc_html__( 'If choose Yes, block will be show description.', 'slz' ),
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Description Length', 'slz' ),
		'param_name'  => 'description_length',
		'description' => esc_html__( 'Enter number for limiting the number of word displayed.', 'slz' ),
		'dependency'  => array(
			'element'   => 'show_description',
			'value'     => array( 'yes' )
		),
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Button Text', 'slz' ),
		'param_name'  => 'button_text',
		'description' => esc_html__( 'Enter text will be show button.', 'slz' ),
	),
	array(
		'type'        => 'vc_link',
		'heading'     => esc_html__( 'Custom URL', 'slz' ),
		'param_name'  => 'custom_link',
		'description' => esc_html__( 'Enter custom url to button.', 'slz' )
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Limit Posts', 'slz' ),
		'param_name'  => 'limit_post',
		'value'       => '-1',
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

$filter = array(
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Show Category Filter Tab', 'slz' ),
		'param_name'  => 'category_filter',
		'value'       => $category_filter,
		'description' => esc_html__( 'If choose Yes, a category filter will display on top of block.', 'slz' ),
		'group'       => esc_html__('Filter', 'slz')
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Filter Tab Text', 'slz' ),
		'param_name'  => 'category_filter_text',
		'value'       => esc_html__('All', 'slz'),
		'description' => esc_html__( 'Enter text for "All" tab.', 'slz' ),
		'dependency'  => array(
			'element'   => 'category_filter',
			'value'     => array( 'category' )
		),
		'group'       => esc_html__('Filter', 'slz')
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Filter By', 'slz' ),
		'param_name'  => 'method',
		'value'       => $method,
		'description' => esc_html__( 'Choose portfolio category or special portfolio to filter', 'slz' ),
		'group'       	=> esc_html__('Filter', 'slz'),
	),
	array(
		'type'        => 'param_group',
		'heading'     => esc_html__( 'Category', 'slz' ),
		'param_name'  => 'list_category',
		'params'      => array(
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
			'element'   => 'method',
			'value'     => array( 'cat' )
		),
		'group'       => esc_html__('Filter', 'slz'),
	),
	array(
		'type'        => 'param_group',
		'heading'     => esc_html__( 'Portfolio', 'slz' ),
		'param_name'  => 'list_post',
		'params'      => array(
			array(
				'type'        => 'dropdown',
				'admin_label' => true,
				'heading'     => esc_html__( 'Add Portfolio', 'slz' ),
				'param_name'  => 'post',
				'value'       => $portfolios,
				'description' => esc_html__( 'Choose special portfolio to show',  'slz'  )
			),
			
		),
		'value'       => '',
		'description' => esc_html__( 'Default display All Portfolio if no portfolio is selected and Number portfolio is empty.', 'slz' ),
		'dependency'  => array(
			'element'   => 'method',
			'value'     => array( 'portfolio' )
		),
		'group'       => esc_html__('Filter', 'slz'),
	)
);

$slider_options = array(
	array(
		'type'          => 'textfield',
		'heading'       => esc_html__( 'Slide To Show', 'slz' ),
		'param_name'    => 'slide_to_show',
		'value'         => '3',
		'admin_label'   => true,
		'description'   => esc_html__( 'Enter number of items to show.', 'slz' ),
		'group'         => esc_html__('Slide Custom', 'slz')
	),
	array(
		'type'        	=> 'dropdown',
		'heading'     	=> esc_html__( 'Is Auto Play ?', 'slz' ),
		'param_name'  	=> 'slide_autoplay',
		'value'       	=> $yes_no,
		'std'      		=> 'yes',
		'description' 	=> esc_html__( 'Choose YES to slide auto play.', 'slz' ),
		'group'         => esc_html__('Slide Custom', 'slz')
	),
	array(
		'type'        	=> 'dropdown',
		'heading'     	=> esc_html__( 'Is Dots Navigation ?', 'slz' ),
		'param_name'  	=> 'slide_dots',
		'value'       	=> $yes_no,
		'std'      		=> 'yes',
		'description' 	=> esc_html__( 'Choose YES to show dot navigation.', 'slz' ),
		'group'         => esc_html__('Slide Custom', 'slz')
	),
	array(
		'type'        	=> 'dropdown',
		'heading'     	=> esc_html__( 'Is Arrows Navigation ?', 'slz' ),
		'param_name'  	=> 'slide_arrows',
		'value'       	=> $yes_no,
		'std'      		=> 'yes',
		'description' 	=> esc_html__( 'Choose YES to show arrow navigation.', 'slz' ),
		'group'         => esc_html__('Slide Custom', 'slz')
	),
	array(
		'type'        	=> 'dropdown',
		'heading'     	=> esc_html__( 'Is Loop Infinite ?', 'slz' ),
		'param_name'  	=> 'slide_infinite',
		'value'       	=> $yes_no,
		'std'      		=> 'yes',
		'description' 	=> esc_html__( 'Choose YES to slide loop infinite.', 'slz' ),
		'group'         => esc_html__('Slide Custom', 'slz')
	),
	array(
		'type'          => 'textfield',
		'heading'       => esc_html__( 'Speed Slide', 'slz' ),
		'param_name'    => 'slide_speed',
		'value'			=> '600',
		'description'   => esc_html__( 'Enter number value. Unit is millisecond. Example: 600.', 'slz' ),
		'group'         => esc_html__('Slide Custom', 'slz')
	),
	array(
		'type'          => 'colorpicker',
		'heading'       => esc_html__( 'Slide Arrow Color', 'slz' ),
		'param_name'    => 'color_slide_arrow',
		'value'         => '',
		'description'   => esc_html__( 'Choose color slide arrow for slide.', 'slz' ),
		'dependency'    => array(
			'element'   => 'slide_arrows',
			'value'     => array( 'yes' )
		),
		'group'       	=> esc_html__('Custom', 'slz')
	),
	array(
		'type'          => 'colorpicker',
		'heading'       => esc_html__( 'Slide Arrow Color Hover', 'slz' ),
		'param_name'    => 'color_slide_arrow_hv',
		'value'         => '',
		'description'   => esc_html__( 'Choose color slide arrow for slide when hover.', 'slz' ),
		'dependency'    => array(
			'element'   => 'slide_arrows',
			'value'     => array( 'yes' )
		),
		'group'       	=> esc_html__('Custom', 'slz')
	),
	array(
		'type'          => 'colorpicker',
		'heading'       => esc_html__( 'Slide Arrow Background Color', 'slz' ),
		'param_name'    => 'color_slide_arrow_bg',
		'value'         => '',
		'description'   => esc_html__( 'Choose background color slide arrow for slide.', 'slz' ),
		'dependency'    => array(
			'element'   => 'slide_arrows',
			'value'     => array( 'yes' )
		),
		'group'       	=> esc_html__('Custom', 'slz')
	),
	array(
		'type'          => 'colorpicker',
		'heading'       => esc_html__( 'Slide Arrow Background Color Hover', 'slz' ),
		'param_name'    => 'color_slide_arrow_bg_hv',
		'value'         => '',
		'description'   => esc_html__( 'Choose background color slide arrow for slide when hover.', 'slz' ),
		'dependency'    => array(
			'element'   => 'slide_arrows',
			'value'     => array( 'yes' )
		),
		'group'       	=> esc_html__('Custom', 'slz')
	),
	array(
		'type'          => 'colorpicker',
		'heading'       => esc_html__( 'Slide Dots Color', 'slz' ),
		'param_name'    => 'color_slide_dots',
		'value'         => '',
		'description'   => esc_html__( 'Choose color slide dots for slide.', 'slz' ),
		'dependency'    => array(
			'element'   => 'slide_dots',
			'value'     => array( 'yes' )
		),
		'group'       	=> esc_html__('Custom', 'slz')
	),
	array(
		'type'          => 'colorpicker',
		'heading'       => esc_html__( 'Slide Dots Color Active', 'slz' ),
		'param_name'    => 'color_slide_dots_at',
		'value'         => '',
		'description'   => esc_html__( 'Choose color slide dots for slide when active, hover.', 'slz' ),
		'dependency'    => array(
			'element'   => 'slide_dots',
			'value'     => array( 'yes' )
		),
		'group'       	=> esc_html__('Custom', 'slz')
	)
);
$custom = array(
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Title Color', 'slz' ),
		'param_name'  => 'color_title',
		'value'       => '',
		'description' => esc_html__( 'Choose color title for block.', 'slz' ),
		'group'       => esc_html__('Custom', 'slz'),
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Title Color Hover', 'slz' ),
		'param_name'  => 'color_title_hv',
		'value'       => '',
		'description' => esc_html__( 'Choose color title for block when hover.', 'slz' ),
		'group'       => esc_html__('Custom', 'slz'),
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Category Color', 'slz' ),
		'param_name'  => 'color_category',
		'value'       => '',
		'description' => esc_html__( 'Choose color category for block.', 'slz' ),
		'group'       => esc_html__('Custom', 'slz'),
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Category Color Hover', 'slz' ),
		'param_name'  => 'color_category_hv',
		'value'       => '',
		'description' => esc_html__( 'Choose color category for block when hover.', 'slz' ),
		'group'       => esc_html__('Custom', 'slz'),
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Meta Info Color', 'slz' ),
		'param_name'  => 'color_meta_info',
		'value'       => '',
		'description' => esc_html__( 'Choose color meta info for block.', 'slz' ),
		'dependency'  => array(
			'element'   => 'layout',
			'value'     => array('', 'layout-1' )
		),
		'group'       => esc_html__('Custom', 'slz'),
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Meta Info Color Hover', 'slz' ),
		'param_name'  => 'color_meta_info_hv',
		'value'       => '',
		'description' => esc_html__( 'Choose color meta info for block when hover.', 'slz' ),
		'dependency'  => array(
			'element'   => 'layout',
			'value'     => array('', 'layout-1' )
		),
		'group'       => esc_html__('Custom', 'slz'),
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Description Color', 'slz' ),
		'param_name'  => 'color_description',
		'value'       => '',
		'description' => esc_html__( 'Choose color description for block.', 'slz' ),
		'group'       => esc_html__('Custom', 'slz'),
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Background Image Color Hover', 'slz' ),
		'param_name'  => 'color_item_bg_hv',
		'value'       => '',
		'description' => esc_html__( 'Choose background color image for block when hover.', 'slz' ),
		'group'       => esc_html__('Custom', 'slz'),
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Button Color', 'slz' ),
		'param_name'  => 'color_button',
		'value'       => '',
		'description' => esc_html__( 'Choose color button for block.', 'slz' ),
		'group'       => esc_html__('Custom', 'slz'),
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Button Color Hover', 'slz' ),
		'param_name'  => 'color_button_hv',
		'value'       => '',
		'description' => esc_html__( 'Choose color button for block when hover.', 'slz' ),
		'group'       => esc_html__('Custom', 'slz'),
	)
);

$vc_options = array_merge( 
	$layouts,
	$layout_options,
	$params,
	$filter,
	$slider_options,
	$custom
);
