<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Forbidden' ); }

$model = new SLZ_Gallery();
if( !empty($data['gallery']) || !empty($data['portfolio'])) {
	if($data['post_type'] == 'slz-gallery'){
		$data['post_id'] = array($data['gallery']);
	}else{
		$data['post_id'] = array($data['portfolio']);
	}
}

$model->init( $data );

$uniq_id = $model->attributes['uniq_id'];
$block_cls = $model->attributes['extra_class'] . ' ' . $uniq_id;
$data['model'] = $model;
$data['block_cls'] = $block_cls;
$data['uniq_id'] = $uniq_id;

$slidesToShow = absint($data['slidetoshow']);

if( empty($slidesToShow) ) {
	$slidesToShow = 5;
}
if( $data['model']->post_count == 0 ) return;
$data['slidetoshow'] = $slidesToShow;
$data['slide_dots']  = ( $data['slide_dots'] == 'yes' ) ? true : false;
$data['slide_arrows']  = ( $data['slide_arrows'] == 'yes' )?  true : false;
$data['slide_autoplay']  = ( $data['slide_autoplay'] == 'yes' )?  true : false;
$data['slide_infinite']  = ( $data['slide_infinite'] == 'yes' )?  true : false;

switch ( $data['layout'] ) {
	case 'layout-1':
		echo slz_render_view( $instance->locate_path( '/views/layout-1.php' ), compact('data'));
		break;
	case 'layout-2':
		echo slz_render_view( $instance->locate_path( '/views/layout-2.php' ), compact('data'));
		break;
	case 'layout-3':
		echo slz_render_view( $instance->locate_path( '/views/layout-3.php' ), compact('data'));
		break;
	case 'layout-4':
		echo slz_render_view( $instance->locate_path( '/views/layout-4.php' ), compact('data'));
		break;
	case 'layout-5':
		echo slz_render_view( $instance->locate_path( '/views/layout-5.php' ), compact('data'));
		break;
	default:
		echo slz_render_view( $instance->locate_path( '/views/layout-1.php' ), compact('data'));
		break;
}
