<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$default_value = slz_get_db_ext_settings_option('social-counter');

$options = array(
	apply_filters('slz:ext:social-counter:settings-options:before', array()),
	'box'   => array(
		'title'     => false,
		'type'      => 'box',
		'options'   => array(
			'facebook-app-id'       => array(
				'label'     => __('Facebook APP ID', 'slz'),
				'desc'      => __('ID of your facebook application', 'slz'),
				'type'      => 'text',
				'value'     => isset($default_value['facebook-app-id']) ? $default_value['facebook-app-id'] : ''
			),
			'facebook-app-secret'   => array(
				'label'     => __('Facebook APP SECRET ID', 'slz'),
				'desc'      => __('Secret ID of your facebook application', 'slz'),
				'type'      => 'text',
				'value'     => isset($default_value['facebook-app-secret']) ? $default_value['facebook-app-secret'] : ''
			),
			'twitter-access-token'   => array(
				'label'     => __('Twitter ACCESS TOKEN', 'slz'),
				'desc'      => __('Access token of your twitter', 'slz'),
				'type'      => 'text',
				'value'     => isset($default_value['twitter-access-token']) ? $default_value['twitter-access-token'] : ''
			),
			'twitter-access-token-secret'   => array(
				'label'     => __('Twitter ACCESS TOKEN SECRET', 'slz'),
				'desc'      => __('Access token secret of your twitter', 'slz'),
				'type'      => 'text',
				'value'     => isset($default_value['twitter-access-token-secret']) ? $default_value['twitter-access-token-secret'] : ''
			),
			'twitter-customer-key'   => array(
				'label'     => __('Twitter CUSTOMER KEY', 'slz'),
				'desc'      => __('Customer key of your twitter', 'slz'),
				'type'      => 'text',
				'value'     => isset($default_value['twitter-customer-key']) ? $default_value['twitter-customer-key'] : ''
			),
			'twitter-customer-secret'   => array(
				'label'     => __('Twitter CUSTOMER SECRET', 'slz'),
				'desc'      => __('Customer secret of your twitter', 'slz'),
				'type'      => 'text',
				'value'     => isset($default_value['twitter-customer-secret']) ? $default_value['twitter-customer-secret'] : ''
			),
		)
	),
);