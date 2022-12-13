<?php
$header_class = '';
$transparent = false;
$search_icon = 'fa fa-search';
if ( !empty ( $search_style['icon-class'] ) ) {

    $search_icon = $search_style['icon-class'];

}

$logo_class = 'float-l';
$main_menu_class = 'float-r';

if ( slz_akg('logo-align', $options, 'left') == 'right'){

    $main_menu_class = 'float-l';
    $logo_class = 'float-r';

}


list($header_class,$transparent) = slz_get_header_transparent(slz_get_db_settings_option('slz-header-style-group/slz-header-style',''));

// sub header
$subheader_icon = $subheader_class = $subheader_mask = '';
if( slz_akg( 'enable-subheader/enable', $options, '' ) == 'show' ):
    $subheader_class = 'slz-has-subheader';
    $subheader_icon = 
        '<a href="#" class="slz-menu-icon">
            <span class="line"></span>
            <span class="line"></span>
            <span class="line"></span>
        </a>';
    $subheader_mask = '<div class="subheader-mask"></div>';
endif;
$enable_topbar = false;
$vcc_account_html = SLZ_Com::get_woo_account(false);

$btn_donation = array();
if (function_exists('slz_theme_render_donation_button_topbar')) {
    $btn_donation = slz_theme_render_donation_button_topbar($options);
}

$banner_event_topbar_left_html = '';
$banner_event_topbar_right_html = '';
if (function_exists('slz_theme_render_banner_event_topbar')) {
    $enable_banner_event_topbar_left = slz_akg('enable-header-top-bar/yes/left-position', $options, '');
    $enable_banner_event_topbar_right = slz_akg('enable-header-top-bar/yes/right-position', $options, '');

    if ( isset($enable_banner_event_topbar_left) && is_array($enable_banner_event_topbar_left) && in_array('event-banner', $enable_banner_event_topbar_left)  ) {
        $banner_event_topbar_left_html = slz_theme_render_banner_event_topbar($options);
    }
    if ( isset($enable_banner_event_topbar_right) && is_array($enable_banner_event_topbar_right) && in_array('event-banner', $enable_banner_event_topbar_right)  ) {
        $banner_event_topbar_right_html = slz_theme_render_banner_event_topbar($options);
    }
}

$enable_topbar_menu_mobile = slz_akg('enable-header-top-bar/yes/show_topbarmenu_menu_mobile', $options, false);
if ($enable_topbar_menu_mobile) {
    $header_mobile_class = ' slz-header-mobile-topbar';
    $header_class .= esc_attr($header_mobile_class);
}
$top_bar = slz_akg('enable-header-top-bar/selected-value', $options, 'no' );
SLZ_Live_Setting::get_top_bar($top_bar);
//sticky
$header_sticky = '';
if ( slz_akg('enable-sticky-header', $options, '') == 'yes' ){
	$header_sticky = 'slz-header-sticky';
}
SLZ_Live_Setting::get_header_animation($header_sticky);
?>
<header>
    <div class="slz-header-wrapper <?php echo esc_attr($header_class);?>">
        <?php
        if ( ( $top_bar == 'yes' && apply_filters('slz_ext_headers_disable_top_bar', true) ) ) :
            $enable_topbar = true;
        ?>
            <div class="slz-header-topbar">
                <div class="container">
                    <div class="slz-topbar-list float-l">
                        <?php echo slz_display_topbar_content('social', slz_akg('yes/left-position', $topbar, array()), array('customize-icon' => slz_akg('yes/customize-icon', $topbar, array()),'button'=>slz_akg('yes/button', $topbar, array())) ); ?>
                        <?php
                        if (!empty($banner_event_topbar_left_html)) {
                            echo ( $banner_event_topbar_left_html );
                        }
                        ?>
                    </div>
                    <div class="slz-topbar-list float-r">
                                                <div class="langsidebar" style="float: right;">
    <?php  dynamic_sidebar( 'sidebarlang' ); ?>
</div>
                        <?php echo slz_display_topbar_content('social', slz_akg('yes/right-position', $topbar, array()), array('customize-icon' => slz_akg('yes/customize-icon', $topbar, array()),'button'=>slz_akg('yes/button', $topbar, array())) );
                        // wpml language
                        if(has_action('wpml_add_language_selector')) {
                        $show_laguage_switcher = slz_get_db_settings_option('enable-wpml', '');
                            if($show_laguage_switcher == 'yes'){
                                echo '<div class="wpml-language item">';
                                    do_action('wpml_add_language_selector');
                                echo '</div>';
                            }
                        }?>
                        <?php
                        echo $vcc_account_html;
                        if (!empty($banner_event_topbar_right_html)) {
                            echo ( $banner_event_topbar_right_html );
                        }

                        if ( isset($btn_donation['button']) ) {
                            echo ( $btn_donation['button'] );
                        }

                        if ( isset($btn_donation['model']) ) {
                            echo ( $btn_donation['model'] );
                        }
                        ?>

                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <?php endif; ?>

        <!-- header main -->
        <?php 
        if( empty($options['show-main-menu']) || (!empty($options['show-main-menu']) && $options['show-main-menu'] == 'show')):?>
            <div class="slz-header-main <?php echo esc_attr($header_sticky) .' '.esc_attr($subheader_class);?>">
                <div class="container">
                    <!-- hamburger menu mobile-->
                    <div class="slz-hamburger-menu">
                        <div class="bar"></div>
                    </div>
                    <div class="slz-main-menu-mobile"> 
                        <?php
                            if ($enable_topbar) :
                                if ($enable_topbar_menu_mobile == true) :?>
                                    <div class="slz-mobile-topbar">
                                        <div class="slz-topbar-list float-l">
                                            <?php echo slz_display_topbar_content('social', slz_akg('yes/left-position', $topbar, array()), array('customize-icon' => slz_akg('yes/customize-icon', $topbar, array()),'button'=>slz_akg('yes/button', $topbar, array())) ); ?>
                                             <?php
						                        if (!empty($banner_event_topbar_left_html)) {
						                            echo ( $banner_event_topbar_left_html );
						                        }
						                        ?>
                                        </div>
                                        <div class="slz-topbar-list float-r">
                                            <?php echo slz_display_topbar_content('social', slz_akg('yes/right-position', $topbar, array()), array('customize-icon' => slz_akg('yes/customize-icon', $topbar, array()),'button'=>slz_akg('yes/button', $topbar, array())) );
                                            // wpml language
                                            if(has_action('wpml_add_language_selector')) {
                                                $show_laguage_switcher = slz_get_db_settings_option('enable-wpml', '');
                                                if($show_laguage_switcher == 'yes'){
                                                    echo '<div class="wpml-language item">';
                                                    do_action('wpml_add_language_selector');
                                                    echo '</div>';
                                                }
                                            }?>
                                            <?php
                                            echo ( $vcc_account_html );

											if (!empty($banner_event_topbar_right_html)) {
						                    	echo ( $banner_event_topbar_right_html );
						                    }

                                            if ( isset($btn_donation['button']) ) {
                                                echo ( $btn_donation['button'] );
                                            }

                                            ?>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>

                                    <?php
                                endif;
                            endif;
                        ?>
                        <div class="nav-wrapper">
                            <div class="nav-search">
                                <?php get_search_form(true); ?>
                            </div>
                        </div>
                        <?php slz_theme_nav_menu( 'main-nav' ); ?>
                    </div>
                    <?php echo slz_get_logo('slz-logo-wrapper ' . $logo_class, $transparent ); ?>

                    <div class="slz-main-menu <?php echo esc_attr($main_menu_class); ?>">
                        
                        <?php slz_theme_nav_menu( 'main-nav' ); ?>

                        <?php if ( slz_akg('enable-search', $options, 'no' ) == 'yes') : ?>

                            <div class="slz-button-search"><i class="icons <?php echo esc_attr($search_icon); ?>"></i></div>

                            <div class="nav-wrapper hide">

                                <div class="nav-search">

                                    <?php get_search_form(true); ?>

                                </div>

                            </div>
                            
                        <?php endif; ?>
                    </div>

                    <!-- sub header icon -->
                    <?php echo wp_kses_post($subheader_icon);?>

                    <div class="clearfix"></div>
                </div>
            </div>
        <?php endif;?>

        <!-- sub header -->
        <?php echo wp_kses_post($subheader_mask);?>
        <?php if( slz_akg( 'enable-subheader/enable', $options, '' ) == 'show' ):?>
            <div class="slz-sub-header slz-sub-menu slz-main-menu">
                <div class="slz-navbar-wrapper">
                    <div class="slz-menu-wrapper">
                    <!-- contact -->
                        <?php if( slz_akg( 'enable-subheader/show/enable-contact', $options, '' ) == 'show' ):?>
                                <div class="contact">
                                 <a href="#" class="slz-close-contact">
                                    <span class="line"></span>
                                    <span class="line"></span>
                                    <span class="line"></span>
                                </a>
                                <div class="inner">
                                    <?php 
                                        $contact_form =  slz_akg( 'enable-subheader/show/contact-form', $options, '' ); 
                                        if( !empty( $contact_form ) &&  is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) ) :
                                            echo '<div class="contact-form">';
                                                echo do_shortcode('[contact-form-7 id="'.$contact_form.'"]');
                                            echo '</div>';
                                        endif;
                                    ?>
                                    </div>
                                </div>
                        <?php endif;?>
                        <div class="inner">

                            <div class="menu-heading">
                                <div class="action-top">
                                    <a href="#" class="slz-menu-icon">
                                        <span class="line"></span>
                                        <span class="line"></span>
                                        <span class="line"></span>
                                    </a>
                                    <?php if( slz_akg( 'enable-subheader/show/enable-contact', $options, '' ) == 'show' ):?>
                                        <?php
                                            $btn_text = slz_akg( 'enable-subheader/show/contact-text', $options, '' ); ?>
                                            <a href="" class="slz-btn btn-contact-toggle"><span class="btn-text"><?php echo esc_attr($btn_text);?></span>
                                            </a>
                                    <?php endif;?>
                                   
                                </div>

                                <!-- add short code -->

                                <div class="app-post">
                                    <?php 
                                        $shortcode = slz_akg( 'enable-subheader/show/add_shortcode', $options, '' );
                                        if( !empty( $shortcode) ):
                                            echo '<div class="sc-content">';
                                            echo do_shortcode( $shortcode );
                                            echo '</div>';
                                        endif;
                                    ?>
                                </div>
                            </div>
                            <div class="menu-body">
                                <!-- sub menu -->
                                <?php if( slz_akg( 'enable-subheader/show/enable-submenu', $options, '' ) == 'show' ):?>
                                    <!-- hamburger menu mobile-->
                                    <div class="slz-sub-menu-mobile"> 
                                        <?php slz_theme_nav_menu( 'sub-nav' ); ?>
                                    </div>
                                    <div class="slz-sub-menu">
                                        <?php slz_theme_nav_menu( 'sub-nav' ); ?>
                                    </div>
                                    <div class="clearfix"></div>
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif;?>

        <!-- end sub header -->
        
    </div>
</header>