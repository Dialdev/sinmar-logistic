<?php
$i = 1;
$x = 0;
$col = '';
$custom_css = $css = '';

switch ( $data['column'] ) {
	case '1':
		$col = 'slz-column-1';
		break;
	case '2':
		$col = 'slz-column-2';
		break;
	case '3':
		$col = 'slz-column-3';
		break;
	case '4':
		$col = 'slz-column-4';
		break;
	default:
		$col = 'slz-column-1';
		break;
}

$param_default = array(
	'title'               => '',
	'percent'             => '',
	'des'                 => '',
	'line_width'          => '5',
	'track_width'         => '1',
	'progress_bar_color'  => '',
	'track_circle_color'  => '',
	'title_color'         => '',
	'percent_color'       => '',
	'des_color'           => '',
);
$column = absint($data['column']); 
if ( !empty( $data['progress_bar_list_3'] ) ) {
	$items = (array) vc_param_group_parse_atts( $data['progress_bar_list_3'] );

	if ( !empty( $items ) ) {
		if( $column ) {
			echo '<div class="slz-list-block slz-list-column '.esc_attr( $col ).'">';
		}
		foreach ($items as $item) {
			$item = array_merge( $param_default, $item );
		?>
		<div class="item">
			<div class="slz-progress-bar-02" data-unit="<?php echo esc_attr( $data['unit'] ); ?>">
				<div data-percent="<?php echo esc_attr( $item['percent'] ); ?>" data-block-class="<?php echo esc_attr( $data['block_class'] ); ?>-<?php echo esc_attr( $i ); ?>" data-plugin-options="{&quot;trackColor&quot;:&quot;<?php echo esc_attr( $item['track_circle_color'] ) ?>&quot;,&quot;barColor&quot;:&quot;<?php echo esc_attr( $item['progress_bar_color'] ); ?>&quot;,&quot;lineWidth&quot;:&quot;<?php echo esc_attr( $item['line_width'] ); ?>&quot;,&quot;lineWidthCircle&quot;:&quot;<?php echo esc_attr( $item['track_width'] ); ?>&quot;}" class="progress-circle <?php echo esc_attr( $data['block_class'] ); ?>-<?php echo esc_attr( $i ); ?>">
					<canvas id="circle-<?php echo esc_attr( $data['block_class'] ) ?>-<?php echo esc_attr( $i ) ?>" width="150" height="150" class="circle"></canvas>
					<span data-from="0" data-to="" data-speed="1500" class="percent progress-bar-percent-<?php echo esc_attr( $i ); ?>"></span>
				</div>
				<div class="progress-content">
					<?php
					if( !empty( $item['title'] ) ) :
					?>
						<div class="title progress-bar-title-<?php echo esc_attr( $i ); ?>"><?php echo esc_html( $item['title'] ); ?></div>
					<?php
					endif;
					?>
					<?php
					if( !empty( $item['des'] ) ):
					?>
						<div class="description progress-bar-des-<?php echo esc_attr( $i ); ?>"><?php echo wp_kses_post( nl2br( $item['des'] ) ); ?></div>
					<?php
					endif;
					?>
				</div>
			</div>
		</div>

		<?php
			if ( !empty( $item['title_color'] ) ) {
				$css = '
					.%1$s .progress-content .title.progress-bar-title-%3$s {
						color: %2$s;
					}
				';
				$custom_css .= sprintf( $css, esc_attr( $data['block_class'] ), esc_attr( $item['title_color'] ), esc_attr( $i ) );
			}
			if ( !empty( $item['des_color'] ) ) {
				$css = '
					.%1$s .progress-content .description.progress-bar-des-%3$s {
						color: %2$s;
					}
				';
				$custom_css .= sprintf( $css, esc_attr( $data['block_class'] ), esc_attr( $item['des_color'] ), esc_attr( $i ) );
			}

			if ( !empty( $item['percent_color'] ) ) {
				$css = '
					.%1$s .percent.progress-bar-percent-%3$s {
						color: %2$s;
					}
				';
				$custom_css .= sprintf( $css, esc_attr( $data['block_class'] ), esc_attr( $item['percent_color'] ), esc_attr( $i ) );
			}

			$i++;
			$x++;
		}// end foreach
		if ( !empty( $custom_css ) ) {
			do_action('slz_add_inline_style', $custom_css);
		}
		if( $column ) {
			echo '</div>'; // close row
		}
	}// end if
}
