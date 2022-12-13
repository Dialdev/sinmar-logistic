<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Forbidden' ); }

$model = new SLZ_Testimonial();
$model->init( $data );
$uniq_id = $model->attributes['uniq_id'];
$block_cls = $model->attributes['extra_class'] . ' ' . $uniq_id;
$css = $custom_css = '';

$data['uniq_id'] = $uniq_id;
$data['block_cls'] = $block_cls;
$data['model'] = $model;
$slidesToShow = absint($data['num_item_show']);

if( empty($slidesToShow) ) {
	$slidesToShow = 5;
}
if( $slidesToShow >= $data['model']->post_count ) {
	if( $data['show_arrows'] == 'yes' || $data['show_dots'] == 'yes') {
		$slidesToShow = $data['model']->post_count - 1;
	} else if( $slidesToShow > $data['model']->post_count ) {
		$slidesToShow = $data['model']->post_count;
	}
}
if( $data['model']->post_count == 0 ) return; 
$data['slidesToShow'] = $slidesToShow;
$data['show_dots']  = ( $data['show_dots'] == 'yes' ) ? true : false;
$data['show_arrows']  = ( $data['show_arrows'] == 'yes' )?  true : false;
$data['slide_speed']  = absint($data['slide_speed']);
$data['slide_autoplay']  = ( $data['slide_autoplay'] == 'yes' )?  true : false;
$data['slide_infinite']  = ( $data['slide_infinite'] == 'yes' )?  true : false;

if( $data['layout'] == 'layout-5' ) {
    $data['slidesToShow'] = $data['column'];
}

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
	case 'layout-4':
	    echo slz_render_view( $instance->locate_path('/views/layout-4.php'), compact('data'));
	    break;
	case 'layout-5':
	    echo slz_render_view( $instance->locate_path('/views/layout-5.php'), compact('data'));
	    break;
	case 'layout-6':
	    echo slz_render_view( $instance->locate_path('/views/layout-6.php'), compact('data'));
	    break;
    default:
        echo slz_render_view( $instance->locate_path('/views/layout-1.php'), compact('data'));
        break;
}
