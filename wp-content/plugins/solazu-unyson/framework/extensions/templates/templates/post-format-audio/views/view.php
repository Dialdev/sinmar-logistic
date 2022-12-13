<?php
$class_no_img = 'no-feature-img';
$has_img = get_post_thumbnail_id( $module->post_id );
if( $has_img ) {
	$class_no_img = '';
}
$data = slz_get_db_post_option( $module->post_id, 'feature-audio-link', '' );

if( $has_img || $data ):
?>
<div class="block-image has-audio <?php echo esc_attr( $class_no_img ); ?>">
	<?php if( $has_img ):?>
	<?php echo ( $module->get_ribbon_date() ); ?>
		<a href="<?php echo esc_url( $module->permalink ); ?>" class="link">
			<?php echo wp_kses_post( $module->get_featured_image() ); ?>
		</a>
	<?php endif;?>
	<?php
	if( !empty( $data ) ) {
		echo '
			<div class="audio-wrapper">
				<audio class="audio-format" controls="controls" src="'. esc_url( $data ) .'"></audio>
				<div class="slz-audio-control">
					<span class="btn-play"></span>
				</div>
			</div>
		';
	}
	?>
</div>
<?php endif;?>