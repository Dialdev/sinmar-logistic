<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Forbidden' ); }


if ( is_plugin_active( 'js_composer/js_composer.php' ) ) {

	$term_arr = array();
	$model = new SLZ_Portfolio();
	$term_arr = $model->init_term( $data );

	if ( !empty( $term_arr ) ) {

		$css = $custom_css = '';
		$data['id'] = SLZ_Com::make_id();
		$block_class = 'project-category-'.$data['id'];
		$block_cls = $block_class.' '.$data['extra_class'];
		$out_html = '';
		$total = 0;
		foreach ( $term_arr as $term ) {
			if( empty( $term ) ) {
				continue;
			}
			$total += $term->count;
			$out_html .= slz_render_view( $instance->locate_path('/views/module.php'), compact( 'term' ) );
		}
		if( $out_html ) {
			echo '<div class="sc_project_category slz-shortcode '. esc_attr( $block_cls ) .'">';
				echo '
					<div class="slz-carousel-wrapper slz-project-category-carousel">
						<div class="carousel-overflow">
							<div data-slidestoshow="'. esc_attr( $data['slide_to_show'] ) .'" data-slidetoscroll="'. esc_attr( $data['slide_to_scroll'] ) .'" data-arrow="'. esc_attr( $data['arrow'] ) .'" data-dots="'. esc_attr( $data['dots'] ) .'" class="slz-carousel" style="margin-left:0;">
								<div class="item">
									<div class="slz-counter-item-1">
										<div class="content-cell">
											<div class="number">'. esc_html( $total ).'</div>
											<div class="title">'.esc_html__('All', 'slz') .'</div>
											<a href="'. esc_url($model->get_archive_link()).'" ></a>
										</div>
									</div>
								</div>
									' . $out_html .'
							</div>
						</div>
					</div>
				';
			echo '</div>';

			/* CUSTOM CSS */
			if ( !empty( $data['project_name_color'] ) ) {
				$css = '
					.%1$s  .title {
						color: %2$s;
					}
				';
				$custom_css .= sprintf( $css, esc_attr( $block_class ), esc_attr( $data['project_name_color'] ) );
			}
			if ( !empty( $data['project_number_color'] ) ) {
				$css = '
					.%1$s.sc_project_category .slz-counter-item-1 .content-cell .number {
						color: %2$s;
					}
				';
				$custom_css .= sprintf( $css, esc_attr( $block_class ), esc_attr( $data['project_number_color'] ) );
			}
			if ( !empty( $custom_css ) ) {
				do_action('slz_add_inline_style', $custom_css);
			}
		}
	}

}// check active visual compoer
