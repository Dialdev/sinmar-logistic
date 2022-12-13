<?php
function slz_autoload_core_css() {
	$ext = slz_ext('autoload');
	$cfg_enables = $ext->get_config('enable_extension_css');
	$version = $ext->manifest->get_version();
	wp_enqueue_style(
			'slz-extension-autoload-layout',
			$ext->locate_URI('/static/css/layout.css'),
			slz()->theme->manifest->get('theme_libs'),
			$version
	);
	
	wp_enqueue_style(
			'slz-extension-autoload-components',
			$ext->locate_URI('/static/css/components.css'),
			array(),
			$version
	);
	if( $ext->get_config('enable_breakingnews') ) {
		wp_enqueue_style(
			'slz-extension-autoload-breaking-news',
			$ext->locate_css_URI('/static/css/breaking-news.css'),
			array(), $version
		);
	}
	//
	foreach( $cfg_enables as $name ) {
		if( slz_ext($name) ) {
			$file = $ext->locate_URI('/static/css/'.$name.'.css');
			wp_enqueue_style(
					'slz-extension-autoload-' . $name,
					$file,
					array(),
					$version
			);
		}
	}
}
function slz_autoload_core_scripts() {
	$ext = slz_ext('autoload');
	$cfg_enables = $ext->get_config('enable_extension_js');
	$version = $ext->manifest->get_version();
	
	wp_enqueue_script(
		'slz-extension-autoload-main',
		$ext->locate_URI( '/static/js/main.js' ),
		array( 'jquery' ),
		$version,
		true
	);
	if( $ext->get_config('enable_breakingnews') ) {
		wp_enqueue_script(
			'slz-extension-autoload-breaking-news',
			$ext->locate_URI( '/static/js/breaking-news.js' ),
			array( 'jquery' ),
			$version,
			true
		);
	}
	if( $ext->get_config('enable_post_format_gallery') ) {
		wp_enqueue_script(
				'slz-extension-autoload-format-gallery',
				$ext->locate_URI( '/static/js/format-gallery.js' ),
				array( 'jquery' ),
				$version,
				true
		);
	}
	//
	foreach( $cfg_enables as $name ) {
		if( slz_ext($name) ) {
			$file = $ext->locate_URI( '/static/js/'.$name.'.js');
			wp_enqueue_script(
					'slz-extension-autoload-' . $name,
					$file,
					array( 'jquery' ),
					$version,
					true
			);
		}
	}
}
function slz_autoload_core_shortcodes_css(){
	$autoload = slz_ext('autoload');
	$cfg_enables = $autoload->get_config('enable_shortcodes_css');
	$ext = slz_ext('shortcodes');
	$active_shorcodes = $ext->get_shortcodes();
	$version = $ext->manifest->get_version();
	foreach($cfg_enables as $name ){
		$shortcode = str_replace('-', '_', $name);
		if( isset($active_shorcodes[$shortcode]) ) {
			wp_enqueue_style(
					'slz-extension-shortcodes-' . $name,
					$autoload->locate_URI('/static/css/shortcodes/'.$name.'.css'),
					array(),
					$version
			);
		}
	}
}
function slz_autoload_core_extra_css(){
	$ext = slz_ext('autoload');
	$cfg_enables = $ext->get_config('extra_css');
	$version = $ext->manifest->get_version();
	foreach($cfg_enables as $name ){
		$file = $ext->locate_URI('/static/css/'.$name.'.css');
		wp_enqueue_style(
				'slz-extension-autoload-' . $name,
				$file,
				array(),
				$version
		);
	}
}