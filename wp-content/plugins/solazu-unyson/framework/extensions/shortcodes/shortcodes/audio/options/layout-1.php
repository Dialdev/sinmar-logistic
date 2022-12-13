<?php
$vc_options = array(
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Title', 'slz' ),
		'param_name'  => 'title',
		'value'       => '',
		'description' => esc_html__( 'Title. If it blank the block will not have a title', 'slz' )
	),
	array(
		'type'        => 'textarea_html',
		'heading'     => esc_html__( 'Description', 'slz' ),
		'param_name'  => 'content',
		'value'       => '',
		'description' => esc_html__( 'Description. If it blank the block will not have a description', 'slz' )
	),
    array(
        'type'           => 'attach_files',
        'heading'        => esc_html__( 'Upload Downloaded File', 'slz' ),
        'param_name'     => 'audio_url',
        'description'    => esc_html__('Select file for downloading.', 'slz'),
    ),
);