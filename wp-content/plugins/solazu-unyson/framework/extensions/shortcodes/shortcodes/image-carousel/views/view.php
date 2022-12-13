<?php if ( ! defined( 'ABSPATH' ) ) {
    die( 'Forbidden' );
}
$data['id'] = SLZ_Com::make_id();
$block_class = 'image-carousel-'.$data['id'];
$block_cls = $block_class.' '.$data['extra_class']. ' ';
$data['block_class'] = $block_class;
$class_layout = 'sc-image-carousel-'. $data['layout'];

$slidesToShow = absint($data['slidetoshow']);

if( empty($slidesToShow) ) {
	$slidesToShow = 5;
}
$data['slidetoshow'] = $slidesToShow;
$data['arrow']  = ( $data['arrow'] == 'yes' ) ? true : false;
$data['dots']  = ( $data['dots'] == 'yes' )?  true : false;
$data['slide_autoplay']  = ( !empty($data['slide_autoplay']) && $data['slide_autoplay'] == 'yes' )?  true : false;
$data['slide_infinite']  = ( !empty($data['slide_infinite']) && $data['slide_infinite'] == 'yes' )?  true : false;



if ( is_plugin_active( 'js_composer/js_composer.php' ) ) {
	if( !empty( $data['img_slider'] ) ) {
		echo '<div class="sc_image_carousel '. esc_attr( $block_cls ) .' '. esc_attr( $class_layout ) .'">';
			switch ( $data['layout'] ) {
				case 'layout-1':
					echo slz_render_view( $instance->locate_path('/views/layout-1.php'), compact( 'data' ) );
					break;
				case 'layout-2':
					echo slz_render_view( $instance->locate_path('/views/layout-2.php'), compact( 'data' ) );
					break;
				case 'layout-3':
					echo slz_render_view( $instance->locate_path('/views/layout-3.php'), compact( 'data' ) );
					break;
				default:
					echo slz_render_view( $instance->locate_path('/views/layout-1.php'), compact( 'data' ) );
					break;
			}
		echo '</div>';
	}
}else{
	echo esc_html__('Please Active Visual Composer', 'slz');
}