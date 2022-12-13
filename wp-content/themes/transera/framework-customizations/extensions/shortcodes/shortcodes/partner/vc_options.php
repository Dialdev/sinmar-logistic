<?php
$column = array(
	esc_html__( 'One', 'transera' )   	=> '1',
	esc_html__( 'Two', 'transera' )   	=> '2',
	esc_html__( 'Three', 'transera' ) 	=> '3',
	esc_html__( 'Four', 'transera' )  	=> '4',
	esc_html__( 'Five', 'transera' )  	=> '5',
	esc_html__( 'Six', 'transera' )  		=> '6',
	esc_html__( 'Seven', 'transera' )  	=> '7',
	esc_html__( 'Eight', 'transera' )  	=> '8',
);
$yes_no  = array(
	esc_html__('Yes', 'transera')			=> 'yes',
	esc_html__('No', 'transera')			=> 'no',
);

$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'partner' );

$params = array(
	array(
		'type'        	=> 'dropdown',
		'heading'     	=> esc_html__( 'Column', 'transera' ),
		'admin_label'	=> true,
		'param_name'  	=> 'column',
		'value'       	=> $column,
		'std'      		=> '6',
		'description' 	=> esc_html__( 'Choose number column will be displayed.', 'transera' ),
	),
	array(
		'type'        	=> 'dropdown',
		'heading'     	=> esc_html__( 'Is Padding ?', 'transera' ),
		'param_name'  	=> 'item_padding',
		'value'       	=> $yes_no,
		'std'      		=> 'yes',
		'description' 	=> esc_html__( 'Choose YES to block is padding.', 'transera' ),
	),
	array(
		'type'       => 'param_group',
		'heading'    => esc_html__( 'List of Partner', 'transera' ),
		'param_name' => 'gr_list_item',
		'params'     => array(
			array(
				'type'           => 'textfield',
				'heading'        => esc_html__( 'Item Title', 'transera' ),
				'admin_label'	=> true,
				'param_name'     => 'item_title',
				'description'    => esc_html__('Enter title of block', 'transera'),
			),
			array(
				'type'           => 'attach_image',
				'heading'        => esc_html__( 'Item Image', 'transera' ),
				'param_name'     => 'item_image',
				'description'    => esc_html__('Upload Image. Recommend uploading the pictures the same size.', 'transera'),
			),
			array(
				'type'        => 'vc_link',
				'heading'     => esc_html__( 'Item Link', 'transera' ),
				'param_name'  => 'item_link',
				'value'       => '',
				'description' => esc_html__( 'Enter link of item.', 'transera' ),
			),
		),
		'value'       => '',
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Extra Class', 'transera' ),
		'param_name'  => 'extra_class',
		'value'       => '',
		'description' => esc_html__( 'Add extra class to block', 'transera' )
	),


);

$vc_options = array_merge( 
	$params
);
