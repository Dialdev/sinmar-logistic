<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$manifest = array(
	'name'          => esc_html__('New Tweets', 'slz'),
	'version'       => '1.0.1',
	'display'       => true,
	'thumbnail'     => slz_get_framework_directory_uri( '/extensions/new-tweet/static/img/twitter.png'),
	'standalone'    => true,
    'description'   => esc_html__('Create a widget or shortcode to show timeline of your tweets, compatible with the new Twitter API 1.1.', 'slz'),
);
