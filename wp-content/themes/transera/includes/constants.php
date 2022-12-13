<?php
/**
 * Constants.
 * 
 * @package Transera
 * @since 1.0
 */
defined( 'TRANSERA_THEME_URI' )         || define( 'TRANSERA_THEME_URI', get_template_directory_uri() );
defined( 'TRANSERA_STATIC_URI' )         || define( 'TRANSERA_STATIC_URI', get_template_directory_uri() . '/static');

defined( 'TRANSERA_INCLUDE_DIR' )       || define( 'TRANSERA_INCLUDE_DIR', get_template_directory() . '/includes' );
defined( 'TRANSERA_FW_CUSTOMIZE_DIR' )  || define( 'TRANSERA_FW_CUSTOMIZE_DIR', get_template_directory() . '/framework-customizations' );
defined( 'TRANSERA_PLUGIN_DIR' )        || define( 'TRANSERA_PLUGIN_DIR', get_template_directory() . '/plugins' );

defined( 'TRANSERA_OPTION_IMG_URI' )    || define( 'TRANSERA_OPTION_IMG_URI', TRANSERA_THEME_URI . '/static/img/theme-option' );
defined( 'TRANSERA_PLUGIN_IMG_URI' )    || define( 'TRANSERA_PLUGIN_IMG_URI', TRANSERA_THEME_URI . '/static/img/tgm-images' );
defined( 'TRANSERA_LOGO_IMG_URI' )    || define( 'TRANSERA_LOGO_IMG_URI', TRANSERA_THEME_URI . '/static/img/logo' );
defined( 'TRANSERA_IMG_URI' )           || define( 'TRANSERA_IMG_URI', TRANSERA_THEME_URI . '/static/img' );

//Active Woocommerce Plugin
defined( 'TRANSERA_WC_ACTIVE' )     || define( 'TRANSERA_WC_ACTIVE', class_exists( 'WooCommerce' ) );

if ( defined( 'YITH_WCWL' ) ) {
	define( 'TRANSERA_WC_WISHLIST', defined( 'YITH_WCWL' ) );
}
else {
	define( 'TRANSERA_WC_WISHLIST', '' );
}