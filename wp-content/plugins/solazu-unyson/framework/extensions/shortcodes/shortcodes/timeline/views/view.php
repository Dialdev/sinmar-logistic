<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$block_class = 'timeline-'.SLZ_Com::make_id();
$block_cls = $block_class.' '.$data['extra_class']. ' ';
$data['block_class'] = $block_class;
if ( is_plugin_active( 'js_composer/js_composer.php' ) ) {

	if ( !empty($data['layout']) && $data['layout'] == 'layout-2' ) {
		echo slz_render_view( $instance->locate_path('/views/layout-2.php'), compact('data'));
	}else {
		echo slz_render_view( $instance->locate_path('/views/layout-1.php'), compact('data'));
	}
}else{
	echo esc_html__('Please Active Visual Composer', 'slz');
}