<?php if ( ! defined( 'SLZ' ) ) {
	die( 'Forbidden' );
}

$transera_server_requirements = slz()->theme->manifest->get('server_requirements');

// wp version
global $wp_version;
$transera_wp_required_version = slz()->theme->manifest->get('requirements/wordpress/min_version');
if( version_compare($wp_version, $transera_wp_required_version , '<=') ){
	$transera_wp_version_text = '<i class="slz-no-icon dashicons dashicons-info"></i>'.'<strong>'.$wp_version.'</strong>';
	$transera_wp_version_description_text = '<span class="slz-error-message">' .esc_html__( "The version of WordPress installed on your site.", 'transera' ). ' '. esc_html__( 'We recommend you update WordPress to the latest version. The minimum required version for this theme is:', 'transera' ) .' <strong>'.$transera_wp_required_version. '</strong>. <a target="_blank" href="'.esc_url( admin_url('update-core.php') ).'">'.esc_html__('Do that right now', 'transera').'</a></span>';
}
else{
	$transera_wp_version_text = '<i class="slz-yes-icon dashicons dashicons-yes"></i>'.'<strong>'.$wp_version.'</strong>';
	$transera_wp_version_description_text = esc_html__( "The version of WordPress installed on your site", 'transera' );
}

// wp multisite
if ( is_multisite() ){
	$transera_multisite_text = '<i class="slz-yes-icon dashicons dashicons-yes"></i>'.'<strong>'.esc_html__('Yes', 'transera').'</strong>';
}
else{
	$transera_multisite_text = '<i class="slz-yes-icon dashicons dashicons-yes"></i>'.'<strong>'.esc_html__('No', 'transera').'</strong>';
}

// wp debug mode
if ( defined('WP_DEBUG') && WP_DEBUG ){
	$transera_wp_debug_mode_text = '<i class="slz-no-icon dashicons dashicons-info"></i>'.'<strong>'.esc_html__('Yes', 'transera').'</strong>';
	$transera_wp_debug_mode_description_text = '<span class="slz-error-message">' .esc_html__( 'Displays whether or not WordPress is in Debug Mode. This mode is used by developers to test the theme. We recommend you turn it off for an optimal user experience on your website.', 'transera' ).' <a href="'.esc_url('https://codex.wordpress.org/WP_DEBUG').'" target="_blank">'.esc_html__('Learn how to do it', 'transera').'</a></span>';
}
else{
	$transera_wp_debug_mode_text = '<i class="slz-yes-icon dashicons dashicons-yes"></i>'.'<strong>'.esc_html__('No', 'transera').'</strong>';
	$transera_wp_debug_mode_description_text = esc_html__( 'Displays whether or not WordPress is in Debug Mode', 'transera' );
}

// wp memory limit
$transera_memory = transera_return_memory_size( WP_MEMORY_LIMIT );
$transera_requirements_wp_memory_limit = transera_return_memory_size($transera_server_requirements['server']['wp_memory_limit']);
if ( $transera_memory < $transera_requirements_wp_memory_limit ) {
	$transera_wp_memory_limit_text = '<i class="slz-no-icon dashicons dashicons-info"></i>'.'<strong>'.size_format( $transera_memory ).'</strong>';
	$transera_wp_memory_limit_description_text = '<span class="slz-error-message">' . esc_html__('The maximum amount of memory (RAM) that your site can use at one time.', 'transera') . ' '.wp_kses(__( 'We recommend setting memory to at least <strong>256MB</strong>. Please define memory limit in <strong>wp-config.php</strong> file.', 'transera'), array('<strong>' => array()) ).' <a href="'.esc_url('http://codex.wordpress.org/Editing_wp-config.php#Increasing_memory_allocated_to_PHP').'" target="_blank">'.esc_html__('Learn how to do it', 'transera' ).'</a></span>';
} else {
	$transera_wp_memory_limit_text = '<i class="slz-yes-icon dashicons dashicons-yes"></i>'.'<strong>'.size_format( $transera_memory ).'</strong>';
	$transera_wp_memory_limit_description_text = esc_html__('The maximum amount of memory (RAM) that your site can use at one time', 'transera');
}

// php version
if ( function_exists( 'phpversion' ) ) {
	if( version_compare(phpversion(), $transera_server_requirements['server']['php_version'], '<=') ){
		$transera_php_version_text = '<i class="slz-no-icon dashicons dashicons-info"></i><strong>'.esc_html( phpversion() ).'</strong>';
		$transera_php_version_description_text = '<span class="slz-error-message">' .esc_html__( 'The version of PHP installed on your hosting server.', 'transera' ).' '.esc_html__( 'We recommend you update PHP to the latest version. The minimum required version for this theme is:', 'transera' ) .' <strong>'.$transera_server_requirements['server']['php_version']. '</strong>. '.__('Contact your hosting provider, they can install it for you.', 'transera').'</span>';
	}
	else{
		$transera_php_version_text = '<i class="slz-yes-icon dashicons dashicons-yes"></i><strong>'.esc_html( phpversion() ).'</strong>';
		$transera_php_version_description_text =  esc_html__( 'The version of PHP installed on your hosting server', 'transera' );
	}
}
else{
	$transera_php_version_text = esc_html__('No PHP Installed', 'transera');
}

// php post max size
$transera_requirements_post_max_size = transera_return_memory_size($transera_server_requirements['server']['post_max_size']);
if ( transera_return_memory_size( ini_get('post_max_size') ) < $transera_requirements_post_max_size ) {
	$transera_php_post_max_size_text = '<i class="slz-no-icon dashicons dashicons-info"></i><strong>'.size_format(transera_return_memory_size( ini_get('post_max_size') ) ).'</strong>';
	$transera_php_post_max_size_description_text = '<span class="slz-error-message">' .esc_html__( 'The largest file size that can be contained in one post.', 'transera'  ).' '. esc_html__( 'We recommend setting the post maximum size to at least:', 'transera' ) .' <strong>'.size_format($transera_requirements_post_max_size). '</strong>'.'. <a href="'.esc_url('http://docs.themefuse.com/the-core/your-theme/theme-settings/how-to-set-a-maximum-file-upload-size').'" target="_blank">'.esc_html__('Learn how to do it','transera').'</a></span>';
}
else{
	$transera_php_post_max_size_text = '<i class="slz-yes-icon dashicons dashicons-yes"></i><strong>'.size_format(transera_return_memory_size( ini_get('post_max_size') ) ).'</strong>';
	$transera_php_post_max_size_description_text = esc_html__( 'The largest file size that can be contained in one post', 'transera'  );
}

// php time limit
$transera_time_limit = ini_get('max_execution_time');
$transera_required_php_time_limit = (int)$transera_server_requirements['server']['php_time_limit'];
if ( $transera_time_limit < $transera_required_php_time_limit && $transera_time_limit != 0 ) {
	$transera_php_time_limit_text = '<i class="slz-no-icon dashicons dashicons-info"></i>'.'<strong>'.$transera_time_limit.'</strong>';
	$transera_php_time_limit_description_text = '<span class="slz-error-message">'.esc_html__( 'The amount of time (in seconds) that your site will spend on a single operation before timing out (to avoid server lockups).', 'transera'  ).' '.esc_html__( 'We recommend setting the maximum execution time to at least', 'transera').' <strong>'.$transera_required_php_time_limit.'</strong>'.'. <a href="'.esc_url('http://codex.wordpress.org/Common_WordPress_Errors#Maximum_execution_time_exceeded').'" target="_blank">'.esc_html__('Learn how to do it','transera').'</a></span>';
} else {
	$transera_php_time_limit_description_text = esc_html__( 'The amount of time (in seconds) that your site will spend on a single operation before timing out (to avoid server lockups)', 'transera'  );
	$transera_php_time_limit_text = '<i class="slz-yes-icon dashicons dashicons-yes"></i>'.'<strong>'.$transera_time_limit.'</strong>';
}

// php max input vars
$transera_max_input_vars = ini_get('max_input_vars');
$transera_required_input_vars = $transera_server_requirements['server']['php_max_input_vars'];
if ( $transera_max_input_vars < $transera_required_input_vars ) {
	$transera_php_max_input_vars_description_text = '<span class="slz-error-message">'.esc_html__( 'The maximum number of variables your server can use for a single function to avoid overloads.', 'transera'  ). ' '.esc_html__( 'Please increase the maximum input variables limit to:','transera').' <strong>' . $transera_required_input_vars . '</strong>'.'. <a href="'.esc_url('http://docs.themefuse.com/the-core/your-theme/theme-settings/how-to-increase-the-maximum-input-variables-limit').'" target="_blank">'.esc_html__('Learn how to do it','transera').'</a></span>';
	$transera_php_max_input_vars_text = '<i class="slz-no-icon dashicons dashicons-info"></i><strong>'.$transera_max_input_vars.'</strong>';
} else {
	$transera_php_max_input_vars_description_text = esc_html__( 'The maximum number of variables your server can use for a single function to avoid overloads.', 'transera'  );
	$transera_php_max_input_vars_text = '<i class="slz-yes-icon dashicons dashicons-yes"></i><strong>'.$transera_max_input_vars.'</strong>';
}

// suhosin
if( extension_loaded( 'suhosin' ) ) {
	$transera_suhosin_text = '<i class="slz-no-icon dashicons dashicons-info"></i><strong>'.esc_html__('Yes', 'transera').'</strong>';
	$transera_suhosin_description_text = '<span class="slz-error-message">'. esc_html__( 'Suhosin is an advanced protection system for PHP installations and may need to be configured to increase its data submission limits', 'transera'  ).'</span>';
	$transera_max_input_vars      = ini_get( 'suhosin.post.max_vars' );
	$transera_required_input_vars = $transera_server_requirements['server']['suhosin_post_max_vars'];
	if ( $transera_max_input_vars < $transera_required_input_vars ) {
		$transera_suhosin_description_text .= '<span class="slz-error-message">' . sprintf( wp_kses(__( '%s - Recommended Value is: %s. <a href="%s" target="_blank">Increasing max input vars limit.</a>', 'transera' ), array( 'a' => array('href' => array()) ) ), $transera_max_input_vars, '<strong>' . ( $transera_required_input_vars ) . '</strong>', esc_url('http://docs.themefuse.com/the-core/your-theme/theme-settings/how-to-increase-the-maximum-input-variables-limit') ) . '</span>';
	}
}
else {
	$transera_suhosin_text = '<i class="slz-yes-icon dashicons dashicons-yes"></i><strong>'.esc_html__('No', 'transera').'</strong>';
	$transera_suhosin_description_text = esc_html__( 'Suhosin is an advanced protection system for PHP installations.', 'transera'  );
}

// mysql version
global $wpdb;
if( version_compare($wpdb->db_version(), $transera_server_requirements['server']['mysql_version'], '<=') ){
	$transera_mysql_version_text = '<i class="slz-no-icon dashicons dashicons-info"></i><strong>'.$wpdb->db_version().'</strong>';
	$transera_mysql_version_description_text = '<span class="slz-error-message">' . esc_html__( 'The version of MySQL installed on your hosting server.', 'transera'  ).' '. esc_html__( 'We recommend you update MySQL to the latest version. The minimum required version for this theme is:', 'transera' ) .' <strong>'.$transera_server_requirements['server']['mysql_version']. '</strong> '.esc_html__('Contact your hosting provider, they can install it for you.', 'transera').'</span>';
}
else{
	$transera_mysql_version_text = '<i class="slz-yes-icon dashicons dashicons-yes"></i><strong>'.$wpdb->db_version().'</strong>';
	$transera_mysql_version_description_text = esc_html__( 'The version of MySQL installed on your hosting server', 'transera'  );
}

// max upload size
$transera_requirements_max_upload_size = transera_return_memory_size($transera_server_requirements['server']['max_upload_size']);
if ( wp_max_upload_size() < $transera_requirements_max_upload_size ) {
	$transera_max_upload_size_text = '<i class="slz-no-icon dashicons dashicons-info"></i><strong>'.size_format(wp_max_upload_size()).'</strong>';
	$transera_max_upload_size_description_text = '<span class="slz-error-message">' . esc_html__( 'The largest file size that can be uploaded to your WordPress installation.', 'transera'  ). ' '.esc_html__( 'We recommend setting the maximum upload file size to at least:', 'transera' ) .' <strong>'.size_format($transera_requirements_max_upload_size). '</strong>. <a href="'.esc_url('http://docs.themefuse.com/the-core/your-theme/theme-settings/how-to-set-a-maximum-file-upload-size').'" target="_blank">'.esc_html__('Learn how to do it', 'transera').'</a></span>';
}
else{
	$transera_max_upload_size_text = '<i class="slz-yes-icon dashicons dashicons-yes"></i><strong>'.size_format(wp_max_upload_size()).'</strong>';
	$transera_max_upload_size_description_text = esc_attr__( 'The largest file size that can be uploaded to your WordPress installation', 'transera'  );
}

// fsockopen
if( function_exists( 'fsockopen' ) || function_exists( 'curl_init' ) ) {
	$transera_fsockopen_text = '<i class="slz-yes-icon dashicons dashicons-yes"></i><strong>'.esc_html__('Yes', 'transera').'</strong>';
	$transera_fsockopen_description_text = esc_html__( 'Payment gateways can use cURL to communicate with remote servers to authorize payments, other plugins may also use it when communicating with remote services', 'transera' );
}
else{
	$transera_fsockopen_text = '<i class="slz-no-icon dashicons dashicons-info"></i><strong>'.esc_html__('No', 'transera').'</strong>';
	$transera_fsockopen_description_text = '<span class="slz-error-message">'.wp_kses(__( 'Payment gateways can use cURL to communicate with remote servers to authorize payments, other plugins may also use it when communicating with remote services. Your server does not have <strong>fsockopen</strong> or <strong>cURL</strong> enabled thus PayPal IPN and other scripts which communicate with other servers will not work. Contact your hosting provider, they can install it for you.', 'transera' ), array( '<strong>' => array() )).'</span>';
}

$options = array(
	'requirements_tab' => array(
		'title'   => esc_html__( 'Requirements', 'transera' ),
		'type'    => 'tab',
		'options' => array(
			'wordpress-environment-box' => array(
				'title'   => esc_html__( 'WordPress Environment', 'transera' ),
				'type'    => 'box',
				'options' => array(
					'home_url' => array(
						'attr'  => array( 'class' => 'slz-theme-requirements-option', ),
						'label' => esc_html__( 'Home URL', 'transera' ),
						'desc'  => esc_html__( "The URL of your site's homepage", 'transera' ),
						'type'  => 'html',
						'html'  => '<i class="slz-yes-icon dashicons dashicons-yes"></i>'.'<strong>'.esc_url(home_url()).'</strong>',
					),
					'site_url' => array(
						'attr'  => array( 'class' => 'slz-theme-requirements-option', ),
						'label' => esc_html__( 'Site URL', 'transera' ),
						'desc'  => esc_html__( "The root URL of your site", 'transera' ),
						'type'  => 'html',
						'html'  => '<i class="slz-yes-icon dashicons dashicons-yes"></i>'.'<strong>'.esc_url(site_url()).'</strong>',
					),
					'wp_version' => array(
						'attr'  => array( 'class' => 'slz-theme-requirements-option', ),
						'label' => esc_html__( 'WP Version', 'transera' ),
						'desc'  => $transera_wp_version_description_text,
						'type'  => 'html',
						'html'  => $transera_wp_version_text,
					),
					'wp_multisite' => array(
						'attr'  => array( 'class' => 'slz-theme-requirements-option', ),
						'label' => esc_html__( 'WP Multisite', 'transera' ),
						'type'  => 'html',
						'desc'  => esc_html__( 'Whether or not you have WordPress Multisite enabled', 'transera' ),
						'html'  => $transera_multisite_text,
					),
					'wp_debug_mode' => array(
						'attr'  => array( 'class' => 'slz-theme-requirements-option', ),
						'label' => esc_html__( 'WP Debug Mode', 'transera' ),
						'type'  => 'html',
						'desc'  => $transera_wp_debug_mode_description_text,
						'html'  => $transera_wp_debug_mode_text,
					),
					'wp_memory_limit' => array(
						'attr'  => array( 'class' => 'slz-theme-requirements-option', ),
						'label' => esc_html__( 'WP Memory Limit', 'transera' ),
						'desc'  => $transera_wp_memory_limit_description_text,
						'type'  => 'html',
						'html'  => $transera_wp_memory_limit_text,
					),
				)
			),
			'server-environment-box' => array(
				'title'   => esc_html__( 'Server Environment', 'transera' ),
				'type'    => 'box',
				'options' => array(
					'server_info' => array(
						'attr'  => array( 'class' => 'slz-theme-requirements-option', ),
						'label' => esc_html__( 'Server Info', 'transera' ),
						'desc'  => esc_html__( "Information about the web server that is currently hosting your site", 'transera' ),
						'type'  => 'html',
						'html'  => '<i class="slz-yes-icon dashicons dashicons-yes"></i><strong>'.esc_html( $_SERVER['SERVER_SOFTWARE'] ).'</strong>',
					),
					'php_version' => array(
						'attr'  => array( 'class' => 'slz-theme-requirements-option', ),
						'label' => esc_html__( 'PHP Version', 'transera' ),
						'desc'  => $transera_php_version_description_text,
						'type'  => 'html',
						'html'  => $transera_php_version_text,
					),
					'php_post_max_size' => array(
						'attr'  => array( 'class' => 'slz-theme-requirements-option', ),
						'label' => esc_html__( 'PHP Post Max Size', 'transera' ),
						'desc'  => $transera_php_post_max_size_description_text,
						'type'  => 'html',
						'html'  => $transera_php_post_max_size_text,
					),
					'php_time_limit' => array(
						'attr'  => array( 'class' => 'slz-theme-requirements-option', ),
						'label' => esc_html__( 'PHP Time Limit', 'transera' ),
						'desc'  => $transera_php_time_limit_description_text,
						'type'  => 'html',
						'html'  => $transera_php_time_limit_text,
					),
					'php_max_input_vars' => array(
						'attr'  => array( 'class' => 'slz-theme-requirements-option', ),
						'label' => esc_html__( 'PHP Max Input Vars', 'transera' ),
						'desc'  => $transera_php_max_input_vars_description_text,
						'type'  => 'html',
						'html'  => $transera_php_max_input_vars_text,
					),
					'suhosin_installed' => array(
						'attr'  => array( 'class' => 'slz-theme-requirements-option', ),
						'label' => esc_html__( 'SUHOSIN Installed', 'transera' ),
						'desc'  => $transera_suhosin_description_text,
						'type'  => 'html',
						'html'  => $transera_suhosin_text,
					),
					'zip_archive' => array(
						'attr'  => array( 'class' => 'slz-theme-requirements-option', ),
						'label' => esc_html__( 'ZipArchive', 'transera' ),
						'desc'  => class_exists( 'ZipArchive' ) ? esc_html__('ZipArchive is required for importing demos. They are used to import and export zip files specifically for sliders', 'transera') : '<span class="slz-error-message">'.esc_html__('ZipArchive is required for importing demos. They are used to import and export zip files specifically for sliders.', 'transera').' '.esc_html__('Contact your hosting provider, they can install it for you.', 'transera').'</span>',
						'type'  => 'html',
						'html'  => class_exists( 'ZipArchive' ) ? '<i class="slz-yes-icon dashicons dashicons-yes"></i><strong>'.esc_html__('Yes', 'transera').'</strong>' : '<i class="slz-no-icon dashicons dashicons-info"></i><strong>'.esc_html__('No', 'transera').'</strong>',
					),
					'mysql_version' => array(
						'attr'  => array( 'class' => 'slz-theme-requirements-option', ),
						'label' => esc_html__( 'MySQL Version', 'transera' ),
						'desc'  => $transera_mysql_version_description_text,
						'type'  => 'html',
						'html'  => $transera_mysql_version_text,
					),
					'max_upload_size' => array(
						'attr'  => array( 'class' => 'slz-theme-requirements-option', ),
						'label' => esc_html__( 'Max Upload Size', 'transera' ),
						'desc'  => $transera_max_upload_size_description_text,
						'type'  => 'html',
						'html'  => $transera_max_upload_size_text,
					),
					'fsockopen' => array(
						'attr'  => array( 'class' => 'slz-theme-requirements-option', ),
						'label' => esc_html__( 'fsockopen/cURL', 'transera' ),
						'desc'  => $transera_fsockopen_description_text,
						'type'  => 'html',
						'html'  => $transera_fsockopen_text,
					),
					'legend' => array(
						'label' => false,
						'type'  => 'html',
						'html'  => '',
						'desc'  => '<i class="slz-yes-icon dashicons dashicons-yes"></i><span class="slz-success-message">'.esc_html__('Meets minimum requirements', 'transera').'</span><br><i class="slz-no-icon dashicons dashicons-info"></i><span class="slz-error-message">'.esc_html__("We have some improvements to suggest", 'transera').'</span>',
					),
				)
			),
		)
	),
);
