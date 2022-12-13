<?php
$class = 'style-1';
$css = $custom_css = '';
$i = 1;
$block_class = array(
	'style-1' => 'style-1',
	'style-2' => 'style-5 stl2',
	'style-3' => 'style-4 stl3',
	'style-4' => 'style-2 stl4',
	'style-5' => 'style-3 stl5',
);
if( isset($block_class[$data['style']])) {
	$class = $block_class[$data['style']];
}
if ( $data['style'] == 'style-4' ) {
	$items = (array) vc_param_group_parse_atts( $data['progress_bar_list_2'] );
	$param_default = array(
		'title'               => '',
		'percent'             => '',
		'progress_bar_color'  => '',
		'title_color'         => '',
		'percent_color'       => '',
	);
}else{
	$items = (array) vc_param_group_parse_atts( $data['progress_bar_list_1'] );
	$param_default = array(
		'title'               => '',
		'percent'             => '',
		'progress_bar_color'  => '',
		'title_color'         => '',
		'percent_color'       => '',
		'marker_color'        => '',
	);
}

if ( !empty( $items ) ) {
	foreach ($items as $item) {
		$item = array_merge( $param_default, $item );
?>
		<div class="slz-progress-bar-01 <?php echo esc_attr( $class ); ?>">
			<div class="progress-title">
				<?php
					if( !empty( $item['title'] ) ) :
				?>
					<span class="text progress-bar-text-<?php echo esc_attr( $i ); ?>"><?php echo esc_html( $item['title'] ); ?></span>
				<?php
					endif;
				?>
				<span data-from="0" data-to="" data-speed="1200" class="percent progress-bar-percent-<?php echo esc_attr( $i ); ?>"></span>
			</div>
			<div class="progress">
				<div role="progressbar" aria-valuenow="<?php echo esc_attr( $item['percent'] ); ?>" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-striped active progress-bar-<?php echo esc_attr( $i ); ?>" data-unit="<?php echo esc_attr( $data['unit'] ); ?>">
					<span data-from="0" data-to="" data-speed="1200" class="percent progress-bar-percent-<?php echo esc_attr( $i ); ?>"></span>
				</div>
			</div>
		</div>
<?php

		/* custom css */
		if ( !empty( $item['progress_bar_color'] ) ) {
			$css = '
				.%1$s .progress .progress-bar.progress-bar-%3$s {
					background-color: %2$s;
				}
			';
			$custom_css .= sprintf( $css, esc_attr( $data['block_class'] ), esc_attr( $item['progress_bar_color'] ), esc_attr( $i ) );
		}
		if ( !empty( $item['title_color'] ) ) {
			$css = '
				.%1$s .progress-title .text.progress-bar-text-%3$s {
					color: %2$s;
				}
			';
			$custom_css .= sprintf( $css, esc_attr( $data['block_class'] ), esc_attr( $item['title_color'] ), esc_attr( $i ) );
		}
		if ( !empty( $item['percent_color'] ) ) {
			$css = '
				.%1$s .percent.progress-bar-percent-%3$s {
					color: %2$s !important;
				}
			';
			$custom_css .= sprintf( $css, esc_attr( $data['block_class'] ), esc_attr( $item['percent_color'] ), esc_attr( $i ) );
		}
		if ( $data['style'] == 'style-4' ) {
			if ( !empty( $item['marker_color'] ) ) {
				$css = '
					.%1$s .percent.progress-bar-percent-%3$s {
						background-color: %2$s !important;
					}
					.%1$s .progress-bar-percent-%3$s.percent:after {
					    border-top: 5px solid %2$s !important;
					}
				';
				$custom_css .= sprintf( $css, esc_attr( $data['block_class'] ), esc_attr( $item['marker_color'] ), esc_attr( $i ) );
			}
		}

		$i++;

	}// end foreach

	if ( !empty( $custom_css ) ) {
		do_action('slz_add_inline_style', $custom_css);
	}

}// end if