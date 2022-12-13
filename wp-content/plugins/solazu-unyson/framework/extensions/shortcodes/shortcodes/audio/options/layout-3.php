<?php

$vc_options = array(
	array(
		'type'       => 'param_group',
		'heading'    => esc_html__( 'Playlist', 'slz' ),
		'param_name' => 'playlist',
		'params'     => array(
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__( 'Audio Title', 'slz' ),
				'param_name'  => 'audio_title',
				'value'       => '',
				'description' => esc_html__( 'Please Input Audio Title', 'slz' )
			),
            array(
                'type'           => 'attach_files',
                'heading'        => esc_html__( 'Upload Downloaded File', 'slz' ),
                'param_name'     => 'audio_url',
                'description'    => esc_html__('Select file for downloading.', 'slz'),
            ),
		),
		'value'       => '',
	),
);