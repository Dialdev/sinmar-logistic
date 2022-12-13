<?php if ( ! defined( 'ABSPATH' ) ) {
    die( 'Direct access forbidden.' );
}

if ( defined( 'SLZ' ) ) {
    $transera_version = slz()->theme->manifest->get_version();
} else {
    $transera_version = '1.0';
}
/*--------------------functions-------------------------*/
if ( ! function_exists( 'transera_google_font_custom' ) ):
function transera_google_font_custom(){
	if ( defined( 'SLZ' ) && function_exists('slz_get_db_settings_option') ) {
		$font_google = $fonts = array();
		$settings = slz_get_db_settings_option();
		//google_font
		$arr_typo = (array)slz()->theme->get_config('typography_settings');
		foreach( $arr_typo as $option_key => $css_key ) {
			$custom_style = slz_akg($option_key .'/custom-style', $settings, '' );
			if( $custom_style == 'custom' && $custom = slz_akg($option_key .'/custom/typography', $settings, '' ) ) {
				if( !empty($custom['google_font']) ) {
					if( !empty($custom['family']) ) {
						if( !empty($custom['variation']) ) {
							$font_google[$custom['family']][$custom['variation']] = $custom['variation'];
						} else {
							$font_google[$custom['family']] = '';
						}
					}
				}
			}
		}
		foreach($font_google as $font=>$variant){
			$fonts[] = $font . ':' .implode(',', $variant);
		}
		if( $fonts ) {
			$font_url = transera_fonts_url( $fonts );
			wp_enqueue_style( 'transera-custom-fonts', $font_url, array(), null );
		}
	}
}
endif;

/*-------------------- enqueue-------------------------*/
//font
wp_enqueue_style( 'transera-fonts', transera_fonts_url(), array(), null );
transera_google_font_custom();
wp_enqueue_style( 'font-awesome.min', TRANSERA_STATIC_URI . '/font/font-icon/font-awesome/css/font-awesome.min.css', array(), false );

//libs css
wp_enqueue_style( 'bootstrap.min', TRANSERA_STATIC_URI . '/libs/bootstrap/css/bootstrap.min.css', array(), false );
wp_enqueue_style( 'bootstrap-datepicker.min', TRANSERA_STATIC_URI . '/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css', array(), false );

//theme css
wp_enqueue_style( 'transera-style', get_stylesheet_uri(), array(), $transera_version );
if ( ! transera_check_extension('headers') ) {
	wp_enqueue_style( 'transera-default', TRANSERA_STATIC_URI . '/css/default.css', array(), $transera_version );
}
transera_slz_enqueue_style();

wp_enqueue_style( 'transera-layout', TRANSERA_STATIC_URI . '/css/layout.css', array(), $transera_version );
wp_enqueue_style( 'transera-responsive', TRANSERA_STATIC_URI . '/css/responsive.css', array(), $transera_version );

if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
	wp_enqueue_script( 'comment-reply' );
}
// js
wp_enqueue_script( 'bootstrap.min', TRANSERA_STATIC_URI . '/libs/bootstrap/js/bootstrap.min.js', array( 'jquery' ), false, true );
wp_enqueue_script( 'bootstrap-datepicker.min', TRANSERA_STATIC_URI . '/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js', array( ), false, true );

wp_enqueue_script( 'transera-main', TRANSERA_STATIC_URI . '/js/main.js', array( ), $transera_version, true );
wp_enqueue_script( 'transera-custom', TRANSERA_STATIC_URI . '/js/custom.js', array( ), $transera_version, true );

if ( defined( 'SLZ' ) && function_exists('slz_get_db_settings_option')) {
	$transera_custom_script = '';
	$transera_custom_script = slz_get_db_settings_option('custom_scripts', '');
	if( !empty( $transera_custom_script ) ) {
		wp_enqueue_script( 'transera-custom-inline', TRANSERA_STATIC_URI . '/js/custom-inline.js', array( ), $transera_version, true );
		wp_add_inline_script( 'transera-custom-inline', $transera_custom_script );
	}
}

if( TRANSERA_WC_ACTIVE ) {
	wp_enqueue_style( 'transera-woocommerce',     TRANSERA_STATIC_URI . '/css/transera-woocommerce.css', array(), $transera_version );
	wp_enqueue_script( 'transera-woocommerce',    TRANSERA_STATIC_URI . '/js/transera-woocommerce.js', array(), $transera_version, true );
}