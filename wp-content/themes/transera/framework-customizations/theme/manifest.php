<?php if ( ! defined( 'SLZ' ) ) {
	die( 'Forbidden' );
}

$manifest = array();

$manifest['id'] 				 = 'transera';
$manifest['skin']                = 'main';

$manifest['requirements']        = array(
	'wordpress' => array(
		'min_version' => '4.4',
	),
);

$manifest['prefix'] = 'transera';
$manifest['post_view_name']		 = 'transera_postview_number';
$manifest['sidebar_name']		 = 'transera-custom-sidebar';
$manifest['log_page_id']         = 'transera-log';

$manifest['supported_extensions'] = array(
	'megamenu'     	=> array(),
	'services'		=> array(),
	'testimonials'	=> array(),
	'teams'			=> array(),
	'gallery'		=> array(),
	'recruitment'	=> array(),
	'backups'		=> array(),
);

$manifest['theme_libs'] = array(
	'bootstrap.min', 'bootstrap-datepicker.min',
	'font-awesome.min', 'transera-fonts',
);

$manifest['server_requirements'] = array(
	'server' => array(
		'wp_memory_limit'          => '256M', // use M for MB, G for GB
		'php_version'              => '5.2.4',
		'post_max_size'            => '8M',
		'php_time_limit'           => '1500',
		'php_max_input_vars'       => '4000',
		'suhosin_post_max_vars'    => '3000',
		'suhosin_request_max_vars' => '3000',
		'mysql_version'            => '5.6',
		'max_upload_size'          => '8M',
	),
);

$manifest['register_image_sizes'] = array(
	'transera-thumb-350x350'       => array( 'width' => 350, 'height' => 350, 'crop' => array('center', 'top' ) ),
	'transera-thumb-800x400'       => array( 'width' => 800, 'height' => 400, 'crop' => array('center', 'top' ) ),
	'transera-thumb-370x180'       => array( 'width' => 370, 'height' => 180, 'crop' => array('center', 'top' ) ),
	'transera-thumb-600x600'       => array( 'width' => 600, 'height' => 600, 'crop' => array('center', 'top' ) ),
 	'transera-thumb-550x350'       => array( 'width' => 550, 'height' => 350, 'crop' => array('center', 'top' ) ),
 	'transera-thumb-800x600'       => array( 'width' => 800, 'height' => 600, 'crop' => array('center', 'top' ) ),
 	'transera-thumb-800x300'       => array( 'width' => 800, 'height' => 300, 'crop' => array('center', 'top' ) ),
	'transera-thumb-160x84'        => array( 'width' => 160, 'height' => 84, 'crop' => array('center', 'top' ) ),
	'transera-thumb-570x320'       => array( 'width' => 570, 'height' => 320, 'crop' => array('center', 'top' ) ),
	'transera-thumb-64x64'         => array( 'width' => 64, 'height' => 64, 'crop' => array('center', 'top' ) ),
);

$manifest['css_supported_shortcodes'] = array(
	'accordion',
    'counter',
    'gallery',
    'icon-box',
    'map',
    'newsletter',
    'posts-block',
    'posts-carousel',
    'progress-bar',
    'pricing-box',
    'tabs',
    'testimonial',
    'teams',
    'timeline',
    'service-list',
    'newsletter',
    'recruitment',
    'banner',
    'header',
    'partner',
);
