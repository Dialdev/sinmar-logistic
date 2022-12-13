<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}
if ( ! is_plugin_active( 'js_composer/js_composer.php' ) ) {
	return;
}

$block_class = 'counter-'.SLZ_Com::make_id();
$block_cls = $block_class .' '.$data['extra_class']. ' ';
$data['block_class'] = $block_class;
$data['counter_items'] = (array) vc_param_group_parse_atts( $data['counter_items'] );
$data['column'] = absint($data['column']);
if( !empty($data['column']) ) {
	$block_cls .= ' slz-column-' . $data['column'];
}
if( empty($data['counter_items']) ) return;
if ( is_plugin_active( 'js_composer/js_composer.php' ) ) {
	echo '<div class="slz_shortcode slz-list-block slz-list-column sc_counter '.esc_attr( $block_cls ).'">';
	switch ( $data['layout'] ) {
		case 'layout-1':
			echo slz_render_view( $instance->locate_path('/views/layout-1.php'), compact('data'));
			break;
		case 'layout-2':
			echo slz_render_view( $instance->locate_path('/views/layout-2.php'), compact('data'));
			break;
		default:
			echo slz_render_view( $instance->locate_path('/views/layout-1.php'), compact('data'));
			break;
	}
	echo '</div>';
}else{
	echo esc_html__('Please Active Visual Composer', 'slz');
}