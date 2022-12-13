<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}


$data['id'] = SLZ_Com::make_id();
$block_class = 'audio-'.$data['id'];
$block_cls = $block_class.' '.$data['extra_class'];
$data['block_class'] = $block_class;

if ( is_plugin_active( 'js_composer/js_composer.php' ) ) {
    echo '<div class="slz-sc-audio">';
	echo '<div class="slz_shortcode sc_audio '.esc_attr( $block_cls ).'">';

	switch ( $data['layout'] ) {
		case 'layout-1':
			echo slz_render_view( $instance->locate_path('/views/layout-1.php'), compact('data'));
			break;
		case 'layout-2':
			echo slz_render_view( $instance->locate_path('/views/layout-2.php'), compact('data'));
			break;
        case 'layout-3':
            echo slz_render_view( $instance->locate_path('/views/layout-3.php'), compact('data'));
            break;
		default:
			echo slz_render_view( $instance->locate_path('/views/layout-1.php'), compact('data'));
			break;
	}

    echo '</div>';
    echo '</div>';
}else{
	echo esc_html__('Please Active Visual Composer', 'slz');
}
