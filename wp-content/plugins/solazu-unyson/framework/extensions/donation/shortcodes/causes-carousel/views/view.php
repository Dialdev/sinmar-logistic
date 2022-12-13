<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Forbidden' ); }

$model = new SLZ_Causes();
$model->init( $data );

$uniq_id = $model->attributes['uniq_id'];
$block_cls = $model->attributes['extra_class'] . ' ' . $uniq_id;
$data['block_cls'] = $block_cls;
$data['uniq_id'] = $uniq_id;
$data['model'] = $model;

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