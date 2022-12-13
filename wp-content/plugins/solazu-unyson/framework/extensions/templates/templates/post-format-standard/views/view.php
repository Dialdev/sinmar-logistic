<?php if( get_post_thumbnail_id( $module->post_id ) ):?>
	<div class="block-image">
		<?php echo ( $module->get_ribbon_date() ); ?>
			<a href="<?php echo esc_url( $module->permalink ); ?>" class="link">
				<?php echo wp_kses_post( $module->get_featured_image() ); ?>
			</a>
	</div>
<?php endif;?>