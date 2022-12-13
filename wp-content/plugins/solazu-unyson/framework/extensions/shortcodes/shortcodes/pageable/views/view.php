<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}
$uniq_id = 'pageable-'.SLZ_Com::make_id();
$block_class = $uniq_id . ' ' . $data['extra_class'];
$shortcode = slz_ext( 'shortcodes' )->get_shortcode('pageable');
if ( is_plugin_active( 'js_composer/js_composer.php' ) ) {
	if ( !empty( $data['content'] ) ) {
		$data['content'] = wpb_js_remove_wpautop( $data['content'] );
	?>
		<div class="slz_shortcode slz-pageable  <?php echo esc_attr( $block_class ); ?>">
			<?php 
			switch ($data['style']) {
				case 'style-1':?>
					<div class="slz-horizontal-scroll">
			            <div class="horizontal-wrapper">
			            	<?php echo ( $data['content'] ); ?>
			            </div>
			        </div>
					<?php break;

				case 'style-2':?>
					<div class="slz-absolute-wrapper">
			            <?php echo ( $data['content'] ); ?>
			        </div>
					<?php break;

				default:
					break;
			}?>
	    </div>
	<?php
		$custom_css = $css = '';
		
		if( !empty($data['bottom'])) {
			$css = '
				.%1$s .slz-absolute-wrapper{
					bottom: %2$s !important;
				}
			';
			$custom_css .= sprintf( $css, esc_attr($uniq_id), esc_attr( $data['bottom'] ) );
		}
	
		if ( !empty( $custom_css ) ) {
			do_action('slz_add_inline_style', $custom_css);
		}
	}

}else{
	echo esc_html__( 'Please active Visual Composer plugin to use this shortcode.', 'slz' );
}