<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$block_class = 'tabs-'.SLZ_Com::make_id();
$data['block_cls'] = $block_class.' '.$data['extra_class'];
$css = $custom_css = $tab = '';
$x = 0;
$class = '';

$shortcode = slz_ext( 'shortcodes' )->get_shortcode('tabs');
$icon_default_value  = $shortcode->get_config('icon_default_value');

if ( is_plugin_active( 'js_composer/js_composer.php' ) ) {

	if ( !empty( $data['content'] ) ) {
		$section_tab_info = array();

		$arr = explode("[/vc_tta_section]", $data['content']);

		if ( !empty( $arr ) ) {
			$data['tab_array'] = array();
			$tab .= '<ul role="tablist" class="tab-list">';
			foreach ($arr as $shortcode) {
				if ( empty( $shortcode ) ) {
					continue;
				}else{
					$t         = array();
					$i         = array();
					$a         = array();
					$i_type    = $add_icon = $icon = $icon_group =array();
					$title     = '';
					$tab_id    = '';
					$image     = '';

					preg_match( '/title="([^"]*)"/i', $shortcode, $t ) ;
					preg_match( '/tab_id="([^"]*)"/i', $shortcode, $i ) ;
					preg_match( '/vc_tta_section image="([^"]*)"/i', $shortcode, $a );
					preg_match( '/add_icon="([^"]*)"/i', $shortcode, $add_icon ) ;

					if(!empty($add_icon) && $add_icon[1] == 'true'){

						preg_match( '/i_type="([^"]*)"/i', $shortcode, $i_type ) ;
						if(!empty($i_type)){

							preg_match( '/i_icon_typicons="([^"]*)"/i', $shortcode, $icon ) ;
							
							$icon_group['i_type'] = $i_type[1];
							if(!empty($icon)){
								$icon_group['i_icon_'.$i_type[1]] =  $icon[1];
							}
						}

						$icon_group = array_merge($icon_default_value,$icon_group);
						
					}

					
					if(!empty($t)){
						$title  .= $t[1];
					}
					if(!empty($i)){
						$tab_id .= $i[1];
					}
					if(!empty($a)){
						$image .= $a[1];
					}
					if ( $x == 0 ) {
						$class = 'active';
					}else{
						$class = '';
					}

					$li_class = (!empty($image))? 'tab-image' : '';
					$tab .= '
						<li role="presentation" class="'.esc_attr( $class ).' '.esc_attr($li_class).'">
							<a href="#tab-'.esc_attr( $tab_id ).'" role="tab" data-toggle="tab" class="link">';

						if($data['style'] == 'style-1'){

							if(!empty($icon_group)){

								$tab .= '<i class="slz-icon '.esc_attr($icon_group['i_icon_'.$icon_group['i_type']]).'"></i>';

							}else if ( !empty( $image ) ) {

								$tab .= '<img src="'. esc_url( wp_get_attachment_url( $image ) ) .'" alt="" class="img-full">';

							}
							$tab .= esc_html( $title );
						}else{
							
							if(!empty($icon_group)){

								$tab .= '<i class="slz-icon '.esc_attr($icon_group['i_icon_'.$icon_group['i_type']]).'"></i>';

							}else if ( !empty( $image ) ) {

								$tab .= '<img src="'. esc_url( wp_get_attachment_url( $image ) ) .'" alt="" class="img-full">';

							}
							$tab .= esc_html( $title );
						}
						
						
					$tab .= '
							</a>
						</li>
					';
					array_push($data['tab_array'], array($title, $tab_id));
					$x++;
				}

			}// end foreach

			$tab .= '</ul>';
			$data['tab'] = $tab;

		}

		if ( !empty( $data['tab_text_color'] ) ) {
			$css = '
				.%1$s .tab-list li a{
					color: %2$s !important;
				}
			';
			$custom_css .= sprintf( $css, esc_attr( $block_class ), $data['tab_text_color'] );
		}
		if( !empty( $data['tab_active_text_color'] ) ) {
			$css = '
				.%1$s .tab-list li.active a{
					color: %2$s !important;
				}
			';
			$custom_css .= sprintf( $css, esc_attr( $block_class ), $data['tab_active_text_color'] );
		}

		// icon

		if ( !empty( $data['icon_color'] ) ) {
			$css = '
				.%1$s .tab-list li i{
					color: %2$s !important;
				}
			';
			$custom_css .= sprintf( $css, esc_attr( $block_class ), $data['icon_color'] );
		}
		if ( !empty( $data['icon_hv_color'] ) ) {
			$css = '
				.%1$s .tab-list li:hover i{
					color: %2$s !important;
				}
			';
			$custom_css .= sprintf( $css, esc_attr( $block_class ), $data['icon_hv_color'] );
		}
		if ( !empty( $data['icon_bg_color'] ) ) {
			$css = '
				.%1$s .tab-list li i{
					background-color: %2$s !important;
				}
			';
			$custom_css .= sprintf( $css, esc_attr( $block_class ), $data['icon_bg_color'] );
		}
		if ( !empty( $data['icon_bg_hv_color'] ) ) {
			$css = '
				.%1$s .tab-list li:hover i{
					background-color: %2$s !important;
				}
			';
			$custom_css .= sprintf( $css, esc_attr( $block_class ), $data['icon_bg_hv_color'] );
		}

		if( !empty( $custom_css ) ) {
			do_action('slz_add_inline_style', $custom_css);
		}

		/*------end add inline css------*/
		$data['content'] = wpb_js_remove_wpautop( $data['content'] );
		switch ( $data['style'] ) {
			case 'style-1':
				echo slz_render_view( $instance->locate_path('/views/style-1.php'), compact('data'));
				break;
			case 'style-2':
				echo slz_render_view( $instance->locate_path('/views/style-2.php'), compact('data'));
				break;
			default:
				echo slz_render_view( $instance->locate_path('/views/style-1.php'), compact('data'));
				break;
		}

	}// end if

}else{
	echo esc_html__( 'Please Active Visual Composer', 'slz' );
}