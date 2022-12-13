<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}
if ( ! is_plugin_active( 'js_composer/js_composer.php' ) ) {
	return;
}

$column_class = $out = $css = $custom_css = '';
$block_class = 'pricing_box-'.SLZ_Com::make_id();
$pricing_option_arr = $btn_link_arr = array();
$block_cls = $block_class.' '.$data['extra_class'];
$data['block_class'] = $block_class;
$separator = '';
$unit = '';
$array = array(
	'text' => ''
);

//column
$class_column = '';
if ( isset( $data['column'] ) ) {
    if (  $data['column'] == 1 ){
        $column_class = 'slz-column-1';
    }
    else if (  $data['column'] == 2 ){
        $column_class = 'slz-column-2';
    }
    else if (  $data['column'] == 3 ){
        $column_class = 'slz-column-3';
    }
    else if (  $data['column'] == 4 ){
        $column_class = 'slz-column-4';
    }
    else {
        $column_class = '';
    }
}

$x = 1;

$out .= '<div class="slz-list-block slz-list-column '.esc_attr( $column_class ).'">';
	for ($i=1; $i <= $data['column'] ; $i++) { 

		if ( $data['active'.$i] == 'yes' ) {
			$active = 'active';
		}else{
			$active = '';
		}

		$out .= '<div class="item">';
			$out .= '<div class="slz-pricing-table-01 pricing-box-total-'.esc_attr( $i ).' '.esc_attr( $active ).'">';
				if ( !empty( $data['label'.$i] ) ) {
					$out .= '<div class="pricing-label pricing-box-label-'.esc_attr( $i ).'">'. esc_html( $data['label'.$i] ) .'</div>';
				}

				$out .= '<div class="pricing-header">';
					if ( !empty( $data['title'.$i] ) ) {
						$out .= '<div class="title pricing-box-title-'.esc_attr( $i ).'">'.esc_html( $data['title'.$i] ).'</div>';
					}
					$out .= '<div class="pricing-section pricing-box-section-'. esc_attr( $i ).'">';
						if ( !empty( $data['price'.$i] ) || !empty( $data['currency'.$i] ) ) {
							if ( !empty( $data['separate'.$i] ) ) {
								$separator = $data['separate'.$i];
							}else{
								$separator = '';
							}
							if ( !empty( $data['unit'.$i] ) ) {
								$unit = $data['unit'.$i];
							}else{
								$unit = '';
							}
							$out .= '
								<sup class="unit">'. esc_html( $unit ) .'</sup>
								'. esc_html( $data['price'.$i] ) .'
								<span class="per">'. esc_html( $separator ) . esc_html( $data['currency'.$i] ) .'</span>
							';
						}
					$out .= '</div>';
					if ( !empty( $data['sub_title'.$i] ) ) {
						$out .= '<div class="sub-title pricing-box-sub-title-'.esc_attr( $i ).'">'.wp_kses_post($data['sub_title'.$i]).'</div>';
					}
				$out .= '</div>';
				$out .= '<div class="pricing-body pricing-box-pricing-body-'.esc_attr( $i ).'">';
					$pricing_option_arr = (array) vc_param_group_parse_atts( $data['pricing_options'.$i] );
					if ( !empty( $pricing_option_arr ) ) {
						$x = 1;
						foreach ($pricing_option_arr as $pricing_option) {
							$pricing_option = array_merge( $array, $pricing_option );
							$out .= '<div class="pricing-option pricing-box-option-'.esc_attr( $x ).'">&nbsp;'. esc_html( $pricing_option['text'] ) .'</div>';
							if ( !empty( $pricing_option['pricing_options_color'] ) ) {
								$css = '
									.%1$s .pricing-box-pricing-body-%2$s .pricing-option.pricing-box-option-%4$s {
										color: %3$s;
									}
								';
								$custom_css .= sprintf( $css, esc_attr( $block_class ), esc_attr( $i ), esc_attr( $pricing_option['pricing_options_color'] ), esc_attr( $x ) );
							}
							$x++;
						}
					}
				$out .= '</div>';
				if ( !empty( $data['btn_text'.$i] ) && !empty( $data['btn_link'.$i] ) ) {
					$btn_link_arr = SLZ_Util::get_link( $data['btn_link'.$i] );
					$out .= '
						<div class="pricing-footer">
							<a href="'. esc_url( $btn_link_arr['link'] ) .'" '. esc_attr( $btn_link_arr['target'] ) .' '. esc_attr( $btn_link_arr['url_title'] ) .' class="btn pricing-box-button-'.esc_attr( $i ).'">'. esc_html( $data['btn_text'.$i] ) .'</a>
						</div>
					';
				}
			$out .= '</div>';
		$out .= '</div>';

		/* custom css */
		if ( !empty( $data['title_color'.$i] ) ) {
			$css = '
				.%1$s .title.pricing-box-title-%2$s {
					color: %3$s;
				}
			';
			$custom_css .= sprintf( $css, esc_attr( $block_class ), esc_attr( $i ), esc_attr( $data['title_color'.$i] ) );
		}
		if ( !empty( $data['price_color'.$i] ) ) {
			$css = '
				.%1$s .pricing-section.pricing-box-section-%2$s {
					color: %3$s;
				}
			';
			$custom_css .= sprintf( $css, esc_attr( $block_class ), esc_attr( $i ), esc_attr( $data['price_color'.$i] ) );
		}
		if ( !empty( $data['price_subfix_color'.$i] ) ) {
			$css = '
				.%1$s .pricing-section.pricing-box-section-%2$s span.per {
					color: %3$s;
				}
			';
			$custom_css .= sprintf( $css, esc_attr( $block_class ), esc_attr( $i ), esc_attr( $data['price_subfix_color'.$i] ) );
		}
		if ( !empty( $data['sub_title_color'.$i] ) ) {
			$css = '
				.%1$s .pricing-box-sub-title-%2$s {
					color: %3$s;
				}
			';
			$custom_css .= sprintf( $css, esc_attr( $block_class ), esc_attr( $i ), esc_attr( $data['sub_title_color'.$i] ) );
		}
		if ( !empty( $data['btn_text_color'.$i] ) ) {
			$css = '
				.%1$s .pricing-box-button-%2$s {
					color: %3$s;
				}
			';
			$custom_css .= sprintf( $css, esc_attr( $block_class ), esc_attr( $i ), esc_attr( $data['btn_text_color'.$i] ) );
		}
		if ( !empty( $data['btn_background_color'.$i] ) ) {
			$css = '
				.%1$s .pricing-box-button-%2$s {
					background-color: %3$s;
				}
			';
			$custom_css .= sprintf( $css, esc_attr( $block_class ), esc_attr( $i ), esc_attr( $data['btn_background_color'.$i] ) );
		}
		if ( !empty( $data['btn_border_color'.$i] ) ) {
			$css = '
				.%1$s .pricing-box-button-%2$s {
					border-color: %3$s;
				}
			';
			$custom_css .= sprintf( $css, esc_attr( $block_class ), esc_attr( $i ), esc_attr( $data['btn_border_color'.$i] ) );
		}
		if ( !empty( $data['active_color'.$i] ) ) {
			$css = '
				.%1$s .pricing-box-total-%2$s.active {
					background-color: %3$s;
				}
			';
			$custom_css .= sprintf( $css, esc_attr( $block_class ), esc_attr( $i ), esc_attr( $data['active_color'.$i] ) );
		}
		if ( !empty( $data['label_text_color'.$i] ) ) {
			$css = '
				.%1$s .pricing-box-label-%2$s {
					background-color: %3$s;
				}
			';
			$custom_css .= sprintf( $css, esc_attr( $block_class ), esc_attr( $i ), esc_attr( $data['label_text_color'.$i] ) );
		}
		if ( !empty( $data['label_background_color'.$i] ) ) {
			$css = '
				.%1$s .pricing-box-label-%2$s {
					color: %3$s;
				}
			';
			$custom_css .= sprintf( $css, esc_attr( $block_class ), esc_attr( $i ), esc_attr( $data['label_background_color'.$i] ) );
		}
		/* end custom css */

	}// end for
$out .= '</div>';


if ( is_plugin_active( 'js_composer/js_composer.php' ) ) {
	echo '<div class="slz_shortcode slz-pricing-plan-01 '.esc_attr( $block_cls ).'">';
		echo '<div class="row">';
			echo ( $out );
		echo '</div>';
	echo '</div>';
}else{
	echo esc_html__('Please Active Visual Composer', 'slz');
}

if ( !empty( $custom_css ) ) {
	do_action('slz_add_inline_style', $custom_css);
}
