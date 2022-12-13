<?php if ( ! defined( 'SLZ' ) ) {
	die( 'Forbidden' );
}


$block_class = 'icon_box-'.SLZ_Com::make_id();
$block_cls = $block_class.' '.$data['extra_class'];
$data['block_class'] = $block_class;
$class_column = '';
if( $data['column'] == '1' ) {
	$class_column = 'col-md-12';
}elseif ( $data['column'] == '2' ) {
	$class_column = 'col-md-6';
}elseif ( $data['column'] == '3' ) {
	$class_column = 'col-md-4';
}elseif ( $data['column'] == '4' ){
	$class_column = 'col-md-3';
}else{
	$class_column = '';
}

if ( is_plugin_active( 'js_composer/js_composer.php' ) ) {
	echo '<div class="slz_shortcode sc_icon_box '.esc_attr( $block_cls ).'">';
    echo slz_render_view( $instance->locate_path('/views/layout-1.php'), compact('data', 'class_column'));

	echo '</div>';
}else{
	echo esc_html__('Please Active Visual Composer', 'transera');
}
