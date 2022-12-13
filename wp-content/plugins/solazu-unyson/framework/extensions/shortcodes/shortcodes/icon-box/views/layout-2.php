<?php
$out = $css = $custom_css = '';
$i = 1;
$param_default = array(
	'icon_type'                => '',
	'img_up'                   => '',
	'title'                    => '',
	'title_color'              => '',
	'des'                      => '',
	'des_color'                => '',
	'button_text'              => '',
	'button_text_color'        => '',
	'button_background_color'  => '',
	'button_link'              => '',
	'image_hv_color'           => '',
	'icon_hv_color'            => '',
	'icon_bg_color'            => '',
	'icon_color'               => '',
	'icon_bg_hv_color'         => ''
);
$shortcode = slz_ext( 'shortcodes' )->get_shortcode('icon_box');
$column = absint( $data['column'] );
if ( !empty( $data['icon_box_2'] ) ) {
	
	$items = (array) vc_param_group_parse_atts( $data['icon_box_2'] );
	if ( !empty( $items ) ) {

		$out .= '<div class="slz-list-block slz-list-column '. esc_attr( $class_column ) .'">';
		foreach ($items as $item) {
			
			$item = array_merge( $param_default, $item );

			/* custom css */
			// icon
			if ( $item['icon_type'] == '' ) {

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
					.%1$s .icon-box-item-%2$s.slz-icon-box-2:hover .wrapper-icon{
						webkit-box-shadow: 0 10px 25px 0 %3$s;
	    				background-color: %3$s !important;
					}
					';
					$custom_css .= sprintf( $css, esc_attr( $data['block_class'] ), esc_attr($i), esc_attr( $item['icon_bg_hv_color'] ) );
				}
			}
			if ( !empty( $item['image_hv_color'] ) ) {
					$css = '
						.%1$s .icon-box-item-%2$s.slz-icon-box-2:hover .wrapper-icon:before{
							background-color : %3$s;
						}
						.%1$s .icon-box-item-%2$s.slz-icon-box-2:hover .wrapper-icon {
						    -webkit-box-shadow: 0 10px 25px 0 %3$s;
						    box-shadow: 0 10px 25px 0 %3$s;
						}
					';
					$custom_css .= sprintf( $css, esc_attr( $data['block_class'] ), esc_attr($i), esc_attr( $item['image_hv_color'] ) );
				}
			// title
			if ( !empty( $item['title_color'] ) ) {
				$css = '
					.%1$s .icon-box-title-%2$s {
						color: %3$s !important;
					}
				';
				$custom_css .= sprintf( $css, esc_attr( $data['block_class'] ), esc_attr( $i ), esc_attr( $item['title_color'] ) );
			}
			if ( !empty( $item['des_color'] ) ) {
				$css = '
					.%1$s .icon-box-description-%2$s {
						color: %3$s !important;
					}
				';
				$custom_css .= sprintf( $css, esc_attr( $data['block_class'] ), esc_attr( $i ), esc_attr( $item['des_color'] ) );
			}
			if ( !empty( $item['button_text_color'] ) ) {
				$css = '
					.%1$s .icon-box-button-%2$s {
						color: %3$s !important;
					}
				';
				$custom_css .= sprintf( $css, esc_attr( $data['block_class'] ), esc_attr( $i ), esc_attr( $item['button_text_color'] ) );
			}
			if ( !empty( $item['button_background_color'] ) ) {
				$css = '
					.%1$s .icon-box-button-%2$s {
						background-color: %3$s !important;
						border-color: %3$s !important;
					}
				';
				$custom_css .= sprintf( $css, esc_attr( $data['block_class'] ), esc_attr( $i ), esc_attr( $item['button_background_color'] ) );
			}
			/* end custom css */
			$out .= '<div data-wow-delay="' . $data['delay_animation'] . '" class="item ' . $data['item_animation'] . ' wow">';

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
				$out .= '<div class="slz-icon-box-2 icon-box-item-'.esc_attr($i).' ">';
					$out .= '<div class="icon-cell">';
					
						$number = (!empty($data['show_number'])) ? '<div class="number"><span>'.str_pad($i, 2, '0', STR_PAD_LEFT).'</span></div>' : '';
						if(!empty($number)){
							$out .= wp_kses_post($number);
						}

						$out .= '<div class="wrapper-icon">';

							if ( !empty( $item['icon_type'] ) && $item['icon_type'] == '02' ) {
								if ( !empty( $item['img_up'] ) && $img_url = wp_get_attachment_url( $item['img_up'] ) ) {
									$out .= '<img src="'. esc_url( $img_url ) .'" alt="" class="slz-icon-img">';
								}
							}else{
								$format = '<i class="slz-icon %1$s"></i>';
								$out .= $shortcode->get_icon_library_views( $item, $format );
							}

						$out .= '</div>';
						if ( !empty( $item['title'] ) ) {
							$out .= '<div class="title icon-box-title-'.esc_attr( $i ).'">'. esc_html( $item['title'] ) .'</div>';
						}
					$out .= '</div>';
					$out .= '<div class="content-cell">';
						$out .= '<div class="wrapper-info">';
							$out .= '<div class="description icon-box-description-'.esc_attr( $i ).'">'. wp_kses_post( nl2br( $item['des'] ) ) .'</div>';

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

						$out .= '</div>';
					$out .= '</div>';
				$out .= '</div>';

				$i++;

			$out .= '</div>';
			
		}// end foreach
		
		$out .= '</div>';
		
	}// endif

	if ( !empty( $custom_css ) ) {
		do_action('slz_add_inline_style', $custom_css);
	}
	echo ( $out );
}//endif
