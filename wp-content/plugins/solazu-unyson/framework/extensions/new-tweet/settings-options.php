<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$default_value = array(
    'consumer_key'          => slz_get_db_ext_settings_option('new-tweet','consumer_key'),
    'consumer_key_secret'   => slz_get_db_ext_settings_option('new-tweet','consumer_key_secret'),
    'access_token'          => slz_get_db_ext_settings_option('new-tweet','access_token'),
    'access_token_secret'   => slz_get_db_ext_settings_option('new-tweet','access_token_secret')
);

$options = array(
    apply_filters('slz:ext:new-tweet:settings-options:before', array()),
    'box' => array(
        'title'   => 'Manage Extension',
        'type'    => 'box',
        'options' => array(
            'consumer_key'          => array(
                'label' => __( 'Consumer Key (API Key)', 'slz' ),
                'type'  => 'text',
            ),
            'consumer_key_secret'   => array(
                'label' => __( 'Consumer Secret (API Secret)','slz' ),
                'type'  => 'text',
            ),
            'access_token'          => array(
                'label' => __('Access Token', 'slz'),
                'type'  => 'text',
            ),
            'access_token_secret'   => array(
                'label' => __('Access Token Secret', 'slz'),
                'type'  => 'text',
            	'desc'  => __( 'These details are available in <a href="https://apps.twitter.com/" target="_blank">your Twitter dashboard</a>', 'slz' ),
            ),
        )
    ),
    apply_filters('slz:ext:new-tweet:settings-options:after', array()),

);