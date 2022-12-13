<?php
$column = array(
	esc_html__( 'One', 'slz' )   	=> '1',
	esc_html__( 'Two', 'slz' )   	=> '2',
	esc_html__( 'Three', 'slz' ) 	=> '3',
	esc_html__( 'Four', 'slz' )  	=> '4',
	esc_html__( 'Five', 'slz' )  	=> '5',
	esc_html__( 'Six', 'slz' )  		=> '6',
	esc_html__( 'Seven', 'slz' )  	=> '7',
	esc_html__( 'Eight', 'slz' )  	=> '8',
);
$yes_no  = array(
	esc_html__('Yes', 'slz')			=> 'yes',
	esc_html__('No', 'slz')			=> 'no',
);

$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'partner' );

$layouts = array(
	array(
        'type'			=> 'dropdown',
        'heading'		=> esc_html__( 'Layout', 'slz' ),
		'admin_label'	=> true,
        'param_name'	=> 'layout',
        'value'			=> $shortcode->get_layouts(),
		'std'			=> 'layout-1',
        'description'	=> esc_html__( 'Choose layout will be displayed.', 'slz' )
    ),
);

$layout_options = $shortcode->get_layout_options();

$params = array(
	array(
		'type'        	=> 'dropdown',
		'heading'     	=> esc_html__( 'Column', 'slz' ),
		'admin_label'	=> true,
		'param_name'  	=> 'column',
		'value'       	=> $column,
		'std'      		=> '6',
		'description' 	=> esc_html__( 'Choose number column will be displayed.', 'slz' ),
	),
	array(
		'type'        	=> 'dropdown',
		'heading'     	=> esc_html__( 'Is Padding ?', 'slz' ),
		'param_name'  	=> 'item_padding',
		'value'       	=> $yes_no,
		'std'      		=> 'yes',
		'description' 	=> esc_html__( 'Choose YES to block is padding.', 'slz' ),
	),
	array(
		'type'       => 'param_group',
		'heading'    => esc_html__( 'List of Partner', 'slz' ),
		'param_name' => 'gr_list_item',
		'params'     => array(
			array(
				'type'           => 'textfield',
				'heading'        => esc_html__( 'Item Title', 'slz' ),
				'admin_label'	=> true,
				'param_name'     => 'item_title',
				'description'    => esc_html__('Enter title of block', 'slz'),
			),
			array(
				'type'           => 'attach_image',
				'heading'        => esc_html__( 'Item Image', 'slz' ),
				'param_name'     => 'item_image',
				'description'    => esc_html__('Upload Image. Recommend uploading the pictures the same size.', 'slz'),
			),
			array(
				'type'        => 'vc_link',
				'heading'     => esc_html__( 'Item Link', 'slz' ),
				'param_name'  => 'item_link',
				'value'       => '',
				'description' => esc_html__( 'Enter link of item.', 'slz' ),
			),
		),
		'value'       => '',
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Extra Class', 'slz' ),
		'param_name'  => 'extra_class',
		'value'       => '',
		'description' => esc_html__( 'Add extra class to block', 'slz' )
	),


);

$vc_options = array_merge( 
	$layouts,
	$layout_options,
	$params
);
