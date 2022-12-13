<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$manifest = array(
	'name'          => esc_html__('Social Counter', 'slz'),
	'version'       => '1.0.0',
	'display'       => true,
	'thumbnail'     => slz_get_framework_directory_uri( '/extensions/social-counter/static/img/socialcounter.jpg'),
	'standalone'    => true,
	'description'   => esc_html__('Get the total count of fans and followers from your social network profiles.', 'slz'),
);
