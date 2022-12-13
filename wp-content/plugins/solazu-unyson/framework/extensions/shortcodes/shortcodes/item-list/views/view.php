<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$block_class = 'item-list-'.SLZ_Com::make_id();
$block_cls = $block_class.' '.$data['extra_class']. ' ';
$data['block_class'] = $block_class;
$icon = '';
$css = $custom_css = '';
$i = 1;

if ( is_plugin_active( 'js_composer/js_composer.php' ) ) {
	
	$param_default = array(
		'icon_color'         => '',
		'text'               => '',
		'text_color'         => ''
	);

	echo '<div class="slz-shortcode sc_item_list '. esc_attr( $block_cls ) .'">';
	if ( !empty( $data['item_list'] ) ) {
	$items = (array) vc_param_group_parse_atts( $data['item_list'] );
	$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'item_list' );

		if ( !empty( $items ) ) {
			echo '<ul class="slz-list">';
			foreach ($items as $item) {
				$item = array_merge( $param_default, $item );
				
				echo '<li class="item-com-'.esc_attr( $i ).'">';
					$format = '<i class="slz-icon %1$s"></i>';
					print ( $shortcode->get_icon_library_views( $item, $format ) );
					if ( !empty( $item['text'] ) ) {
						echo '<span class="text">'. esc_html( $item['text'] ) .'</span>';
					}
				echo '</li>';

				/* custom css */
				if ( !empty( $item['icon_color'] ) ) {
					$css = '
						.%1$s li.item-com-%2$s i{
							color: %3$s;
						}
					';
					$custom_css .= sprintf( $css, esc_attr( $block_class ), esc_attr( $i ), esc_attr( $item['icon_color'] ) );
				}
				if ( !empty( $item['text_color'] ) ) {
					$css = '
						.%1$s li.item-com-%2$s .text{
							color: %3$s;
						}
					';
					$custom_css .= sprintf( $css, esc_attr( $block_class ), esc_attr( $i ), esc_attr( $item['text_color'] ) );
				}

				$i++;
			}// end foreach
			echo '</ul>';
		}//end if
	}
	echo '</div>';
	if( !empty( $data['margin_top'] ) ) {
		$css = '
			.%1$s .slz-list li{
				margin-top: %2$spx;
			}
		';
		$custom_css .= sprintf( $css, esc_attr( $block_class ), $data['margin_top'] );
	}
	if( !empty( $data['icon_color'] ) ) {
		$css = '
			.%1$s .slz-list li .slz-icon{
				color: %2$s;
			}
		';
		$custom_css .= sprintf( $css, esc_attr( $block_class ), $data['icon_color'] );
	}
	if( !empty( $data['margin_bottom'] ) ) {
		$css = '
			.%1$s .slz-list li{
				margin-bottom: %2$spx;
			}
		';
		$custom_css .= sprintf( $css, esc_attr( $block_class ), $data['margin_bottom'] );
	}
	if ( !empty( $custom_css ) ) {
		do_action('slz_add_inline_style', $custom_css);
	}

}else{
	echo esc_html__('Please Active Visual Composer', 'slz');
}