<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$block_cls = $data['block_class']. ' ';
$css = $custom_css = '';
$i = 1;

$params_default = array(
	'timeline'            => '',
	'timeline_color'      => '',
	'title'               => '',
	'title_link'          => '',
	'title_color'         => '',
	'description'         => '',
	'description_color'   => '',
	'image'               => '',
);

if ( !empty( $data['timeline_info'] ) ) {
	echo '<div class="slz-shortcode sc_timeline '. esc_attr( $block_cls ) .'">';
		echo '<div class="slz-timeline layout-1">';
		$items = (array) vc_param_group_parse_atts( $data['timeline_info'] );
		if ( !empty( $items ) ) {
			foreach ( $items as $item ) {
				$item = array_merge( $params_default, $item );

				if ( empty( $item['title'] ) && empty( $item['description'] ) && empty( $item['image'] ) && empty( $item['timeline'] ) ) {
					continue;
				}

				$link_arr = array();
				if ( !empty( $item['title_link'] ) ) {
					$link_arr = SLZ_Util::parse_vc_link( $item['title_link'] );
				}
				
				echo '<div class="milestone timeline-cnt-'. esc_attr( $i ) .'"><div class="milestone-content">';
				if ( !empty( $item['title'] ) ) {
					echo '<div class="milestone-time">';
					if ( empty( $link_arr['url'] ) ) {
						echo '<a href="javascript:void(0)">'. esc_html( $item['title'] ) .'</a>';
					}else{
						echo '<a href="'. esc_url( $link_arr['url'] ) .'" '. esc_attr( $link_arr['other_atts'] ) .'>'. esc_html( $item['title'] ) .'</a>';
					}
					echo '</div>';
				}
				if ( !empty( $item['description'] ) ) {
					echo '<div class="milestone-text">'. wp_kses_post( nl2br( $item['description'] ) ) .'</div>';
				}
				if ( !empty( $item['image'] ) && $img_url = wp_get_attachment_url( $item['image'] ) ) {
					echo '<div class="milestone-img"><img src="'. esc_url( $img_url ) .'" alt=""></div>';
				}
				if ( !empty( $item['timeline'] ) ) {
					if ( !empty( $link_arr['url'] ) ) {
						echo '<a class="milestone-number" href="'. esc_url( $link_arr['url'] ) .'" '. esc_attr( $link_arr['other_atts'] ) .'>'. esc_html( $item['timeline'] ) .'</a>';
					} else {
						echo '<div class="milestone-number">'. esc_html( $item['timeline'] ) .'</div>';
					}
				}
				echo '</div></div>';

				/* custom css of item */
				if ( !empty( $item['timeline_color'] ) ) {
					$css = '
						.%1$s .timeline-cnt-%2$s .milestone-number{
							color: %3$s;
						}
					';
					$custom_css .= sprintf( $css, esc_attr( $block_class ), esc_attr( $i ), esc_attr( $item['timeline_color'] ) );
				}
				if ( !empty( $item['title_color'] ) ) {
					$css = '
						.%1$s .timeline-cnt-%2$s .milestone-time a{
							color: %3$s;
						}
					';
					$custom_css .= sprintf( $css, esc_attr( $block_class ), esc_attr( $i ), esc_attr( $item['title_color'] ) );
				}
				if ( !empty( $item['description_color'] ) ) {
					$css = '
						.%1$s .timeline-cnt-%2$s .milestone-text{
							color: %3$s;
						}
					';
					$custom_css .= sprintf( $css, esc_attr( $block_class ), esc_attr( $i ), esc_attr( $item['description_color'] ) );
				}
				/* end custom css of item */

				$i++;
			} // end foreach
		} // end if
		echo '</div>';
	echo '</div>';
}

if ( !empty( $data['milestone_point_color'] ) ) {
	$css = '
		.%1$s .slz-timeline .milestone:before {
			background-color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $block_class ), esc_attr( $data['milestone_point_color'] ) );
}
if ( !empty( $data['timeline_line_color'] ) ) {
	$css = '
		.%1$s .slz-timeline .milestone .milestone-content:before,
		.%1$s .slz-timeline:before {
			background-color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $block_class ), esc_attr( $data['timeline_line_color'] ) );
}

if ( !empty( $custom_css ) ) {
	do_action( 'slz_add_inline_style', $custom_css );
}