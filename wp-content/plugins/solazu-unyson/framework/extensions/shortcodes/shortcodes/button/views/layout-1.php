<?php 
$title = $icon = $link_arr = $href = $css = '';
$custom_css = $extra_class = $out = '';

// get title
	if(!empty($item['title'])){
		$title = $item['title'];
	}

//get icon
	$shortcode = slz_ext( 'shortcodes' )->get_shortcode('button');
	$format = '<span class="'.esc_attr($item['icon_extra_class']).' btn-icon %1$s"></span>';
	$icon = $shortcode->get_icon_library_views( $item, $format );

// get button link

	if( !empty( $item['button_link'] ) ){
		$link = SLZ_Util::parse_vc_link( $item['button_link'] );
		if( !empty( $link['url'] ) ) {
			$href = $link['url'];
		}
		$link_arr =  $link['other_atts'];
	}

//get extra class
	if(!empty($item['extra_class'])){
		$extra_class  = $item['extra_class'];
	}

//custom css
	if ( !empty( $item['bg_color'] ) ) {
	    $css = '.%1$s.slz-btn { background-color:%2$s;}';
	    $custom_css .= sprintf( $css, esc_attr( $item['button_class'] ), esc_attr($item['bg_color']) );
	}
	if ( !empty( $item['bg_color_hover'] ) ) {
	    $css = '.%1$s.slz-btn:hover {background-color:%2$s;}';
	    $custom_css .= sprintf( $css, esc_attr( $item['button_class'] ),esc_attr($item['bg_color_hover']) );
	}

	if ( !empty( $item['btn_border_color'] ) ) {
	    $css = '.%1$s.slz-btn { border-color: %2$s;}';
	    $custom_css .= sprintf( $css, esc_attr( $item['button_class'] ), esc_attr($item['btn_border_color']) );
	}
	if ( !empty( $item['btn_border_color_hover'] ) ) {
	    $css = '.%1$s.slz-btn:hover {border-color: %2$s;}';
	    $custom_css .= sprintf( $css, esc_attr( $item['button_class'] ),esc_attr($item['btn_border_color_hover']) );
	}

	if ( !empty( $item['btn_color'] ) ) {
	    $css = '.%1$s.slz-btn {color: %2$s;}';
	    $custom_css .= sprintf( $css, esc_attr( $item['button_class'] ), esc_attr($item['btn_color']) );
	}
	if ( !empty( $item['btn_color_hover'] ) ) {
	    $css = '
	    	.%1$s.slz-btn:hover {
	    		color: %2$s;
			}
		';
	    $custom_css .= sprintf( $css, esc_attr( $item['button_class'] ),esc_attr($item['btn_color_hover']) );
	}
	if ( !empty( $item['border_radius'] ) ) {
	    $css = '.%1$s.slz-btn {border-radius: %2$spx;}';
	    $custom_css .= sprintf( $css, esc_attr( $item['button_class'] ),esc_attr($item['border_radius']) );
	}
	if ( !empty( $item['margin_right'] ) ) {
	    $css = '.%1$s.slz-btn {margin-right: %2$spx;}';
	    $custom_css .= sprintf( $css, esc_attr( $item['button_class'] ),esc_attr($item['margin_right']) );
	}
	// icon
	if ( !empty( $item['icon_color'] ) ) {
	    $css = '.%1$s.slz-btn .btn-icon:before{color: %2$s;}';
	    $custom_css .= sprintf( $css, esc_attr( $item['button_class'] ), esc_attr($item['icon_color']) );
	}
	if ( !empty( $item['icon_hv_color'] ) ) {
	    $css = '.%1$s.slz-btn:hover .btn-icon:before{color: %2$s;}';
	    $custom_css .= sprintf( $css, esc_attr( $item['button_class'] ), esc_attr($item['icon_hv_color']) );
	}

	if ( !empty( $custom_css ) ) {
		do_action('slz_add_inline_style', $custom_css);
	}
 
//out put
	$out = '<a href="'.esc_url($href).'" '.esc_attr($link_arr).' class="'.esc_attr( $item['button_class'] ).' slz-btn '.esc_attr($extra_class).'">';

		if($item['icon_position'] == 'left'){
			$out .= wp_kses_post($icon);
		}
		$out .= '<span class="btn-text">'.esc_html($title).'</span>';
		if($item['icon_position'] == 'right'){
			$out .= wp_kses_post($icon);
		}
	$out.= '</a>';
	echo wp_kses_post($out);