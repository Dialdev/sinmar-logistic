<div class="media">
	<div class="media-left">
		<a href="<?php echo esc_url( $module->permalink ); ?>" class="wrapper-image">
			<?php echo ( $module->get_featured_image( 'small', array( 'thumb_class' => 'media-object' ) ) ); ?>
		</a>
	</div>
	<div class="media-right">
		<?php echo ( $module->get_title( true, array(), '<a href="%2$s" class="media-heading block-title">%1$s</a>' ) ); ?>
		<ul class="block-info">
			<?php echo ( $module->get_meta_data() ); ?>
		</ul>
	</div>
</div>