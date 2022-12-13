<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Forbidden' ); } ?>

<div class="slz_shortcode sc_partner <?php echo esc_attr( $data['block_class'] ); ?>" data-item="<?php echo esc_attr($data['uniq_id']); ?>">
	<?php
	switch ( $data['layout'] ) {
		case 'layout-1':
			echo slz_render_view( $instance->locate_path('/views/layout-1.php'), compact('data'));
			break;
		case 'layout-2':
			echo slz_render_view( $instance->locate_path('/views/layout-2.php'), compact('data'));
			break;
		default:
			echo esc_html__( 'Please choose another style to show', 'slz' );
			break;
	}
	?>
</div>