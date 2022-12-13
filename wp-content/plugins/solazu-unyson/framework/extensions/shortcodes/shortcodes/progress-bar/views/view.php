<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}


$class = '';
$data['id'] = SLZ_Com::make_id();
$block_class = 'progress-bar-'.$data['id'];
$class = '';
if ( $data['layout'] == 'layout-2' ) {
	$class = 'text-c';
}
$block_cls = $block_class.' '.$data['extra_class']. ' ' . $class;
$data['block_class'] = $block_class;
$css = $custom_css = '';

if ( is_plugin_active( 'js_composer/js_composer.php' ) ) {
	echo '<div class="slz_shortcode sc_progress_bar '.esc_attr( $block_cls ).'">';

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
