<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$cfg = array();

$cfg['default_values'] = array(
	'show_progress_bar'     => 'yes',
	'show_social_share_2'   => 'no',
);

$cfg['archive_columns'] = array(
	'has_sidebar' => 2,
	'no_sidebar'  => 3,
);
$cfg['post-type'] = array(
'slz-gallery'   => esc_html__('Gallery','slz'),
'slz-portfolio' => esc_html__('Portfolio','slz')
);
