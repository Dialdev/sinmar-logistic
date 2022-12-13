<?php
$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'gallery_carousel' );
$sort_by = SLZ_Params::get('sort-other');

$yes_no = array(
	esc_html__( 'Yes', 'slz' ) => 'yes',
	esc_html__( 'No', 'slz' )  => 'no',
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

// filter title
$filter_title = array(
	esc_html__( 'Post Title', 'slz' )	=> 'title',
	esc_html__( 'Icon', 'slz' ) => 'icon'
);

// gallery
$args = array('post_type'     => 'slz-gallery');
$options = array('empty'      => esc_html__( '-All Gallery-', 'slz' ) );
$gallery = SLZ_Com::get_post_title2id( $args, $options );

// portfolio
$args = array('post_type'     => 'slz-portfolio');
$options = array('empty'      => esc_html__( '-All Portfolio-', 'slz' ) );
$portfolio = SLZ_Com::get_post_title2id( $args, $options );


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
		'description' => esc_html__( 'Choose post type to show', 'slz' ),
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Choose Gallery', 'slz' ),
		'param_name'  => 'gallery',
		'value'       => $gallery,
		'dependency'  => array(
			'element'   => 'post_type',
			'value'     => array( 'slz-gallery' )
		),
		'description' => esc_html__( 'Choose special gallery to show list of gallery images in the post.',  'slz'  )
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Choose Portfolio', 'slz' ),
		'param_name'  => 'portfolio',
		'value'       => $portfolio,
		'dependency'  => array(
			'element'   => 'post_type',
			'value'     => array( 'slz-portfolio' )
		),
		'description' => esc_html__( 'Choose special portfolio to show list of gallery images in the post.',  'slz'  )
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Limit Posts', 'slz' ),
		'param_name'  => 'limit_post',
		'value'       => '-1',
		'description' => esc_html__( 'Add limit posts per page. Set -1 or empty to show all. The number of posts to display. If it blank the number posts will be the number from Settings -> Reading', 'slz' ),
		'dependency'  => array(
			'element'   => 'gallery',
			'value'     => array('')
		),
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Limit Posts', 'slz' ),
		'param_name'  => 'portfolio_limit_post',
		'value'       => '-1',
		'description' => esc_html__( 'Add limit posts per page. Set -1 or empty to show all. The number of posts to display. If it blank the number posts will be the number from Settings -> Reading', 'slz' ),
		'dependency'  => array(
			'element'   => 'portfolio',
			'value'     => array('')
		),
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Limit Images', 'slz' ),
		'param_name'  => 'limit_image',
		'value'       => '',
		'description' => esc_html__( 'Add number of images to display. If it blank, display all gallery images', 'slz' ),
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Extra Class', 'slz' ),
		'param_name'  => 'extra_class',
		'value'       => '',
		'description' => esc_html__( 'Add extra class to block', 'slz' )
	),
);
$custom_slide = array(
	array(
		'type'          => 'textfield',
		'heading'       => esc_html__( 'Slide To Show', 'slz' ),
		'param_name'    => 'slidetoshow',
		'value'			=> '5',
		'admin_label'   => true,
		'description'   => esc_html__( 'Please input number of item show in slider.', 'slz' ),
		'group'         => esc_html__('Slide Custom', 'slz'),
		'dependency'  => array(
			'element'   => 'layout',
			'value_not_equal_to'     => array( 'layout-2', 'layout-5' )
		),
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
		'heading'     	=> esc_html__( 'Show Dots Navigation ?', 'slz' ),
		'param_name'  	=> 'slide_dots',
		'value'       	=> $yes_no,
		'std'      		=> 'yes',
		'description' 	=> esc_html__( 'Choose YES to show dots navigation.', 'slz' ),
		'group'         => esc_html__('Slide Custom', 'slz')
	),
	array(
		'type'        	=> 'dropdown',
		'heading'     	=> esc_html__( 'Show Arrows Navigation ?', 'slz' ),
		'param_name'  	=> 'slide_arrows',
		'value'       	=> $yes_no,
		'std'      		=> 'yes',
		'description' 	=> esc_html__( 'Choose YES to show arrows navigation.', 'slz' ),
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
		'type'          => 'colorpicker',
		'heading'       => esc_html__( 'Arrows Color', 'slz' ),
		'param_name'    => 'color_slide_arrow',
		'value'         => '',
		'description'   => esc_html__( 'Choose color to slide arrows.', 'slz' ),
		'dependency'    => array(
			'element'   => 'slide_arrows',
			'value'     => array( 'yes' )
		),
		'group'       	=> esc_html__('Custom', 'slz')
	),
	array(
		'type'          => 'colorpicker',
		'heading'       => esc_html__( 'Arrows Hover Color', 'slz' ),
		'param_name'    => 'color_slide_arrow_hv',
		'value'         => '',
		'description'   => esc_html__( 'Choose hover color to slide arrows.', 'slz' ),
		'dependency'    => array(
			'element'   => 'slide_arrows',
			'value'     => array( 'yes' )
		),
		'group'       	=> esc_html__('Custom', 'slz')
	),
	array(
		'type'          => 'colorpicker',
		'heading'       => esc_html__( 'Arrows Background Color', 'slz' ),
		'param_name'    => 'color_slide_arrow_bg',
		'value'         => '',
		'description'   => esc_html__( 'Choose background color to slide arrows.', 'slz' ),
		'dependency'    => array(
			'element'   => 'slide_arrows',
			'value'     => array( 'yes' )
		),
		'group'       	=> esc_html__('Custom', 'slz')
	),
	array(
		'type'          => 'colorpicker',
		'heading'       => esc_html__( 'Arrows Background Hover Color', 'slz' ),
		'param_name'    => 'color_slide_arrow_bg_hv',
		'value'         => '',
		'description'   => esc_html__( 'Choose background hover color to slide arrow.', 'slz' ),
		'dependency'    => array(
			'element'   => 'slide_arrows',
			'value'     => array( 'yes' )
		),
		'group'       	=> esc_html__('Custom', 'slz')
	),
	array(
		'type'          => 'colorpicker',
		'heading'       => esc_html__( 'Dots Color', 'slz' ),
		'param_name'    => 'color_slide_dots',
		'value'         => '',
		'description'   => esc_html__( 'Choose color to slide dots.', 'slz' ),
		'dependency'    => array(
			'element'   => 'slide_dots',
			'value'     => array( 'yes' )
		),
		'group'       	=> esc_html__('Custom', 'slz')
	),
	array(
		'type'          => 'colorpicker',
		'heading'       => esc_html__( 'Dots Color Active', 'slz' ),
		'param_name'    => 'color_slide_dots_at',
		'value'         => '',
		'description'   => esc_html__( 'Choose color to slide dots when active, hover.', 'slz' ),
		'dependency'    => array(
			'element'   => 'slide_dots',
			'value'     => array( 'yes' )
		),
		'group'       	=> esc_html__('Custom', 'slz')
	)
);

$vc_options = array_merge(
	$layouts,
	$layouts_option,
	$params,
	$custom_slide
);