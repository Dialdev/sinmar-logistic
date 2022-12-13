<?php
$taxonomy = 'slz-portfolio-cat';
$params_cat = array('empty'   => esc_html__( '-All Project Categories-', 'slz' ) );
$portfolio_cat = SLZ_Com::get_tax_options2slug( $taxonomy, $params_cat );

$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'portfolio_category' );

$params = array(
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
				'description' => esc_html__( 'Choose special category to show', 'slz'  )
			),
		),
		'value'       => '',
		'description' => esc_html__( 'Choose Portfolio Category.', 'slz' ),
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Extra Class', 'slz' ),
		'param_name'  => 'extra_class',
		'value'       => '',
		'description' => esc_html__( 'Add extra class to block', 'slz' )
	),
);

$slider_options = array(
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Slide To Show', 'slz' ),
		'param_name'  => 'slide_to_show',
		'value'       => '5',
		'description' => esc_html__( 'Please input number of slide to show.', 'slz'  ),
		'group'       => esc_html__( 'Custom Slider', 'slz' ),
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Slide To Scroll', 'slz' ),
		'param_name'  => 'slide_to_scroll',
		'value'       => '1',
		'description' => esc_html__( 'Please input number of slide to scroll.', 'slz'  ),
		'group'       => esc_html__( 'Custom Slider', 'slz' ),
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Show Dots?', 'slz' ),
		'param_name'  => 'dots',
		'std'         => 'yes',
		'value'       => $shortcode->get_config('yes_no'),
		'description' => esc_html__( 'Choose if want to show dots or not.', 'slz'  ),
		'group'       => esc_html__( 'Custom Slider', 'slz' ),
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Show Arrows?', 'slz' ),
		'param_name'  => 'arrow',
		'std'         => 'yes',
		'value'       => $shortcode->get_config('yes_no'),
		'description' => esc_html__( 'Choose if want to show arrows or not.', 'slz'  ),
		'group'       => esc_html__( 'Custom Slider', 'slz' ),
	),
);

$custom_css = array(
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Project Category Name Color', 'slz' ),
		'param_name'  => 'project_name_color',
		'description' => esc_html__( 'Choose a custom project category name color.', 'slz' ),
		'group'       => esc_html__('Custom CSS', 'slz'),
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Project Category Number Color', 'slz' ),
		'param_name'  => 'project_number_color',
		'description' => esc_html__( 'Choose a custom project category number color.', 'slz' ),
		'group'       => esc_html__('Custom CSS', 'slz'),
	),
);

$vc_options = array_merge( 
	$params,
	$slider_options,
	$custom_css
);
