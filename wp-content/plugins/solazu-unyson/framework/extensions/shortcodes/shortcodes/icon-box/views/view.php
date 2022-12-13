<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$block_class = 'icon_box-'.SLZ_Com::make_id();
$block_cls = $block_class.' '.$data['extra_class'];
$data['block_class'] = $block_class;

$class_column = '';
if(  $data['column'] == 1 ){
    $class_column = 'slz-column-1';
}
else if(  $data['column'] == 2 ){
    $class_column = 'slz-column-2';
}
else if(  $data['column'] == 3 ){
    $class_column = 'slz-column-3';
}
else if(  $data['column'] == 4 ){
    $class_column = 'slz-column-4';
}else{
	$class_column = '';
}

if( !isset($data['delay_animation'])) {
	$data['delay_animation'] = '';
}
if( !isset($data['item_animation'])) {
	$data['item_animation'] = '';
}
//check show number
if(!empty($data['show_number'])){
    $number_class = 'has_number';
}else{
    $number_class = '';
}

if ( is_plugin_active( 'js_composer/js_composer.php' ) ) {
	echo '<div class="slz_shortcode sc_icon_box '.esc_attr( $block_cls ).' '.esc_attr($number_class).'">';

	if ( $data['layout'] == 'layout-1' ) {
		echo slz_render_view( $instance->locate_path('/views/layout-1.php'), compact('data', 'class_column'));
	}elseif ( $data['layout'] == 'layout-2' ) {
		echo slz_render_view( $instance->locate_path('/views/layout-2.php'), compact('data', 'class_column'));
	}

	echo '</div>';
}else{
	echo esc_html__('Please Active Visual Composer', 'slz');
}
