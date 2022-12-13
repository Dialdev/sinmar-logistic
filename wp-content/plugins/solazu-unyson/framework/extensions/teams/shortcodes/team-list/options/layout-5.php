<?php

$column = array(
	esc_html__( 'One', 'slz' )      => '1',
	esc_html__( 'Two', 'slz' )      => '2',
	esc_html__( 'Three', 'slz' )    => '3',
	esc_html__( 'Four', 'slz' )     => '4'
);
$yes_no  = array(
	esc_html__('Yes', 'slz')        => 'yes',
	esc_html__('No', 'slz')         => 'no'
);

$vc_options = array(
	array(
		'type'          => 'dropdown',
		'heading'       => esc_html__( 'Column', 'slz' ),
		'admin_label'   => true,
		'param_name'    => 'column',
		'value'         => $column,
		'std'           => '3',
		'description'   => esc_html__( 'Choose number column will be displayed.', 'slz' )
	),
	array(
		'type'          => 'dropdown',
		'heading'       => esc_html__( 'Show Pagination ?', 'slz' ),
		'param_name'    => 'pagination',
		'value'         => $yes_no,
		'std'           => 'no',
		'description'   => esc_html__( 'If choose Yes, block will be show pagination.', 'slz' ),
	),
	array(
		'type'          => 'textfield',
		'heading'       => esc_html__( 'Max Posts', 'slz' ),
		'param_name'    => 'max_post',
		'value'         => '',
		'description'   => esc_html__( 'Add total posts when paging.', 'slz' ),
		'dependency'    => array(
			'element'   => 'pagination',
			'value'     => array( 'yes' )
		)
	),
);