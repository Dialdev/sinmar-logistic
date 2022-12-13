
<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}
$shortcode = slz_ext( 'shortcodes' )->get_shortcode('button');
$param_default  = $shortcode->get_config('param_group_default');

if ( ! is_plugin_active( 'js_composer/js_composer.php' ) ) {
	return;
}
if ( !empty( $data['btn'] ) ) {
$items = (array) vc_param_group_parse_atts( $data['btn'] );
$alignment = $data['alignment'];
    if ( !empty( $items ) ) {
        echo '<div class="' . esc_attr($alignment) .'">';
        foreach ($items as $item) {
        	$item = array_merge( $param_default, $item );
            if(!empty($item['box_shadow'])){
                $item['extra_class']  .= ' box-shadow';
            }
            if(!empty($item['icon_box_shadow'])){
                $item['icon_extra_class']  .= ' icon-box-shadow';
            }
            $item['button_class']  = 'button_box-'.SLZ_Com::make_id();
            switch ( $item['layout'] ) {
                case 'layout-1':
                    echo slz_render_view( $instance->locate_path('/views/layout-1.php'), compact('item'));
                    break;
                case 'layout-2':
                    echo slz_render_view( $instance->locate_path('/views/layout-2.php'), compact('item'));
                    break;
                case 'layout-3':
                    echo slz_render_view( $instance->locate_path('/views/layout-3.php'), compact('item'));
                    break;
                default:
                    echo slz_render_view( $instance->locate_path('/views/layout-1.php'), compact('item'));
                    break;
            }
        }//end foreach
        echo "</div>";
    
    }//end if
}