<?php if ( ! defined( 'SLZ' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'import_export_tab' => array(
		'title'   => esc_html__( 'Import / Export', 'transera' ),
		'type'    => 'tab',
		'options' => array(
			'import'	=>	array(
				'type'	=>	'slz-import',
				'label' =>	esc_html__('Import Options', 'transera'),
                'desc'  =>	esc_html__('WARNING! This will overwrite all existing option values, please proceed with caution!', 'transera'),
			),
			'export'	=>	array(
				'type'	=>	'slz-export',
				'label' =>	esc_html__('Export Options', 'transera'),
                'desc'  =>	esc_html__('Here you can copy/download your current option settings. Keep this safe as you can use it as a backup should anything go wrong, or you can use it to restore your settings on this site (or any other site).', 'transera'),
			)
		)
	)
);
