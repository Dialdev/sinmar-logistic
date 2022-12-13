<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$limits = apply_filters('slz_ext_backups_schedule_lifetime_limits', array(
	'monthly' => 12,
	'weekly' => 4,
	'daily' => 7,
));

$sub_options = array(
	'type' => 'multi-picker',
	'label' => false,
	'desc'  => false,
	'show_borders' => true,
	'picker' => array(
		'interval' => array(
			'label'   => __('Interval', 'slz'),
			'type'    => 'radio',
			'inline'  => true,
			'choices' => array(
				''  => __('Disabled', 'slz'),
				'monthly' => __('Monthly', 'slz'),
				'weekly' => __('Weekly', 'slz'),
				'daily' => __('Daily', 'slz'),
			),
			'desc'    => __('Select how often do you want to backup your website.', 'slz'),
		)
	),
	'choices' => array(
		'monthly' => array(
			'lifetime' => array(
				'type' => 'short-slider',
				'label' => __('Age Limit', 'slz'),
				'desc' => __('Age limit of backups in months', 'slz'),
				'value' => $limits['monthly'],
				'properties' => array(
					'min' => 1,
					'max' => $limits['monthly'],
					'grid_snap' => true,
				),
			),
		),
		'weekly' => array(
			'lifetime' => array(
				'type' => 'short-slider',
				'label' => __('Age Limit', 'slz'),
				'desc' => __('Age limit of backups in weeks', 'slz'),
				'value' => $limits['weekly'],
				'properties' => array(
					'min' => 1,
					'max' => $limits['weekly'],
					'grid_snap' => true,
				),
			),
		),
		'daily' => array(
			'lifetime' => array(
				'type' => 'short-slider',
				'label' => __('Age Limit', 'slz'),
				'desc' => __('Age limit of backups in days', 'slz'),
				'value' => $limits['daily'],
				'properties' => array(
					'min' => 1,
					'max' => $limits['daily'],
					'grid_snap' => true,
				),
			),
		),
	),
);

$options = array();

if (slz_ext_backups_current_user_can_full()) {
	$options['full'] = array(
		'type'    => 'tab',
		'title'   => __( 'Full Backup', 'slz' ),
		'options' => array(
			'full' => $sub_options,
		),
	);
}

$options['content'] = array(
	'type' => 'tab',
	'title' => __('Content Backup', 'slz'),
	'options' => array(
		'content' => $sub_options,
	),
);
