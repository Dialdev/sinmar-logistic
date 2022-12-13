<?php
$class_view = $out = $link_arr = '';
$custom_css = '';
$css = '';
$i = 1;
$x = 0;
$align= '';
$param_default = array(
	'custom'                   => '',
	'style_1'                  => '',
	'align'                    => '',
	'icon_type'                => '',
	'icon_vs'                  => '',
	'img_up'                   => '',
	'icon_flaticon'            => '',
	'icon_type_2'              => '',
	'icon_vs_2'                => '',
	'icon_flaticon_2'          => '',
	'icon_hv_color'            => '',
	'icon_bg_color'            => '',
	'icon_color'               => '',
	'icon_bg_hv_color'         => '',
	'img_up_custom_1'          => '',
	'img_up_custom_2'          => '',
	'title'                    => '',
	'title_color'              => '',
	'des'                      => '',
	'des_color'                => '',
	'button_text'              => '',
	'button_text_color'        => '',
	'button_background_color'  => '',
	'button_link'              => '',
	//icon update
	'icon_library'             => 'vs',
	'icon_vs'                  => '',
	'icon_openiconic'          => '',
	'icon_typicons'            => '',
	'icon_linecons'            => '',
	'icon_monosocial'          => '',
	'icon_entypo'              => '',
);

$component = '';
if( $data['style_layout_1'] == '4' ) {
	$component = '<div class="icon-circle"></div>';
}


$column = absint( $data['column'] );
if ( !empty( $data['icon_box']) ) {
    $items = (array) vc_param_group_parse_atts( $data['icon_box'] );

	if ( !empty( $items ) ) {
		if( $column ){
			$out .= '<div class="row">';
		}

		foreach ($items as $item) {
			if ( $column && $x == $column ) {
				$out .= '</div><div class="row">';
				$x = 0;
			}

			$out .= '<div class="'. esc_attr( $class_column ) .'">';
			$item = array_merge( $param_default, $item );

			// icon
			if ( $item['custom'] == '') {
				if ( !empty( $item['icon_color'] ) ) {
					$css = '
						.%1$s .icon-box-item-%2$s .wrapper-icon i{
							color: %3$s;
						}
					';
					$custom_css .= sprintf( $css, esc_attr( $data['block_class'] ), esc_attr($i), esc_attr( $item['icon_color'] ) );
				}
				if ( !empty( $item['icon_bg_color'] ) ) {
					$css = '
						.%1$s .icon-box-item-%2$s .wrapper-icon{
							background-color: %3$s;
						}
					';
					$custom_css .= sprintf( $css, esc_attr( $data['block_class'] ), esc_attr($i), esc_attr( $item['icon_bg_color'] ) );
				}
				if ( !empty( $item['icon_hv_color'] ) ) {
					$css = '
						.%1$s .icon-box-item-%2$s:hover .wrapper-icon i{
							color: %3$s;
						}
					';
					$custom_css .= sprintf( $css, esc_attr( $data['block_class'] ), esc_attr($i), esc_attr( $item['icon_hv_color'] ) );
				}
				if ( !empty( $item['icon_bg_hv_color'] ) ) {
					$css = '

					.%1$s .icon-box-item-%2$s .wrapper-icon:before{
						background: %3$s;
					}
					.%1$s .icon-box-item-%2$s.slz-icon-box-1:hover .wrapper-icon{
						webkit-box-shadow: 0 10px 25px 0 %3$s;
	    				background-color: %3$s !important;
					}
					';
					$custom_css .= sprintf( $css, esc_attr( $data['block_class'] ), esc_attr($i), esc_attr( $item['icon_bg_hv_color'] ) );
				}
			}


			// title
			if ( !empty( $item['title_color'] ) ) {
				$css = '
					.%1$s .icon_box_title-%2$s {
						color: %3$s !important;
					}
				';
				$custom_css .= sprintf( $css, esc_attr( $data['block_class'] ), esc_attr( $i ), esc_attr( $item['title_color'] ) );
			}
			if ( !empty( $item['des_color'] ) ) {
				$css = '
					.%1$s .icon_box_description-%2$s {
						color: %3$s !important;
					}
				';
				$custom_css .= sprintf( $css, esc_attr( $data['block_class'] ), esc_attr( $i ), esc_attr( $item['des_color'] ) );
			}
			if ( !empty( $item['button_text_color'] ) ) {
				$css = '
					.%1$s .icon-box-button-%2$s.btn {
						color: %3$s;
					}
				';
				$custom_css .= sprintf( $css, esc_attr( $data['block_class'] ), esc_attr( $i ), esc_attr( $item['button_text_color'] ) );
			}
			if ( !empty( $item['button_background_color'] ) ) {
				$css = '
					.%1$s .icon-box-button-%2$s.btn{
						border-color: %3$s;
						background-color: %3$s;
					}
				';
				$custom_css .= sprintf( $css, esc_attr( $data['block_class'] ), esc_attr( $i ), esc_attr( $item['button_background_color'] ) );
			}

			if ( isset( $item['style_1'] ) ) {
				if ( $item['style_1'] == '1' ) {
					$class_view = 'style-vertical';
					if ( $item['align'] == 'center' ) {
						$align = '';
					}elseif ( $item['align'] == 'left' ) {
						$align = 'left';
					}elseif ( $item['align'] == 'right' ) {
						$align = 'right';
					}
				}
			}else{
				$class_view = '';
			}
			//shortcode title
            if(!empty($data['title'])) {
                $out .= '<h2 class="title">'.esc_html($data['title']).'</h2>';
                if(!empty($data['title_color'])){
                    $css = '
					.%1$s h2.title{
                        color: %2$s;
					}';
                    $custom_css .= sprintf($css, esc_attr($data['block_class']), esc_attr($data['title_color']));
                }
            }

			$out .= '<div class="slz-icon-box-1 icon-box-item-'.esc_attr($i).' '.esc_attr( $class_view ).' '. esc_attr( $align ) .'style-'.esc_attr($data['style_layout_1']).'">';
				$out .= '<div class="icon-cell">';
                if ( !empty( $item['icon_type'] ) ) {
                    if ( $item['icon_type'] == '02' ) {
                        if ( !empty( $item['img_up'] ) && $img_url = wp_get_attachment_url( $item['img_up'] ) ) {
                            $out .= '
                                <div class="wrapper-icon-image">
                                    <img src="'.esc_url( $img_url ).'" alt="" class="slz-icon-img">
                                    '. $component .'
                                </div>
                            ';
                        }
                    }elseif ( $item['icon_type'] == '03' ) {
                        $out .= '
                            <div class="wrapper-icon">
                                <i class="slz-icon '.esc_attr( $item['icon_flaticon'] ).'"></i>
                                '. $component .'
                            </div>
                        ';
                    }
                }else{
                    $icon = $item['icon_library'];
                    if ( !empty( $item['icon_'.$icon] ) ) {
                        SLZ_Util::slz_icon_fonts_enqueue($item['icon_library'] );
                        $out .= '
                            <div class="wrapper-icon">
                                <i class="slz-icon '.esc_attr( $item['icon_'.$icon] ).'"></i>
								'. $component .'
                            </div>
                        ';
                    }
                }

				$out .= '</div>';
				$out .= '
					<div class="content-cell">
						<div class="wrapper-info">
				';
					if ( !empty( $item['title'] ) ) {
						$out .= '<div class="title icon_box_title-'.esc_attr( $i ).'">'. esc_html( $item['title'] ) .'</div>';
					}
					if ( !empty( $item['des'] ) ) {
						$out .= '<div class="description icon_box_description-'. esc_attr( $i ) .'">'. wp_kses_post( nl2br ($item['des'] ) ) .'</div>';
					}
					if ( !empty( $item['button_text'] ) ) {
						$link_arr = array(
									'link'        => '',
									'url_title'   => '',
									'target'      => '',
								);
						$link_arr_default = array(
									'link'        => '',
									'url_title'   => '',
									'target'      => '',
								);
						if ( !empty( $item['button_link'] ) ) {
							$link_arr = SLZ_Util::get_link( $item['button_link'] );
						}
						$link_arr = array_merge( $link_arr_default, $link_arr );

						$out .= '
							<a href="'.esc_url( $link_arr['link'] ).'" '.esc_attr( $link_arr['url_title'] ).' '.esc_attr( $link_arr['target'] ).' class="fancybox-inline slz-btn icon-box-button-'.esc_attr( $i ).'">
								<span class="text">'.esc_html( $item['button_text'] ).'</span>
								<span class="icons fa fa-angle-double-right"></span>
							</a>
						';
					}
				$out .= '
						</div>
					</div>
				';
			$out .= '</div>';
			$out .= '</div>'; // close col
			$i++;
			$x++;
		}//end foreach

		if( $column ) {
			$out .= '</div>';
		}
	}//end if


	if ( !empty( $custom_css ) ) {
		do_action('slz_add_inline_style', $custom_css);
	}
	echo ( $out );
}
