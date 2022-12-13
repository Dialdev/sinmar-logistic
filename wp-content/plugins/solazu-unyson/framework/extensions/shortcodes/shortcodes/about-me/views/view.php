<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

?>

<div class="slz-shortcode sc_about_me <?php echo  ( !empty ( $data['extra_class'] ) ? esc_attr( $data['extra_class'] ) : '' ) . ' block-' . esc_attr( $block_id ); ?>">

<?php
	
if ($data['block_title'] != '') {
	echo '<div class="' . esc_attr( $data['block_title_class'] ) . '">' . esc_html($data['block_title']) . '</div>';
}
?>
	<?php 
	if ( is_plugin_active( 'js_composer/js_composer.php' ) ) {
		if( $data['layout'] == 'layout-1' ) {
			echo '<div class="slz-about-me-01">';
				echo slz_render_view( $instance->locate_path('/views/layout-1.php'), compact('data'));
			echo '</div>';
		}elseif( $data['layout'] == 'layout-2' ) {
			echo '<div class="slz-about-me-02">';
				echo slz_render_view( $instance->locate_path('/views/layout-2.php'), compact('data'));
			echo '</div>';
		}
	}
	?>
</div>
