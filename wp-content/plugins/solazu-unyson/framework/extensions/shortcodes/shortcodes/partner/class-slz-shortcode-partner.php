<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

class SLZ_Shortcode_Partner extends SLZ_Shortcode
{
	protected function _render($atts, $content = null, $tag = '', $ajax = false)
	{
		if ( !is_plugin_active( 'js_composer/js_composer.php' ) ) {
			echo esc_html__('Please Active Plugin Visual Composer', 'slz');
			return '';
		}


        $view_path = $this->locate_path('/views');

		if( !$ajax ){
		    $data = $this->get_data( $atts );
		} else {
		    $data = $atts;
		}
		if ( !empty($data['gr_list_item']) && function_exists('vc_param_group_parse_atts')) {
			$data['gr_list_item_arr'] = (array) vc_param_group_parse_atts( $data['gr_list_item'] );
		}

		if ( empty($data['layout']) && empty($data['style']) && empty($data['extra_class']) ) {
			return '';
		}

		$layout_class = 'layout-'. $data['layout'];
		$style_class = 'style-'. $data['style'];

		$padding_class = '';
		if ( !empty($data['item_padding']) && $data['item_padding'] != 'yes' ) {
			$padding_class = 'no-padding';
		}

		$data['id'] = SLZ_Com::make_id();
		$data['uniq_id'] = 'partner-'.$data['id'];
		$data['block_class'] = $data['extra_class'] . ' ' . $data['uniq_id'] . ' ' . $layout_class . ' ' . $style_class . ' ' . $padding_class;

		$this->enqueue_static();

		return slz_render_view($this->locate_path('/views/view.php'), array( 'data' => $data, 'view_path' => $view_path, 'instance' => $this ) );
	}

	public static function render_partner_item_sc ( $data = array(), $html_options = array() ) {
		if ( !empty($data['gr_list_item_arr']) ) {
			foreach ($data['gr_list_item_arr'] as $key => $item) {
				if ( !empty($item['item_image']) ) {
					$get_attached_file = get_attached_file($item['item_image']);
					if ( !file_exists($get_attached_file) ) {
						continue;
					}
				} else {
					continue;
				}

				$imgAttr = array();
				$imgAttr['class'] = 'img-responsive';
				$link_arr = array(
					'url'    => '',
					'title'  => '',
					'target' => '',
					'rel'    => '',
					'other_atts' => '',
				);
				if ( !empty($item['item_link']) ) {
					$link_arr = SLZ_Util::parse_vc_link( $item['item_link'] );
				}
				if ( !empty($link_arr['title']) ) {
					$imgAttr['alt'] = $link_arr['title'];
				}
				if ( !empty($item['item_title']) ) {
					$imgAttr['alt'] = $item['item_title'];
				}
				$item_link = !empty($link_arr['url']) ? esc_url($link_arr['url']) : 'javascript:;';

				$thumb_img = wp_get_attachment_image( $item['item_image'], 'full', false, $imgAttr );
				printf('<div class="item">
							<a href="%2$s" class="link" %3$s>%1$s</a>
						</div>',
						$thumb_img,
						$item_link,
						wp_kses_post($link_arr['other_atts'])
					);
			}
		}
	}

}
