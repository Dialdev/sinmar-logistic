<?php
	
	echo slz_html_tag('button', 
		array(
			'type'  => 'button',
			'class' => 'button add-new-item slz-export-button',
			'id'	=> $data['id_prefix'] . $id . '-copy-data'
		), 
		esc_html__('Copy Data', 'slz')
	);

	echo '<a href="' . esc_url( $export_url ) . '">';
	
	echo slz_html_tag('button', 
		array(
			'type'  => 'button',
			'class' => 'button button-primary add-new-item slz-export-button',
			'id'	=> $data['id_prefix'] . $id . '-download-data',
		),
		esc_html__('Download Data File', 'slz')
	);

	echo '</a>';


	echo slz_html_tag('button', 
		array(
			'type'  => 'button',
			'class' => 'button add-new-item slz-export-button',
			'id'	=> $data['id_prefix'] . $id . '-copy-url'
		),
		esc_html__('Copy Export URL', 'slz')
	);


	echo '<br />';


	echo slz()->backend->option_type('textarea')->render('txt-copy-data',
		array( 
			'attr'	=>	array( 
				'class'	=>	'slz-export-textarea slz-hidden',
				'rows'			=>	3,
			),
			'value'	=>	$export_data
		),
		array(
			'id_prefix' => $data['id_prefix'] . $id . '-',
			'name_prefix' => $data['name_prefix'] . '[' . $id . ']',
		)
	);


	echo slz()->backend->option_type('textarea')->render('txt-copy-url',
		array( 
			'attr'	=>	array( 
				'class'	=>	'slz-export-textarea slz-hidden',
				'rows'			=>	3,
			),
			'value'	=>	$export_url
		),
		array(
			'id_prefix' => $data['id_prefix'] . $id . '-',
			'name_prefix' => $data['name_prefix'] . '[' . $id . ']',
		)
	);

?>