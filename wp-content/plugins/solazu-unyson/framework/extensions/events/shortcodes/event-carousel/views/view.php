<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Forbidden' ); }

switch ( $data['layout'] ) {
	case 'layout-1':
		$data['image_size'] = array(
			'large'           => '341x257',
			'no-image-large'  => '341x257'
		);
		break;
	case 'layout-2':
		$data['image_size'] = array(
			'large'           => '360x148',
			'no-image-large'  => '360x148'
		);
		break;
	default:
		break;
}

$model = new SLZ_Event();
$model->init( $data );

$uniq_id = $model->attributes['uniq_id'];
$block_cls = $model->attributes['extra_class'] . ' ' . $uniq_id;

if( ! $model->query->have_posts() ) {
    return;
}
?>
<div class="slz-shortcode event-slider sc_event_carousel <?php echo esc_attr( $block_cls ); ?>">
	<?php if( !empty( $data['title'] ) ): ?>
    <div class="slz-title-shortcode"><?php echo $data['title']; ?></div>
    <?php endif; ?>
    <?php
    switch ( $model->attributes['layout'] ) {
        case 'layout-1':
	        echo slz_render_view( $instance->locate_path('/views/layout-1.php'), compact('model', 'data'));
            break;
        case 'layout-2':
	        echo slz_render_view( $instance->locate_path('/views/layout-2.php'), compact('model', 'data'));
            break;
    }
    ?>
</div>
