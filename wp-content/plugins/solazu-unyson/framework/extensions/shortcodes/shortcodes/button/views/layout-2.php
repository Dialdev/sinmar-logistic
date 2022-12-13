<?php
$title = $img = $extra_class = $link_arr = $href = $out = $custom_css = '';

// get title
	if(!empty($item['title'])){
		$title = $item['title'];
	}

// get button link
	if( !empty( $item['button_link'] ) ){
		$link = SLZ_Util::parse_vc_link( $item['button_link'] );
		if( !empty( $link['url'] ) ) {
			$href = $link['url'];
		}
		$link_arr =  $link['other_atts'];
	}
//get img
	if(!empty($item['btn-image'])){
		$img = '<img src="'.esc_url(wp_get_attachment_url($item['btn-image'])).'" alt="">';
	}

//get extra class
	if(!empty($item['extra_class'])){
		$extra_class  = $item['extra_class'];
	}

// custom css
if ( !empty( $item['border_radius'] ) ) {
    $css = '.%1$s.slz-btn {border-radius: %2$spx;}';
    $custom_css .= sprintf( $css, esc_attr( $item['button_class'] ),esc_attr($item['border_radius']) );
}
if ( !empty( $item['margin_right'] ) ) {
    $css = '.%1$s.slz-btn {margin-right: %2$spx;}';
    $custom_css .= sprintf( $css, esc_attr( $item['button_class'] ),esc_attr($item['margin_right']) );
}
if ( !empty( $custom_css ) ) {
	do_action('slz_add_inline_style', $custom_css);
}

//out put
$out = '<a href="'.esc_url($href).'" '.esc_attr($link_arr).'  class="slz-btn-02 '.esc_attr( $item['button_class'] ).' btn-img slz-btn '.esc_attr($extra_class).'">';
	$out .= $img;
$out.= '</a>';
echo wp_kses_post($out);