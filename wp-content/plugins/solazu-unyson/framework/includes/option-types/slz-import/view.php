<?php
	
	echo slz_html_tag('button', 
		array(
			'type' => 'button',
			'class' => 'button button-primary add-new-item slz-import-button',
			'id'	=> $data['id_prefix'] . $id . '-btn-import-file'
		),
		esc_html__('Import from File', 'slz')
	);

	echo slz_html_tag('button', 
		array(
			'type' => 'button',
			'class' => 'button add-new-item',
			'id'	=> $data['id_prefix'] . $id . '-btn-import-url'
		),
		esc_html__('Import from URL', 'slz')
	);

	echo '<br />';

	echo slz()->backend->option_type('textarea')->render('import-file',
		array( 
			'attr'	=>	array( 
				'class'	=>	'slz-import-textarea',
				'rows'			=>	3,
				'placeholder'	=>	esc_html__('Input your backup file below and hit Import to restore your sites options from a backup.', 'slz')
			),
		),
		array(
			'id_prefix' => $data['id_prefix'] . $id . '-',
			'name_prefix' => $data['name_prefix'] . '[' . $id . ']',
		)
	);

	echo slz()->backend->option_type('textarea')->render('import-url',
		array( 
			'attr'	=>	array( 
				'class' 		=> 'slz-import-textarea slz-hidden',
				'rows'			=>	3,
				'placeholder'	=>	esc_html__('Input the URL to another sites options set and hit Import to load the options from that site.', 'slz')
			),
		),
		array(
			'id_prefix' => $data['id_prefix'] . $id . '-',
			'name_prefix' => $data['name_prefix'] . '[' . $id . ']',
		)
	);

	echo '<br />';

	echo slz_html_tag('button', 
		array(
			'type' => 'button',
			'class' => 'button button-primary add-new-item',
			'id'	=> $data['id_prefix'] . $id . '-btn-import-submit',
			'import-from'	=> 	'file'
		), 
		esc_html__('Import', 'slz')
	);

?>