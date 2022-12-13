<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

class SLZ_Shortcode_Category extends SLZ_Shortcode
{
	protected function _render($atts, $content = null, $tag = '', $ajax = false)
	{
		$this->enqueue_static();
		$unique_id = SLZ_Com::make_id();
		$defaults = $this->get_config('default_value');
		$atts = shortcode_atts( $defaults, $atts );
		// Get posttype slug
        $posttype_slug = $atts['posttype_slug'];
        // Get taxonomy
        $taxonomy = ( $posttype_slug == 'slz-posts' ) ? 'category' : $posttype_slug.'-cat';
        // Get Category slug
        $ids = array();
        if( function_exists('vc_param_group_parse_atts')) {
			$category_slug = (array) vc_param_group_parse_atts( $atts[str_replace( '-', '_', $posttype_slug.'_list_choose' )] );
			foreach ($category_slug as $key => $value) {
				if ( ! empty ( $value ) )
				{
				    $obj = SLZ_Com::get_tax_options_by_slug( $value, $taxonomy );
				    $ids[] = $obj->term_id;
				}
			}
         }
		$id = join(',', $ids);
		$args = array(
			'childless' => true
		);
		if ( !empty ( $id ) ) {
            $args['include'] = $id;
        }
		if ( !empty ( $atts['order_sort'] ) ){ 
			$args['order'] = $atts['order_sort'];
		}
		if ( !empty ( $atts['sort_by'] ) ){ 
			$args['orderby'] = $atts['sort_by'];
		}
		if ( !empty ( $atts['number'] ) && is_numeric( $atts['number'] )){ 
			$args['number'] = $atts['number'];
		}
		else {
			$args['number'] = 20;
		}
		if ( !empty ( $atts['offset_cat'] ) ){ 
			$args['offset'] = $atts['offset_cat'];
		}
		$categories = array();
		$categories = get_terms( $taxonomy, $args );
		$style = '';
		$css = '';
		if ( !empty( $atts['block_title_color'] ) && $atts['block_title_color'] != '#'  ) {
			$style ='.slz-categories.category-%1$s .%3$s{ color: %2$s; }';
			$css .= sprintf( $style, esc_attr( $unique_id ), esc_attr( $atts['block_title_color'] ), esc_attr( $atts['block_title_class'] ) );
			do_action( 'slz_add_inline_style', $css );
		}
		return slz_render_view($this->locate_path('/views/view.php'), compact( 'atts', 'categories', 'unique_id' ));
	}

}
