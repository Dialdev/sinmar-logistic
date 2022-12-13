<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


if ( ! function_exists( 'slz_get_footer_logo' ) ) :
	/**
	 * Display site logo
	 *
	 * @param string $class
	 */
	function slz_get_footer_logo( $class ) {

		$logo_key = apply_filters('slz_theme_logo_setting_key', 'logo');

		$logo_settings = slz_get_db_settings_option( $logo_key );

		$logo_alt = slz_get_db_settings_option( apply_filters('slz_theme_logo_alt_setting_key', 'logo-alt'), '' );

		$logo_title = slz_get_db_settings_option( apply_filters('slz_theme_logo_title_setting_key', 'logo-title'), '' );

		$url = slz_akg('url', $logo_settings, '' );

		$logo_html = '';

		if ( ! empty( $url ) ) {

			$logo_html = '<a href="' . esc_url( home_url( '/' ) ) . '" class="logo">
							<img src="' . esc_url($url) . '" alt="' . esc_attr( $logo_alt ) . '" title="' . esc_attr( $logo_title ) . '" class="slz-logo img-responsive" />
						</a>';
		}

		return '<div class="' . esc_attr($class) . '">' . $logo_html . '</div>';
	}
endif;

if ( ! function_exists( 'slz_theme_bottom_menu' ) ) :
	/**
	 * Display the nav menu
	 */
	function slz_theme_bottom_menu() {

		$location_name = apply_filters('slz_theme_bottom_menu_key', 'bottom-nav');

		$menu_args = array(
			'depth'           => 1,
			'container'       => 'ul',
			'menu_class'      => 'navbar-footer',
			'theme_location'  => $location_name,
		);

		if ( has_nav_menu ( $location_name ) )
			wp_nav_menu( $menu_args );

	}
endif;
