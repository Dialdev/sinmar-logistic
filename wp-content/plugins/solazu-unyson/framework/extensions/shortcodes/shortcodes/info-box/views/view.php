<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'info_box' );
$block_class = 'info-box-'.SLZ_Com::make_id();
$block_cls = $block_class.' '.$data['extra_class']. ' ';
$css = $custom_css = '';
$out  = '';

$out .= '<div class="slz-shortcode slz-shortcode-list sc_info_box '. esc_attr( $block_cls ). ' ">';

    // icon or image
    $out .= '<div class="icon-cell">';

        if ( $data['icon_type'] == '0') {
            
            if ( !empty( $data['img_up'] ) && $img_url = wp_get_attachment_url( $data['img_up'] ) ) {
                $out .= '
                    <div class="wrapper-icon-image">
                        <img src="'.esc_url( $img_url ).'" alt="" class="slz-icon-img">
                    </div>
                ';
            }
        }else{
            $format = '<div class="wrapper-icon"><i class="slz-icon %1$s"></i></div>';
            $shortcode = slz_ext( 'shortcodes' )->get_shortcode('info_box');
            $out .= $shortcode->get_icon_library_views( $data, $format );
        }
        
    $out .= '</div>';

    // information

   if( ! empty( $data['content'] ) ) :
    
    $out .=  '<div class="content-cell description">';
       $out .= wp_kses_post( $data['content'] ); 
    $out .= '</div>';

    endif;
   
$out .=  '</div>';


echo wp_kses_post($out);

//custom css


if( isset( $data['des_color'] ) && !empty( $data['des_color'] ) ) {
    $css = '
		.%1$s.sc_info_box .description {
			color: %2$s;
		}
	';
    $custom_css .= sprintf( $css, esc_attr( $block_class ), esc_attr( $data['des_color'] ) );
}

if( !empty( $data['background_color'] ) ) {
	
	$css = '
		.%1$s.sc_info_box {
			background-color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $block_class ), esc_attr( $data['background_color'] ) );
}
if( !empty( $data['border_color'] ) ) {
    $css = '
		.%1$s.sc_info_box::before {
			background-color: %2$s;
		}
	';
    $custom_css .= sprintf( $css, esc_attr( $block_class ), esc_attr( $data['border_color'] ) );
}
if( !empty( $data['icon_color'] ) ) {
    $css = '
		.%1$s.sc_info_box .icon-cell .slz-icon {
			color: %2$s;
		}
	';
    $custom_css .= sprintf( $css, esc_attr( $block_class ), esc_attr( $data['icon_color'] ) );
}

if ( !empty( $custom_css ) ) {
	do_action('slz_add_inline_style', $custom_css);
}