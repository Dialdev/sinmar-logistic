<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Forbidden' ); }


$model = new SLZ_Gallery();
$model->init( $data );
$class_col = '';
$css = $custom_css = '';
$data['uniq_id'] = $model->attributes['uniq_id'];
$data['block_cls'] = $model->attributes['extra_class'] . ' ' . $data['uniq_id'];
$data['model'] = $model;

switch ( $data['layout'] ) {
	case 'layout-1':
		echo slz_render_view( $instance->locate_path( '/views/layout-1.php' ), compact('data'));
		break;
	case 'layout-2':
		echo slz_render_view( $instance->locate_path( '/views/layout-2.php' ), compact('data'));
		break;
	default:
		echo slz_render_view( $instance->locate_path( '/views/layout-1.php' ), compact('data'));
		break;
}