<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! function_exists( 'slz_get_socials' ) ) :
	/**
	 * Display socials buttons
	 *
	 * @param string $class
	 */
	function slz_get_socials( $class ) {

		$social_key = apply_filters('slz_theme_social_setting_key', 'socials');

		$socials = slz_get_db_settings_option( $social_key );

		if ( ! empty( $socials ) ) {
			$arr = array();
			$socials_html = '';
			// parse all socials
			foreach ( $socials as $social ) {
				$icon = '';
				if ( $social['social_type']['social-type'] == 'icon-social' ) {
					// get icon class
					if ( ! empty( $social['social_type']['icon-social']['icon_class'] ) ) {
						$icon .= '<i class="icons ' . $social['social_type']['icon-social']['icon_class'] . '"></i>';
					}
				} else {
					// get uploaded icon
					if ( ! empty( $social['social_type']['upload-icon']['upload-social-icon'] ) ) {
						$icon .= '<img src="' . $social['social_type']['upload-icon']['upload-social-icon']['url'] . '" alt="" />';
					}
				}

				// get social link
				$link = esc_url($social['social-link']);
				$item = '';
				if( strchr( $social['social_type']['icon-social']['icon_class'] , 'fa fa-') ) {
					$arr = array();
					$item = str_replace( 'fa fa-', '',$social['social_type']['icon-social']['icon_class'] );

					$arr = explode('-', $item);
					$item = $arr[0];
					
				}
				$socials_html .= '<a class="link share-'. $item .'" target="_blank" href="' . $link . '">' . $icon . '</a>';
			}

			// return socials html
			return '<div class="' . esc_attr($class) . '">' . $socials_html . '</div>';
		}
	}
endif;

if ( ! function_exists( 'slz_get_customize_icon' ) ) :
	/**
	 * Display icons buttons
	 *
	 * @param string $class
	 */
	function slz_get_customize_icon( $class, $settings=array() ) {

		$icon_key = apply_filters('slz_theme_customize_icon_setting_key', 'customize-icon');

		$position_key = apply_filters('slz_theme_position_setting_key', 'customize-icon');

		$icons = slz_get_db_settings_option( $icon_key );

		if ( ! empty( $icons ) ) {
			$icons_html = '';
			// parse all icons
			foreach ( $icons as $icon ) {
				$icon_data = '';

				switch ( $settings['icon-display'] ) {
					case 'icon':
						if ( $icon['icon_type']['icon-type'] == 'icon' ) {
							// get icon class
							if ( ! empty( $icon['icon_type']['icon']['icon_class'] ) ) {
								$icon_data .= '<i class="' . $icon['icon_type']['icon']['icon_class'] . '"></i>';
							}
						} else {
							// get uploaded icon
							if ( ! empty( $icon['icon_type']['upload-icon']['upload-icon'] ) ) {
								$icon_data .= '<img src="' . $icon['icon_type']['upload-icon']['upload-icon']['url'] . '" alt="" />';
							}
						}
						break;
					case 'text':

						$icon_data .= ( !empty ( $icon['icon_name'] ) ? $icon['icon_name'] : '' );
						break;

					case 'both':

						if ( $icon['icon_type']['icon-type'] == 'icon' ) {
							// get icon class
							if ( ! empty( $icon['icon_type']['icon']['icon_class'] ) ) {
								$icon_data .= '<i class="' . $icon['icon_type']['icon']['icon_class'] . '"></i>';
							}
						} else {
							// get uploaded icon
							if ( ! empty( $icon['icon_type']['upload-icon']['upload-icon'] ) ) {
								$icon_data .= '<img src="' . $icon['icon_type']['upload-icon']['upload-icon']['url'] . '" alt="" />';
							}
						}

						if ( slz_akg('both/text-position', $settings, '') == 'left' )

							$icon_data = ( !empty ( $icon['icon_name'] ) ? $icon['icon_name'] : '' ) . ' ' .$icon_data;

						else

							$icon_data = $icon_data . ' ' .( !empty ( $icon['icon_name'] ) ? $icon['icon_name'] : '' );

						break;
					default:
						break;
				}

				// get icon link
				$link = esc_url($icon['icon-link']);
				if( !empty($link)) {
					$icons_html .= '<a class="text" target="_blank" href="' . $link . '">' . $icon_data . '</a>';
				} else {
					$icons_html .= '<span class="text" >' . $icon_data . '</span>';
				}
			}

			// return icons html
			return '<div class="customize-icon ' . esc_attr($class) . '">' . $icons_html . '</div>';
		}
	}
endif;


if ( ! function_exists( 'slz_display_topbar_content' ) ) :
	/**
	 * Display socials buttons
	 *
	 * @param string $class
	 */
	function slz_display_topbar_content( $class, $data, $settings=array() ) {

	
		$result = '';

		foreach ($data as $option) {
				
			switch ( $option ) {

				case 'menu':

					$result .= slz_theme_nav_menu( 'top-nav' );

					break;

				case 'social':

					$result .= slz_get_socials( $class );
					break;

				case 'icon':
					$result .= slz_get_customize_icon( $class, $settings['customize-icon'] );
					break;

				case 'button':
					$result .= slz_get_button($settings['button']);
					break;

				default:
					break;
			}

		}

		return $result;
	}
endif;


if ( ! function_exists( 'slz_get_button' ) ) :
	/**
	 * Display button on top bar
	 *
	 * @param string $settings
	 */
	function slz_get_button($settings=array()) {
		$custom_css = '';
	
		if ( !empty ( $settings['bg-color'] ) ){
			$custom_css .= '.slz-header-topbar .slz-btn{ 
				background-color: ' . esc_attr( $settings['bg-color'] ) . ' ;
			}';
		}
		if ( !empty ( $settings['bg-hv-color'] ) ){
			$custom_css .= '.slz-header-topbar .slz-btn:hover{ 
				background-color: ' . esc_attr( $settings['bg-hv-color'] ) . ' ;
			}';
		}
		if ( !empty ( $settings['text-color'] ) ){
			$custom_css .= '.slz-header-topbar .slz-btn{ 
				color: ' . esc_attr( $settings['text-color'] ) . ' ;
			}';
		}
		if ( !empty ( $settings['text-hv-color'] ) ){
			$custom_css .= '.slz-header-topbar .slz-btn:hover{ 
				color: ' . esc_attr( $settings['text-hv-color'] ) . ' ;
			}';
		}
		if ( !empty ( $settings['bd-color'] ) ){
			$custom_css .= '.slz-header-topbar .slz-btn{ 
				border-color: ' . esc_attr( $settings['bd-color'] ) . ' ;
			}';
		}
		if ( !empty ( $settings['bd-hv-color'] ) ){
			$custom_css .= '.slz-header-topbar .slz-btn:hover{ 
				border-color: ' . esc_attr( $settings['bd-hv-color'] ) . ' ;
			}';
		}
		do_action('slz_add_inline_style', $custom_css);

		if ( ! empty( $settings['btn-text'] ) ) {
			return '<a href="'.esc_url($settings['btn-link']).'" class="slz-btn"><span class="btn-text">'.esc_attr($settings['btn-text']).'</span></a>';
		}

	}
endif;

if ( ! function_exists( 'slz_get_socials' ) ) :
	/**
	 * Display socials buttons
	 *
	 * @param string $class
	 */
	function slz_get_socials( $class ) {

		$social_key = apply_filters('slz_theme_social_setting_key', 'socials');

		$socials = slz_get_db_settings_option( $social_key );

		if ( ! empty( $socials ) ) {
			$socials_html = '';
			// parse all socials
			foreach ( $socials as $social ) {
				$icon = '';
				if ( $social['social_type']['social-type'] == 'icon-social' ) {
					// get icon class
					if ( ! empty( $social['social_type']['icon-social']['icon_class'] ) ) {
						$icon .= '<i class="' . $social['social_type']['icon-social']['icon_class'] . '"></i>';
					}
				} else {
					// get uploaded icon
					if ( ! empty( $social['social_type']['upload-icon']['upload-social-icon'] ) ) {
						$icon .= '<img src="' . $social['social_type']['upload-icon']['upload-social-icon']['url'] . '" alt="" />';
					}
				}

				// get social link
				$link = esc_url($social['social-link']);

				$socials_html .= '<a target="_blank" href="' . $link . '">' . $icon . '</a>';
			}

			// return socials html
			return '<div class="' . esc_attr($class) . '">' . $socials_html . '</div>';
		}
	}
endif;


if ( ! function_exists( 'slz_get_logo' ) ) :
	/**
	 * Display site logo
	 *
	 * @param string $class
	 */
	function slz_get_logo( $class, $transparent = false ) {

		$logo_key = apply_filters('slz_theme_logo_setting_key', 'logo');

		$logo_settings = slz_get_db_settings_option( $logo_key );
		
		$logo_alt = slz_get_db_settings_option( apply_filters('slz_theme_logo_alt_setting_key', 'logo-alt'), '' );

		$logo_text = slz_get_db_settings_option( apply_filters('slz_theme_logo_alt_setting_key', 'logo-text'), '' );

		$logo_title = slz_get_db_settings_option( apply_filters('slz_theme_logo_title_setting_key', 'logo-title'), '' );

		$logo_page = slz_get_db_post_option( get_the_ID() , 'page-logo', '' );

		if(!empty($logo_page)){
			$url = slz_akg('url', $logo_page, '' );
		}else{
			$url = slz_akg('url', $logo_settings, '' );
		}

		$logo_html = '';

		if ( ! empty( $url ) ) {

			$logo_html = '<a href="' . esc_url( home_url( '/' ) ) . '" class="logo">';
				if( $transparent ) {
					$logo_transparent_key = apply_filters('slz_theme_logo_setting_key', 'logo-transparent');
					$logo_transparent_settings = slz_get_db_settings_option( $logo_transparent_key );
					$logo_page_transparent = slz_get_db_post_option( get_the_ID() , 'page-logo-transparent', '' );
					
					if( isset( $logo_page_transparent['logo_transparent_options'] ) && $logo_page_transparent['logo_transparent_options'] == 'enable' ) {
						if( !empty( $logo_page_transparent['enable']['logo-transparent']['attachment_id'] ) ) {
							$logo_html .= wp_get_attachment_image( $logo_page_transparent['enable']['logo-transparent']['attachment_id'], 'full', false, array( 'class' => 'img-responsive logo-header-transparent' ) );
						}
					}elseif( isset( $logo_transparent_settings['logo_transparent_options'] ) && $logo_transparent_settings['logo_transparent_options'] == 'enable' ){
						if( !empty( $logo_transparent_settings['enable']['logo-transparent']['url'] ) ) {
							$logo_html .= '<img src="' . esc_url( $logo_transparent_settings['enable']['logo-transparent']['url'] ) . '" alt="' . esc_attr( $logo_alt ) . '" title="' . esc_attr( $logo_title ) . '" class="img-responsive logo-header-transparent" />';
						}
					}
				}
				$logo_html .= '<img src="' . esc_url($url) . '" alt="' . esc_attr( $logo_alt ) . '" title="' . esc_attr( $logo_title ) . '" class="img-responsive" />';
			$logo_html .= '</a>';
		}else{
			$logo_html = '<a href="' . esc_url( home_url( '/' ) ) . '" class="logo">'.esc_html($logo_text).'</a>';
		}

		return '<div class="' . esc_attr($class) . '">' . $logo_html . '</div>';
	}
endif;

if ( ! function_exists( 'slz_get_header_transparent' ) ) :
	/**
	 * Header Transparent
	 *
	 * @param string $header
	 */
	function slz_get_header_transparent( $header ) {

		$out_put = array();
		$trans_page =  slz_get_db_post_option( get_the_ID() ,'page-header-transparent', '' );
		$trans_options = slz_get_db_settings_option('slz-header-style-group/'.$header, array() );

		$transparent = false;
		$header_class = '';

		if(!empty($trans_page)){
			if( $trans_page == 'header-transparent' ){
				$header_class = $trans_page;
				$transparent = true;
			}

		}else{
			if($trans_options['header-transparent'] == 'header-transparent'){
				$header_class = $trans_options['header-transparent'];
				$transparent = true;
			}
		};
		SLZ_Live_Setting::get_header_transparent($header_class, $transparent);
		
		$out_put = array($header_class,$transparent);
		return $out_put;
	}
endif;

global $slz_menus;
$slz_menus = array(
	'top-nav'   => array(
		'echo'			  => false,
		'depth'           => 1,
		'container'       => 'ul',
		'menu_class'      => 'navbar-topbar',
		'theme_location'  => apply_filters('slz_theme_top_menu_key', 'top-nav'),
	),
	'main-nav' => array(
		'depth'           => 4,
		'container'       => 'ul',
		'menu_class'      => 'nav navbar-nav slz-menu-wrapper',
		'theme_location'  => apply_filters('slz_theme_main_menu_key', 'main-nav'),
		'link_before'     => '<span>',
		'link_after'      => '</span>',
		'after'           => '<span class="icon-dropdown-mobile fa fa-angle-down"></span>',
	),
	'left-nav' => array(
		'depth'           => 4,
		'container'       => 'ul',
		'menu_class'      => 'nav navbar-nav slz-menu-wrapper',
		'theme_location'  => apply_filters('slz_theme_left_menu_key', 'left-nav'),
		'link_before'     => '<span>',
		'link_after'      => '</span>',
		'after'           => '<span class="icon-dropdown-mobile fa fa-angle-down"></span>',
	),
	'right-nav' => array(
		'depth'           => 4,
		'container'       => 'ul',
		'menu_class'      => 'nav navbar-nav slz-menu-wrapper',
		'theme_location'  => apply_filters('slz_theme_right_menu_key', 'right-nav'),
		'link_before'     => '<span>',
		'link_after'      => '</span>',
		'after'           => '<span class="icon-dropdown-mobile fa fa-angle-down"></span>',
	),
	'sub-nav' => array(
		'depth'           => 4,
		'container'       => 'ul',
		'menu_class'      => 'nav navbar-nav slz-menu-wrapper',
		'theme_location'  => apply_filters('slz_theme_sub_menu_key', 'sub-nav'),
		'link_before'     => '<span>',
		'link_after'      => '</span>'
	),
	'feature-nav' => array(
		'depth'           => 4,
		'container'       => 'ul',
		'menu_class'      => 'nav navbar-nav slz-menu-wrapper feature-nav',
		'theme_location'  => apply_filters('slz_theme_sub_menu_key', 'feature-nav'),
		'link_before'     => '<span>',
		'link_after'      => '</span>'
	),
);


if ( ! function_exists( 'slz_theme_nav_menu' ) ) :
	/**
	 * Display the nav menu
	 */
	function slz_theme_nav_menu( $menu_type ) {
		global $slz_menus;
		$page_options = slz_get_db_post_option( get_the_ID() ,'page-main-menu');
		if( isset($page_options['options']) && $page_options['options'] == 'custom' 
				&& isset($page_options['custom']['main-menu']) && $page_menu = $page_options['custom']['main-menu'] ){
			$page_nav = $slz_menus['main-nav'];
			$page_nav['menu'] = $page_menu;
			wp_nav_menu( $page_nav);
		} else {
			if ( ! isset( $slz_menus[ $menu_type ] ) ) {
				return;
			}
			if ( has_nav_menu ( $menu_type ) ) {
				if ( isset ( $slz_menus[ $menu_type ]['echo'] ) && $slz_menus[ $menu_type ]['echo'] == false){
					return wp_nav_menu( $slz_menus[ $menu_type ] );
				}else {
					wp_nav_menu( $slz_menus[ $menu_type ] );
				}
			}
		}
	}
endif;

if ( ! function_exists( 'slz_theme_render_recurring' ) ) :
    function slz_theme_render_recurring( ) {
        $out = '<div class="gdlr-recurring-payment-wrapper">
				<span class="gdlr-subhead">'.esc_html__('I would like to make','slz').'</span>
				<select name="t3" class="gdlr-recurring-option">
					<option value="0">'.esc_html__('a one time', 'slz').'</option>
					<option value="W">'.esc_html__('weekly', 'slz').'</option>
					<option value="M">'.esc_html__('monthly', 'slz').'</option>
					<option value="Y">'.esc_html__('yearly', 'slz').'</option>
				</select>
				<span class="gdlr-subhead">'.esc_html__('donation(s)', 'slz').'</span>
				
				<div class="gdlr-recurring-time-wrapper" style="display: none;">
					<span class="gdlr-subhead">'.esc_html__('How many times would you like this to recur? (including this payment)', 'slz').'</span>
					<select name="p3" class="gdlr-recurring-option">
					</select>
				</div>
			</div>';
            return $out;
    }
endif;
if ( ! function_exists( 'slz_theme_render_price_payppal' ) ) :
    function slz_theme_render_price_payppal($name, $limit) {
        $data_price_paypal = (array)slz()->theme->get_config('price_paypal');
        $format_item = '<div class="donate-item">
                                    <input type="radio" name="%1$s" value="%2$s"/>
                                    <span class="label-check slz-btn">%3$s</span>
                                </div>';

        $format_price_paypal = '<div class="radio">
                                    %1$s
                                    <div class="donate-item">
                                        <input type="radio" class="donation-other-price" name="%2$s"/>
                                        <div class="label-check another-donation">
                                            <span class="currencies">' . slz_get_db_settings_option('currency-money-format', '$') . '</span>
                                            <input class="form-control" type="text" maxlength="12" name="anotherAmount" placeholder="Or Your Amount(USD)"/>
                                        </div>
                                    </div>
                                </div>';
        $html_item = '';
        foreach ($data_price_paypal as $index=>$value) {
            $html_item .= sprintf($format_item, $name, $value, slz_get_currency_format_options($value));
            if ($index == $limit-1) {
                break;
            }
        }
        return sprintf($format_price_paypal, $html_item, $name);
    }
endif;
if ( ! function_exists( 'slz_theme_render_donation_paypal' ) ) :
    function slz_theme_render_donation_paypal($business, $button_text, &$out=array() ) {
        $model_view = 'donate-modal-donation-orther';
        $headers = slz_ext( 'headers' );
        $donation_text = $button_text;
        $link_form = 'https://www.paypal.com/cgi-bin/webscr';

        $out['button'] = '<input type="button" data-toggle="modal" data-target=".' . esc_attr($model_view) . '" class="slz-btn btn-block-donate" value="' . esc_html( $donation_text ) . '"/>';
        $out['model']= '
                <div  tabindex="-1" role="dialog" class="modal fade '.esc_attr($model_view).'">
                    <div role="document" class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title">' . esc_html__('Donation', 'slz') . '</h4>
                            </div>
                            <div class="slz-donate-submit slz-form-donate">
                                <div class="modal-body">
                                    <form action="'.esc_url($link_form).'" method="post">
                                        <div class="form-group" style="color: black">
	                                        <span class="gdlr-head">'.esc_html__('How much would you like to donate?', 'slz').'</span>
	                                        '.slz_theme_render_price_payppal('amount', 4).'
	                                         <span class="gdlr-head">'.esc_html__('Would you like to make regular donations?', 'slz').'</span>
	                                         '.slz_theme_render_recurring().'   
	                                          <input type="hidden" name="cmd" value="_donations">
	                                         <input type="hidden" name="business" value="'.esc_attr($business).'">
	                                          
	                                          <input type="hidden" name="item_name">
	                                          <input type="hidden" name="item_number">
	                                         <div class="row">                                                                    
	                                          <div class="donation-item donation-firstname"> 
	                                              <span class="slz-required">'.esc_html__('First name', 'slz').'</span>
	                                              <input type="text" name="first_name" placeholder="Ex: Join">
	                                         </div>
	                                          <div class="donation-item donation-lastname"> 
	                                              <span class="slz-required">'.esc_html__('Last name', 'slz').'</span>
	                                              <input type="text" name="last_name" placeholder="Ex: Doe">
	                                         </div>
	                                          
	                                          <input type="hidden" name="address2">
	                                          <input type="hidden" name="city">
	                                          <input type="hidden" name="state">
	                                          <input type="hidden" name="zip">
	                                          
	                                          <div class="donation-item"> 
	                                              <span>'.esc_html__('Number phone', 'slz').'</span>
	                                              <input type="text" name="night_phone_a" placeholder="Ex: 03 2685987">
	                                         </div>
	                                          <input type="hidden" name="night_phone_b" value="">
	                    
	                                          <input type="hidden" name="night_phone_c" value="">
	                                          <div class="donation-item"> 
	                                              <span class="slz-required"> '.esc_html__('Email', 'slz').'</span>
	                                              <input type="text" name="email" placeholder="Ex: jdoe@zyzzyu.com">
	                                         </div>
	                                         <div class="donation-item"> 
	                                              <span>'.esc_html__('Address', 'slz').'</span>
	                                              <textarea name="address1" placeholder="Ex: 9 Elm Street"></textarea>
	                                         </div>
	                                         <div class="donation-item"> 
	                                              <span>'.esc_html__('Additional Note', 'slz').'</span>
	                                              <textarea name="item_name" placeholder="Ex: Get Volunteer Idea Festival 2017"></textarea>
	                                         </div>
	                                         </div>
                                    	</div>
                                        <button name="submit" class="slz-btn btn-block-donate">'.esc_html( $donation_text ).'</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    ';
    }
endif;
if ( ! function_exists( 'slz_theme_render_donation_orther' ) ) :
    function slz_theme_render_donation_orther($id, $option_type_donation, $button_text, &$out= array()) {
        $headers = slz_ext( 'headers' );
        $donation_text = $button_text;
        $model_view = 'donate-modal-donation-orther';
        $class_post = 'slz_'.$option_type_donation.'_post_id';
        $out['button'] = '<input type="button" data-toggle="modal" data-target=".'.esc_attr($model_view).'" class="slz-btn btn-block-donate" value="'. esc_html( $donation_text ).'"/>';
        $out['model']  = '
            <div tabindex="-1" role="dialog" class="modal fade '.esc_attr($model_view).'">
                <div role="document" class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title">'. esc_html__( 'Donation', 'slz' ) .'</h4>
                        </div>
                        <div class="slz-donate-submit slz-form-donate">
                            <div class="modal-body">
                                <div class="form-group">
                                    <span class="gdlr-head">How much would you like to donate?</span>
                                    <div class="donation-button-segment-group slz-form-donate">
                                        '.slz_theme_render_price_payppal('valueDonation', 4).'
                                        <input type="text" name="'.esc_attr($class_post).'" value="'. esc_attr( $id ) .'" class="'.esc_attr($class_post).'" hidden />
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="slz-btn btn-block-donate slz_money_donate_btn">'. esc_html( $donation_text ) .'</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        ';
    }
endif;
if ( ! function_exists( 'slz_theme_render_donation_button_topbar' ) ) :
    function slz_theme_render_donation_button_topbar($options) {
        $out = array(
            'button' => '',
            'model'  => ''
        );

        $is_btn_donation = slz_akg('enable-header-top-bar/yes/btn-donation/btn_donation_options', $options, '' );
        if ($is_btn_donation == 'yes') {
            $payment_option = slz_akg('enable-header-top-bar/yes/btn-donation/yes/option', $options, '' );
            $option_type_donation = $payment_option['choice_option'];
            $button_text = slz_akg('enable-header-top-bar/yes/btn-donation/yes/button-text', $options);

            if ( empty($button_text) ) {
                $headers = slz_ext('headers');
                $button_text = $headers->get_config('text_btn_donation');
            }

            if (isset($payment_option) && isset($payment_option['choice_option']) && $option_type_donation != 'paypal') {
                $orther = $payment_option[$payment_option['choice_option']];
                $choice_option = $orther['option']['choice_option'];
                if( !is_plugin_active( 'woocommerce/woocommerce.php' ) || $choice_option == 'customlink' ){
                    $url = $orther['option']['customlink']['link'];
                    $out['button'] = '<a href="'. ( empty( $url ) ? 'javascript:void(0)' : esc_url( $url ) ).'" class="slz-btn btn-block-donate">'. esc_html__( 'Donate now', 'slz' ) .'</a>';
                } else {
                    slz_theme_render_donation_orther($orther['id'], $option_type_donation, $button_text, $out);
                }
            }

            if (isset($payment_option) && isset($payment_option['choice_option']) && $option_type_donation == 'paypal') {
                $paypal = $payment_option['paypal'];

                if (!is_plugin_active('woocommerce/woocommerce.php') || $paypal['option']['choice_option'] == 'customlink') {
                    $url = $paypal['option']['customlink']['link'];
                    $out['button'] = '<a href="' . (empty($url) ? 'javascript:void(0)' : esc_url($url)) . '" class="slz-btn btn-block-donate">' . esc_html__('Donate now', 'slz') . '</a>';
                } else {
                    $business = '';

                    if ( isset($paypal['option']['paypal']['business']) ) {
                        $business = $paypal['option']['paypal']['business'];
                    }

                    slz_theme_render_donation_paypal($business, $button_text, $out);
                }
            }

            $custom_css = '.slz-header-topbar{z-index:inherit}';
            do_action('slz_add_inline_style', $custom_css);

            return $out;
        }
    }
endif;

if ( ! function_exists( 'slz_get_option_donation_paypal' ) ) :
    function slz_get_option_donation_paypal() {
        $headers = slz_ext( 'headers' );

        $is_show_btn_donation = $headers->get_config('show_btn_donation');
        if (empty($is_show_btn_donation)) {
            $is_show_btn_donation = false;
        }

        if (!$is_show_btn_donation) {
            return array();
        }

        $is_active_events = slz_ext('events');
        $is_active_causes = slz_ext('donation');
        $events_option = array();
        $causes_option = array();

        $option_type_button = array(
            'paypal' => esc_html__( 'Donation For Organizations', 'slz' )
        );

        $option_post = array(
            'type'   => 'multi-picker',
            'label'  => false,
            'desc'   => false,
            'picker' => array(
                'choice_option' => array(
                    'type'  => 'select',
                    'value' => 'woocommerce',
                    'label' => esc_html__('Payment', 'slz'),
                    'choices' => array(
                        'woocommerce' => esc_html__('WooCommerce', 'slz'),
                        'customlink'  => esc_html__('Custom link', 'slz')
                    ),
                    'no-validate' => false,
                )
            ),
            'choices' => array(
                'customlink' => array(
                    'link' => array(
                        'type'  => 'text',
                        'label' => esc_html__('Link', 'slz'),
                    )
                ),
            )
        );

        if ( isset($is_active_events) ) {
            $chose_option_events = SLZ_Com::get_post_id2title(array('post_type' => 'slz-event'), '', false);
            $option_type_button['events'] = esc_html__( 'Events', 'slz' );
            if (!is_array($chose_option_events)) {
                $chose_option_events = array();
            }
            $events_option = array(
                'id' => array(
                    'type'  => 'select',
                    'value' => 'woocommerce',
                    'label' => esc_html__('Events', 'slz'),
                    'choices' => $chose_option_events,
                    'no-validate' => false,
                ),
                'option' =>	$option_post
            );
        }

        if ( isset($is_active_causes) ) {
            $chose_option_causes = SLZ_Com::get_post_id2title(array('post_type' => 'slz-causes'), '', false);
            $option_type_button['causes'] = esc_html__( 'Causes', 'slz' );
            if (!is_array($chose_option_causes)) {
                $chose_option_causes = array();
            }
            $causes_option = array(
                'id' => array(
                    'type'  => 'select',
                    'value' => 'woocommerce',
                    'label' => esc_html__('Causes', 'slz'),
                    'choices' => $chose_option_causes,
                    'no-validate' => false,
                ),
                'option' =>	$option_post
            );
        }

        $paypal_option = array(
            'option' =>	array(
                'type'   => 'multi-picker',
                'label'  => false,
                'desc'   => false,
                'picker' => array(
                    'choice_option' => array(
                        'type'  => 'select',
                        'value' => 'paypal',
                        'label' => esc_html__('Payment', 'slz'),
                        'choices' => array(
                            'paypal' => esc_html__('Paypal', 'slz'),
                            'customlink'  => esc_html__('Custom link', 'slz')
                        ),
                        'no-validate' => false,
                    )
                ),
                'choices' => array(
                    'paypal' => array(
                        'business' => array(
                            'type'  => 'text',
                            'label' => esc_html__('Email Receiver', 'slz'),
                        )
                    ),
                    'customlink' => array(
                        'link' => array(
                            'type'  => 'text',
                            'label' => esc_html__('Link', 'slz'),
                        )
                    ),
                )
            )
        );

        return array(
            'btn-donation'   => array(
                'type'   => 'multi-picker',
                'label'  => false,
                'desc'   => false,
                'picker' => array(
                    'btn_donation_options' => array(
                        'type'  => 'switch',
                        'value' => 'disable',
                        'label' => esc_html__( 'Button Donation', 'slz' ),
                        'right-choice' => array(
                            'value' => 'yes',
                            'label' => esc_html__( 'Yes', 'slz' ),
                        ),
                        'left-choice' => array(
                            'value' => 'no',
                            'label' => esc_html__( 'No', 'slz' ),
                        ),
                        'desc'      => esc_html__( 'Show button donation in top bar right menu', 'slz' ),
                    ),
                ),
                'choices' => array(
                    'yes' => array(
                        'button-text' => array(
                            'type'  => 'text',
                            'label' => esc_html__('Button Text', 'slz'),
                        ),
                        'option'	=>	array(
                            'type'   => 'multi-picker',
                            'label'  => false,
                            'desc'   => false,
                            'picker' => array(
                                'choice_option' => array(
                                    'type'  => 'select',
                                    'value' => 'causes',
                                    'label' => esc_html__( 'Donation Type', 'slz' ),
                                    'choices' => $option_type_button
                                )
                            ),
                            'choices' => array(
                                'paypal' => $paypal_option,
                                'causes' => $causes_option,
                                'events' => $events_option
                            )
                        ),
                    ),
                ),
            )
        );
    }
endif;

if ( ! function_exists( 'slz_get_option_event_top_bar' ) ) :
    function slz_get_option_event_top_bar() {

        $headers = slz_ext( 'headers' );

        $is_show_banner_event_topbar = $headers->get_config('show_banner_event');
        if (empty($is_show_banner_event_topbar)) {
            $is_show_banner_event_topbar = false;
        }

        if (!$is_show_banner_event_topbar) {
            return array();
        }

        $chose_option_events = SLZ_Com::get_post_id2title(array('post_type' => 'slz-event'), '', false);

        if (!is_array($chose_option_events)) {
            $chose_option_events = array();
        }

        $events_option = array(
            'type'  => 'select',
            'value' => '',
            'label' => esc_html__('Event', 'slz'),
            'choices' => $chose_option_events,
            'no-validate' => false,
        );

        return array(
            'event-type'   => array(
                'type'   => 'multi-picker',
                'label'  => false,
                'desc'   => false,
                'picker' => array(
                    'choice_option' => array(
                        'type'  => 'radio',
                        'value' => 'recent',
                        'label' => esc_html__('Event Banner', 'slz'),
                        'desc'  => esc_html__('Type of event show in banner', 'slz'),
                        'choices' => array(
                            'recent'  => esc_html__('Recent Event', 'slz'),
                            'event'   => esc_html__('Event', 'slz'),
                        ),
                    )
                ),
                'choices' => array(
                    'event' => array(
                        'event-banner' => $events_option
                    ),
                )
            ),
        );
    }
endif;

if ( !function_exists('slz_theme_render_banner_event_topbar') ) {
    function slz_theme_render_banner_event_topbar($options) {
        $out = '';
        $enable_topbar = slz_akg('enable-header-top-bar/selected-value', $options, '');
        if ($enable_topbar == 'yes') {
            $option_event_type = slz_akg('enable-header-top-bar/yes/event-type/choice_option', $options,'');
            $atts = array(
                'btn_more_format' => '<a href="%2$s" class="slz-btn readmore">%1$s</a>'
            );
            $query_args = array();

            if ( $option_event_type ) {
                if ( $option_event_type == 'recent' ) {
                    $atts['limit_post'] = 1;
                    $query_args = array(
                        'post_type' => 'slz-event',
                        'meta_key' => 'slz_option:from_date',
                        'orderby'   => 'meta_value',
                        'order' => 'ASC',
                        'post_status' => 'publish',
                        'meta_query' => array(
                            array(
                                'key' => 'slz_option:from_date',
                                'value' => date( "Y/m/d" ),
                                'compare' => '>'
                            )
                        )
                    );
                } else {
                    $id = slz_akg('enable-header-top-bar/yes/event-type/event/event-banner', $options,'');
                    $atts['post_id'] = array($id);
                }
                $model = new SLZ_Event();
                $model->init($atts, $query_args);

                while ( $model->query->have_posts()) {
                    $model->query->the_post();
                    $model->loop_index();
                    $btn_readmore_html = $model->get_btn_more($atts);
                    $html_options = array(
                        'banner_format' => '<div class="slz-comming-event">
                            <div class="item title">
                                <span class="text">'.esc_html__('Upcoming event', 'slz').'</span>
                            </div>
                            <div class="item countdown">
                                <div class="coming-soon single-page-comming-soon count-down" data-unique-id="%1$s" data-expire="%2$s">
                                    <div class="main-count-wrapper">
                                        <div class="main-count">
                                            <div class="time days flip">
                                                <span class="count curr top">00</span>
                                            </div>
                                            <div class="count-height"></div>
                                            <div class="stat-label">'.esc_html__('days', 'slz').'</div>
                                        </div>
                                    </div>
                                    <div class="main-count-wrapper">
                                        <div class="main-count">
                                            <div class="time hours flip">
                                                <span class="count curr top">00</span>
                                            </div>
                                            <div class="count-height"></div>
                                            <div class="stat-label">'.esc_html__('hours', 'slz').'</div>
                                        </div>
                                    </div>
                                    <div class="main-count-wrapper">
                                        <div class="main-count">
                                            <div class="time minutes flip">
                                                <span class="count curr top">00</span>
                                            </div>
                                            <div class="count-height"></div>
                                            <div class="stat-label">'.esc_html__('mins', 'slz').'</div>
                                        </div>
                                    </div>
                                    <div class="main-count-wrapper">
                                        <div class="main-count">
                                            <div class="time seconds flip">
                                                <span class="count curr top">00</span>
                                            </div>
                                            <div class="count-height"></div>
                                            <div class="stat-label">'.esc_html__('secs', 'slz').'</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item view-detail">
                                '.$btn_readmore_html.'
                            </div>
                        </div>'
                    );
                    $out .= $model->get_banner_countdown($html_options);
                }
                $model->reset();
            }
        }
        return $out;
    }
}

